document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".checkboxSquare");
    const editBtn = document.querySelector(".editButton");
    const deleteBtn = document.querySelector(".deleteButton");

    // check if admin is connected
    if (checkboxes.length === 0 || !editBtn || !deleteBtn) return;

    // toggle visibility
    function toggleButtons() {
        const hasChecked = Array.from(checkboxes).some(cb => cb.checked);

        editBtn.disabled = !hasChecked;
        deleteBtn.disabled = !hasChecked;
    }

    //listen to each checkbox
    checkboxes.forEach(cb => {
        cb.addEventListener("change", toggleButtons);
    });
});