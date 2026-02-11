document.addEventListener('DOMContentLoaded', function() {
    
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    }
    
    // Form validation
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Clear previous error states
            const inputs = this.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            
            // Validate each required field
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                event.stopPropagation();
                
                // Show alert if not already shown
                if (!document.querySelector('.alert-danger')) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle me-2"></i> Please fill in all required fields.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    
                    const form = document.querySelector('#loginForm');
                    if (form) {
                        form.insertBefore(alertDiv, form.firstChild);
                    }
                }
            }
        });
    }
});