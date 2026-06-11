const loginWindow = document.getElementById('loginWindow');
const overlay = document.getElementById('overlay');

function openLoginClicked() {
    loginWindow.classList.add('active');
    overlay.classList.add('active');
}

function closeLoginClicked() {
    loginWindow.classList.remove('active');
    overlay.classList.remove('active');

    const loginErrorTextbox = document.getElementById("loginErrorTextbox");
    if (loginErrorTextbox) {
        loginErrorTextbox.remove();
    }
}

document.addEventListener("DOMContentLoaded", function()
{
    const loginErrorTextbox = document.getElementById('loginErrorTextbox');
    if (loginErrorTextbox) {
        openLoginClicked();
    }
});