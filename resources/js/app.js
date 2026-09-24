'use strict';

const textarea = document.querySelector('textarea');

function autoResize () {
  textarea.style.height = 'auto';
  textarea.style.height = textarea.scrollHeight + 'px';
}

if (textarea) {
  textarea.addEventListener('input', autoResize);
  autoResize();
}