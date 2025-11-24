document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggle-category-form");
    const form = document.getElementById("category-form");
    const addBtn = document.getElementById("add-category-btn");
    const input = document.getElementById("new-category-title");
  
    toggleBtn.onclick = () => {
      form.classList.toggle("hidden");
      input.focus();
    };
  
    addBtn.onclick = () => {
      const title = input.value.trim();
      if (!title) return alert("Enter a category name");
      fetch("add_category.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "title=" + encodeURIComponent(title)
      }).then(() => location.reload());
    };
  
    // Modal
    let currentCat = null;
    const modal = document.getElementById("modal");
    const backdrop = document.getElementById("modal-backdrop");
    const labelInput = document.getElementById("modal-label");
    const urlInput = document.getElementById("modal-url");
    const saveBtn = document.getElementById("save-link");
    const cancelBtn = document.getElementById("cancel-modal");
  
    document.querySelectorAll(".add-link").forEach(btn => {
      btn.onclick = () => {
        currentCat = btn.dataset.cat;
        labelInput.value = "";
        urlInput.value = "";
        modal.classList.remove("hidden");
        backdrop.classList.remove("hidden");
        labelInput.focus();
      };
    });
  
    const closeModal = () => {
      modal.classList.add("hidden");
      backdrop.classList.add("hidden");
      currentCat = null;
    };
  
    cancelBtn.onclick = closeModal;
    backdrop.onclick = closeModal;
  
    saveBtn.onclick = () => {
      const label = labelInput.value.trim();
      const url = urlInput.value.trim();
      if (!label || !url) return alert("Enter both label and URL");
      fetch("add_link.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `cat=${currentCat}&label=${encodeURIComponent(label)}&url=${encodeURIComponent(url)}`
      }).then(() => location.reload());
    };
  
    // Delete link
    document.querySelectorAll(".delete-link").forEach(btn => {
      btn.onclick = () => {
        const cat = btn.dataset.cat;
        const link = btn.dataset.link;
        fetch("delete_link.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `cat=${cat}&link=${link}`
        }).then(() => location.reload());
      };
    });
  
    // Delete category
    document.querySelectorAll(".delete-cat").forEach(btn => {
      btn.onclick = () => {
        const cat = btn.dataset.cat;
        if (!confirm("Delete this category?")) return;
        fetch("delete_category.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `cat=${cat}`
        }).then(() => location.reload());
      };
    });
  });
  