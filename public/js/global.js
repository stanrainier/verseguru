document.addEventListener("DOMContentLoaded", function() {
    var passwordInput = document.getElementById("password");
    var passwordIcon = document.getElementById("togglePasswordIcon");
    var passwordConfirmInput = document.getElementById("password-confirm")

    function togglePasswordVisibility() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.remove("fa-eye-slash");
            passwordIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            passwordIcon.classList.remove("fa-eye");
            passwordIcon.classList.add("fa-eye-slash");
        }
    }

    // Attach the event listener to the eye icon span element
    var togglePasswordElement = document.querySelector(".passwordvisibility");
    togglePasswordElement.addEventListener("click", togglePasswordVisibility);
});

