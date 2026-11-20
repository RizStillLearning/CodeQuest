/**
 * Homepage "try a question" card.
 *
 * This is a demo for visitors: the answer is checked in the browser and no XP
 * is saved. Real questions are checked on the server, which also awards XP.
 * All learner-facing text comes from data attributes in the Blade view.
 */

// Same rule as content/README.md: compare after trimming the start and end.
const normalize = (value) => value.replace(/\r\n?/g, '\n').trim();

export function initTryQuestion(root) {
    const answers = JSON.parse(root.dataset.answers).map(normalize);
    const form = root.querySelector('[data-try-form]');
    const input = root.querySelector('[data-answer-input]');
    const options = root.querySelectorAll('[data-option]');
    const hint = root.querySelector('[data-hint]');
    const feedback = root.querySelector('[data-feedback]');
    const feedbackTitle = root.querySelector('[data-feedback-title]');
    const next = root.querySelector('[data-next]');
    const xpChip = root.querySelector('[data-xp-chip]');

    const isCorrect = (value) => answers.includes(normalize(value));

    const showFeedback = (correct) => {
        hint.hidden = true;
        feedback.classList.toggle('is-correct', correct);
        feedback.classList.toggle('is-wrong', !correct);
        feedbackTitle.textContent = correct ? root.dataset.textCorrect : root.dataset.textWrong;

        // Re-insert so screen readers announce repeat answers too.
        feedback.hidden = true;
        requestAnimationFrame(() => {
            feedback.hidden = false;
            next.hidden = false;
        });

        if (correct) {
            xpChip.classList.remove('is-earned');
            void xpChip.offsetWidth; // restart the animation
            xpChip.classList.add('is-earned');
        }
    };

    // Typed answers (predict the output, fill in the code).
    if (input) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            if (normalize(input.value) === '') {
                hint.textContent = root.dataset.textEmpty;
                hint.hidden = false;
                input.focus();
                return;
            }

            const correct = isCorrect(input.value);
            input.classList.toggle('is-valid', correct);
            input.classList.toggle('is-invalid', !correct);
            showFeedback(correct);
        });

        input.addEventListener('input', () => {
            input.classList.remove('is-valid', 'is-invalid');
            hint.hidden = true;
        });
    }

    // Option buttons (multiple choice, case study).
    options.forEach((button) => {
        button.addEventListener('click', () => {
            const correct = isCorrect(button.dataset.option);

            options.forEach((option) => {
                option.disabled = true;
                if (isCorrect(option.dataset.option)) option.classList.add('is-correct');
            });

            if (!correct) button.classList.add('is-wrong');
            button.setAttribute('aria-pressed', 'true');
            showFeedback(correct);
        });
    });
}
