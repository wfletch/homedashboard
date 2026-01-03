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

document.addEventListener('DOMContentLoaded', () => {
    if (window.__TASK_ENDED__) {
        confetti({
            particleCount: 80,
            angle: 60,
            spread: 55,
            origin: { x: 0 },
            colors: ['#fbcfe8', '#f9a8d4', '#ec4899']
        });
        confetti({
            particleCount: 80,
            angle: 120,
            spread: 55,
            origin: { x: 1 },
            colors: ['#fbcfe8', '#f9a8d4', '#ec4899']
        });
    }
})
