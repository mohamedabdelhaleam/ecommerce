document.addEventListener("DOMContentLoaded", function () {
    const primaryColor = window.primaryColor || "#42b6f0";
    const currencySymbol = window.currencySymbol || "$";

    // Quantity controls
    document.querySelectorAll(".quantity-decrease").forEach((btn) => {
        btn.addEventListener("click", function () {
            const input = this.parentElement.querySelector(".cart-quantity");
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateCartItem(input);
            }
        });
    });

    document.querySelectorAll(".quantity-increase").forEach((btn) => {
        btn.addEventListener("click", function () {
            const input = this.parentElement.querySelector(".cart-quantity");
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
            updateCartItem(input);
        });
    });

    // Update quantity on input change
    document.querySelectorAll(".cart-quantity").forEach((input) => {
        input.addEventListener("change", function () {
            const value = parseInt(this.value) || 1;
            if (value < 1) {
                this.value = 1;
            }
            updateCartItem(this);
        });
    });

    // Remove item
    document.querySelectorAll(".remove-item").forEach((btn) => {
        btn.addEventListener("click", function () {
            const key = this.getAttribute("data-key");
            removeCartItem(key);
        });
    });

    // Function to update cart item
    function updateCartItem(input) {
        const key = input.getAttribute("data-key");
        const quantity = parseInt(input.value) || 1;
        const cartItem = input.closest(".cart-item");

        // Disable input during update
        input.disabled = true;

        fetch(`/cart/update/${key}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
            body: JSON.stringify({ quantity: quantity }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Update item total
                    const itemTotalEl = cartItem.querySelector(".item-total");
                    if (itemTotalEl) {
                        itemTotalEl.textContent = data.item_total;
                    }

                    // Update cart totals
                    const subtotalEl = document.getElementById("cart-subtotal");
                    const totalEl = document.getElementById("cart-total");
                    if (subtotalEl) subtotalEl.textContent = data.subtotal;
                    if (totalEl) totalEl.textContent = data.total;
                } else {
                    showToast({
                        icon: "error",
                        title: "Error",
                        text: data.message || "Failed to update cart item.",
                    });
                    // Revert input value
                    input.value = input.getAttribute("data-old-value") || 1;
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showToast({
                    icon: "error",
                    title: "Error",
                    text: "There was an error updating the cart item.",
                });
                // Revert input value
                input.value = input.getAttribute("data-old-value") || 1;
            })
            .finally(() => {
                input.disabled = false;
            });
    }

    // Function to remove cart item
    function removeCartItem(key) {
        if (
            confirm("Are you sure you want to remove this item from your cart?")
        ) {
            performRemove(key);
        }
    }

    function performRemove(key) {
        fetch(`/cart/remove/${key}`, {
            method: "DELETE",
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
                    // Remove item from DOM
                    const cartItem = document.querySelector(
                        `.cart-item[data-key="${key}"]`
                    );
                    if (cartItem) {
                        cartItem.style.transition = "opacity 0.3s";
                        cartItem.style.opacity = "0";
                        setTimeout(() => {
                            cartItem.remove();
                            // Check if cart is empty
                            const remainingItems =
                                document.querySelectorAll(".cart-item");
                            if (remainingItems.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }

                    // Update cart count in header
                    updateCartCount();

                    showToast({
                        icon: "success",
                        title: "Removed!",
                        text: data.message || "Item removed from cart.",
                        timer: 1500,
                    });
                } else {
                    showToast({
                        icon: "error",
                        title: "Error",
                        text:
                            data.message || "Failed to remove item from cart.",
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showToast({
                    icon: "error",
                    title: "Error",
                    text: "There was an error removing the item from cart.",
                });
            });
    }

    // Function to update cart count in header
    function updateCartCount() {
        fetch("/cart/count", {
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
