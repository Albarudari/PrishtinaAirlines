const form = document.querySelector(".contact-form");
const errors = document.querySelectorAll(".error");

form.addEventListener("submit", function (e) {
    e.preventDefault();

    errors.forEach(err => err.textContent = "");

    const name = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const message = document.querySelector('textarea[name="message"]').value.trim();

    let isValid = true;

    if (name.length < 2) {
        errors[0].textContent = "Name must contain at least 2 characters.";
        isValid = false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.(com|net|org|gov|edu|io)$/;
    if (!emailRegex.test(email)) {
        errors[1].textContent = "Enter a valid email ending with .com, .net, .org, .gov, .edu, or .io.";
        isValid = false;
    }

    const words = message.split(/\s+/).filter(w => w.length > 0);
    if (words.length <= 2) {
        errors[2].textContent = "Message must contain more than 2 words.";
        isValid = false;
    }

    if (isValid) {
        form.submit();
    }
});
