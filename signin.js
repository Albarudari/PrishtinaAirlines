const form = document.getElementById("signinForm");
const email = document.getElementById("email");
const password = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");

const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");

const emailPattern = /^[^\s@]+@[^\s@]+\.(com|net|org|gov|io)$/;
const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

togglePassword.addEventListener("click", () => {
  const isHidden = password.type === "password";
  password.type = isHidden ? "text" : "password";

  togglePassword.classList.toggle("fa-eye", isHidden);
  togglePassword.classList.toggle("fa-eye-slash", !isHidden);
});

form.addEventListener("submit", (e) => {
  let valid = true;

  emailError.textContent = "";
  passwordError.textContent = "";

  if (email.value.trim() === "") {
    emailError.textContent = "Email is required";
    valid = false;
  } else if (!emailPattern.test(email.value.trim().toLowerCase())) {
    emailError.textContent = "Invalid email format (Use .com, .net, .org, .gov, or .io)";
    valid = false;
  }

  if (password.value.trim() === "") {
    passwordError.textContent = "Password is required";
    valid = false;
  } else if (!passwordPattern.test(password.value)) {
    passwordError.textContent = "Minimum 8 characters, one uppercase letter and one number";
    valid = false;
  }

  if (!valid) {
    e.preventDefault();
  }
});