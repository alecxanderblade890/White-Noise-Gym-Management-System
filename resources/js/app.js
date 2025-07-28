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
function openDeleteLogModal(logId) {
    // Close any open modals first
    closeLogDetailsModal();
    
    // Find the specific delete modal for this log
    const modal = document.getElementById('deleteLogModal' + logId);
    if (modal) {
        modal.classList.remove('hidden');
        const form = modal.querySelector('form');
        if (form) {
            form.action = '/daily-logs/' + logId;
        }
    }
}
function closeDeleteLogModal() {
    // Close all delete modals (in case any are open)
    document.querySelectorAll('[id^="deleteLogModal"]').forEach(modal => {
        modal.classList.add('hidden');
    });
}
function showLogDetailsModal(log) {
    console.log("Log Details:", log);
    let upgrade_gym_access = false;
    if(log.upgrade_gym_access == 0) {
        upgrade_gym_access = 'No';
    }
    else if(log.upgrade_gym_access == 1) {
        upgrade_gym_access = 'Yes';
    }
    else {
        upgrade_gym_access = 'Unknown';
    }

    var html = `
        <div class="space-y-2">
            <div><span class="font-semibold">Date:</span> ${log.date}</div>
            <div><span class="font-semibold">Time In:</span> ${log.time_in}</div>
            <div><span class="font-semibold">Time Out:</span> ${log.time_out}</div>
            <div><span class="font-semibold">Member ID:</span> ${log.member_id}</div>
            <div><span class="font-semibold">Full Name:</span> ${log.full_name}</div>
            <div><span class="font-semibold">Membership Term Gym Access:</span> ${log.membership_term_gym_access}</div>
            <div><span class="font-semibold">Payment Method:</span> ${log.payment_method}</div>
            <div><span class="font-semibold">Payment Amount: </span> PHP ${log.payment_amount}</div>
            <div><span class="font-semibold">Purpose of Visit:</span> ${log.purpose_of_visit}</div>
            <div><span class="font-semibold">Staff Assigned:</span> ${log.staff_assigned}</div>
            <div><span class="font-semibold">Upgrade Gym Access:</span> ${upgrade_gym_access}</div>
            <div><span class="font-semibold">Notes:</span> ${log.notes}</div>
        </div>
    `;
    
    // Update the modal content
    document.getElementById('logDetailsContent').innerHTML = html;
    
    // Set up the delete button click handler with the current log ID
    const deleteButton = document.getElementById('deleteLogButton');
    deleteButton.onclick = function() {
        openDeleteLogModal(log.id);
    };
    
    // Show the modal
    document.getElementById('logDetailsModal').classList.remove('hidden');
    document.getElementById('logDetailsModal').classList.add('flex');
}
function closeLogDetailsModal() {
    document.getElementById('logDetailsModal').classList.add('hidden');
    document.getElementById('logDetailsModal').classList.remove('flex');
}

window.openDeleteLogModal = openDeleteLogModal;
window.closeDeleteLogModal = closeDeleteLogModal;
window.openModal = openModal;
window.closeModal = closeModal;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;
window.showLogDetailsModal = showLogDetailsModal;
window.closeLogDetailsModal = closeLogDetailsModal;

document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM Content Loaded event fired!")
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const membershipTermInput = document.getElementById('membership_term_gym_access');
    function calculateMembershipTerm() {
        const startDateValue = startDateInput.value;
        const endDateValue = endDateInput.value;
        if (startDateValue && endDateValue) {
            const startDate = new Date(startDateValue);
            const endDate = new Date(endDateValue);
            // Calculate the difference in months
            // This approach accounts for year differences
            let months;
            months = (endDate.getFullYear() - startDate.getFullYear()) * 12;
            months -= startDate.getMonth();
            months += endDate.getMonth();
            // Adjust for day differences if necessary.
            // If end day is before start day in the same month, subtract 1.
            if (endDate.getDate() < startDate.getDate()) {
                months--;
            }
            
            // Ensure the minimum term is 0 (or 1 if you prefer a minimum of 1 month)
            // If the end date is before the start date, the term should be 0 or negative
            if (months < 0) {
                months = 0; // Or handle as an error/invalid date range
            } else if (months === 0 && endDate.getDate() >= startDate.getDate()) {
                months = 1; // If dates are in the same month and end date is not before start date, consider it 1 month
            }
            membershipTermInput.value = months;
        } else {
            membershipTermInput.value = ''; // Clear if dates are not fully selected
        }
    }
    // Add event listeners
    startDateInput.addEventListener('change', calculateMembershipTerm);
    endDateInput.addEventListener('change', calculateMembershipTerm);
    // Call it once on load to handle pre-filled values (e.g., old() or now()->format())
    calculateMembershipTerm();
});

document.querySelector('[data-edit-profile]').addEventListener('click', function(e) {
    e.preventDefault();
    openModal();
});

document.querySelector('[data-delete-member]').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default action
    openDeleteModal(); // Show the modal
});


