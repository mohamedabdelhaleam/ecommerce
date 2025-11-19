<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#42b6f0",
                    "background-light": "#f6f7f8",
                    "background-dark": "#101c22",
                    "brand-peach": "#FFDAB9",
                    "brand-blue": "#A7D7F7",
                    "brand-mint": "#C1E1C1",
                    "brand-yellow": "#FFFACD",
                    "brand-offwhite": "#FDFBF6",
                    "brand-charcoal": "#4A4A4A",
                },
                fontFamily: {
                    "display": ["Plus Jakarta Sans", "Noto Sans", "sans-serif"]
                },
                borderRadius: {
                    "DEFAULT": "0.5rem",
                    "lg": "1rem",
                    "xl": "1.5rem",
                    "full": "9999px"
                },
            },
        },
    }
</script>
<script>
    // Scroll animations using Intersection Observer API
    (function() {
        // Check if observer is already initialized
        if (window.scrollAnimationsInitialized) {
            return;
        }

        window.scrollAnimationsInitialized = true;

        // Track if user has scrolled
        let hasScrolled = false;
        const initialViewportElements = new Set();

        // Check which elements are in viewport on page load
        const checkInitialViewport = () => {
            document.querySelectorAll('[data-animate]').forEach((el) => {
                const rect = el.getBoundingClientRect();
                const isInViewport = (
                    rect.top < window.innerHeight &&
                    rect.bottom > 0 &&
                    rect.left < window.innerWidth &&
                    rect.right > 0
                );
                if (isInViewport) {
                    initialViewportElements.add(el);
                }
            });
        };

        window.addEventListener('scroll', () => {
            hasScrolled = true;
        }, {
            once: true
        });

        // Animation options - require element to be visible before animating
        const defaultOptions = {
            threshold: 0.15,
            rootMargin: "0px 0px -80px 0px",
        };

        // Fade in animation
        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                // Only animate if user has scrolled OR element wasn't in initial viewport
                if (entry.isIntersecting && (hasScrolled || !initialViewportElements.has(entry
                        .target))) {
                    entry.target.classList.add("animate-fade-in");
                    entry.target.classList.remove("opacity-0");
                    fadeInObserver.unobserve(entry.target);
                }
            });
        }, defaultOptions);

        // Slide in from left
        const slideLeftObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && (hasScrolled || !initialViewportElements.has(entry
                        .target))) {
                    entry.target.classList.add("animate-slide-in-left");
                    entry.target.classList.remove("opacity-0", "-translate-x-8");
                    slideLeftObserver.unobserve(entry.target);
                }
            });
        }, defaultOptions);

        // Slide in from right
        const slideRightObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && (hasScrolled || !initialViewportElements.has(entry
                        .target))) {
                    entry.target.classList.add("animate-slide-in-right");
                    entry.target.classList.remove("opacity-0", "translate-x-8");
                    slideRightObserver.unobserve(entry.target);
                }
            });
        }, defaultOptions);

        // Slide in from bottom
        const slideUpObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && (hasScrolled || !initialViewportElements.has(entry
                        .target))) {
                    entry.target.classList.add("animate-slide-in-up");
                    entry.target.classList.remove("opacity-0", "translate-y-8");
                    slideUpObserver.unobserve(entry.target);
                }
            });
        }, defaultOptions);

        // Scale in
        const scaleObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && (hasScrolled || !initialViewportElements.has(entry
                        .target))) {
                    entry.target.classList.add("animate-scale-in");
                    entry.target.classList.remove("opacity-0", "scale-90");
                    scaleObserver.unobserve(entry.target);
                }
            });
        }, defaultOptions);

        // Stagger animation for children (grid items, cards, etc.)
        const staggerObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && (hasScrolled || !initialViewportElements.has(entry
                        .target))) {
                    const children = entry.target.querySelectorAll(
                        "[data-stagger-item]"
                    );
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.classList.add("animate-fade-in");
                            child.classList.remove("opacity-0");
                        }, index * 100);
                    });
                    staggerObserver.unobserve(entry.target);
                }
            });
        }, defaultOptions);

        // Initialize observers based on data attributes
        const init = () => {
            // Fade in
            document.querySelectorAll('[data-animate="fade-in"]').forEach((el) => {
                el.classList.add("opacity-0", "transition-all", "duration-700");
                fadeInObserver.observe(el);
            });

            // Slide in from left
            document
                .querySelectorAll('[data-animate="slide-left"]')
                .forEach((el) => {
                    el.classList.add(
                        "opacity-0",
                        "-translate-x-8",
                        "transition-all",
                        "duration-700"
                    );
                    slideLeftObserver.observe(el);
                });

            // Slide in from right
            document
                .querySelectorAll('[data-animate="slide-right"]')
                .forEach((el) => {
                    el.classList.add(
                        "opacity-0",
                        "translate-x-8",
                        "transition-all",
                        "duration-700"
                    );
                    slideRightObserver.observe(el);
                });

            // Slide in from bottom
            document.querySelectorAll('[data-animate="slide-up"]').forEach((el) => {
                el.classList.add(
                    "opacity-0",
                    "translate-y-8",
                    "transition-all",
                    "duration-700"
                );
                slideUpObserver.observe(el);
            });

            // Scale in
            document.querySelectorAll('[data-animate="scale"]').forEach((el) => {
                el.classList.add(
                    "opacity-0",
                    "scale-90",
                    "transition-all",
                    "duration-700"
                );
                scaleObserver.observe(el);
            });

            // Stagger animation - initialize children with opacity-0
            document.querySelectorAll('[data-animate="stagger"]').forEach((el) => {
                const children = el.querySelectorAll("[data-stagger-item]");
                children.forEach((child) => {
                    child.classList.add(
                        "opacity-0",
                        "transition-all",
                        "duration-700"
                    );
                });
                staggerObserver.observe(el);
            });
        };

        // Initialize when DOM is ready
        const startInit = () => {
            // First check initial viewport elements before setting up observers
            checkInitialViewport();
            // Then initialize observers
            init();
        };

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", startInit);
        } else {
            startInit();
        }
    })();
