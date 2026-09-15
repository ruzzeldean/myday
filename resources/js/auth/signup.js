'use strict';

const form = document.getElementById('signup-form');
const submitBtn = document.getElementById('submit-btn');
const signupMsg = document.getElementById('signup-message');
const errorList = document.getElementById('error-list');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Processing...`;

    let isValid = true;

    const name = document.getElementById('name').value;
    const namehint = document.getElementById('name-hint');

    const username = document.getElementById('username').value;
    const usernamehint = document.getElementById('username-hint');

    const email = document.getElementById('email').value;
    const emailhint = document.getElementById('email-hint');

    const password_input = document.getElementById('password');
    const password = password_input.value;
    const passwordhint = document.getElementById('password-hint');

    const password_confirmation_input = document.getElementById(
        'password_confirmation'
    );
    const password_confirmation = password_confirmation_input.value;
    const password_confirmation_hint = document.getElementById(
        'password_confirmation-hint'
    );

    if (name.length < 2) {
        namehint.textContent = 'Name must be at least 2 characters long.';
        isValid = false;
    }

    if (username.length < 2) {
        usernamehint.textContent =
            'Username must be at least 2 characters long.';
        isValid = false;
    }

    if (email === '') {
        emailhint.textContent = 'Email is required.';
        isValid = false;
    }

    if (password.length < 8) {
        passwordhint.textContent =
            'Password must be at least 8 characters long.';
        isValid = false;
    }

    if (password !== password_confirmation) {
        password_input.setAttribute('aria-invalid', 'true');
        password_confirmation_input.setAttribute('aria-invalid', 'true');

        passwordhint.textContent = 'Passwords do not match.';
        password_confirmation_hint.textContent = 'Passwords do not match.';
        isValid = false;
    } else {
        password_input.removeAttribute('aria-invalid');
        password_confirmation_input.removeAttribute('aria-invalid');
    }

    if (!isValid) {
        submitBtn.textContent = 'Sign up';
        submitBtn.disabled = false;
        return;
    }

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-requested-With': 'XMLHttpRequest',
            },
            body: new FormData(form),
        });

        const data = await response.json();

        if (response.status === 422) {
            signupMsg.classList.add('alert-error');
            signupMsg.classList.remove('hidden');

            errorList.classList.remove('hidden');
            errorList.innerHTML = '';
            for (const [_, messages] of Object.entries(data.errors)) {
                messages.forEach((message) => {
                    const errorElement = document.createElement('li');
                    errorElement.textContent = message;
                    errorList.appendChild(errorElement);
                });
            }

            submitBtn.textContent = 'Sign up';
            submitBtn.disabled = false;
            return;
        }

        if (!response.ok) {
            signupMsg.classList.add('alert-error');
            signupMsg.classList.remove('hidden');

            errorList.classList.remove('hidden');
            errorList.innerHTML = '';

            const errorElement = document.createElement('li');
            errorElement.textContent = `${data.message}`;
            errorList.appendChild(errorElement);

            submitBtn.textContent = 'Sign in';
            submitBtn.disabled = false;
            return;
        }

        if (response.ok) {
            errorList.classList.add('hidden');
            signupMsg.classList.remove('alert-error');
            signupMsg.classList.add('alert-success');

            document
                .querySelectorAll('.success-message')
                .forEach((el) => el.classList.remove('hidden'));

            signupMsg.classList.remove('hidden');

            submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Redirecting...`;

            setTimeout(() => {
                window.location.href = '/explore';
            }, 3000);
            return;
        }
    } catch (error) {
        console.error('Network error:', error);
        submitBtn.textContent = 'Sign up';
        submitBtn.disabled = false;
    }
});
