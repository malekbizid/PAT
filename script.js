const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const email = document.getElementById('email');
const password = document.getElementById('pass');
const form = document.getElementById('form')

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});
registerBtn.addEventListener('mouseover', (event) => {
    event.target.classList.add("hover");
});
registerBtn.addEventListener('mouseout', (event) => {
    event.target.classList.remove("hover");
});
window.onload = function () {
    email.focus();
};
email.onblur = function () {
    password.focus();
};
form.addEventListener('submit', e => {
    e.preventDefault();
    if (email.value == '') {
        email.classList.add('fail');
    }

});