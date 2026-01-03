console.log("Dashboard JS loaded");

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("addBacklogEntryModal");
    const openBtn = document.getElementById("openBacklogEntryModalBtn");
    const closeBtn = document.getElementById("closeBacklogEntryModalBtn");

    openBtn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});


document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('editCompletedTaskModal')
      .addEventListener('htmx:afterSwap', function () {
          console.log('Target swapped');
          this.classList.remove('hidden');
          this.classList.add('visible');
      });
});

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('editCounterModal')
      .addEventListener('htmx:afterSwap', function () {
          console.log('Target swapped');
          this.classList.remove('hidden');
          this.classList.add('visible');
      });
});

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("startTaskModal");
    const openBtn = document.getElementById("openStartTaskModalBtn");
    const closeBtn = document.getElementById("closeStartTaskModalBtn");

    openBtn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
