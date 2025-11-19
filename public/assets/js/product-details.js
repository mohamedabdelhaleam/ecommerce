document.addEventListener("DOMContentLoaded", function () {
    // Variants data from server
    const variants = window.productVariants || [];
    const priceElement = document.getElementById("product-price");
    const minPrice = window.productMinPrice || 0;
    const maxPrice = window.productMaxPrice || 0;

    // Selected size and color
    let selectedSizeId = null;
    let selectedColorId = null;

    // Function to find matching variant
    function findVariant(sizeId, colorId) {
        // Try exact match first
        let variant = variants.find((v) => {
            const sizeMatch = sizeId ? v.size_id == sizeId : v.size_id === null;
            const colorMatch = colorId
                ? v.color_id == colorId
                : v.color_id === null;
            return sizeMatch && colorMatch;
        });

        // If no exact match, try with size only
        if (!variant && sizeId) {
            variant = variants.find(
                (v) => v.size_id == sizeId && v.color_id === null
            );
        }

        // If still no match, try with color only
        if (!variant && colorId) {
            variant = variants.find(
                (v) => v.size_id === null && v.color_id == colorId
            );
        }

        // If still no match, get first variant with price
        if (!variant) {
            variant = variants.find((v) => v.price !== null);
        }

        return variant;
    }

    // Function to update price
    function updatePrice() {
        if (!priceElement) return;

        const variant = findVariant(selectedSizeId, selectedColorId);
        const currencySymbol = window.currencySymbol || "$";

        if (variant && variant.price !== null) {
            priceElement.textContent =
                currencySymbol + parseFloat(variant.price).toFixed(2);
        } else {
            // Fallback to price range
            if (minPrice && maxPrice) {
                if (minPrice === maxPrice) {
                    priceElement.textContent =
                        currencySymbol + minPrice.toFixed(2);
                } else {
                    priceElement.textContent =
                        currencySymbol +
                        minPrice.toFixed(2) +
                        " - " +
                        currencySymbol +
                        maxPrice.toFixed(2);
                }
            } else {
                priceElement.textContent = "N/A";
            }
        }
    }

    // Image gallery functionality
    const mainImage = document.getElementById("main-product-image");
    const thumbnailContainer = document.querySelector(
        ".grid.grid-cols-4.gap-4"
    );
    const colorImagesData = window.colorImagesData || {};

    // Function to update images based on selected color
    function updateImagesForColor(colorId) {
        if (!mainImage) return;

        // Get images for the selected color, or fallback to general images
        let images =
            colorImagesData[colorId] || colorImagesData["general"] || [];

        // If no color-specific images, use general images
        if (images.length === 0 && colorId !== null) {
            images = colorImagesData["general"] || [];
        }

        if (images.length === 0) return;

        // Sort images: primary first, then by order
        images.sort((a, b) => {
            if (a.is_primary && !b.is_primary) return -1;
            if (!a.is_primary && b.is_primary) return 1;
            return a.order - b.order;
        });

        // Update main image
        const primaryImage = images.find((img) => img.is_primary) || images[0];
        if (primaryImage && primaryImage.url) {
            mainImage.style.backgroundImage = `url("${primaryImage.url}")`;
        }

        // Update thumbnails
        if (thumbnailContainer) {
            // Clear existing thumbnails
            thumbnailContainer.innerHTML = "";

            // Create new thumbnails (max 4)
            const thumbnailsToShow = images.slice(0, 4);
            thumbnailsToShow.forEach((image, index) => {
                const thumbnail = document.createElement("div");
                thumbnail.className = `thumbnail-image w-full bg-center bg-no-repeat aspect-square bg-cover rounded-lg cursor-pointer transition-all ${
                    index === 0
                        ? "border-2 border-primary"
                        : "border border-gray-300 dark:border-gray-700"
                }`;
                thumbnail.setAttribute(
                    "data-alt",
                    `Product Image ${index + 1}`
                );
                thumbnail.setAttribute("data-image", image.url);
                thumbnail.style.backgroundImage = `url("${image.url}")`;

                // Add click handler
                thumbnail.addEventListener("click", function () {
                    mainImage.style.backgroundImage = `url("${image.url}")`;

                    // Update active thumbnail
                    thumbnailContainer
                        .querySelectorAll(".thumbnail-image")
                        .forEach((t) => {
                            t.classList.remove("border-2", "border-primary");
                            t.classList.add(
                                "border",
                                "border-gray-300",
                                "dark:border-gray-700"
                            );
                        });
                    this.classList.remove(
                        "border",
                        "border-gray-300",
                        "dark:border-gray-700"
                    );
                    this.classList.add("border-2", "border-primary");
                });

                thumbnailContainer.appendChild(thumbnail);
            });
        }
    }

    // Initialize thumbnails click handlers
    function initializeThumbnails() {
        const thumbnailImages = document.querySelectorAll(".thumbnail-image");
        thumbnailImages.forEach((thumbnail) => {
            thumbnail.addEventListener("click", function () {
                const imageUrl = this.getAttribute("data-image");
                if (mainImage && imageUrl) {
                    mainImage.style.backgroundImage = `url("${imageUrl}")`;

                    // Update active thumbnail
                    thumbnailImages.forEach((t) => {
                        t.classList.remove("border-2", "border-primary");
                        t.classList.add(
                            "border",
                            "border-gray-300",
                            "dark:border-gray-700"
                        );
                    });
                    this.classList.remove(
                        "border",
                        "border-gray-300",
                        "dark:border-gray-700"
                    );
                    this.classList.add("border-2", "border-primary");
                }
            });
        });
    }

    // Initialize thumbnails on page load
    initializeThumbnails();

    // Quantity controls
    const quantityInput = document.getElementById("quantity-input");
    const decreaseBtn = document.querySelector(".quantity-decrease");
    const increaseBtn = document.querySelector(".quantity-increase");

    if (decreaseBtn && quantityInput) {
        decreaseBtn.addEventListener("click", function () {
            const currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    }

    if (increaseBtn && quantityInput) {
        increaseBtn.addEventListener("click", function () {
            const currentValue = parseInt(quantityInput.value) || 1;
            quantityInput.value = currentValue + 1;
        });
    }

    // Size and Color selection
    const sizeOptions = document.querySelectorAll(".size-option");
    const colorOptions = document.querySelectorAll(".color-option");

    sizeOptions.forEach((option) => {
        option.addEventListener("click", function () {
            sizeOptions.forEach((opt) => {
                opt.classList.remove(
                    "border-2",
                    "border-primary",
                    "bg-primary/20",
                    "font-bold"
                );
                opt.classList.add(
                    "border",
                    "border-border-light",
                    "dark:border-border-dark"
                );
            });
            this.classList.remove(
                "border",
                "border-border-light",
                "dark:border-border-dark"
            );
            this.classList.add(
                "border-2",
                "border-primary",
                "bg-primary/20",
                "font-bold"
            );

            // Update selected size and price
            selectedSizeId = parseInt(this.getAttribute("data-size-id"));
            updatePrice();
        });
    });

    colorOptions.forEach((option) => {
        option.addEventListener("click", function () {
            colorOptions.forEach((opt) => {
                opt.classList.remove(
                    "border-2",
                    "border-primary",
                    "bg-primary/20",
                    "font-bold"
                );
                opt.classList.add(
                    "border",
                    "border-border-light",
                    "dark:border-border-dark"
                );
            });
            this.classList.remove(
                "border",
                "border-border-light",
                "dark:border-border-dark"
            );
            this.classList.add(
                "border-2",
                "border-primary",
                "bg-primary/20",
                "font-bold"
            );

            // Update selected color and price
            selectedColorId = parseInt(this.getAttribute("data-color-id"));
            updatePrice();

            // Update images for selected color
            updateImagesForColor(selectedColorId);
        });
    });

    // Set initial selection if first option exists
    if (sizeOptions.length > 0) {
        const firstSize = sizeOptions[0];
        selectedSizeId = parseInt(firstSize.getAttribute("data-size-id"));
    }
    if (colorOptions.length > 0) {
        const firstColor = colorOptions[0];
        selectedColorId = parseInt(firstColor.getAttribute("data-color-id"));
        // Initialize images for first color
        updateImagesForColor(selectedColorId);
    }

    // Update price on initial load if we have selections
    if (selectedSizeId || selectedColorId) {
        updatePrice();
    }

    // Review Form Functionality
    const reviewForm = document.getElementById("review-form");
    const ratingStars = document.querySelectorAll(".rating-star");
    const ratingInput = document.getElementById("review-rating");
    let selectedRating = 0;
    const reviewStoreUrl = window.reviewStoreUrl || "";
    const primaryColor = window.primaryColor || "#42b6f0";

    // Rating stars interaction
    ratingStars.forEach((star, index) => {
        star.addEventListener("click", function () {
            selectedRating = parseInt(this.getAttribute("data-rating"));
            ratingInput.value = selectedRating;

            // Update star display
            ratingStars.forEach((s, i) => {
                const icon = s.querySelector("span");
                if (i < selectedRating) {
                    icon.textContent = "star";
                    s.classList.remove("text-gray-300", "dark:text-gray-600");
                    s.classList.add("text-primary");
                } else {
                    icon.textContent = "star_outline";
                    s.classList.remove("text-primary");
                    s.classList.add("text-gray-300", "dark:text-gray-600");
                }
            });
        });

        star.addEventListener("mouseenter", function () {
            const hoverRating = parseInt(this.getAttribute("data-rating"));
            ratingStars.forEach((s, i) => {
                const icon = s.querySelector("span");
                if (i < hoverRating) {
                    icon.textContent = "star";
                    s.classList.add("text-primary");
                } else {
                    icon.textContent = "star_outline";
                }
            });
        });
    });

    // Reset stars on mouse leave (if no rating selected)
    const ratingStarsContainer = document.getElementById("rating-stars");
    if (ratingStarsContainer) {
        ratingStarsContainer.addEventListener("mouseleave", function () {
            if (selectedRating === 0) {
                ratingStars.forEach((s) => {
                    const icon = s.querySelector("span");
                    icon.textContent = "star_outline";
                    s.classList.remove("text-primary");
                    s.classList.add("text-gray-300", "dark:text-gray-600");
                });
            } else {
                // Restore selected rating
                ratingStars.forEach((s, i) => {
                    const icon = s.querySelector("span");
                    if (i < selectedRating) {
                        icon.textContent = "star";
                        s.classList.add("text-primary");
                    } else {
                        icon.textContent = "star_outline";
                    }
                });
            }
        });
    }

    // Character counter for review comment
    const reviewComment = document.getElementById("review-comment");
    const reviewCharCount = document.getElementById("review-char-count");
    const maxLength = 150;

    if (reviewComment && reviewCharCount) {
        // Update counter on input
        reviewComment.addEventListener("input", function () {
            const currentLength = this.value.length;
            reviewCharCount.textContent = currentLength;

            // Change color when approaching limit
            if (currentLength >= maxLength * 0.9) {
                reviewCharCount.classList.add("text-red-500");
                reviewCharCount.classList.remove(
                    "text-gray-500",
                    "dark:text-gray-400"
                );
            } else {
                reviewCharCount.classList.remove("text-red-500");
                reviewCharCount.classList.add(
                    "text-gray-500",
                    "dark:text-gray-400"
                );
            }
        });

        // Initialize counter
        reviewCharCount.textContent = reviewComment.value.length;
    }

    // Function to update review statistics
    function updateReviewStatistics(stats) {
        const statsContainer = document.getElementById(
            "review-stats-container"
        );
        const reviewAverage = document.getElementById("review-average");
        const reviewStars = document.getElementById("review-stars");
        const reviewTotalText = document.getElementById("review-total-text");
        const reviewDistribution = document.getElementById(
            "review-distribution"
        );
        const productRatingDisplay = document.getElementById(
            "product-rating-display"
        );
        const productRatingStars = document.getElementById(
            "product-rating-stars"
        );
        const productRatingText = document.getElementById(
            "product-rating-text"
        );

        if (!stats || !stats.total) return;

        // Show stats container if hidden
        if (statsContainer) {
            statsContainer.classList.remove("hidden");
        }

        // Update product rating display at the top
        if (productRatingDisplay) {
            productRatingDisplay.classList.remove("hidden");
        }

        if (productRatingStars) {
            productRatingStars.innerHTML = "";
            const average = parseFloat(stats.average);
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement("span");
                star.className = "material-symbols-outlined";
                if (i <= Math.floor(average)) {
                    star.textContent = "star";
                } else if (i - 0.5 <= average) {
                    star.textContent = "star_half";
                } else {
                    star.textContent = "star_outline";
                }
                productRatingStars.appendChild(star);
            }
        }

        if (productRatingText) {
            const total = stats.total;
            productRatingText.textContent = `${parseFloat(
                stats.average
            ).toFixed(1)} (${total} ${total === 1 ? "Review" : "Reviews"})`;
        }

        // Update average rating
        if (reviewAverage) {
            reviewAverage.textContent = parseFloat(stats.average).toFixed(1);
        }

        // Update stars display
        if (reviewStars) {
            reviewStars.innerHTML = "";
            const average = parseFloat(stats.average);
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement("span");
                star.className = "material-symbols-outlined";
                if (i <= Math.floor(average)) {
                    star.textContent = "star";
                } else if (i - 0.5 <= average) {
                    star.textContent = "star_half";
                } else {
                    star.textContent = "star_outline";
                }
                reviewStars.appendChild(star);
            }
        }

        // Update total text
        if (reviewTotalText) {
            const total = stats.total;
            reviewTotalText.textContent = `Based on ${total} ${
                total === 1 ? "review" : "reviews"
            }`;
        }

        // Update distribution bars
        if (reviewDistribution && stats.distribution) {
            const distributionBars =
                reviewDistribution.querySelectorAll("[data-rating]");
            distributionBars.forEach((bar) => {
                const rating = parseInt(bar.getAttribute("data-rating"));
                const count = stats.distribution[rating] || 0;
                const percentage = stats.percentages[rating] || 0;

                // Update count
                const countElement = bar.querySelector(".rating-count");
                if (countElement) {
                    countElement.textContent = count;
                }

                // Update progress bar
                const progressBar = bar.querySelector(".bg-primary");
                if (progressBar) {
                    progressBar.style.width = percentage + "%";
                }
            });
        }
    }

    // Form submission
    if (reviewForm && reviewStoreUrl) {
        reviewForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById("submit-review-btn");
            const formData = new FormData(this);

            // Validate rating
            if (!ratingInput.value || ratingInput.value === "0") {
                showToast({
                    icon: "error",
                    title: "Rating Required",
                    text: "Please select a rating before submitting your review.",
                });
                return;
            }

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = "Submitting...";

            // Submit via AJAX
            fetch(reviewStoreUrl, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        showToast({
                            icon: "success",
                            title: "Thank You!",
                            text:
                                data.message ||
                                "Your review has been submitted successfully.",
                        });

                        // Add new review to the reviews list
                        const reviewsList =
                            document.getElementById("reviews-list");
                        if (reviewsList && data.reviewHtml) {
                            // Show reviews list if hidden
                            reviewsList.classList.remove("hidden");

                            // Create a temporary container to parse the HTML
                            const tempDiv = document.createElement("div");
                            tempDiv.innerHTML = data.reviewHtml.trim();
                            const newReviewElement = tempDiv.firstElementChild;

                            // Add animation class for smooth appearance
                            newReviewElement.style.opacity = "0";
                            newReviewElement.style.transform =
                                "translateY(-10px)";

                            // Insert at the top of the reviews list
                            if (reviewsList.firstChild) {
                                reviewsList.insertBefore(
                                    newReviewElement,
                                    reviewsList.firstChild
                                );
                            } else {
                                reviewsList.appendChild(newReviewElement);
                            }

                            // Animate in
                            setTimeout(() => {
                                newReviewElement.style.transition =
                                    "opacity 0.3s ease, transform 0.3s ease";
                                newReviewElement.style.opacity = "1";
                                newReviewElement.style.transform =
                                    "translateY(0)";
                            }, 10);

                            // Scroll to the new review
                            setTimeout(() => {
                                newReviewElement.scrollIntoView({
                                    behavior: "smooth",
                                    block: "nearest",
                                });
                            }, 100);
                        }

                        // Update review statistics
                        if (data.reviewStats) {
                            updateReviewStatistics(data.reviewStats);
                        }

                        // Reset form
                        reviewForm.reset();
                        selectedRating = 0;
                        ratingInput.value = "";
                        ratingStars.forEach((s) => {
                            const icon = s.querySelector("span");
                            icon.textContent = "star_outline";
                            s.classList.remove("text-primary");
                            s.classList.add(
                                "text-gray-300",
                                "dark:text-gray-600"
                            );
                        });
                        // Reset character counter
                        if (reviewCharCount) {
                            reviewCharCount.textContent = "0";
                            reviewCharCount.classList.remove("text-red-500");
                            reviewCharCount.classList.add(
                                "text-gray-500",
                                "dark:text-gray-400"
                            );
                        }
                    } else {
                        showToast({
                            icon: "error",
                            title: "Error",
                            text:
                                data.message ||
                                "There was an error submitting your review. Please try again.",
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showToast({
                        icon: "error",
                        title: "Error",
                        text: "There was an error submitting your review. Please try again.",
                    });
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = "Submit Review";
                });
        });
    }

    // Add to Cart functionality
    const addToCartBtn = document.getElementById("add-to-cart-btn");
    const productId = window.productId || null;
    const addToCartUrl = window.addToCartUrl || "";

    if (addToCartBtn && productId && addToCartUrl) {
        addToCartBtn.addEventListener("click", function () {
            const quantity =
                parseInt(document.getElementById("quantity-input").value) || 1;
            const variant = findVariant(selectedSizeId, selectedColorId);
            const variantId = variant ? variant.id : null;

            // Disable button
            addToCartBtn.disabled = true;
            const originalText = addToCartBtn.textContent;
            addToCartBtn.textContent = "Adding...";

            // Prepare form data
            const formData = new FormData();
            formData.append("product_id", productId);
            formData.append("quantity", quantity);
            if (variantId) {
                formData.append("variant_id", variantId);
            }

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
                        showToast({
                            icon: "success",
                            title: "Added to Cart!",
                            text:
                                data.message ||
                                "Product added to cart successfully.",
                            timer: 2000,
                        });
                        // Update cart count in header
                        updateCartCount();
                    } else {
                        showToast({
                            icon: "error",
                            title: "Error",
                            text:
                                data.message ||
                                "Failed to add product to cart.",
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showToast({
                        icon: "error",
                        title: "Error",
                        text: "There was an error adding the product to cart.",
                    });
                })
                .finally(() => {
                    addToCartBtn.disabled = false;
                    addToCartBtn.textContent = originalText;
                });
        });
    }

    // Function to update cart count in header
    function updateCartCount() {
        fetch(window.cartCountUrl || "/cart/count", {
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

    // Initialize Add to Cart functionality for product cards (related products)
    function initProductCardAddToCart() {
        const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
        const addToCartUrl = window.addToCartUrl || "/cart/add";
        const cartCountUrl = window.cartCountUrl || "/cart/count";

        addToCartButtons.forEach((btn) => {
            // Skip if already has listener (check by data attribute)
            if (btn.hasAttribute("data-listener-attached")) {
                return;
            }
            btn.setAttribute("data-listener-attached", "true");

            btn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = this.getAttribute("data-product-id");
                const productUrl = this.getAttribute("data-product-url");
                const variantId = this.getAttribute("data-variant-id");

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
                if (variantId) {
                    formData.append("variant_id", variantId);
                }

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
                            showToast({
                                icon: "success",
                                title: "Added to Cart!",
                                text:
                                    data.message ||
                                    "Product added to cart successfully.",
                                timer: 2000,
                            });
                            // Update cart count in header
                            updateCartCount();
                        } else {
                            showToast({
                                icon: "error",
                                title: "Error",
                                text:
                                    data.message ||
                                    "Failed to add product to cart.",
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        showToast({
                            icon: "error",
                            title: "Error",
                            text: "There was an error adding the product to cart.",
                        });
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.textContent = originalText;
                    });
            });
        });
    }

    // Initialize product card add to cart on page load
    initProductCardAddToCart();

    // Re-initialize when new product cards are added (e.g., after color change)
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.addedNodes.length) {
                initProductCardAddToCart();
            }
        });
    });

    // Observe the document body for changes
    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
});
