// File: public/javascripts/modules/swiper.js
import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.mjs';

export function initializeSwiper() {
    return new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
}

// File: public/javascripts/modules/cart.js
export function initializeCart() {
    const cartButton = document.querySelector('.btn-cart');
    if (cartButton) {
        cartButton.addEventListener('click', (e) => {
            e.preventDefault();
            // Add your cart logic here
        });
    }
}

// File: public/javascripts/app.js
import { initializeSwiper } from './modules/swiper.js';
import { initializeCart } from './modules/cart.js';

document.addEventListener('DOMContentLoaded', () => {
    initializeSwiper();
    initializeCart();
});