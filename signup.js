document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("signupForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        document.querySelectorAll(".error").forEach(el => el.textContent = "");

        const firstName = document.getElementById("firstName").value.trim();
        const lastName = document.getElementById("lastName").value.trim();
        const dob = document.getElementById("dob").value;
        const nationality = document.getElementById("nationality").value;
        const country = document.getElementById("country").value;
        const city = document.getElementById("city").value.trim();
        const zip = document.getElementById("zip").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        let valid = true;

        if (firstName.length < 2) {
            document.getElementById("firstNameError").textContent =
                "First name must have at least 2 letters";
            valid = false;
        }

        if (lastName.length < 2) {
            document.getElementById("lastNameError").textContent =
                "Last name must have at least 2 letters";
            valid = false;
        }

        if (dob === "") {
            document.getElementById("dobError").textContent =
                "Please select your date of birth";
            valid = false;
        }

        if (nationality === "Select") {
            document.getElementById("nationalityError").textContent =
                "Please select nationality";
            valid = false;
        }

        if (country === "Select") {
            document.getElementById("countryError").textContent =
                "Please select country";
            valid = false;
        }

        if (city.length < 2) {
            document.getElementById("cityError").textContent =
                "City must have at least 2 characters";
            valid = false;
        }

        if (!/^\d{4,}$/.test(zip)) {
            document.getElementById("zipError").textContent =
                "ZIP code must have at least 4 numbers";
            valid = false;
        }

        if (!/^\+?\d{8,}$/.test(phone)) {
            document.getElementById("phoneError").textContent =
                "Enter a valid phone number";
            valid = false;
        }

        if (!/^[^\s@]+@[^\s@]+\.com$/.test(email)) {
            document.getElementById("emailError").textContent =
                "Email must be valid and end with .com";
            valid = false;
        }

        if (password.length < 8) {
            document.getElementById("passwordError").textContent =
                "Password must have at least 8 characters";
            valid = false;
        }

        if (password !== confirmPassword) {
            document.getElementById("confirmPasswordError").textContent =
                "Passwords do not match";
            valid = false;
        }

        if (valid) {
            alert("Account created successfully!");
            form.reset();
        }
    });
});


