/**
 * Products Filter - AJAX Filtering System
 * Handles filtering, sorting, and pagination without page reloads
 * Also handles Add to Cart functionality on product cards
 */
document.addEventListener("DOMContentLoaded", function () {
    const sortSelect = document.getElementById("sort-by");
    const categoryCheckboxes = document.querySelectorAll(".category-checkbox");
    const priceRange = document.getElementById("price-range");
    const priceDisplay = document.getElementById("price-display");
    const clearFiltersBtn = document.getElementById("clear-filters");
    const clearFiltersEmptyBtn = document.getElementById("clear-filters-empty");
    const productsContainer = document.getElementById("products-container");

    // Get price values safely
    const minPriceEl = document.getElementById("min-price");
    const maxPriceEl = document.getElementById("max-price");

    if (!minPriceEl || !maxPriceEl || !productsContainer) {
        console.error("Required elements not found");
        return;
    }

    const minPrice = parseFloat(minPriceEl.value) || 0;
    const maxPrice = parseFloat(maxPriceEl.value) || 1000;

    // Loading state
    let isLoading = false;

    // Update price display when slider changes
    if (priceRange && priceDisplay) {
        priceRange.addEventListener("input", function () {
            const value = parseFloat(this.value);
            priceDisplay.textContent = "$" + value.toFixed(2) + "+";
        });
    }

    // Function to build URL with current filters
    function buildFilterUrl() {
        const url = new URL(window.location.href);
        const baseUrl = url.origin + url.pathname;
        const params = new URLSearchParams();

        // Get sort value
        if (sortSelect && sortSelect.value && sortSelect.value !== "newest") {
            params.set("sort", sortSelect.value);
        }

        // Get selected categories
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter((cb) => cb.checked)
            .map((cb) => cb.value);

        if (selectedCategories.length > 0) {
            params.set("categories", selectedCategories.join(","));
        }

        // Get price range
        if (priceRange) {
            const maxPriceValue = parseFloat(priceRange.value);

            // Only set max_price if it's less than the maximum available price
            if (maxPriceValue < maxPrice) {
                params.set("max_price", maxPriceValue);
            }
        }

        // Build final URL
        const queryString = params.toString();
        return queryString ? baseUrl + "?" + queryString : baseUrl;
    }

    // Function to show loading state
    function showLoading() {
        if (isLoading) return;
        isLoading = true;
        productsContainer.innerHTML = `
            <div class="flex items-center justify-center py-12">
                <div class="flex flex-col items-center gap-4">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                    <p class="text-sm text-text-light/70 dark:text-text-dark/70">Loading products...</p>
                </div>
            </div>
        `;
    }

    // Function to apply filters via AJAX
    async function applyFilters() {
        if (isLoading) return;

        const url = buildFilterUrl();
        showLoading();

        try {
            const response = await fetch(url, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            });

            if (!response.ok) {
                throw new Error("Network response was not ok");
            }

            const data = await response.json();

            if (data.success && data.html) {
                // Update products container
                productsContainer.innerHTML = data.html;

                // Update URL without reload
                window.history.pushState(
                    {
                        html: data.html,
                        pageTitle: document.title,
                    },
                    "",
                    url
                );

                // Re-initialize event listeners for pagination
                initPaginationListeners();

                // Scroll to top of products container smoothly
                productsContainer.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            } else {
                throw new Error("Invalid response format");
            }
        } catch (error) {
            console.error("Error loading products:", error);
            productsContainer.innerHTML = `
                <div class="text-center py-12">
                    <p class="text-lg text-text-light/70 dark:text-text-dark/70">Error loading products. Please try again.</p>
                    <button onclick="location.reload()" class="mt-4 text-sm font-semibold py-2 px-4 rounded bg-primary text-white hover:bg-primary/90 transition-colors">
                        Reload Page
                    </button>
                </div>
            `;
        } finally {
            isLoading = false;
        }
    }

    // Initialize pagination listeners
    function initPaginationListeners() {
        // Remove existing listeners by cloning and replacing
        const paginationContainer = document.getElementById(
            "products-pagination"
        );
        if (paginationContainer) {
            const newContainer = paginationContainer.cloneNode(true);
            paginationContainer.parentNode.replaceChild(
                newContainer,
                paginationContainer
            );
        }

        const paginationLinks = document.querySelectorAll(".pagination-link");
        paginationLinks.forEach((link) => {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                const url = this.getAttribute("href");
                if (url) {
                    window.history.pushState({}, "", url);
                    showLoading();
                    fetch(url, {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            Accept: "application/json",
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success && data.html) {
                                productsContainer.innerHTML = data.html;
                                initPaginationListeners();
                                // Scroll to top of products
                                productsContainer.scrollIntoView({
                                    behavior: "smooth",
                                    block: "start",
                                });
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            location.reload();
                        })
                        .finally(() => {
                            isLoading = false;
                        });
                }
            });
        });
    }

    // Handle browser back/forward buttons
    window.addEventListener("popstate", function (e) {
        if (e.state && e.state.html) {
            productsContainer.innerHTML = e.state.html;
            initPaginationListeners();
        } else {
            location.reload();
        }
    });

    // Sort change handler
    if (sortSelect) {
        sortSelect.addEventListener("change", function () {
            applyFilters();
        });
    }

    // Category checkbox change handler (with debounce)
    let categoryTimeout;
    categoryCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            clearTimeout(categoryTimeout);
            categoryTimeout = setTimeout(() => {
                applyFilters();
            }, 300); // Wait 300ms after last change
        });
    });

    // Price range change handler (with debounce)
    let priceTimeout;
    if (priceRange) {
        priceRange.addEventListener("change", function () {
            clearTimeout(priceTimeout);
            priceTimeout = setTimeout(() => {
                applyFilters();
            }, 500); // Wait 500ms after slider stops
        });
    }

    // Clear filters handler
    function clearFilters() {
        const baseUrl = window.location.origin + window.location.pathname;
        window.history.pushState({}, "", baseUrl);
        showLoading();
        fetch(baseUrl, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success && data.html) {
                    productsContainer.innerHTML = data.html;
                    initPaginationListeners();
                    initAddToCartListeners();
                    initAddToCartListeners();

                    // Reset form elements
                    if (sortSelect) sortSelect.value = "newest";
                    categoryCheckboxes.forEach((cb) => (cb.checked = false));
                    if (priceRange) priceRange.value = maxPrice;
                    if (priceDisplay)
                        priceDisplay.textContent =
                            "$" + maxPrice.toFixed(2) + "+";
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                location.reload();
            })
            .finally(() => {
                isLoading = false;
            });
    }

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", clearFilters);
    }

    if (clearFiltersEmptyBtn) {
        clearFiltersEmptyBtn.addEventListener("click", clearFilters);
    }

    // Initialize pagination listeners on page load
    initPaginationListeners();

    // Initialize Add to Cart functionality
    initAddToCartListeners();

    // Function to initialize Add to Cart button listeners
    function initAddToCartListeners() {
        const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
        const primaryColor = window.primaryColor || "#42b6f0";
        const addToCartUrl = window.addToCartUrl || "/cart/add";
        const cartCountUrl = window.cartCountUrl || "/cart/count";

        addToCartButtons.forEach((btn) => {
            // Remove existing listeners to prevent duplicates
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);

            newBtn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = this.getAttribute("data-product-id");
                const productUrl = this.getAttribute("data-product-url");

                if (!productId) {
                    console.error("Product ID not found");
                    return;
                }

                // Disable button
                const originalText = this.textContent;
                this.disabled = true;
                this.textContent = "Adding...";

                // Prepare form data
                const formData = new FormData();
                formData.append("product_id", productId);
                formData.append("quantity", 1);

                // Submit via AJAX
                fetch(addToCartUrl, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN":
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content") || "",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            if (typeof Swal !== "undefined") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Added to Cart!",
                                    text:
                                        data.message ||
                                        "Product added to cart successfully.",
                                    confirmButtonColor: primaryColor,
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            }
                            // Update cart count in header
                            updateCartCount();
                        } else {
                            if (typeof Swal !== "undefined") {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text:
                                        data.message ||
                                        "Failed to add product to cart.",
                                    confirmButtonColor: primaryColor,
                                });
                            }
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        if (typeof Swal !== "undefined") {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "There was an error adding the product to cart.",
                                confirmButtonColor: primaryColor,
                            });
                        }
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.textContent = originalText;
                    });
            });
        });
    }

    // Function to update cart count in header
    function updateCartCount() {
        const cartCountUrl = window.cartCountUrl || "/cart/count";
        fetch(cartCountUrl, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const cartCountEl = document.getElementById("cart-count");
                if (cartCountEl) {
                    cartCountEl.textContent = data.count || 0;
                    cartCountEl.style.display =
                        data.count > 0 ? "flex" : "none";
                }
            })
            .catch((error) =>
                console.error("Error updating cart count:", error)
            );
    }
});
