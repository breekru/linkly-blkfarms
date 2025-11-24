// js/main.js

document.addEventListener("DOMContentLoaded", () => {
    // === Add Category dropdown toggle ===
    const toggleAddCategoryBtn = document.getElementById("toggle-add-category");
    const addCategoryPanel = document.getElementById("add-category-panel");
    const addCategoryBtn = document.getElementById("add-category-btn");
    const newCategoryInput = document.getElementById("new-category-title");

    if (toggleAddCategoryBtn && addCategoryPanel) {
        toggleAddCategoryBtn.addEventListener("click", () => {
            addCategoryPanel.classList.toggle("hidden");
            if (!addCategoryPanel.classList.contains("hidden") && newCategoryInput) {
                newCategoryInput.focus();
            }
        });
    }

    if (addCategoryBtn && newCategoryInput) {
        addCategoryBtn.addEventListener("click", () => {
            const title = newCategoryInput.value.trim();
            if (!title) {
                alert("Please enter a category name.");
                return;
            }

            fetch("add_category.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "title=" + encodeURIComponent(title)
            }).then(() => {
                // Reload to see updated board
                window.location.reload();
            });
        });

        // Enter key submits add-category
        newCategoryInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                addCategoryBtn.click();
            }
        });
    }

    // === Add Link Modal ===
    let currentCatIndex = null;

    const modal = document.getElementById("add-link-modal");
    const backdrop = document.getElementById("modal-backdrop");
    const modalLabelInput = document.getElementById("modal-label-input");
    const modalUrlInput = document.getElementById("modal-url-input");
    const modalCancel = document.getElementById("modal-cancel");
    const modalSave = document.getElementById("modal-save");

    function openModal(catIndex) {
        currentCatIndex = catIndex;
        if (modal && backdrop) {
            modal.classList.remove("hidden");
            backdrop.classList.remove("hidden");
        }
        if (modalLabelInput) {
            modalLabelInput.value = "";
            modalLabelInput.focus();
        }
        if (modalUrlInput) {
            modalUrlInput.value = "";
        }
    }

    function closeModal() {
        currentCatIndex = null;
        if (modal && backdrop) {
            modal.classList.add("hidden");
            backdrop.classList.add("hidden");
        }
    }

    // Attach click handlers to each "+ link" icon
    document.querySelectorAll(".add-link-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const cat = btn.getAttribute("data-cat");
            if (cat === null) return;
            openModal(cat);
        });
    });

    if (modalCancel) {
        modalCancel.addEventListener("click", () => {
            closeModal();
        });
    }

    if (backdrop) {
        backdrop.addEventListener("click", () => {
            closeModal();
        });
    }

    if (modalSave && modalLabelInput && modalUrlInput) {
        modalSave.addEventListener("click", () => {
            if (currentCatIndex === null) return;

            const label = modalLabelInput.value.trim();
            const url = modalUrlInput.value.trim();

            if (!label || !url) {
                alert("Please enter both label and URL.");
                return;
            }

            fetch("add_link.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body:
                    "cat=" + encodeURIComponent(currentCatIndex) +
                    "&label=" + encodeURIComponent(label) +
                    "&url=" + encodeURIComponent(url)
            }).then(() => {
                window.location.reload();
            });
        });

        // Enter key support in modal
        [modalLabelInput, modalUrlInput].forEach(input => {
            input.addEventListener("keydown", (e) => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    modalSave.click();
                }
            });
        });
    }

    // === Delete Link ===
    document.querySelectorAll(".delete-link-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const cat = btn.getAttribute("data-cat");
            const link = btn.getAttribute("data-link");
            if (cat === null || link === null) return;

            fetch("delete_link.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body:
                    "cat=" + encodeURIComponent(cat) +
                    "&link=" + encodeURIComponent(link)
            }).then(() => {
                window.location.reload();
            });
        });
    });

    // === Delete Category ===
    document.querySelectorAll(".delete-category-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const cat = btn.getAttribute("data-cat");
            if (cat === null) return;

            if (!confirm("Delete this category and all its links?")) return;

            fetch("delete_category.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "cat=" + encodeURIComponent(cat)
            }).then(() => {
                window.location.reload();
            });
        });
    });
});
