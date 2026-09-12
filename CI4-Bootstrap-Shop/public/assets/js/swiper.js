const swiper = new Swiper(".product-swiper", {
  slidesPerView: 1.5,
  spaceBetween: 20,
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  },
  breakpoints: {
    480: {
      slidesPerView: 2,
      spaceBetween: 15,
    },
    576: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 25,
    },
    992: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
    1200: {
      slidesPerView: 5,
      spaceBetween: 30,
    },
    1400: {
      slidesPerView: 6,
      spaceBetween: 30,
    },
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  speed: 600,
  effect: "slide",
  autoHeight: true,
  watchOverflow: true,
  grabCursor: true,
});

const mainSwiper = new Swiper("#mainCarousel", {
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
    pauseOnMouseEnter: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  speed: 600,
});

const brandSwiper = new Swiper(".brand-swiper", {
  slidesPerView: "auto",
  spaceBetween: 20,
  loop: true,
  freeMode: false,
  freeModeMomentum: false,
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
    pauseOnMouseEnter: false,
  },
  speed: 4000,
  allowTouchMove: false,
});

const popularCategoriesSwiper = new Swiper(".popular-categories-swiper", {
  slidesPerView: 1.2,
  spaceBetween: 20,
  loop: true,
  breakpoints: {
    480: {
      slidesPerView: 1,
      spaceBetween: 15,
    },
    576: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 25,
    },
    992: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    1200: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    1400: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
  },
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  speed: 600,
  effect: "slide",
  autoHeight: true,
  watchOverflow: true,
  grabCursor: true,
});
