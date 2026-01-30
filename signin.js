const form = document.getElementById("signinForm");
const email = document.getElementById("email");
const password = document.getElementById("password");

const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");

form.addEventListener("submit", function (e) {

    let valid = true;

    emailError.textContent = "";
    passwordError.textContent = "";

    const emailPattern = /^[^\s@]+@[^\s@]+\.com$/;
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

    if (email.value.trim() === "") {
        emailError.textContent = "Email is required";
        valid = false;
    } else if (!emailPattern.test(email.value)) {
        emailError.textContent = "Invalid email format";
        valid = false;
    }

    if (password.value.trim() === "") {
        passwordError.textContent = "Password is required";
        valid = false;
    } else if (!passwordPattern.test(password.value)) {
        passwordError.textContent = "Invalid password format";
        valid = false;
    }

    if (!valid) {
        e.preventDefault();
    }
});
