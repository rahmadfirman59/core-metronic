const showPasswordElement = document.querySelector('#viewModal #showPassword');

showPasswordElement.addEventListener('click', function(_) {
  const isHidden = showPasswordElement.getAttribute('aria-hidden');
  const passwordInput = document.querySelector('#viewModal input')
  const eyeIcon = showPasswordElement.querySelector('i');

  if (isHidden === 'true') {
    passwordInput.setAttribute('type', 'text');
    showPasswordElement.setAttribute('aria-hidden', false);
    eyeIcon.className = 'far fa-eye'
  } else {
    passwordInput.setAttribute('type', 'password');
    showPasswordElement.setAttribute('aria-hidden', true);
    eyeIcon.className = 'far fa-eye-slash'
  }
});