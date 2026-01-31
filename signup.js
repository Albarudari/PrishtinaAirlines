document.addEventListener("DOMContentLoaded", function() {

    const setupToggle = (inputId, iconId) => {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input && icon) {
            icon.addEventListener('click', function() {
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    };
    setupToggle('password', 'togglePassword');
    setupToggle('confirmPassword', 'toggleConfirmPassword');

    const showError = (inputElement, message) => {
        const wrapper = inputElement.closest('.field') || inputElement.parentElement;
        
        let oldErr = wrapper.querySelector(".error-msg");
        if (oldErr) oldErr.remove();

        const errorSpan = document.createElement("span");
        errorSpan.className = "error-msg";
        errorSpan.textContent = message;
        
        errorSpan.style.color = "red";
        errorSpan.style.fontSize = "12px";
        errorSpan.style.display = "block";
        errorSpan.style.width = "100%";
        errorSpan.style.marginTop = "5px";
        errorSpan.style.clear = "both";

        wrapper.appendChild(errorSpan);
    };

    const form = document.getElementById("signupForm");
    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            document.querySelectorAll(".error-msg").forEach(el => el.remove());
            let valid = true;

            const passInput = document.getElementById("password");
            const passRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*]).{8,}$/;
            if (!passRegex.test(passInput.value)) {
                showError(passInput, "Min 8 chars, 1 Uppercase, 1 Number and 1 Symbol");
                valid = false;
            }

            const confirmInput = document.getElementById("confirmPassword");
            if (passInput.value !== confirmInput.value) {
                showError(confirmInput, "Passwords do not match!");
                valid = false;
            }

            const ids = ["firstName", "lastName", "email", "birthdate", "city", "zip_code", "phone"];
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el && el.value.trim() === "") {
                    showError(el, "This field is required");
                    valid = false;
                }
            });

            if (valid) {
                form.submit();
            }
        });
    }
});