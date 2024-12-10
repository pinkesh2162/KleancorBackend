/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab support for dropdown menus.
 */

document.addEventListener("DOMContentLoaded", function () {
  // Function declarations
  function toggleMenuVisibility() {
    mobileMenu.classList.toggle("mobile-menu-visible");
  }

  function toggleFocus() {
    let element = this;
    while (!element.classList.contains("nav-menu")) {
      if (element.tagName.toLowerCase() === "li") {
        element.classList.toggle("focus");
      }
      element = element.parentNode;
    }
  }

  function handleOutsideClick(event) {
    if (!siteNavigation.contains(event.target)) {
      siteNavigation.classList.remove("toggled");
      button.setAttribute("aria-expanded", "false");
    }
  }

  function toggleAriaExpanded() {
    const isExpanded = siteNavigation.classList.toggle("toggled");
    button.setAttribute("aria-expanded", isExpanded ? "true" : "false");
  }

  // Mobile menu toggling
  const mobileMenuButton = document.querySelector(
    ".wpmart-pt-mobile-menu-button"
  );
  const mobileMenu = document.querySelector(".wpmart-pt-mobile-menu");

  mobileMenuButton.addEventListener("click", function () {
    mobileMenu.classList.toggle("wpmart-pt-mobile-menu-visible");
  });

  // Site navigation functionality
  const siteNavigation = document.getElementById("site-navigation");
  if (!siteNavigation) return;

  const button = siteNavigation.querySelector("button");
  const menu = siteNavigation.querySelector("ul");

  if (!button || !menu) return;

  // Add class if not present
  if (!menu.classList.contains("nav-menu")) {
    menu.classList.add("nav-menu");
  }

  button.addEventListener("click", toggleAriaExpanded);
  document.addEventListener("click", handleOutsideClick);

  // Toggle focus for menu links
  const links = menu.querySelectorAll("a");
  links.forEach((link) => {
    link.addEventListener("focus", toggleFocus, true);
    link.addEventListener("blur", toggleFocus, true);
  });
});
