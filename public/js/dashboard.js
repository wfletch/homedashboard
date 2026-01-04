document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editCompletedTaskModal");
    const content = document.getElementById("editCompletedTaskModalContent");

    content.addEventListener("htmx:afterSwap", () => {
        if (!modal.open) {
            modal.showModal();
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editCounterModal");
    const content = document.getElementById("editCounterModalContent");

    content.addEventListener("htmx:afterSwap", () => {
        if (!modal.open) {
            modal.showModal();
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editSleepTimesModal");
    const content = document.getElementById("editSleepTimesModalContent");

    content.addEventListener("htmx:afterSwap", () => {
        if (!modal.open) {
            modal.showModal();
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addNewSleepTimesModal");
    const content = document.getElementById("addNewSleepTimesModalContent");

    content.addEventListener("htmx:afterSwap", () => {
        if (!modal.open) {
            modal.showModal();
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme") || "dark";
    document.documentElement.setAttribute("data-theme", savedTheme);

    const toggle = document.querySelector('[type="checkbox"]');
    if (toggle) {
        toggle.checked = savedTheme === "dark";

        toggle.addEventListener("change", (e) => {
            const theme = e.target.checked ? "dark" : "light";
            document.documentElement.setAttribute("data-theme", theme);
            localStorage.setItem("theme", theme);
        });
    }
});

