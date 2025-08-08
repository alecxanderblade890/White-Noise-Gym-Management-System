import './bootstrap';

// Function to update base rate based on membership term and member type
function updateMembershipTermBillingRate() {
    const memberType = document.getElementById('member_type');
    const membershipTerm = document.getElementById('membership_term_gym_access');
    const baseRateField = document.getElementById('membership_term_billing_rate');
    const hiddenRateField = document.getElementById('membership_term_billing_rate_hidden');
    const billingRateSuffix = document.getElementById('billing-rate-suffix');
    const gymAccessStartDate = document.getElementById('gym_access_start_date');
    const gymAccessEndDate = document.getElementById('gym_access_end_date');
    const currentEndDate = document.getElementById('current_end_date');

    
    
    if (!memberType || !membershipTerm || !baseRateField || !hiddenRateField || !billingRateSuffix || !gymAccessStartDate) return;
    
    let rate = 0;
    
    if(membershipTerm.value != 'None') {
        
        const date = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        gymAccessStartDate.value = date.toLocaleDateString('en-US', options);

        if(membershipTerm.value == '1 month') {
            const endDate = currentEndDate.value ? new Date(currentEndDate.value) : new Date();
            endDate.setMonth(endDate.getMonth() + 1);
            gymAccessEndDate.value = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }
        else if(membershipTerm.value == '3 months') {
            const endDate = currentEndDate.value ? new Date(currentEndDate.value) : new Date();
            endDate.setMonth(endDate.getMonth() + 3);
            gymAccessEndDate.value = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }
        else if(membershipTerm.value == 'Walk in') {
            gymAccessEndDate.value = '';
        }
    }
    else {
        gymAccessStartDate.value = '';
        gymAccessEndDate.value = '';
    }
    // Base rates
    if (membershipTerm.value === 'None') {
        rate = 0;
    }
    else if (membershipTerm.value === '1 month') {
        rate = (memberType.value === 'Student') ? 1000 : 1500;
    } else if (membershipTerm.value === '3 months') {
        rate = (memberType.value === 'Student') ? 2500 : 4500;
    } else if (membershipTerm.value === 'Walk in') {
        rate = (memberType.value === 'Student') ? 100 : 150;
    }
    
    // Update the hidden field with raw numeric value
    hiddenRateField.value = rate;
    
    // Update the visible field with formatted value
    baseRateField.value = '₱' + rate.toLocaleString();
    
    // Update the billing rate suffix
    billingRateSuffix.textContent = membershipTerm.value === 'Walk in' ? '/day' : membershipTerm.value === '3 months' ? '/quarterly' : '/month';
}

// Function to update PT billing rate based on selection
function updatePtBillingRate() {
    const withPt = document.getElementById('with_pt');
    const currentEndDatePt = document.getElementById('current_end_date_pt');
    const ptStartDate = document.getElementById('pt_start_date');
    const ptEndDate = document.getElementById('pt_end_date');
    const ptBillingRateField = document.getElementById('with_pt_billing_rate');
    const hiddenPtBillingRateField = document.getElementById('with_pt_billing_rate_hidden');
    
    if (!withPt || !ptBillingRateField || !hiddenPtBillingRateField) return;
    
    let rate = 0;
    

    if (withPt.value === '1 month') {
        rate = 3000;
        const date = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        ptStartDate.value = date.toLocaleDateString('en-US', options);
        const endDate = currentEndDatePt.value ? new Date(currentEndDatePt.value) : new Date();
        endDate.setMonth(endDate.getMonth() + 1);
        ptEndDate.value = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
    else if (withPt.value === 'None') {
        rate = 0;
        ptStartDate.value = null;
        ptEndDate.value = null;
    }
    
    // Update the PT billing rate field
    ptBillingRateField.value = '₱' + rate.toLocaleString();
    
    // Update the hidden field with raw numeric value
    hiddenPtBillingRateField.value = rate;
    
}

function openModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
}
function openEditDailyLogModal(dailyLog) {
    document.getElementById('editDailyLogModal').classList.remove('hidden');
    document.getElementById('date').value = dailyLog.date;
    document.getElementById('time_in').value = dailyLog.time_in;
    document.getElementById('time_out').value = dailyLog.time_out ? dailyLog.time_out : '';
    document.getElementById('member_id').value = dailyLog.member_id ? dailyLog.member_id : 'N/A';
    document.getElementById('payment_method').value = dailyLog.payment_method;
    document.getElementById('payment_amount').value = dailyLog.payment_amount;
    document.getElementById('purpose_of_visit').value = dailyLog.purpose_of_visit;
    document.getElementById('staff_assigned').value = dailyLog.staff_assigned;
    document.getElementById('notes').value = dailyLog.notes || '';
    document.getElementById('upgrade_gym_access').checked = dailyLog.upgrade_gym_access || false;

    // Handle items_bought checkboxes for both items and t_shirts
    if (dailyLog.items_bought) {
        try {
            // Parse items_bought if it's a JSON string, or use as is if it's already an object
            const itemsBought = typeof dailyLog.items_bought === 'string' 
                ? JSON.parse(dailyLog.items_bought) 
                : dailyLog.items_bought;

            // Check regular items
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            itemCheckboxes.forEach(checkbox => {
                const itemValue = checkbox.value;
                checkbox.checked = itemsBought.some(item => item === itemValue);
            });

            // Check t-shirt checkboxes
            const tshirtCheckboxes = document.querySelectorAll('.tshirt-checkbox');
            tshirtCheckboxes.forEach(checkbox => {
                const tshirtValue = checkbox.value;
                checkbox.checked = itemsBought.some(item => item === tshirtValue);
            });
        } catch (e) {
            console.error('Error parsing items_bought:', e);
        }
    }
    

}
function closeEditDailyLogModal() {
    document.getElementById('editDailyLogModal').classList.add('hidden');
}
function openDeleteModal() {
    document.getElementById('deleteMemberModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteMemberModal').classList.add('hidden');
}

window.openModal = openModal;
window.closeModal = closeModal;
window.openEditDailyLogModal = openEditDailyLogModal;
window.closeEditDailyLogModal = closeEditDailyLogModal;
window.openDeleteModal = openDeleteModal;
window.closeDeleteModal = closeDeleteModal;

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

// Add event listeners for base rate calculation
document.addEventListener('DOMContentLoaded', function() {
    const memberType = document.getElementById('member_type');
    const membershipTerm = document.getElementById('membership_term_gym_access');
    const billingRateSuffix = document.getElementById('billing-rate-suffix');
    const withPt = document.getElementById('with_pt');

    
    // Update billing rate suffix when membership term changes
    if (membershipTerm && billingRateSuffix) {
        membershipTerm.addEventListener('change', function() {
            billingRateSuffix.textContent = this.value === 'walk_in' ? '/day' : '/month';
        });
        
        // Initialize on page load
        billingRateSuffix.textContent = membershipTerm.value === 'walk_in' ? '/day' : '/month';
    }
    
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
