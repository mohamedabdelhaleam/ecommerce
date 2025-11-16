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

    // Form submission
    if (reviewForm && reviewStoreUrl) {
        reviewForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById("submit-review-btn");
            const formData = new FormData(this);

            // Validate rating
            if (!ratingInput.value || ratingInput.value === "0") {
                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        icon: "error",
                        title: "Rating Required",
                        text: "Please select a rating before submitting your review.",
                        confirmButtonColor: primaryColor,
                    });
                }
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
                        if (typeof Swal !== "undefined") {
                            Swal.fire({
                                icon: "success",
                                title: "Thank You!",
                                text:
                                    data.message ||
                                    "Your review has been submitted successfully. It will be reviewed before being published.",
                                confirmButtonColor: primaryColor,
                            }).then(() => {
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
                            });
                        }
                    } else {
                        if (typeof Swal !== "undefined") {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text:
                                    data.message ||
                                    "There was an error submitting your review. Please try again.",
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
                            text: "There was an error submitting your review. Please try again.",
                            confirmButtonColor: primaryColor,
                        });
                    }
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
            const quantity = parseInt(document.getElementById("quantity-input").value) || 1;
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
                    "X-CSRF-TOKEN": document
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
                                text: data.message || "Product added to cart successfully.",
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
                                text: data.message || "Failed to add product to cart.",
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
                    cartCountEl.style.display = data.count > 0 ? "flex" : "none";
                }
            })
            .catch((error) => console.error("Error updating cart count:", error));
    }
});
