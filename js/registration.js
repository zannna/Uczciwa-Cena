const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const confirmedPasswordInput = form.querySelector('input[name="repeatedPassword"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail() {
    var condition=false;
    setTimeout(function () {
            condition=  isEmail(emailInput.value);
            markValidation(emailInput, condition);
        },
        1000
    );
    return condition;
}

function validatePassword() {
    var condition=false;
    setTimeout(function () {
             condition = arePasswordsSame(
                 form.querySelector('input[name="password"]').value,
                confirmedPasswordInput.value
            );
            markValidation(confirmedPasswordInput, condition);
        },
        1000
    );
    return condition;
}
function mySubmitFunction(e) {
    e.preventDefault();
    return true;
}
function validateMyForm(event)
{
    event.preventDefault();
    return true;
}
emailInput.addEventListener('keyup', validateEmail);
confirmedPasswordInput.addEventListener('keyup', validatePassword);