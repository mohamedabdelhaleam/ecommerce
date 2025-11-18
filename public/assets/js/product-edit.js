// Product Edit Page JavaScript
(function () {
    "use strict";

    // Configuration - will be set from blade template
    let config = {
        csrfToken: null,
        colors: [],
        sizes: [],
        productId: null,
        existingVariants: [],
        existingImages: [],
        storageUrl: "",
        updateRoute: "",
        variantsRoute: "",
        imagesRoute: "",
        variantsDeleteRoute: "",
        imagesDeleteRoute: "",
        redirectRoute: "",
    };

    // State
    let currentStep = 1;
    let variantCount = 0;
    let savedColors = [];

    // Initialize configuration from data attributes
    function initConfig() {
        const scriptTag = document.querySelector(
            "script[data-product-edit-config]"
        );
        if (scriptTag) {
            const data = JSON.parse(scriptTag.textContent);
            Object.assign(config, data);
        }
    }

    // Step Navigation Functions
    function updateStepIndicator(step) {
        const steps = document.querySelectorAll(".dm-steps__item");
        steps.forEach((item, index) => {
            item.classList.remove("active", "finished");
            const icon = item.querySelector(".dm-steps__icon");
            const stepNum = index + 1;

            if (stepNum < step) {
                item.classList.add("finished");
                icon.innerHTML = '<i class="la la-check"></i>';
            } else if (stepNum === step) {
                item.classList.add("active");
                icon.innerHTML = `<span class="dm-steps__count">${stepNum}</span>`;
            } else {
                icon.innerHTML = `<span class="dm-steps__count">${stepNum}</span>`;
            }
        });
    }

    function showStep(step) {
        document.querySelectorAll(".step-content").forEach((el) => {
            el.style.display = "none";
        });

        document.getElementById(`step${step}`).style.display = "block";
        currentStep = step;
        updateStepIndicator(step);

        if (step === 2 && variantCount === 0) {
            loadExistingVariants();
        }
        if (step === 3) {
            loadImagesStep();
        }
    }

    window.goToStep = function (step) {
        showStep(step);
    };

    // Step 1: Update Product
    function initStep1Form() {
        const form = document.getElementById("step1Form");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<i class="uil uil-spinner uil-spin"></i> Saving...';

            fetch(config.updateRoute, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-HTTP-Method-Override": "PUT",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((err) => {
                            let errorMsg = "Server error";
                            if (err.message) {
                                errorMsg = err.message;
                            } else if (err.errors) {
                                const errors = Object.values(err.errors).flat();
                                errorMsg = errors.join("\n");
                            }
                            throw new Error(errorMsg);
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    showStep(2);
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Error: " + error.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        });
    }

    // Step 2: Load Existing Variants
    function loadExistingVariants() {
        const container = document.getElementById("variantsContainer");
        if (!container) return;

        container.innerHTML = "";
        variantCount = 0;

        config.existingVariants.forEach((variant) => {
            addVariantRow(
                variant.color_id || "",
                variant.size_id || "",
                variant.price || "",
                variant.stock || "",
                variant.id
            );
        });

        savedColors = [];
        config.existingVariants.forEach((variant) => {
            if (variant.color_id && variant.color) {
                const color = config.colors.find(
                    (c) => c.id == variant.color_id
                );
                if (color && !savedColors.find((c) => c.id == color.id)) {
                    savedColors.push(color);
                }
            }
        });
    }

    // Step 2: Variants Management
    function addVariantRow(
        colorId = "",
        sizeId = "",
        price = "",
        stock = "",
        variantId = null
    ) {
        const container = document.getElementById("variantsContainer");
        if (!container) return;

        const variantHtml = `
            <div class="card mb-3 variant-row" data-variant-index="${variantCount}" data-variant-id="${
            variantId || ""
        }">
                <div class="card-body">
                    <div class="row align-items-end">
                        ${
                            variantId
                                ? `<input type="hidden" name="variants[${variantCount}][id]" value="${variantId}">`
                                : ""
                        }
                        <div class="col-md-3">
                            <label class="form-label">Color</label>
                            <select class="form-control variant-color" name="variants[${variantCount}][color_id]">
                                <option value="">None</option>
                                ${config.colors
                                    .map(
                                        (color) =>
                                            `<option value="${color.id}" ${
                                                colorId == color.id
                                                    ? "selected"
                                                    : ""
                                            }>${color.name_en}</option>`
                                    )
                                    .join("")}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Size</label>
                            <select class="form-control variant-size" name="variants[${variantCount}][size_id]">
                                <option value="">None</option>
                                ${config.sizes
                                    .map(
                                        (size) =>
                                            `<option value="${size.id}" ${
                                                sizeId == size.id
                                                    ? "selected"
                                                    : ""
                                            }>${size.name_en}</option>`
                                    )
                                    .join("")}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control variant-price" name="variants[${variantCount}][price]" value="${price}" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Stock</label>
                            <input type="number" class="form-control variant-stock" name="variants[${variantCount}][stock]" value="${stock}" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-variant" ${
                                variantId
                                    ? `data-variant-id="${variantId}"`
                                    : ""
                            }>
                                <i class="uil uil-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML("beforeend", variantHtml);
        variantCount++;
    }

    function initVariantsManagement() {
        const addBtn = document.getElementById("addVariantBtn");
        if (addBtn) {
            addBtn.addEventListener("click", function () {
                addVariantRow();
            });
        }

        document.addEventListener("click", function (e) {
            if (e.target.closest(".remove-variant")) {
                const btn = e.target.closest(".remove-variant");
                const variantId = btn.getAttribute("data-variant-id");
                const row = e.target.closest(".variant-row");

                if (variantId) {
                    if (
                        confirm("Are you sure you want to delete this variant?")
                    ) {
                        fetch(
                            config.variantsDeleteRoute.replace(
                                ":id",
                                variantId
                            ),
                            {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": config.csrfToken,
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            }
                        )
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    row.remove();
                                } else {
                                    alert("Error: " + data.message);
                                }
                            })
                            .catch((error) => {
                                console.error("Error:", error);
                                alert("Error deleting variant");
                            });
                    }
                } else {
                    row.remove();
                }
            }
        });
    }

    // Step 2: Save Variants
    function initStep2Form() {
        const form = document.getElementById("step2Form");
        if (!form) return;

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<i class="uil uil-spinner uil-spin"></i> Saving...';

            fetch(config.variantsRoute, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((err) => {
                            let errorMsg = "Server error";
                            if (err.message) {
                                errorMsg = err.message;
                            } else if (err.errors) {
                                const errors = Object.values(err.errors).flat();
                                errorMsg = errors.join("\n");
                            }
                            throw new Error(errorMsg);
                        });
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success || data.message) {
                        const variantRows =
                            document.querySelectorAll(".variant-row");
                        savedColors = [];
                        variantRows.forEach((row) => {
                            const colorSelect =
                                row.querySelector(".variant-color");
                            const colorId = colorSelect.value;
                            if (colorId) {
                                const color = config.colors.find(
                                    (c) => c.id == colorId
                                );
                                if (
                                    color &&
                                    !savedColors.find((c) => c.id == color.id)
                                ) {
                                    savedColors.push(color);
                                }
                            }
                        });
                        showStep(3);
                    } else {
                        alert(
                            "Error: " +
                                (data.message || "Failed to save variants")
                        );
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Error: " + error.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        });
    }

    // Helper function to create image HTML
    function createImageHtml(img, isExisting = false) {
        const imgPath = img.image
            ? config.storageUrl + "/" + img.image
            : "https://placehold.co/100";
        const deleteBtn = isExisting
            ? `
            <button type="button" class="btn btn-sm btn-danger mt-1 delete-existing-image" data-image-id="${img.id}">
                <i class="uil uil-trash"></i>
            </button>
        `
            : "";
        return `
            <div class="col-md-2 mb-2">
                <img src="${imgPath}" alt="Product Image" class="img-fluid rounded product-image-thumbnail">
                ${deleteBtn}
            </div>
        `;
    }

    // Helper function to attach delete handlers
    function attachDeleteHandlers() {
        document.querySelectorAll(".delete-existing-image").forEach((btn) => {
            btn.addEventListener("click", function () {
                const imageId = this.getAttribute("data-image-id");
                if (confirm("Are you sure you want to delete this image?")) {
                    fetch(config.imagesDeleteRoute.replace(":id", imageId), {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": config.csrfToken,
                            "X-Requested-With": "XMLHttpRequest",
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                this.closest(".col-md-2").remove();
                            } else {
                                alert("Error: " + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert("Error deleting image");
                        });
                }
            });
        });
    }

    // Step 3: Load Images Step
    function loadImagesStep() {
        const colorsDisplay = document.getElementById("productColorsDisplay");
        const noColorsMsg = document.getElementById("noColorsMessage");
        const imagesContainer = document.getElementById("imagesContainer");

        if (savedColors.length > 0) {
            if (colorsDisplay) {
                colorsDisplay.innerHTML = savedColors
                    .map(
                        (color) =>
                            `<span class="badge bg-primary">${color.name_en}</span>`
                    )
                    .join("");
            }
            if (noColorsMsg) {
                noColorsMsg.style.display = "none";
            }

            if (imagesContainer) {
                imagesContainer.innerHTML = savedColors
                    .map((color) => {
                        const colorImages = config.existingImages.filter(
                            (img) => img.color_id == color.id
                        );
                        const imagesHtml = colorImages
                            .map((img) => createImageHtml(img, true))
                            .join("");

                        return `
                        <div class="card mb-3 color-image-section" data-color-id="${color.id}">
                            <div class="card-header">
                                <h6 class="mb-0">Images for: ${color.name_en}</h6>
                            </div>
                            <div class="card-body">
                                <form class="color-image-form" data-color-id="${color.id}">
                                    <input type="hidden" name="_token" value="${config.csrfToken}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Image File</label>
                                                <input type="file" class="form-control image-file" name="image" accept="image/*" multiple>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Order</label>
                                                <input type="number" class="form-control image-order" name="order" value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <div class="checkbox-theme-default custom-checkbox">
                                                    <input class="checkbox" type="checkbox" name="is_primary" value="1" class="image-primary">
                                                    <label>
                                                        <span class="checkbox-text">Primary</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="uploaded-images-${color.id} mt-3 row">
                                    ${imagesHtml}
                                </div>
                            </div>
                        </div>
                    `;
                    })
                    .join("");
            }
        } else {
            if (colorsDisplay) colorsDisplay.innerHTML = "";
            if (noColorsMsg) noColorsMsg.style.display = "block";
        }

        // Load general images (no color)
        const generalImages = config.existingImages.filter(
            (img) => !img.color_id || img.color_id === null
        );
        const generalContainer = document.querySelector(
            ".uploaded-images-general"
        );
        if (generalContainer) {
            if (generalImages.length > 0) {
                generalContainer.innerHTML = generalImages
                    .map((img) => createImageHtml(img, true))
                    .join("");
            } else {
                generalContainer.innerHTML = "";
            }
        }

        attachDeleteHandlers();
    }

    // Complete Product Update
    function initCompleteButton() {
        const completeBtn = document.getElementById("completeBtn");
        if (!completeBtn) return;

        completeBtn.addEventListener("click", async function () {
            const originalText = completeBtn.innerHTML;
            completeBtn.disabled = true;
            completeBtn.innerHTML =
                '<i class="uil uil-spinner uil-spin"></i> Uploading Images...';

            try {
                const allImageForms =
                    document.querySelectorAll(".color-image-form");
                let uploadPromises = [];

                for (const form of allImageForms) {
                    const colorId = form.getAttribute("data-color-id");
                    const fileInput = form.querySelector(".image-file");
                    const orderInput = form.querySelector(".image-order");
                    const isPrimary =
                        form.querySelector(".image-primary")?.checked || false;

                    const files = fileInput.files;
                    if (files.length > 0) {
                        Array.from(files).forEach((file, index) => {
                            const formData = new FormData();
                            formData.append("image", file);
                            formData.append(
                                "color_id",
                                colorId === "general" ? "" : colorId
                            );
                            formData.append(
                                "order",
                                parseInt(orderInput?.value || 0) + index
                            );
                            formData.append(
                                "is_primary",
                                index === 0 && isPrimary ? 1 : 0
                            );
                            formData.append("_token", config.csrfToken);

                            uploadPromises.push(
                                fetch(config.imagesRoute, {
                                    method: "POST",
                                    body: formData,
                                    headers: {
                                        "X-Requested-With": "XMLHttpRequest",
                                    },
                                })
                                    .then((response) => response.json())
                                    .then((data) => {
                                        if (data.success) {
                                            const container =
                                                document.querySelector(
                                                    `.uploaded-images-${colorId}`
                                                );
                                            if (container) {
                                                const imageHtml =
                                                    createImageHtml(
                                                        {
                                                            image: data.image
                                                                .url,
                                                            id: data.image.id,
                                                        },
                                                        true
                                                    );
                                                container.insertAdjacentHTML(
                                                    "beforeend",
                                                    imageHtml
                                                );
                                                attachDeleteHandlers();
                                            }
                                        } else {
                                            throw new Error(
                                                "Error uploading image: " +
                                                    (data.message ||
                                                        "Unknown error")
                                            );
                                        }
                                    })
                            );
                        });
                    }
                }

                if (uploadPromises.length > 0) {
                    await Promise.all(uploadPromises);
                }

                window.location.href = config.redirectRoute;
            } catch (error) {
                console.error("Error:", error);
                alert("Error uploading images: " + error.message);
                completeBtn.disabled = false;
                completeBtn.innerHTML = originalText;
            }
        });
    }

    // Image Preview
    window.previewImage = function (input) {
        const preview = document.getElementById("imagePreview");
        if (preview && input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // Initialize image preview handler
    function initImagePreview() {
        const imageInput = document.getElementById("image");
        if (imageInput) {
            imageInput.addEventListener("change", function () {
                previewImage(this);
            });
        }
    }

    // Auto-generate slug
    function initSlugGeneration() {
        const nameEn = document.getElementById("name_en");
        const nameAr = document.getElementById("name_ar");
        const slugInput = document.getElementById("slug");

        if (nameEn && slugInput) {
            nameEn.addEventListener("blur", function () {
                if (!slugInput.value && this.value) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, "-")
                        .replace(/^-|-$/g, "");
                }
            });
        }

        if (nameAr && slugInput) {
            nameAr.addEventListener("blur", function () {
                const nameEnValue = nameEn ? nameEn.value : "";
                if (!slugInput.value && !nameEnValue && this.value) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, "-")
                        .replace(/^-|-$/g, "");
                }
            });
        }
    }

    // Initialize on DOM ready
    document.addEventListener("DOMContentLoaded", function () {
        initConfig();
        updateStepIndicator(1);
        initStep1Form();
        initVariantsManagement();
        initStep2Form();
        initCompleteButton();
        initSlugGeneration();
        initImagePreview();

        // Load general images on page load if they exist
        const generalImages = config.existingImages.filter(
            (img) => !img.color_id || img.color_id === null
        );
        const generalContainer = document.querySelector(
            ".uploaded-images-general"
        );
        if (generalContainer && generalImages.length > 0) {
            generalContainer.innerHTML = generalImages
                .map((img) => createImageHtml(img, true))
                .join("");
            attachDeleteHandlers();
        }
    });
})();
