// Add event listeners when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add Log button click handler
    const addLogBtn = document.getElementById('add-log-btn');
    if (addLogBtn) {
        addLogBtn.addEventListener('click', function(e) {
            const spinner = document.getElementById('add-log-spinner');
            const form = document.querySelector('form#daily-log-form');
            
            if (form && form.checkValidity()) {
                spinner.classList.remove('hidden');
                this.disabled = true;
                
                // Submit the form
                form.submit();
            } else if (form) {
                // If form is not valid, trigger the browser's validation UI
                form.reportValidity();
            }
        });
    }
    
    // Existing Validate Member button handler
    const validateMemberBtn = document.getElementById('validate-member-btn');
    const labelText = document.getElementById('label_text');
    const fullName = document.getElementById('full_name');
    const timeIn = document.getElementById('time_in');
    const memberId = document.getElementById('white_noise_id');
    const spinner = document.getElementById('validate-member-spinner');
    if (validateMemberBtn) {
        validateMemberBtn.addEventListener('click', function(e) {
            e.preventDefault();
        if (memberId) {
            spinner.classList.remove('hidden');
            fetch(`/validate-member-id/${memberId.value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        labelText.textContent = "Member is invalid!";
                        labelText.classList.add('text-red-500');
                        labelText.classList.remove('text-green-500');
                        document.getElementById('daily-log-form').classList.add('hidden');
                        spinner.classList.add('hidden');
                    }
                    else {
                        timeIn.value = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
                        // Set the member ID in the form
                        memberId.value = data.white_noise_id;
                        // Also set the hidden form field
                        const whiteNoiseIdForm = document.getElementById('white_noise_id_form');
                        if (whiteNoiseIdForm) {
                            whiteNoiseIdForm.value = memberId.value;
                        }
                        if(fullName){
                            fullName.value = data.full_name || ''; // Use the actual full name from the response
                        }
                        else{
                            console.log("NOTHING")
                        }
                        // Update the validation message
                        labelText.textContent = "Member is valid!";
                        labelText.classList.add('text-green-500');
                        labelText.classList.remove('text-red-500');

                        if(data.member_type == 'Student') {
                            document.getElementById('member_type_student').checked = true;
                        }
                        else {
                            document.getElementById('member_type_regular').checked = true;
                        }
                        
                        if(data.membership_term_gym_access == '1 month') {
                            document.getElementById('gym_access_1_month').checked = true;
                        }
                        else if(data.membership_term_gym_access == '3 months') {
                            document.getElementById('gym_access_3_month').checked = true;
                        }
                        else if(data.membership_term_gym_access == 'Walk in') {
                            document.getElementById('gym_access_walk_in').checked = true;
                        }
                        else {
                            document.getElementById('gym_access_none').checked = true;
                        }

                        if(data.with_pt == 'None') {
                            document.getElementById('personal_trainer_none').checked = true;
                        }
                        else {
                            document.getElementById('personal_trainer_1_month').checked = true;
                        }
                        
                        // Show the form
                        const form = document.getElementById('daily-log-form');
                        if (form) {
                            form.classList.remove('hidden');
                        }
                        spinner.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.classList.add('hidden');
                });
            }
        });
    }
    
    // Add change event listeners to all item and t-shirt checkboxes
    const checkboxes = document.querySelectorAll('input[name="items[]"], input[name="t_shirts[]"], input[name="items_day_pass[]"], input[name="t_shirts_day_pass[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePaymentTotal);
    });

    const purposeOfVisitCheckboxes = document.querySelectorAll('input[name="purpose_of_visit[]"]');
    purposeOfVisitCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePaymentTotal);
    });

    // Add change event listeners for radio buttons
    ['gym_access', 'member_type'].forEach(name => {
        const radios = document.querySelectorAll(`input[name="${name}"]`);
        radios.forEach(radio => {
            radio.addEventListener('change', updatePaymentTotal);
        });
    });
});

const itemPrices = {
    'Pocari Sweat': 50,
    'Gatorade Blue': 65,
    'Gatorade Red': 65,
    'Bottled Water': 20,
    'White - Large': 350,
    'White - XL': 350,
    'Black - Large': 350,
    'Black - XL': 350,
    'Black - XS': 300,
    'Black - Medium': 300
};


// Function to calculate and update the total payment amount
function updatePaymentTotal() {
    const paymentInput = document.getElementById('payment_amount');
    const paymentInputDayPass = document.getElementById('payment_amount_day_pass'); 
    const selectedPurposes = document.querySelectorAll('input[name="purpose_of_visit[]"]:checked');
    const selectedGymAccess = document.querySelector('input[name="gym_access"]:checked');
    const selectedMemberType = document.querySelector('input[name="member_type"]:checked');
    let totalAmount = 0;
    let totalAmountDayPass = 200;

    // Add prices of selected items
    document.querySelectorAll('input[name="items[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmount += itemPrices[itemName] || 0;
    });

    // Add prices of selected t-shirts
    document.querySelectorAll('input[name="t_shirts[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmount += itemPrices[itemName] || 0;
    });

    document.querySelectorAll('input[name="items_day_pass[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmountDayPass += itemPrices[itemName] || 0;
    });

    document.querySelectorAll('input[name="t_shirts_day_pass[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmountDayPass += itemPrices[itemName] || 0;
    });

    
    // Process all selected purposes of visit
    selectedPurposes.forEach(checkbox => {
        const gymAccessValue = selectedGymAccess.value.toLowerCase();
        const isStudent = selectedMemberType && selectedMemberType.value === 'Student';
        const purpose = checkbox.value;
        
        // Handle different payment types
        if (purpose === 'Gym Use' && selectedGymAccess.value.includes('Walk in')) {
            if(selectedMemberType){
                totalAmount += isStudent ? 100 : 150;
            }
            else{
                totalAmount += 200;
            }
        } 
        if (purpose === 'Membership Payment' || purpose === 'Renew Membership') {
            totalAmount += 500;
        } 
        if (purpose === 'Personal Trainer Payment' || purpose === 'Renew Personal Trainer') {
            totalAmount += 3000;
        }
        if (purpose === 'Personal Trainer 1 Day') {
            totalAmount += 300;
        }
        if ((purpose === 'Gym Access Payment' || purpose === 'Renew Gym Access') && selectedGymAccess) {
            if (gymAccessValue.includes('1 month')) {
                totalAmount += isStudent ? 1000 : 1500;
            }
            else if (gymAccessValue.includes('3 month')) {
                totalAmount += isStudent ? 2500 : 4000;
            }
            else if (gymAccessValue.includes('Walk in')) {
                totalAmount += isStudent ? 100 : 150;
            }
        }
    });

    // Update the payment input field and ensure it's a valid number
    if (paymentInput) {
        paymentInput.value = Math.max(0, totalAmount);
    }
    if (paymentInputDayPass) {
        paymentInputDayPass.value = Math.max(0, totalAmountDayPass);
    }
}