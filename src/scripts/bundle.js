import Swiper, { EffectCoverflow, Navigation } from "swiper";
import HystModal from "hystmodal";

// import.meta.glob(['../images/**', '../fonts/**'])

const rulesModal = new HystModal({
  linkAttributeName: "data-hystmodal",
  //settings (optional). see Configuration
});

const swiper = new Swiper(".mySwiper", {
  modules: [EffectCoverflow, Navigation],
  effect: "coverflow",
  speed: 500,
  loop: true,
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: "auto",
  coverflowEffect: {
    rotate: 0,
    stretch: 180,
    depth: 290,
    modifier: 1,
    slideShadows: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

const productSwiper = new Swiper(".productSwiper", {
  modules: [Navigation],
  speed: 500,
  loop: true,
  grabCursor: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

const headerLinks = document.querySelectorAll(".header a") || [];
headerLinks.forEach((headerLink) => {
  if (headerLink.hash) {
    headerLink.addEventListener("click", (e) => {
      e.preventDefault();

      let offset = document.querySelector(".header").offsetHeight;
      let top = 0;
      let left = 0;
      let target = document.querySelector(headerLink.hash);
      if (target) {
        top = target.offsetTop - offset;
      } else {
        window.location = `/${headerLink.hash}`;
      }

      window.scroll({
        top: top,
        left: 0,
        behavior: "smooth",
      });
    });
  }
});

const menuToggle = document.querySelector(".header-toggle");
const menuList = document.querySelector(".header-menu");
menuToggle.addEventListener("click", () => {
  if (menuList.classList.contains("_active")) {
    menuList.classList.remove("_active");
  } else {
    menuList.classList.add("_active");
  }
  if (menuToggle.classList.contains("_active")) {
    menuToggle.classList.remove("_active");
  } else {
    menuToggle.classList.add("_active");
  }
});

const langToggle = document.querySelector(".header-lang__button");
const langList = document.querySelector(".header-lang__list");
langToggle.addEventListener("click", () => {
  if (langList.classList.contains("_active")) {
    langList.classList.remove("_active");
  } else {
    langList.classList.add("_active");
  }
  if (langToggle.classList.contains("_active")) {
    langToggle.classList.remove("_active");
  } else {
    langToggle.classList.add("_active");
  }
});

const forms = document.querySelectorAll("[data-from]") || [];
forms.forEach((form) => {
  const messagesContainer = form.querySelector("[data-from-messages]") || form;

  let messages = new Set();

  const showMessage = (text, mode, delay) => {
    const el = document.createElement("div");
    el.classList.add("ui-form-message");
    el.classList.add("ui-form-message_" + mode);
    el.innerHTML = text;
    const close = document.createElement("button");
    close.classList.add("ui-form-message__close");
    close.addEventListener("click", (e) => {
      e.stopPropagation();
      messages.delete(el);
      el.parentNode.removeChild(el);
    });
    el.appendChild(close);
    messagesContainer.appendChild(el);

    messages.add(el);

    if (delay) {
      setTimeout(() => {
        messages.delete(el);
        el.parentNode.removeChild(el);
      }, delay);
    }
  };

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    for (let message of messages) {
      messages.delete(message);
      message.parentNode.removeChild(message);
    }

    try {
      const response = await fetch(form.action, {
        method: "POST",
        credentials: "include",
        body: new FormData(form),
      });
      const json = await response.json();
      if (json.success) {
        form.reset();
        showMessage(json.message, "success", 8000);
      } else {
        showMessage(json.message, "error");
      }
    } catch (e) {
      showMessage(e.name + ": " + e.message, "error");
    }
  });
});
