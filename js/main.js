// ===== Add Category dropdown =====
const showAddCatBtn = document.getElementById("show-add-category");
const addCatPanel = document.getElementById("add-category-panel");
const addCatBtn = document.getElementById("add-category-btn");
const newCatTitleInput = document.getElementById("new-cat-title");

if (showAddCatBtn && addCatPanel && addCatBtn && newCatTitleInput) {
    showAddCatBtn.addEventListener("click", () => {
        addCatPanel.classList.toggle("hidden");
        if (!addCatPanel.classList.contains("hidden")) {
            newCatTitleInput.focus();
        }
    });

    addCatBtn.addEventListener("click", () => {
        const title = newCatTitleInput.value.trim();
        if (!title) {
            alert("Please enter a category name.");
            return;
        }

        fetch("add_category.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "title=" + encodeURIComponent(title)
        }).then(() => location.reload());
    });
}

// ===== Add Link modal =====
let currentCatForLink = null;

const modal = document.getElementById("add-link-modal");
const backdrop = document.getElementById("modal-backdrop");
const modalLabel = document.getElementById("modal-label");
const modalUrl = document.getElementById("modal-url");
const modalCancel = document.getElementById("modal-cancel");
const modalSave = document.getElementById("modal-save");

function openModalForCategory(catIndex) {
    currentCatForLink = catIndex;
    modalLabel.value = "";
    modalUrl.value = "";
    modal.classList.remove("hidden");
    backdrop.classList.remove("hidden");
    modalLabel.focus();
}

function closeModal() {
    modal.classList.add("hidden");
    backdrop.classList.add("hidden");
    currentCatForLink = null;
}

document.querySelectorAll(".add-link-icon").forEach(btn => {
    btn.addEventListener("click", () => {
        const cat = btn.getAttribute("data-cat");
        openModalForCategory(cat);
    });
});

if (modalCancel) {
    modalCancel.addEventListener("click", closeModal);
}
if (backdrop) {
    backdrop.addEventListener("click", closeModal);
}

if (modalSave) {
    modalSave.addEventListener("click", () => {
        if (currentCatForLink === null) return;

        const label = modalLabel.value.trim();
        const url = modalUrl.value.trim();

        if (!label || !url) {
            alert("Please enter both label and URL.");
            return;
        }

        fetch("add_link.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `cat=${encodeURIComponent(currentCatForLink)}&label=${encodeURIComponent(label)}&url=${encodeURIComponent(url)}`
        }).then(() => location.reload());
    });
}

// Optional: Enter key submits in modal
[modalLabel, modalUrl].forEach(input => {
    if (input) {
        input.addEventListener("keydown", e => {
            if (e.key === "Enter") {
                e.preventDefault();
                modalSave.click();
            }
        });
    }
});

// ===== Delete Link =====
document.querySelectorAll(".delete-link").forEach(btn => {
    btn.addEventListener("click", () => {
        const cat = btn.getAttribute("data-cat");
        const link = btn.getAttribute("data-link");

        fetch("delete_link.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `cat=${encodeURIComponent(cat)}&link=${encodeURIComponent(link)}`
        }).then(() => location.reload());
    });
});

// ===== Delete Category =====
document.querySelectorAll(".delete-cat").forEach(btn => {
    btn.addEventListener("click", () => {
        const cat = btn.getAttribute("data-cat");

        if (!confirm("Delete this category and all its links?")) return;

        fetch("delete_category.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `cat=${encodeURIComponent(cat)}`
        }).then(() => location.reload());
    });
});
