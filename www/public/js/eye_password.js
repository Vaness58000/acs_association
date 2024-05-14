    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('.registration_form_plainPassword');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('bi-eye');
    });


    const togglePassword2 = document.querySelector('#togglePassword2');
    const password2 = document.querySelector('.registration_form_plainPassword2');
    if(togglePassword2 != undefined){
        togglePassword2.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password2.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('bi-eye');
        });
    }