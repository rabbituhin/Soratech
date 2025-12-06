var x=document.getElementById('login');
		var y=document.getElementById('register');
		var z=document.getElementById('button');
		function register()
		{
			x.style.left='-400px';
			y.style.left='50px';
			z.style.left='110px';
		}
		function login()
		{
			x.style.left='50px';
			y.style.left='450px';
			z.style.left='0px';
		}

 // Toggle password visibility function
function initPasswordToggle(passwordFieldId, toggleButtonId) {
	var passwordInput = document.getElementById(passwordFieldId);
	var toggleBtn = document.getElementById(toggleButtonId);
	
	if (!passwordInput || !toggleBtn) {
		return;
	}
	
	toggleBtn.addEventListener('click', function() {
		var type = passwordInput.getAttribute('type');
		var icon = toggleBtn.querySelector('i');
		
		if (type === 'password') {
			passwordInput.setAttribute('type', 'text');
			icon.classList.remove('fa-eye');
			icon.classList.add('fa-eye-slash');
		} else {
			passwordInput.setAttribute('type', 'password');
			icon.classList.remove('fa-eye-slash');
			icon.classList.add('fa-eye');
		}
	});
}

// Password strength validation
function validatePasswordStrength() {
	var passwordInput = document.getElementById('password');
	var passwordMessage = document.getElementById('passwordMessage');
	var password = passwordInput.value;
	
	if (password.length === 0) {
		passwordMessage.classList.remove('show', 'success');
		passwordInput.classList.remove('invalid', 'valid');
		return false;
	}

	var hasLength = password.length >= 8;
	var hasLetter = /[a-zA-Z]/.test(password);
	var hasNumber = /[0-9]/.test(password);
	var hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
	
	var missing = [];
	
	if (!hasLength) missing.push('at least 8 characters');
	if (!hasLetter) missing.push('a letter');
	if (!hasNumber) missing.push('a number');
	if (!hasSpecial) missing.push('a special character');
	
	if (missing.length > 0) {
		passwordMessage.classList.remove('success');
		passwordMessage.classList.add('show');
		passwordInput.classList.add('invalid');
		passwordInput.classList.remove('valid');
		passwordMessage.textContent = 'Password must contain ' + missing.join(', ');
		return false;
	} else {
		passwordMessage.classList.add('success', 'show');
		passwordInput.classList.remove('invalid');
		passwordInput.classList.add('valid');
		passwordMessage.textContent = 'Great! Your password is strong.';
		return true;
	}
}

// Confirm password validation
function validatePasswordMatch() {
	var passwordInput = document.getElementById('password');
	var confirmInput = document.getElementById('confirmPassword');
	var confirmMessage = document.getElementById('confirmPasswordMessage');
	
	var password = passwordInput.value;
	var confirmPassword = confirmInput.value;
	
	if (confirmPassword.length === 0) {
		confirmMessage.classList.remove('show', 'success', 'error');
		confirmInput.classList.remove('invalid', 'valid');
		return false;
	}

	if (confirmPassword !== password) {
		confirmMessage.classList.remove('success');
		confirmMessage.classList.add('show', 'error');
		confirmInput.classList.add('invalid');
		confirmInput.classList.remove('valid');
		confirmMessage.textContent = 'Passwords do not match';
		return false;
	} else {
		confirmMessage.classList.remove('error');
		confirmMessage.classList.add('success', 'show');
		confirmInput.classList.remove('invalid');
		confirmInput.classList.add('valid');
		confirmMessage.textContent = 'Passwords match!';
		return true;
	}
}

// Check if form is valid
function checkFormValidity() {
	var registerBtn = document.getElementById('registerBtn');
	var passwordInput = document.getElementById('password');
	var confirmInput = document.getElementById('confirmPassword');
	
	var isPasswordValid = passwordInput.classList.contains('valid');
	var isConfirmValid = confirmInput.classList.contains('valid');
	
	if (isPasswordValid && isConfirmValid) {
		registerBtn.disabled = false;
	} else {
		registerBtn.disabled = true;
	}
}

// Initialize password toggles
initPasswordToggle('loginPassword', 'toggleLoginPassword');
initPasswordToggle('password', 'togglePassword');
initPasswordToggle('confirmPassword', 'toggleConfirmPassword');

// Add event listeners for validation
var passwordInput = document.getElementById('password');
var confirmInput = document.getElementById('confirmPassword');

if (passwordInput) {
	passwordInput.addEventListener('input', function() {
		validatePasswordStrength();
		checkFormValidity();
	});
}

if (confirmInput) {
	confirmInput.addEventListener('input', function() {
		validatePasswordMatch();
		checkFormValidity();
	});
}

// Form submission handlers
// var loginForm = document.getElementById('login');
// if (loginForm) {
//     loginForm.addEventListener('submit', function(e) {
//         // Remove e.preventDefault(); so the form can submit
//         // You can optionally add validation here
//     });
// }

document.getElementById('register').addEventListener('submit', function(e) {
    if (!validatePasswordStrength() || !validatePasswordMatch()) {
        e.preventDefault(); // stop only if invalid
        alert('Please fix password errors before submitting.');
    }
});



// Phone number validation
var phoneInput = document.getElementById('tel');

phoneInput.addEventListener('input', function(e) {
    // Remove any non-digit characters
    this.value = this.value.replace(/[^0-9]/g, '');
});

phoneInput.addEventListener('input', function(e) {
	var value = this.value.replace(/[^0-9]/g, '');
	
	if (value.length >= 10) {
		// Format: (123) 456-7890
		this.value = '(' + value.substring(0,3) + ') ' + 
						value.substring(3,6) + '-' + 
						value.substring(6,10);
	}
});

