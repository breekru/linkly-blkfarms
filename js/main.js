// Add category
document.getElementById("add-category-btn").onclick = () => {
    const title = document.getElementById("new-cat-title").value;
    if (!title.trim()) return;

    fetch("add_category.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "title=" + encodeURIComponent(title)
    }).then(() => location.reload());
};

// Add link
document.querySelectorAll(".add-link-button").forEach(btn => {
    btn.onclick = () => {
        const cat = btn.dataset.cat;
        const label = document.querySelector(`.label-input[data-cat="${cat}"]`).value;
        const url   = document.querySelector(`.url-input[data-cat="${cat}"]`).value;

        if (!label.trim() || !url.trim()) return;

        fetch("add_link.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `cat=${cat}&label=${encodeURIComponent(label)}&url=${encodeURIComponent(url)}`
        }).then(() => location.reload());
    };
});

// Delete link
document.querySelectorAll(".delete-link").forEach(btn => {
    btn.onclick = () => {
        fetch("delete_link.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `cat=${btn.dataset.cat}&index=${btn.dataset.index}`
        }).then(() => location.reload());
    };
});

// Delete category
document.querySelectorAll(".delete-cat").forEach(btn => {
    btn.onclick = () => {
        fetch("delete_category.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: `index=${btn.dataset.index}`
        }).then(() => location.reload());
    };
});
