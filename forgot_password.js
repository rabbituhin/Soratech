var form = document.getElementById('forgotPasswordForm');
var successMessage = document.getElementById('successMessage');
var resendLink = document.getElementById('resendLink');

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    var email = document.getElementById('email').value;
    
    // Basic email validation
    if (email && validateEmail(email)) {
        // Hide form and show success message
        form.style.display = 'none';
        successMessage.classList.add('show');
        
        // Here you would normally send the reset email via your backend
        console.log('Password reset requested for:', email);
    } else {
        alert('Please enter a valid email address');
    }
});

// Resend link functionality
resendLink.addEventListener('click', function(e) {
    e.preventDefault();
    alert('Reset link has been resent to your email!');
});

// Email validation function
function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}