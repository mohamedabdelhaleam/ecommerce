/**
 * Reusable AJAX Status Switcher Functionality
 * Works with status-switcher component
 */
(function () {
    "use strict";

    // Function to initialize status switchers
    function initializeStatusSwitchers() {
        // Remove existing event listeners by cloning elements
        document
            .querySelectorAll(".status-switcher-toggle")
            .forEach(function (toggle) {
                // Skip if already initialized
                if (toggle.hasAttribute("data-initialized")) {
                    return;
                }
                toggle.setAttribute("data-initialized", "true");
                toggle.addEventListener("change", function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const wrapper = this.closest(".status-switcher-wrapper");
                    const toggleUrl = wrapper.getAttribute("data-toggle-url");
                    const itemId = wrapper.getAttribute("data-item-id");
                    const itemType =
                        wrapper.getAttribute("data-item-type") || "item";
                    const csrfToken = wrapper.getAttribute("data-csrf-token");
                    const toggleSwitch = this;
                    const isChecked = toggleSwitch.checked;

                    // Disable toggle during request
                    toggleSwitch.disabled = true;

                    // Make AJAX request
                    fetch(toggleUrl, {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                            "X-Requested-With": "XMLHttpRequest",
                            Accept: "application/json",
                        },
                        body: JSON.stringify({
                            is_active: isChecked,
                        }),
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then((data) => {
                            if (data.success) {
                                // Show success notification
                                if (typeof Swal !== "undefined") {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Status Updated",
                                        text:
                                            data.message ||
                                            `${itemType} status has been updated.`,
                                        timer: 1500,
                                        showConfirmButton: false,
                                        toast: true,
                                        position: "top-end",
                                        customClass: {
                                            popup: "swal2-popup-custom",
                                        },
                                        didOpen: () => {
                                            // Ensure SweetAlert2 displays above header
                                            const swalContainer =
                                                document.querySelector(
                                                    ".swal2-container"
                                                );
                                            if (swalContainer) {
                                                swalContainer.style.zIndex =
                                                    "99999";
                                            }
                                        },
                                    });
                                }
                            } else {
                                // Revert toggle state
                                toggleSwitch.checked = !isChecked;

                                // Show error message
                                if (typeof Swal !== "undefined") {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error!",
                                        text:
                                            data.message ||
                                            "Failed to update status. Please try again.",
                                        customClass: {
                                            popup: "swal2-popup-custom",
                                        },
                                        didOpen: () => {
                                            // Ensure SweetAlert2 displays above header
                                            const swalContainer =
                                                document.querySelector(
                                                    ".swal2-container"
                                                );
                                            if (swalContainer) {
                                                swalContainer.style.zIndex =
                                                    "99999";
                                            }
                                        },
                                    });
                                }
                            }
                        })
                        .catch((error) => {
                            // Revert toggle state
                            toggleSwitch.checked = !isChecked;

                            // Show error message
                            if (typeof Swal !== "undefined") {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Failed to update status. Please try again.",
                                    customClass: {
                                        popup: "swal2-popup-custom",
                                    },
                                    didOpen: () => {
                                        // Ensure SweetAlert2 displays above header
                                        const swalContainer =
                                            document.querySelector(
                                                ".swal2-container"
                                            );
                                        if (swalContainer) {
                                            swalContainer.style.zIndex =
                                                "99999";
                                        }
                                    },
                                });
                            }
                        })
                        .finally(() => {
                            // Re-enable toggle
                            toggleSwitch.disabled = false;
                        });
                });
            });
    }

    // Initialize on page load
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initializeStatusSwitchers);
    } else {
        initializeStatusSwitchers();
    }

    // Expose function for re-initialization after AJAX updates
    window.reinitializeStatusSwitchers = initializeStatusSwitchers;
})();
