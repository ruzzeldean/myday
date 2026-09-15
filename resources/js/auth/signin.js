'use strict';

const form = document.getElementById('signin-form');
const submitBtn = document.getElementById('submit-btn');
const csrfToken = document.querySelector('input[name="_token"]').value;
const signinMsg = document.getElementById('signin-message');
const errorList = document.getElementById('error-list');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Processing...`;

    let isValid = true;

    const email = document.getElementById('email').value;
    const emailHint = document.getElementById('email-hint');

    const password = document.getElementById('password').value;
    const passwordHint = document.getElementById('password-hint');

    if (email === '') {
        emailHint.textContent = 'Email is required.';
        isValid = false;
    }

    if (password === '') {
        passwordHint.textContent = 'Password is required.';
        isValid = false;
    }

    if (!isValid) {
        submitBtn.textContent = 'Sign in';
        submitBtn.disabled = false;
        return;
    }

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ email, password }),
        });
        const data = await response.json();

        if (response.status === 422) {
            signinMsg.classList.add('alert-error');
            signinMsg.classList.remove('hidden');

            errorList.classList.remove('hidden');
            errorList.innerHTML = '';
            for (const [_, messages] of Object.entries(data.errors)) {
                messages.forEach((message) => {
                    const errorElement = document.createElement('li');
                    errorElement.textContent = message;
                    errorList.appendChild(errorElement);
                });
            }
            submitBtn.textContent = 'Sign in';
            submitBtn.disabled = false;
            return;
        }

        if (!response.ok) {
            signinMsg.classList.add('alert-error');
            signinMsg.classList.remove('hidden');

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
            signinMsg.classList.remove('alert-error');
            signinMsg.classList.add('alert-success');

            document
                .querySelectorAll('.success-message')
                .forEach((el) => el.classList.remove('hidden'));

            signinMsg.classList.remove('hidden');
            submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Redirecting...`;

            window.location.href = '/explore';
            return;
        }
    } catch (error) {
        console.error('Network error:', error);
        submitBtn.textContent = 'Sign in';
        submitBtn.disabled = false;
    }
});
