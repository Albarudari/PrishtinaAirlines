document.getElementById("signupForm").addEventListener("submit", function(e) {
    e.preventDefault();

    document.querySelectorAll(".error").forEach(el => el.textContent = "");
    const formMsg = document.getElementById("formMessage");
    if (formMsg) formMsg.textContent = "";

    let valid = true;

    const emailInput = document.getElementById("email");
    const email = emailInput ? emailInput.value.trim() : "";
    const emailRegex = /^[^\s@]+@[^\s@]+\.(com|net|org|edu|gov|io)$/i;
    
    if (!emailRegex.test(email)) {
        const errSpan = document.getElementById("emailError");
        if (errSpan) errSpan.textContent = "Email must end with .com, .net, .org, .edu, .gov or .io";
        valid = false;
    }

    const passInput = document.getElementById("password");
    const password = passInput ? passInput.value : "";
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*]).{8,}$/;
    
    if (!passwordRegex.test(password)) {
        const errSpan = document.getElementById("passwordError");
        if (errSpan) errSpan.textContent = "Min 8 chars, 1 Uppercase, 1 Number and 1 Symbol";
        valid = false;
    }

    const confirmPassInput = document.getElementById("confirmPassword");
    const confirmPassword = confirmPassInput ? confirmPassInput.value : "";
    if (password !== confirmPassword) {
        const errSpan = document.getElementById("confirmPasswordError");
        if (errSpan) errSpan.textContent = "Passwords do not match!";
        valid = false;
    }

    const fields = [
        { id: "firstName", err: "firstNameError" },
        { id: "lastName", err: "lastNameError" },
        { id: "dob", err: "dobError" },
        { id: "city", err: "cityError" },
        { id: "zip", err: "zipError" },
        { id: "phone", err: "phoneError" }
    ];

    fields.forEach(f => {
        const input = document.getElementById(f.id);
        if (input && input.value.trim() === "") {
            const errSpan = document.getElementById(f.err);
            if (errSpan) errSpan.textContent = "This field is required";
            valid = false;
        }
    });

    if (valid) {
        if (formMsg) {
            formMsg.style.color = "green";
            formMsg.textContent = "Success! Redirecting...";
        }
        
        setTimeout(() => {
            this.submit(); 
        }, 1200);
    }
});