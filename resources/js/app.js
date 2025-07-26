import './bootstrap';

function openModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
}
function openDeleteModal() {
    document.getElementById('deleteMemberModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteMemberModal').classList.add('hidden');
}
window.openModal = openModal;
window.closeModal = closeModal;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;

document.querySelector('[data-edit-profile]').addEventListener('click', function(e) {
    e.preventDefault();
    openModal();
});

document.querySelector('[data-delete-member]').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default action
    openDeleteModal(); // Show the modal
});
