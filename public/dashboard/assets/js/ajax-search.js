/**
 * Generic AJAX Search Functionality
 * Handles search by name, status, and date range without page refresh
 * Usage: Add data-form-id, data-table-body-id, data-pagination-id attributes to your search form
 */
(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        // Find all search forms
        const searchForms = document.querySelectorAll('[id$="-search-form"]');

        searchForms.forEach(function (searchForm) {
            const formId = searchForm.id;
            const searchUrl = searchForm.getAttribute("data-search-url");

            // Extract entity name from form ID (e.g., "color-search-form" -> "color")
            const entityName = formId.replace("-search-form", "");
            const tableBodyId = `${entityName}s-table-body`;
            const paginationId = `${entityName}s-pagination`;

            const searchInput = searchForm.querySelector("#search");
            const statusSelect = searchForm.querySelector("#is_active");
            const typeSelect = searchForm.querySelector("#type");
            const fromDateInput = searchForm.querySelector("#from_date");
            const toDateInput = searchForm.querySelector("#to_date");
            const tableBody = document.getElementById(tableBodyId);
            const paginationContainer = document.getElementById(paginationId);

            if (!searchUrl || !tableBody) {
                console.warn(
                    `Search form ${formId} is missing required attributes or table body.`
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
                const colCount = tableBody.querySelector("tr")
                    ? tableBody.querySelector("tr").cells.length
                    : 5;
                tableBody.innerHTML = `<tr><td colspan="${colCount}" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

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
                            if (paginationContainer) {
                                paginationContainer.innerHTML = data.pagination
                                    ? `<div class="mt-4">${data.pagination}</div>`
                                    : "";
                            }

                            // Re-initialize status switchers after AJAX update
                            if (
                                typeof window.reinitializeStatusSwitchers ===
                                "function"
                            ) {
                                window.reinitializeStatusSwitchers();
                            }
                        } else {
                            tableBody.innerHTML = `<tr><td colspan="${colCount}" class="text-center text-danger">Error loading data. Please try again.</td></tr>`;
                        }
                    })
                    .catch((error) => {
                        console.error("Search error:", error);
                        tableBody.innerHTML = `<tr><td colspan="${colCount}" class="text-center text-danger">Error loading data. Please try again.</td></tr>`;
                    });
            }

            // Search input with debounce
            if (searchInput) {
                searchInput.addEventListener("input", function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(performSearch, 500); // Wait 500ms after user stops typing
                });
            }

            // Status select change
            if (statusSelect) {
                statusSelect.addEventListener("change", performSearch);
            }

            // Type select change (for coupons)
            if (typeSelect) {
                typeSelect.addEventListener("change", performSearch);
            }

            // Date range inputs change
            if (fromDateInput) {
                fromDateInput.addEventListener("change", performSearch);
            }

            if (toDateInput) {
                toDateInput.addEventListener("change", performSearch);
            }

            // Handle pagination links (if using AJAX pagination)
            if (paginationContainer) {
                document.addEventListener("click", function (e) {
                    const paginationLink = e.target.closest(
                        `#${paginationId} .pagination a`
                    );
                    if (paginationLink) {
                        e.preventDefault();
                        const url = paginationLink.href;
                        if (url) {
                            // Extract query parameters from URL
                            const urlObj = new URL(url);
                            const params = new URLSearchParams(urlObj.search);

                            // Update form values
                            if (params.get("search") && searchInput) {
                                searchInput.value = params.get("search");
                            }
                            if (params.get("is_active") && statusSelect) {
                                statusSelect.value = params.get("is_active");
                            }
                            if (params.get("type") && typeSelect) {
                                typeSelect.value = params.get("type");
                            }
                            if (params.get("from_date") && fromDateInput) {
                                fromDateInput.value = params.get("from_date");
                            }
                            if (params.get("to_date") && toDateInput) {
                                toDateInput.value = params.get("to_date");
                            }

                            // Perform search with pagination
                            const colCount = tableBody.querySelector("tr")
                                ? tableBody.querySelector("tr").cells.length
                                : 5;
                            tableBody.innerHTML = `<tr><td colspan="${colCount}" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>`;

                            fetch(url, {
                                method: "GET",
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                    Accept: "application/json",
                                },
                            })
                                .then((response) => {
                                    if (!response.ok) {
                                        throw new Error(
                                            "Network response was not ok"
                                        );
                                    }
                                    return response.json();
                                })
                                .then((data) => {
                                    if (data.success) {
                                        tableBody.innerHTML = data.table;
                                        if (paginationContainer) {
                                            paginationContainer.innerHTML =
                                                data.pagination
                                                    ? `<div class="mt-4">${data.pagination}</div>`
                                                    : "";
                                        }

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
                                    const colCount = tableBody.querySelector(
                                        "tr"
                                    )
                                        ? tableBody.querySelector("tr").cells
                                              .length
                                        : 5;
                                    tableBody.innerHTML = `<tr><td colspan="${colCount}" class="text-center text-danger">Error loading data. Please try again.</td></tr>`;
                                });
                        }
                    }
                });
            }
        });
    });
})();
