'use strict';

const form = document.getElementById('edit-post-form');
const submitBtn = document.getElementById('submit-btn');
const serverMessage = document.getElementById('server-message');
const errorList = document.getElementById('error-list');
const successServerMsg = document.getElementById('success-server-message');

const titleInput = document.getElementById('title');
const titleHint = document.getElementById('title-hint');

const imageInput = document.getElementById('image');
const imageHint = document.getElementById('image-hint');

const allowedImageTypes = ['image/jpeg', 'image/png'];
const maxImageSize = 8 * 1024 * 1024;

const content = document.getElementById('content').value.trim();

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Processing...`;

    let isValid = true;

    const title = titleInput.value.trim();

    /* Validation */
    if (title.length < 2) {
        titleInput.setAttribute('aria-invalid', 'true');
        titleHint.textContent = 'Title must be at least 2 characters long.';
        isValid = false;
    } else {
        titleInput.removeAttribute('aria-invalid');
    }

    const image = imageInput.files[0];

    if (image) {
        if (!allowedImageTypes.includes(image.type)) {
            imageInput.setAttribute('aria-invalid', 'true');
            imageHint.textContent = 'Image must be a JPEG or PNG file.';
            isValid = false;
        } else if (image.size > maxImageSize) {
            imageInput.setAttribute('aria-invalid', 'true');
            imageHint.textContent = 'Image must not be larget than 8 MB.';
            isValid = false;
        } else {
            imageInput.removeAttribute('aria-invalid', 'true');
        }
    }

    if (!isValid) {
        submitBtn.textContent = 'Update';
        submitBtn.disabled = false;
        return;
    }

    /* Form submit */
    try {
        const response = await fetch(form.action, {
            method: 'PUT',
            headers: {
                Accept: 'application/json',
                'X-requested-With': 'XMLHttpRequest',
            },
            body: new FormData(form),
        });

        const data = await response.json();

        if (response.status === 422) {
            serverMessage.classList.add('alert-error');
            serverMessage.classList.remove('hidden');

            errorList.classList.remove('hidden');
            errorList.innerHTML = '';
            for (const [_, messages] of Object.entries(data.errors)) {
                messages.forEach((message) => {
                    const errorElement = document.createElement('li');
                    errorElement.textContent = message;
                    errorList.appendChild(errorElement);
                });
            }

            submitBtn.textContent = 'Update';
            submitBtn.disabled = false;
            return;
        }

        if (!response.ok) {
            serverMessage.classList.add('alert-error');
            serverMessage.classList.remove('hidden');

            errorList.classList.remove('hidden');
            errorList.innerHTML = '';

            const errorElement = document.createElement('li');

            errorElement.textContent = `${data.message}`;
            errorList.appendChild(errorElement);

            submitBtn.textContent = 'Update';
            submitBtn.disabled = false;
            return;
        }

        if (response.ok) {
            submitBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Updating...`;
            successServerMsg.textContent = data.message;

            errorList.classList.add('hidden');
            serverMessage.classList.remove('alert-error');
            serverMessage.classList.add('alert-success');

            document
                .querySelectorAll('.success-message')
                .forEach((el) => el.classList.remove('hidden'));

            serverMessage.classList.remove('hidden');

            window.location.reload();

            return;
        }
    } catch (error) {
        console.error(error);
        submitBtn.textContent = 'Update';
        submitBtn.disabled = false;
    }
});
