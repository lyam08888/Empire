'use strict';

const changeAction = (type) => {
    if (type === 'login') {
        const url = `http://${document.loginForm.universe.value}/index.php`;
        document.getElementById('loginForm').action = url;
    } else if (type === 'getpw') {
        const url = `http://${document.loginForm.universe.value}/mail.php`;
        document.loginForm.action = url;
        document.loginForm.submit();
    } else if (type === 'register') {
        const url = `http://${document.registerForm.universe.value}/register.php`;
        document.registerForm.action = url;
    }
};
