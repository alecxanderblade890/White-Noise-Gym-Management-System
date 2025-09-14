// Add event listeners when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get all edit modals
    const editModals = document.querySelectorAll('[id^="editDailyLogModal-"]');
    
    editModals.forEach(modal => {
        const modalId = modal.id.replace('editDailyLogModal-', '');
        
        // Add change event listeners to all item and t-shirt checkboxes
        const checkboxes = modal.querySelectorAll('input[name="items[]"], input[name="t_shirts[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateEditPaymentTotal(modalId);
            });
        });

        // Add change event listeners for purpose of visit checkboxes
        const purposeOfVisitCheckboxes = modal.querySelectorAll('input[name="purpose_of_visit[]"]');
        purposeOfVisitCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateEditPaymentTotal(modalId);
            });
        });

        // Add change event listeners for radio buttons
        ['gym_access', 'member_type'].forEach(name => {
            const radios = modal.querySelectorAll(`input[name="${name}"]`);
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateEditPaymentTotal(modalId);
                });
            });
        });

        // Initial calculation
        updateEditPaymentTotal(modalId);
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

// Function to calculate and update the total payment amount for edit modal
function updateEditPaymentTotal(modalId) {
    const modal = document.getElementById(`editDailyLogModal-${modalId}`);
    if (!modal) return;

    const paymentInput = modal.querySelector(`#payment_amount_${modalId}`);
    const selectedPurposes = modal.querySelectorAll('input[name="purpose_of_visit[]"]:checked');
    const selectedGymAccess = modal.querySelector('input[name="gym_access"]:checked');
    const selectedMemberType = modal.querySelector('input[name="member_type"]:checked');
    let totalAmount = 0;

    // Add prices of selected items
    modal.querySelectorAll('input[name="items[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmount += itemPrices[itemName] || 0;
    });

    // Add prices of selected t-shirts
    modal.querySelectorAll('input[name="t_shirts[]"]:checked').forEach(checkbox => {
        const itemName = checkbox.value;
        totalAmount += itemPrices[itemName] || 0;
    });

    // Process all selected purposes of visit
    selectedPurposes.forEach(checkbox => {
        const gymAccessValue = selectedGymAccess ? selectedGymAccess.value.toLowerCase() : '';
        const isStudent = selectedMemberType && selectedMemberType.value === 'Student';
        const purpose = checkbox.value;
        
        // Handle different payment types
        if (purpose === 'Gym Use' && selectedGymAccess && selectedGymAccess.value.includes('Walk in')) {
            if(selectedMemberType) {
                totalAmount += isStudent ? 100 : 150;
            } else {
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
}

// Function to open the edit modal
function openEditDailyLogModal(id) {
    const modal = document.getElementById(`editDailyLogModal-${id}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Recalculate payment total when opening the modal
        updateEditPaymentTotal(id);
    }
}

// Function to close the edit modal
function closeEditDailyLogModal(id) {
    const modal = document.getElementById(`editDailyLogModal-${id}`);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}