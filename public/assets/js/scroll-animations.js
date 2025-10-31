// Scroll animations using Intersection Observer API
export function initScrollAnimations() {
    // Check if observer is already initialized
    if (window.scrollAnimationsInitialized) {
        return;
    }

    window.scrollAnimationsInitialized = true;

    // Animation options
    const defaultOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    // Fade in animation
    const fadeInObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-fade-in");
                entry.target.classList.remove("opacity-0");
                fadeInObserver.unobserve(entry.target);
            }
        });
    }, defaultOptions);

    // Slide in from left
    const slideLeftObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-slide-in-left");
                entry.target.classList.remove("opacity-0", "-translate-x-8");
                slideLeftObserver.unobserve(entry.target);
            }
        });
    }, defaultOptions);

    // Slide in from right
    const slideRightObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-slide-in-right");
                entry.target.classList.remove("opacity-0", "translate-x-8");
                slideRightObserver.unobserve(entry.target);
            }
        });
    }, defaultOptions);

    // Slide in from bottom
    const slideUpObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-slide-in-up");
                entry.target.classList.remove("opacity-0", "translate-y-8");
                slideUpObserver.unobserve(entry.target);
            }
        });
    }, defaultOptions);

    // Scale in
    const scaleObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate-scale-in");
                entry.target.classList.remove("opacity-0", "scale-90");
                scaleObserver.unobserve(entry.target);
            }
        });
    }, defaultOptions);

    // Stagger animation for children (grid items, cards, etc.)
    const staggerObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
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
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
}

// Auto-initialize if script is loaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initScrollAnimations);
} else {
    initScrollAnimations();
}
