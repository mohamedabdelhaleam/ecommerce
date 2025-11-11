/**
 * Reusable AJAX Delete Functionality
 * Works with SweetAlert2 for confirmation
 */
(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", function () {
        // Handle all AJAX delete buttons
        document
            .querySelectorAll(".ajax-delete-btn")
            .forEach(function (button) {
                button.addEventListener("click", function (e) {
                    e.preventDefault();

                    const deleteUrl = this.getAttribute("data-delete-url");
                    const itemId = this.getAttribute("data-item-id");
                    const itemName = this.getAttribute("data-item-name");
                    const itemType =
                        this.getAttribute("data-item-type") || "item";
                    const tableRowId = this.getAttribute("data-table-row-id");
                    const csrfToken = this.getAttribute("data-csrf-token");
                    const button = this;

                    // Show confirmation dialog
                    Swal.fire({
                        title: "Are you sure?",
                        text: `Do you want to delete "${itemName}"? This action cannot be undone!`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                        reverseButtons: true,
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return fetch(deleteUrl, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken,
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
                                .catch((error) => {
                                    Swal.showValidationMessage(
                                        `Request failed: ${error.message}`
                                    );
                                });
                        },
                        allowOutsideClick: () => !Swal.isLoading(),
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            const response = result.value;

                            if (response.success) {
                                // Remove the table row
                                if (tableRowId) {
                                    const row =
                                        document.getElementById(tableRowId);
                                    if (row) {
                                        row.style.transition = "opacity 0.3s";
                                        row.style.opacity = "0";
                                        setTimeout(() => {
                                            row.remove();

                                            // Check if table is empty
                                            const tbody = row.closest("tbody");
                                            if (
                                                tbody &&
                                                tbody.querySelectorAll("tr")
                                                    .length === 0
                                            ) {
                                                tbody.innerHTML =
                                                    '<tr><td colspan="100%" class="text-center">No items found.</td></tr>';
                                            }
                                        }, 300);
                                    }
                                }

                                // Show success message
                                Swal.fire({
                                    title: "Deleted!",
                                    text:
                                        response.message ||
                                        `${itemType} has been deleted.`,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            } else {
                                // Show error message
                                Swal.fire({
                                    title: "Error!",
                                    text:
                                        response.message ||
                                        "Failed to delete item. Please try again.",
                                    icon: "error",
                                });
                            }
                        }
                    });
                });
            });
    });
})();
