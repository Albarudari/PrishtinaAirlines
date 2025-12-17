const form = document.getElementById("signinForm");
const email = document.getElementById("email");
const password = document.getElementById("password");

const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    let valid = true;

    emailError.textContent = "";
    passwordError.textContent = "";
    email.style.borderColor = "#ccc";
    password.style.borderColor = "#ccc";

    const emailPattern = /^[^\s@]+@[^\s@]+\.com$/;

    if (email.value.trim() === "") {
        emailError.textContent = "Email is required";
        email.style.borderColor = "red";
        valid = false;
    } else if (!emailPattern.test(email.value)) {
        emailError.textContent = "Email must contain @ and end with .com";
        email.style.borderColor = "red";
        valid = false;
    }

    const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

    if (password.value.trim() === "") {
        passwordError.textContent = "Password is required";
        password.style.borderColor = "red";
        valid = false;
    } else if (!passwordPattern.test(password.value)) {
        passwordError.textContent =
            "Password must be at least 8 characters, include 1 uppercase letter and 1 number";
        password.style.borderColor = "red";
        valid = false;
    }

    if (valid) {
        alert("Login successful!");
        form.reset();
    }
});
