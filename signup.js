document.getElementById("signupForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const inputs = document.querySelectorAll("#signupForm input, #signupForm select");
  const message = document.getElementById("formMessage");

  let password = document.querySelector('input[type="password"]').value;
  let confirmPassword = document.querySelectorAll('input[type="password"]')[1].value;
  let email = document.querySelector('input[type="email"]').value;
  let phone = document.querySelector('input[type="tel"]').value;

  message.textContent = "";
  message.style.color = "red";

  for (let input of inputs) {
    if (input.value.trim() === "" || input.value === "Select") {
      message.textContent = "Please fill in all fields.";
      return;
    }
  }

  if (!email.includes("@") || !email.includes(".")) {
    message.textContent = "Please enter a valid email address.";
    return;
  }

  if (phone.length < 8) {
    message.textContent = "Please enter a valid phone number.";
    return;
  }

  if (password.length < 6) {
    message.textContent = "Password must be at least 6 characters.";
    return;
  }

  if (password !== confirmPassword) {
    message.textContent = "Passwords do not match.";
    return;
  }

  message.style.color = "green";
  message.textContent = "Account created successfully!";
  alert("Sign up successful!");

  document.getElementById("signupForm").reset();
});
