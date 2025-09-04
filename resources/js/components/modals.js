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

function openEditDayPassModal(logId) {
    const modal = document.getElementById(`editDayPassModal-${logId}`);
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

function closeEditDayPassModal(logId) {
    const modal = document.getElementById(`editDayPassModal-${logId}`);
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
function openDayPassModal() {
    if (document.getElementById('dayPassModal')) {
        document.getElementById('dayPassModal').classList.remove('hidden');
    }
    else{
        console.log("NOT FOUND")
    }
}
function closeDayPassModal() {
    document.getElementById('dayPassModal').classList.add('hidden');
}
// Only add event listeners if the elements exist
const editProfileBtn = document.querySelector('[data-edit-profile]');
const deleteMemberBtn = document.querySelector('[data-delete-member]');
const dayPassBtn = document.getElementById('day-pass-btn');

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

if (dayPassBtn) {
    dayPassBtn.addEventListener('click', function(event) {
        event.preventDefault();
        const timeIn = document.getElementById('time_in_day_pass');
        timeIn.value = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
        openDayPassModal();
    });
}

window.openModal = openModal;
window.closeModal = closeModal;
window.openEditDailyLogModal = openEditDailyLogModal;
window.closeEditDailyLogModal = closeEditDailyLogModal;
window.openEditDayPassModal = openEditDayPassModal;
window.closeEditDayPassModal = closeEditDayPassModal;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.openDayPassModal = openDayPassModal;
window.closeDayPassModal = closeDayPassModal;
