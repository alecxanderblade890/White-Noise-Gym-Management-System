function openModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
}
function openEditDailyLogModal(logId) {
    const modal = document.getElementById(`editDailyLogModal-${logId}`);
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeEditDailyLogModal(logId) {
    const modal = document.getElementById(`editDailyLogModal-${logId}`);
    if (modal) {
        modal.classList.add('hidden');
        // Reset the form when closing the modal
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}
function openDeleteModal() {
    document.getElementById('deleteMemberModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteMemberModal').classList.add('hidden');
}
// Only add event listeners if the elements exist
const editProfileBtn = document.querySelector('[data-edit-profile]');
const deleteMemberBtn = document.querySelector('[data-delete-member]');

if (editProfileBtn) {
    editProfileBtn.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });
}

if (deleteMemberBtn) {
    deleteMemberBtn.addEventListener('click', function(event) {
        event.preventDefault();
        openDeleteModal();
    });
}

window.openModal = openModal;
window.closeModal = closeModal;
window.openEditDailyLogModal = openEditDailyLogModal;
window.closeEditDailyLogModal = closeEditDailyLogModal;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;
