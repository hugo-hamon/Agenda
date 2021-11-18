function show_password_func() {
    var pass = document.getElementById("password-entry");
    if (pass.type === "password") {
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}