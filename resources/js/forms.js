/**
 * Small form helpers. Learner-facing text comes from data attributes in Blade.
 */

// Show/hide buttons on password fields ([data-reveal] holds the input id).
export function initPasswordReveal() {
    document.querySelectorAll('[data-reveal]').forEach((button) => {
        const input = document.getElementById(button.dataset.reveal);
        const icon = button.querySelector('[class^="pixelart-icons-font-"]');

        button.hidden = false;
        button.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(show));
            button.setAttribute('aria-label', show ? button.dataset.labelHide : button.dataset.labelShow);
            icon.classList.replace(show ? 'pixelart-icons-font-eye' : 'pixelart-icons-font-eye-off', show ? 'pixelart-icons-font-eye-off' : 'pixelart-icons-font-eye');
        });
    });
}

// Disable the submit button while a form is sending, so a double tap
// can't register the same account twice.
export function initSubmitOnce() {
    const forms = document.querySelectorAll('form[data-submit-once]');

    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.submitting) {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = 'true';
            form.querySelectorAll('button[type="submit"]').forEach((button) => {
                button.dataset.originalLabel = button.textContent;
                button.disabled = true;

                const spinner = document.createElement('span');
                spinner.className = 'spinner-border spinner-border-sm';
                spinner.setAttribute('aria-hidden', 'true');
                button.replaceChildren(spinner, ` ${button.dataset.loadingText}`);
            });
        });
    });

    // Pages restored with the browser's Back button keep their old state; reset it.
    window.addEventListener('pageshow', (event) => {
        if (!event.persisted) return;

        forms.forEach((form) => {
            delete form.dataset.submitting;
            form.querySelectorAll('button[type="submit"]').forEach((button) => {
                button.disabled = false;
                if (button.dataset.originalLabel) button.textContent = button.dataset.originalLabel;
            });
        });
    });
}

export function focusFirstInvalidField() {
    document.querySelector('form .is-invalid')?.focus();
}
