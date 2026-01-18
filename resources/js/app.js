import './bootstrap';

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()


import Swal from 'sweetalert2'

window.Swal = Swal.mixin({
    customClass: {
        popup: 'bg-base-100 text-base-content rounded-box shadow-xl',
        title: 'text-lg font-bold',
        htmlContainer: 'text-sm',
        confirmButton: 'btn btn-error',
        cancelButton: 'btn btn-ghost'
    },
    buttonsStyling: true
})

import confetti from 'canvas-confetti'

window.confetti = confetti

function oklchToRgb(l, c, h) {
    // Convert OKLCH → OKLab
    const a = c * Math.cos(h * Math.PI / 180);
    const b = c * Math.sin(h * Math.PI / 180);

    // OKLab → linear RGB
    let L = l + 0.3963377774 * a + 0.2158037573 * b;
    let M = l - 0.1055613458 * a - 0.0638541728 * b;
    let S = l - 0.0894841775 * a - 1.2914855480 * b;

    L = L ** 3;
    M = M ** 3;
    S = S ** 3;

    let r = +4.0767416621 * L - 3.3077115913 * M + 0.2309699292 * S;
    let g = -1.2684380046 * L + 2.6097574011 * M - 0.3413193965 * S;
    let b2 = -0.0041960863 * L - 0.7034186147 * M + 1.7076147010 * S;

    // Gamma correction
    r = r <= 0.0031308 ? 12.92 * r : 1.055 * Math.pow(r, 1 / 2.4) - 0.055;
    g = g <= 0.0031308 ? 12.92 * g : 1.055 * Math.pow(g, 1 / 2.4) - 0.055;
    b2 = b2 <= 0.0031308 ? 12.92 * b2 : 1.055 * Math.pow(b2, 1 / 2.4) - 0.055;

    return `rgb(${Math.round(r * 255)}, ${Math.round(g * 255)}, ${Math.round(b2 * 255)})`;
}
function randomVibrantColor() {
    const lightness = 0.75;

    // Wider chroma band (still vibrant)
    const chroma = 0.15 + Math.random() * 0.25;

    // Micro hue jitter (prevents RGB collapse)
    const hue = 330 + (Math.random() * 8 - 4);

    return oklchToRgb(lightness, chroma, hue);
}


document.addEventListener('DOMContentLoaded', () => {
    if (window.__TASK_ENDED__) {
        const colors = Array.from({ length: 8 }, randomVibrantColor);

        confetti({
            particleCount: 80,
            angle: 60,
            spread: 55,
            origin: { x: 0 },
            colors
        });

        confetti({
            particleCount: 80,
            angle: 120,
            spread: 55,
            origin: { x: 1 },
            colors
        });
    }
});
