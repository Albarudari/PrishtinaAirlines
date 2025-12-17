document.getElementById("signinForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if (email === "" || password === "") {
        alert("Please fill in all fields!");
        return;
    }

    if (!email.includes("@")) {
        alert("Please enter a valid email address!");
        return;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters!");
        return;
    }

    alert("Login successful!");
});
