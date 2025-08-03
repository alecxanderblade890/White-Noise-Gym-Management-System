import './bootstrap';

// Function to update base rate based on membership term and member type
function updateMembershipTermBillingRate() {
    const memberType = document.getElementById('member_type');
    const membershipTerm = document.getElementById('membership_term_gym_access');
    const baseRateField = document.getElementById('membership_term_billing_rate');
    const hiddenRateField = document.getElementById('membership_term_billing_rate_hidden');
    const billingRateSuffix = document.getElementById('billing-rate-suffix');
    
    if (!memberType || !membershipTerm || !baseRateField || !hiddenRateField || !billingRateSuffix) return;
    
    let rate = 0;
    
    // Base rates
    if (membershipTerm.value === 'none') {
        rate = 0;
    }
    else if (membershipTerm.value === '1_month') {
        rate = (memberType.value === 'student') ? 1000 : 1500;
    } else if (membershipTerm.value === '3_months') {
        rate = (memberType.value === 'student') ? 2500 : 4500;
    } else if (membershipTerm.value === 'walk_in') {
        rate = (memberType.value === 'student') ? 100 : 150;
    }
    
    // Update the hidden field with raw numeric value
    hiddenRateField.value = rate;
    
    // Update the visible field with formatted value
    baseRateField.value = '₱' + rate.toLocaleString();
    
    // Update the billing rate suffix
    billingRateSuffix.textContent = membershipTerm.value === 'walk_in' ? '/day' : '/month';
}

// Function to update PT billing rate based on selection
function updatePtBillingRate() {
    const withPt = document.getElementById('with_pt');
    const ptBillingRateField = document.getElementById('with_pt_billing_rate');
    const hiddenPtBillingRateField = document.getElementById('with_pt_billing_rate_hidden');
    
    if (!withPt || !ptBillingRateField) return;
    
    let rate = 0;
    
    if (withPt.value === 'none') {
        rate = 0;
    }
    else if (withPt.value === '1_month') {
        rate = 3000;
    }
    // else rate remains 0
    
    // Update the PT billing rate field
    ptBillingRateField.value = '₱' + rate.toLocaleString();
    
    // Update the hidden field with raw numeric value
    hiddenPtBillingRateField.value = rate;
}

// Add event listeners for base rate calculation
document.addEventListener('DOMContentLoaded', function() {
    const memberType = document.getElementById('member_type');
    const membershipTerm = document.getElementById('membership_term_gym_access');
    const billingRateSuffix = document.getElementById('billing-rate-suffix');
    
    // Update billing rate suffix when membership term changes
    if (membershipTerm && billingRateSuffix) {
        membershipTerm.addEventListener('change', function() {
            billingRateSuffix.textContent = this.value === 'walk_in' ? '/day' : '/month';
        });
        
        // Initialize on page load
        billingRateSuffix.textContent = membershipTerm.value === 'walk_in' ? '/day' : '/month';
    }
    const withPt = document.getElementById('with_pt');
    
    // Base rate event listeners
    if (memberType && membershipTerm) {
        memberType.addEventListener('change', updateMembershipTermBillingRate);
        membershipTerm.addEventListener('change', updateMembershipTermBillingRate);
        
        // Calculate initial base rate
        updateMembershipTermBillingRate();
    }
    
    // PT billing rate event listener
    if (withPt) {
        withPt.addEventListener('change', updatePtBillingRate);
        // Set initial PT billing rate
        updatePtBillingRate();
    }
});

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


