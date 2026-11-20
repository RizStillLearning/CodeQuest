import './bootstrap';
import * as bootstrap from 'bootstrap';
import { focusFirstInvalidField, initPasswordReveal, initSubmitOnce } from './forms';
import { initTryQuestion } from './home/try-question';

initPasswordReveal();
initSubmitOnce();
focusFirstInvalidField();

document.querySelectorAll('[data-try-question]').forEach(initTryQuestion);

// Flash messages render visible (so they work without JS) and hide themselves after a while.
document.querySelectorAll('[data-autohide-toast]').forEach((element) => {
    bootstrap.Toast.getOrCreateInstance(element, { delay: 6000 }).show();
});
