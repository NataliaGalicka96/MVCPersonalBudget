const input = document.querySelector('#password');

const checkbox = document.querySelector('#checbox');

const h1 = document.querySelector('h1');


function showPassword() {
    if (input.type === "password") {
        input.type = "text";
        input.innerText = input.value;
    } else {
        input.type = "password";
    }
}