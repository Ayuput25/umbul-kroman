import "./bootstrap";

import * as bootstrap from "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

/*
|--------------------------------------------------------------------------
| GLOBAL BOOTSTRAP
|--------------------------------------------------------------------------
|
| Beberapa halaman Blade menggunakan bootstrap.Modal secara langsung.
| Kita expose bootstrap ke window agar semuanya tetap bisa digunakan.
|
*/

window.bootstrap = bootstrap;

/*
|--------------------------------------------------------------------------
| DOM READY
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | NAVBAR SCROLL
    |--------------------------------------------------------------------------
    */

    const navbar = document.querySelector(".site-navbar");

    const handleNavbar = () => {
        if (!navbar) {
            return;
        }

        if (window.scrollY > 20) {
            navbar.classList.add("navbar-scrolled");
        } else {
            navbar.classList.remove("navbar-scrolled");
        }
    };

    handleNavbar();

    window.addEventListener("scroll", handleNavbar, {
        passive: true,
    });

    /*
    |--------------------------------------------------------------------------
    | REVEAL ANIMATION
    |--------------------------------------------------------------------------
    */

    const revealElements = document.querySelectorAll(".reveal");

    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver(
            (entries, currentObserver) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add("reveal-visible");

                    currentObserver.unobserve(entry.target);
                });
            },
            {
                threshold: 0.12,
            },
        );

        revealElements.forEach((element) => {
            observer.observe(element);
        });
    } else {
        revealElements.forEach((element) => {
            element.classList.add("reveal-visible");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | MOBILE NAVBAR
    |--------------------------------------------------------------------------
    */

    const navbarCollapse = document.getElementById("navbarMain");

    if (navbarCollapse) {
        const menuLinks = navbarCollapse.querySelectorAll(".nav-link");

        menuLinks.forEach((link) => {
            link.addEventListener("click", () => {
                if (window.innerWidth >= 992) {
                    return;
                }

                const instance = bootstrap.Collapse.getInstance(navbarCollapse);

                if (instance) {
                    instance.hide();
                }
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | BACK TO TOP
    |--------------------------------------------------------------------------
    */

    const backToTop = document.getElementById("backToTop");

    if (backToTop) {
        const updateBackToTop = () => {
            if (window.scrollY > 500) {
                backToTop.classList.add("show");
            } else {
                backToTop.classList.remove("show");
            }
        };

        updateBackToTop();

        window.addEventListener("scroll", updateBackToTop, {
            passive: true,
        });

        backToTop.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN TOAST
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".admin-toast").forEach((toastElement) => {
        const toast = new bootstrap.Toast(toastElement, {
            delay: 4500,
        });

        toast.show();
    });

    /*
    |--------------------------------------------------------------------------
    | IMAGE PREVIEW
    |--------------------------------------------------------------------------
    |
    | Cara pakai:
    |
    | <input
    |   type="file"
    |   data-image-preview="#previewId"
    | >
    |
    | <img id="previewId">
    |
    */

    const imageInputs = document.querySelectorAll("[data-image-preview]");

    imageInputs.forEach((input) => {
        input.addEventListener("change", function () {
            const targetSelector = this.dataset.imagePreview;

            if (!targetSelector) {
                return;
            }

            const preview = document.querySelector(targetSelector);

            if (!preview) {
                return;
            }

            const file = this.files?.[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith("image/")) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                preview.src = event.target.result;

                preview.classList.remove("d-none");

                const emptyState = document.querySelector(
                    preview.dataset.emptyTarget ?? "",
                );

                if (emptyState) {
                    emptyState.classList.add("d-none");
                }
            };

            reader.readAsDataURL(file);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | FILE NAME
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll("[data-file-name-target]").forEach((input) => {
        input.addEventListener("change", function () {
            const target = document.querySelector(this.dataset.fileNameTarget);

            if (!target) {
                return;
            }

            target.textContent = this.files?.[0]?.name ?? "";
        });
    });
});
