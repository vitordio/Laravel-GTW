// Google Captcha
const grecaptchaKeyMeta = document.querySelector("meta[name='grecaptcha-key']");
const grecaptchaKey = grecaptchaKeyMeta.getAttribute("content");

grecaptcha.ready(function() {
    let forms = document.querySelectorAll('form[data-grecaptcha-action]');

    Array.from(forms).forEach(function (form) {
        form.onsubmit = (e) => {
            e.preventDefault();

            const grecaptchaAction = form.getAttribute('data-grecaptcha-action');

            grecaptcha.execute(grecaptchaKey, {action: grecaptchaAction})
                .then((token) => {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'grecaptcha';
                    input.value = token;

                    form.append(input);

                    form.submit();
                });
        }
    });
});