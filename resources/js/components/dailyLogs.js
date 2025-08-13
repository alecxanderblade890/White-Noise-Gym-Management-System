// Add event listeners when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const filterBtn = document.getElementById('filter-btn');
    if (filterBtn) {
        filterBtn.addEventListener('click', function(e) {
            const spinner = document.getElementById('filter-spinner');
            const form = document.querySelector('form#filter-form');
            
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
});