</script>
<script>
    // Page Loader Handler
    (function() {
        const pageLoader = document.getElementById('page-loader');

        if (!pageLoader) return;

        // Check if dark mode is active and apply to loader
        function checkDarkMode() {
            if (document.documentElement.classList.contains('dark') ||
                document.body.classList.contains('dark')) {
                pageLoader.classList.add('dark');
            }
        }

        // Hide loader when page is fully loaded
        function hideLoader() {
            if (pageLoader) {
                pageLoader.classList.add('hidden');
                // Remove from DOM after animation
                setTimeout(() => {
                    if (pageLoader && pageLoader.parentNode) {
                        pageLoader.remove();
                    }
                }, 500);
            }
        }

        // Check dark mode immediately
        checkDarkMode();

        // Watch for dark mode changes
        const observer = new MutationObserver(checkDarkMode);
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Hide loader when page is fully loaded
        if (document.readyState === 'complete') {
            // Page already loaded
            setTimeout(hideLoader, 300);
        } else {
            // Wait for all resources to load
            window.addEventListener('load', () => {
                setTimeout(hideLoader, 300);
            });
        }

        // Fallback: hide after maximum wait time
        setTimeout(hideLoader, 3000);
    })();
</script>
<!-- Toast Notification System -->
<style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .toast {
        background: white;
        border-radius: 8px;
        padding: 16px 20px;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        pointer-events: auto;
        animation: slideInRight 0.3s ease-out;
        border-left: 4px solid;
    }

    .toast.dark {
        background: #1f2937;
        color: #f3f4f6;
    }

    .toast.success {
        border-left-color: #10b981;
    }

    .toast.error {
        border-left-color: #ef4444;
    }

    .toast.info {
        border-left-color: #3b82f6;
    }

    .toast.warning {
        border-left-color: #f59e0b;
    }

    .toast-icon {
        font-size: 24px;
        flex-shrink: 0;
    }

    .toast.success .toast-icon {
        color: #10b981;
    }

    .toast.error .toast-icon {
        color: #ef4444;
    }

    .toast.info .toast-icon {
        color: #3b82f6;
    }

    .toast.warning .toast-icon {
        color: #f59e0b;
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .toast-message {
        font-size: 13px;
        color: #6b7280;
    }

    .toast.dark .toast-message {
        color: #9ca3af;
    }

    .toast-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #9ca3af;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .toast-close:hover {
        color: #374151;
    }

    .toast.dark .toast-close {
        color: #6b7280;
    }

    .toast.dark .toast-close:hover {
        color: #d1d5db;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .toast.hiding {
        animation: slideOutRight 0.3s ease-out forwards;
    }
</style>
<div id="toast-container" class="toast-container"></div>
<script>
    // Toast Notification System
    function showToast(options) {
        const {
            icon = 'success',
                title = '',
                text = '',
                timer = 3000,
                showConfirmButton = false
        } = options;

        const container = document.getElementById('toast-container');
        if (!container) {
            // Create container if it doesn't exist
            const newContainer = document.createElement('div');
            newContainer.id = 'toast-container';
            newContainer.className = 'toast-container';
            document.body.appendChild(newContainer);
        }

        const toast = document.createElement('div');
        const isDark = document.documentElement.classList.contains('dark') ||
            document.body.classList.contains('dark');

        toast.className = `toast ${icon} ${isDark ? 'dark' : ''}`;

        const iconMap = {
            success: 'check_circle',
            error: 'error',
            info: 'info',
            warning: 'warning'
        };

        const iconName = iconMap[icon] || 'info';

        toast.innerHTML = `
            <span class="material-symbols-outlined toast-icon">${iconName}</span>
            <div class="toast-content">
                ${title ? `<div class="toast-title">${title}</div>` : ''}
                ${text ? `<div class="toast-message">${text}</div>` : ''}
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">×</button>
        `;

        container.appendChild(toast);

        // Auto remove after timer
        if (timer > 0) {
            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }, timer);
        }

        return toast;
    }
</script>
