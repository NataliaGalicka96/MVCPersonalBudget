
function ValidationEvent() {

    let name = document.getElementById("username").value;
    let errorSpan = document.getElementById("error");

    if (name == '') {
        errorSpan.innerHTML = "Username is required";
    }

    else if (name.length < 2 || name.length > 20) {
        valid = false;
        errorSpan.innerHTML = "Username needs to be between 2 to 20 characters.";

    }

    else if (!(name.match(/^[A-Za-z]+$/))) {
        valid = false;
        errorSpan.innerHTML = "Username must contain letters only. Special characters are not allowed.";

    }

    for (let i = 0; i < allUsers.length; i++) {
        if (name == allUsers[i].username) {
            valid = false;
            errorSpan.innerHTML = "Username already taken! ";

        }
    }

}

