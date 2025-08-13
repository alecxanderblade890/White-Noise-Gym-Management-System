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
    document.getElementById('validate-member-btn').addEventListener('click', function(e) {
        e.preventDefault();
        const memberId = document.getElementById('member_id').value;
        const labelText = document.getElementById('label_text');
        const spinner = document.getElementById('validate-member-spinner');
        
        if (memberId) {
            spinner.classList.remove('hidden');
            fetch(`/validate-member-id/${memberId}`)
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
                        // Set the member ID in the form
                        document.getElementById('form_member_id').value = data.member_id;                        
                        // Update the validation message
                        labelText.textContent = "Member is valid!";
                        labelText.classList.add('text-green-500');
                        labelText.classList.remove('text-red-500');

                        window.memberData = {
                            memberType: data.member_type,
                            membershipTermGymAccess: data.membership_term_gym_access,
                            withPt: data.with_pt
                        };
                        
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
    
    // Add change event listeners to all item and t-shirt checkboxes
    const checkboxes = document.querySelectorAll('input[name="items[]"], input[name="t_shirts[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePaymentTotal);
    });
    
    // Add change event listener for purpose of visit
    const purposeOfVisit = document.getElementById('purpose_of_visit');
    if (purposeOfVisit) {
        purposeOfVisit.addEventListener('change', updatePaymentTotal);
    }
});

// Item prices (you can modify these values as needed)
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
// Function to calculate and update the total payment amount
function updatePaymentTotal() {
    const paymentInput = document.getElementById('payment_amount');
    const purposeOfVisit = document.getElementById('purpose_of_visit');

    let totalAmount = 0;

    // 1. Calculate the base amount based on the purpose of visit
    if (purposeOfVisit.value === 'Membership') {
        totalAmount = 500;
    } else if (purposeOfVisit.value === 'Membership Term') {
        if (window.memberData.membershipTermGymAccess === '1 month') {
            totalAmount += (window.memberData.memberType === 'Student' ? 1000 : 1500);
        } else if (window.memberData.membershipTermGymAccess === '3 months') {
            totalAmount += (window.memberData.memberType === 'Student' ? 2500 : 4500);
        }
    } else if (purposeOfVisit.value === 'Personal Trainer') {
        if (window.memberData.withPt === '1 month') {
            totalAmount += 3000;
        } else if (window.memberData.withPt === '3 months') {
            totalAmount += 9000; // Assuming this is a missing value from your original code, as it was `0`.
        }
    } else if (purposeOfVisit.value === 'Gym Use') {
        if (window.memberData.membershipTermGymAccess === 'Walk in') {
            totalAmount += (window.memberData.memberType === 'Student' ? 100 : 150);
        }
    } else if (purposeOfVisit.value === 'Gym Use & Membership Payment') {
        if (window.memberData.membershipTermGymAccess === 'Walk in') {
            totalAmount += (window.memberData.memberType === 'Student' ? 600 : 650);
        } else if (window.memberData.membershipTermGymAccess === '1 month' || window.memberData.membershipTermGymAccess === '3 months') {
            totalAmount += 500;
        }
    } else if (purposeOfVisit.value === 'Gym Use & Membership Term Payment') {
        if (window.memberData.membershipTermGymAccess === 'Walk in') {
            totalAmount += (window.memberData.memberType === 'Student' ? 100 : 150);
        } else if (window.memberData.membershipTermGymAccess === '1 month') {
            totalAmount += (window.memberData.memberType === 'Student' ? 1000 : 1500);
        } else if (window.memberData.membershipTermGymAccess === '3 months') {
            totalAmount += (window.memberData.memberType === 'Student' ? 2500 : 4500);
        }
    } else if (purposeOfVisit.value === 'Gym Use & Personal Trainer Payment') {
        if (window.memberData.membershipTermGymAccess === 'Walk in' && window.memberData.withPt === 'None') {
            totalAmount += (window.memberData.memberType === 'Student' ? 100 : 150);
        } else if (window.memberData.membershipTermGymAccess === 'Walk in' && window.memberData.withPt === '1 month') {
            totalAmount += (window.memberData.memberType === 'Student' ? 3100 : 3500);
        } else if (window.memberData.membershipTermGymAccess === '1 month' && window.memberData.withPt === '1 month') {
            totalAmount += 3000;
        } else if (window.memberData.membershipTermGymAccess === '3 months' && window.memberData.withPt === '1 month') {
            totalAmount += 3000;
        }
    }

    // 2. Add the price of any selected items
    document.querySelectorAll('input[name="items[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmount += itemPrices[itemName] || 0;
    });

    // 3. Add the price of any selected t-shirts
    document.querySelectorAll('input[name="t_shirts[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmount += itemPrices[itemName] || 0;
    });

    // 4. Update the payment input field
    paymentInput.value = Math.max(0, totalAmount);
}