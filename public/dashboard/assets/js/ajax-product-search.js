/**
 * AJAX Product Search Functionality
 * Handles search by name, category, and status without page refresh
 */
(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        const searchForm = document.getElementById("product-search-form");
        const searchInput = document.getElementById("search");
        const categorySelect = document.getElementById("category_id");
        const statusSelect = document.getElementById("is_active");
        const fromDateInput = document.getElementById("from_date");
        const toDateInput = document.getElementById("to_date");
        const tableBody = document.getElementById("products-table-body");
        const paginationContainer = document.getElementById(
            "products-pagination"
        );

        // Get search URL from form data attribute
        const searchUrl = searchForm
            ? searchForm.getAttribute("data-search-url")
            : "";

        if (!searchUrl) {
            console.error(
                "Search URL not found. Please add data-search-url attribute to the form."
            );
            return;
        }

        let searchTimeout;

        // Function to perform AJAX search
        function performSearch() {
            const formData = new FormData(searchForm);
            const params = new URLSearchParams();

            // Add form data to params
            for (const [key, value] of formData.entries()) {
                if (value) {
                    params.append(key, value);
                }
            }

            // Show loading state
            tableBody.innerHTML =
                '<tr><td colspan="7" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';

            // Make AJAX request
            fetch(`${searchUrl}?${params.toString()}`, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Update table body
                        tableBody.innerHTML = data.table;

                        // Update pagination
                        paginationContainer.innerHTML = data.pagination
                            ? `<div class="mt-4">${data.pagination}</div>`
                            : "";

                        // Re-initialize status switchers after AJAX update
                        if (
                            typeof window.reinitializeStatusSwitchers ===
                            "function"
                        ) {
                            window.reinitializeStatusSwitchers();
                        }
                    } else {
                        tableBody.innerHTML =
                            '<tr><td colspan="7" class="text-center text-danger">Error loading products. Please try again.</td></tr>';
                    }
                })
                .catch((error) => {
                    console.error("Search error:", error);
                    tableBody.innerHTML =
                        '<tr><td colspan="7" class="text-center text-danger">Error loading products. Please try again.</td></tr>';
                });
        }

        // Search input with debounce
        if (searchInput) {
            searchInput.addEventListener("input", function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 500); // Wait 500ms after user stops typing
            });
        }

        // Category select change
        if (categorySelect) {
            categorySelect.addEventListener("change", performSearch);
        }

        // Status select change
        if (statusSelect) {
            statusSelect.addEventListener("change", performSearch);
        }

        // Date range inputs change
        if (fromDateInput) {
            fromDateInput.addEventListener("change", performSearch);
        }

        if (toDateInput) {
            toDateInput.addEventListener("change", performSearch);
        }

        // Handle clear input buttons
        document.addEventListener("click", function (e) {
            if (e.target.closest(".clear-input-btn")) {
                const btn = e.target.closest(".clear-input-btn");
                const targetId = btn.getAttribute("data-target-id");
                const triggerSearch =
                    btn.getAttribute("data-trigger-search") === "true";
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Clear the input/select value
                    if (targetElement.tagName === "SELECT") {
                        targetElement.value = "";
                    } else {
                        targetElement.value = "";
                    }

                    // Trigger change event to update search if needed
                    if (triggerSearch) {
                        const changeEvent = new Event("change", {
                            bubbles: true,
                        });
                        targetElement.dispatchEvent(changeEvent);
                    }

                    // Remove the clear button if input is empty
                    if (!targetElement.value) {
                        btn.remove();
                    }
                }
            }
        });

        // Show/hide clear buttons based on input values
        function toggleClearButtons() {
            const inputs = [searchInput, fromDateInput, toDateInput];
            const selects = [categorySelect, statusSelect];

            inputs.forEach((input) => {
                if (input) {
                    const wrapper = input.closest(
                        "div[style*='position: relative']"
                    );
                    if (wrapper) {
                        let clearBtn =
                            wrapper.querySelector(".clear-input-btn");
                        if (input.value && !clearBtn) {
                            // Create and add clear button
                            const btn = document.createElement("button");
                            btn.type = "button";
                            btn.className = "clear-input-btn";
                            btn.setAttribute("data-target-id", input.id);
                            btn.setAttribute("data-trigger-search", "true");
                            btn.style.cssText =
                                "position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: white; border: 1px solid #ddd; border-radius: 4px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; z-index: 10;";
                            btn.title = "Clear";
                            btn.innerHTML =
                                '<i class="uil uil-times" style="font-size: 14px; color: #666;"></i>';
                            wrapper.appendChild(btn);
                        } else if (!input.value && clearBtn) {
                            clearBtn.remove();
                        }
                    }
                }
            });

            selects.forEach((select) => {
                if (select) {
                    const wrapper = select.closest(
                        "div[style*='position: relative']"
                    );
                    if (wrapper) {
                        let clearBtn =
                            wrapper.querySelector(".clear-input-btn");
                        if (select.value && !clearBtn) {
                            // Create and add clear button
                            const btn = document.createElement("button");
                            btn.type = "button";
                            btn.className = "clear-input-btn";
                            btn.setAttribute("data-target-id", select.id);
                            btn.setAttribute("data-trigger-search", "true");
                            btn.style.cssText =
                                "position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: white; border: 1px solid #ddd; border-radius: 4px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; z-index: 10;";
                            btn.title = "Clear";
                            btn.innerHTML =
                                '<i class="uil uil-times" style="font-size: 14px; color: #666;"></i>';
                            wrapper.appendChild(btn);
                        } else if (!select.value && clearBtn) {
                            clearBtn.remove();
                        }
                    }
                }
            });
        }

        // Monitor input changes to show/hide clear buttons
        [
            searchInput,
            fromDateInput,
            toDateInput,
            categorySelect,
            statusSelect,
        ].forEach((element) => {
            if (element) {
                element.addEventListener("input", toggleClearButtons);
                element.addEventListener("change", toggleClearButtons);
            }
        });

        // Initial check for clear buttons
        toggleClearButtons();

        // Handle pagination links (if using AJAX pagination)
        document.addEventListener("click", function (e) {
            if (e.target.closest(".pagination a")) {
                e.preventDefault();
                const url = e.target.closest("a").href;
                if (url) {
                    // Extract query parameters from URL
                    const urlObj = new URL(url);
                    const params = new URLSearchParams(urlObj.search);

                    // Update form values
                    if (params.get("search")) {
                        searchInput.value = params.get("search");
                    }
                    if (params.get("category_id")) {
                        categorySelect.value = params.get("category_id");
                    }
                    if (params.get("is_active")) {
                        statusSelect.value = params.get("is_active");
                    }
                    if (params.get("from_date")) {
                        fromDateInput.value = params.get("from_date");
                    }
                    if (params.get("to_date")) {
                        toDateInput.value = params.get("to_date");
                    }

                    // Perform search with pagination
                    tableBody.innerHTML =
                        '<tr><td colspan="7" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';

                    fetch(url, {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            Accept: "application/json",
                        },
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then((data) => {
                            if (data.success) {
                                tableBody.innerHTML = data.table;
                                paginationContainer.innerHTML = data.pagination
                                    ? `<div class="mt-4">${data.pagination}</div>`
                                    : "";

                                // Re-initialize status switchers after AJAX update
                                if (
                                    typeof window.reinitializeStatusSwitchers ===
                                    "function"
                                ) {
                                    window.reinitializeStatusSwitchers();
                                }
                            }
                        })
                        .catch((error) => {
                            console.error("Pagination error:", error);
                            tableBody.innerHTML =
                                '<tr><td colspan="7" class="text-center text-danger">Error loading products. Please try again.</td></tr>';
                        });
                }
            }
        });
    });
})();
