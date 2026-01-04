const filterBtns = document.querySelectorAll(".filter-btn");
const courseCards = document.querySelectorAll(".course-card");

filterBtns.forEach((btn) => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();

    filterBtns.forEach((b) => b.classList.remove("active"));

    this.classList.add("active");

    const filter = this.getAttribute("href").replace("#", "");

    courseCards.forEach((card) => {
      if (filter === "all" || card.getAttribute("data-level") === filter) {
        card.classList.remove("hidden");
      } else {
        card.classList.add("hidden");
      }
    });
  });
});

function toggleMenu() {
  const nav = document.getElementById("mainNav");
  const overlay = document.getElementById("overlay");
  const btn = document.querySelector(".mobile-menu-btn");

  nav.classList.toggle("active");
  overlay.classList.toggle("active");

  // Change icon
  const icon = btn.querySelector("i");
  if (nav.classList.contains("active")) {
    icon.className = "fas fa-times";
  } else {
    icon.className = "fas fa-bars";
  }
}

// Close menu when clicking on a link
document.querySelectorAll("nav a").forEach((link) => {
  link.addEventListener("click", function () {
    if (window.innerWidth <= 900) {
      toggleMenu();
    }
  });
});

// Handle window resize
window.addEventListener("resize", function () {
  const nav = document.getElementById("mainNav");
  const overlay = document.getElementById("overlay");
  const btn = document.querySelector(".mobile-menu-btn");
  const icon = btn.querySelector("i");

  if (window.innerWidth > 900) {
    nav.classList.remove("active");
    overlay.classList.remove("active");
    icon.className = "fas fa-bars";
  }
});

// slider

$(document).ready(function () {
  $(".banner-slider").slick({
    dots: true,
    infinite: true,
    speed: 900,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    fade: true,
    cssEase: "cubic-bezier(0.645, 0.045, 0.355, 1)",
    pauseOnHover: true,
    pauseOnFocus: true,
    arrows: true,
  });
});

let scrollBtn = document.getElementById("scrollTopBtn");

window.addEventListener("scroll", function () {
  if (window.scrollY > 300) {
    scrollBtn.classList.add("show");
  } else {
    scrollBtn.classList.remove("show");
  }
});

scrollBtn.addEventListener("click", function () {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});

const tabs = document.querySelectorAll(".tab");
const tabContents = document.querySelectorAll(".tab-content");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const targetTab = tab.getAttribute("data-tab");

    tabs.forEach((t) => t.classList.remove("active"));
    tabContents.forEach((content) => content.classList.remove("active"));

    tab.classList.add("active");
    document.getElementById(targetTab).classList.add("active");
  });
});
