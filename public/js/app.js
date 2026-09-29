const $ = (selector, root = document) => root.querySelector(selector);
const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));

function initSidebar() {
    $$('.sidebar-menu-item.has-dropdown > a').forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            link.parentElement.classList.toggle('focused');
        });
    });

    const toggle = $('.sidebar-toggle');
    if (toggle) {
        toggle.addEventListener('click', () => toggle.classList.toggle('rotated'));
    }

    const sidebar = $('.sidebar');
    if (sidebar && window.innerWidth < 768) {
        sidebar.classList.add('collapsed');
    }
}

function initModalForms() {
    $$('.modal[data-fill-form]').forEach(modal => {
        modal.addEventListener('show.bs.modal', event => {
            const trigger = event.relatedTarget;
            const form = $('form', modal);
            if (!trigger || !form) return;

            Object.entries(trigger.dataset).forEach(([key, value]) => {
                if (key === 'action') {
                    form.action = value;
                    return;
                }
                const field = form.elements[key];
                if (field) field.value = value;
            });
        });
    });
}

function initAutoSubmit() {
    $$('[data-auto-submit]').forEach(element => {
        element.addEventListener('change', () => element.form.submit());
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initModalForms();
    initAutoSubmit();
});
