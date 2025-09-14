// Add event listeners when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handler
    const registrationForm = document.getElementById('member-registration-form');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function() {
            const button = document.getElementById('register-button');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('button-text');
            
            if (button && spinner && buttonText) {
                // Disable the button to prevent multiple submissions
                button.disabled = true;
                // Show the spinner
                spinner.classList.remove('hidden');
                // Change button text
                buttonText.textContent = 'Registering...';
            }
        });
    }

    // Base rate calculation elements
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

// Function to update base rate based on membership term and member type
function updateMembershipTermBillingRate() {
    const memberType = document.getElementById('member_type');
    const membershipTerm = document.getElementById('membership_term_gym_access');
    const baseRateField = document.getElementById('membership_term_billing_rate');
    const hiddenRateField = document.getElementById('membership_term_billing_rate_hidden');
    const billingRateSuffix = document.getElementById('billing-rate-suffix');
    // const gymAccessStartDate = document.getElementById('gym_access_start_date');
    // const gymAccessEndDate = document.getElementById('gym_access_end_date');
    // const currentEndDate = document.getElementById('current_end_date');

    
    
    if (!memberType || !membershipTerm || !baseRateField || !hiddenRateField || !billingRateSuffix) return;
    
    let rate = 0;
    
    // if(membershipTerm.value != 'None') {
        
    //     const date = new Date();
    //     const options = { year: 'numeric', month: 'long', day: 'numeric' };
    //     gymAccessStartDate.value = date.toLocaleDateString('en-US', options);

    //     if(membershipTerm.value == '1 month') {
    //         const endDate = currentEndDate.value ? new Date(currentEndDate.value) : new Date();
    //         endDate.setMonth(endDate.getMonth() + 1);
    //         gymAccessEndDate.value = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    //     }
    //     else if(membershipTerm.value == '3 months') {
    //         const endDate = currentEndDate.value ? new Date(currentEndDate.value) : new Date();
    //         endDate.setMonth(endDate.getMonth() + 3);
    //         gymAccessEndDate.value = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    //     }
    //     else if(membershipTerm.value == 'Walk in') {
    //         gymAccessEndDate.value = '';
    //     }
    // }
    // else {
    //     gymAccessStartDate.value = '';
    //     gymAccessEndDate.value = '';
    // }
    // Base rates
    if (membershipTerm.value === 'None') {
        rate = 0;
    }
    else if (membershipTerm.value === '1 month') {
        rate = (memberType.value === 'Student') ? 1000 : 1500;
    } else if (membershipTerm.value === '3 months') {
        rate = (memberType.value === 'Student') ? 2500 : 4000;
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
    // const currentEndDatePt = document.getElementById('current_end_date_pt');
    // const ptStartDate = document.getElementById('pt_start_date');
    // const ptEndDate = document.getElementById('pt_end_date');
    const ptBillingRateField = document.getElementById('with_pt_billing_rate');
    const hiddenPtBillingRateField = document.getElementById('with_pt_billing_rate_hidden');
    
    if (!withPt || !ptBillingRateField || !hiddenPtBillingRateField) return;
    
    let rate = 0;

    if (withPt.value === '1 month') {
        rate = 3000;
        // const date = new Date();
        // const options = { year: 'numeric', month: 'long', day: 'numeric' };
        // ptStartDate.value = date.toLocaleDateString('en-US', options);
        // const endDate = currentEndDatePt.value ? new Date(currentEndDatePt.value) : new Date();
        // endDate.setMonth(endDate.getMonth() + 1);
        // ptEndDate.value = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }
    else if (withPt.value === 'None') {
        rate = 0;
        // ptStartDate.value = null;
        // ptEndDate.value = null;
    }
    
    // Update the PT billing rate field
    ptBillingRateField.value = '₱' + rate.toLocaleString();
    
    // Update the hidden field with raw numeric value
    hiddenPtBillingRateField.value = rate;
}