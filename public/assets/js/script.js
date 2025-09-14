<<<<<<< HEAD
const wrapper = document.querySelector(".wrapper");
const registerLink = document.querySelector(".register-link");
const loginLink = document.querySelector(".login-link");
const loginPopupBtn = document.querySelector(".login-pop");
const iconClose = document.querySelector(".icon-close");

// Show login/register popup
loginPopupBtn.onclick = () => {
    wrapper.classList.add("active-popup");
};

// Hide popup
iconClose.onclick = () => {
    wrapper.classList.remove("active-popup");
    wrapper.classList.remove("active"); // reset to login
};

// Switch to register form
// registerLink.onclick = () => {
//     wrapper.classList.add("active");
// };

// Switch back to login form
loginLink.onclick = () => {
    wrapper.classList.remove("active");
};
=======
const wrapper = document.querySelector(".wrapper");
const registerLink = document.querySelector(".register-link");
const loginLink = document.querySelector(".login-link");
const loginPopupBtn = document.querySelector(".login-pop");
const iconClose = document.querySelector(".icon-close");

// Show login/register popup
loginPopupBtn.onclick = () => {
    wrapper.classList.add("active-popup");
};

// Hide popup
iconClose.onclick = () => {
    wrapper.classList.remove("active-popup");
    wrapper.classList.remove("active"); // reset to login
};

// Switch to register form
// registerLink.onclick = () => {
//     wrapper.classList.add("active");
// };

// Switch back to login form
loginLink.onclick = () => {
    wrapper.classList.remove("active");
};
>>>>>>> 608070bb6edcc1ac30574973e4c7f8822926a93f
