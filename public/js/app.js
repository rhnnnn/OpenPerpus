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

(() => {
    const grid = document.getElementById('book-grid');
    if (!grid) return;

    const form = document.getElementById('book-search-form');
    const searchInput = document.getElementById('book-search');
    const categoryInput = document.getElementById('book-category');
    const chips = document.querySelectorAll('#category-chips .chip');

    const panelEmpty = document.getElementById('panel-empty');
    const panelContent = document.getElementById('panel-content');
    const panelCover = document.getElementById('panel-cover');
    const panelCoverTitle = document.getElementById('panel-cover-title');
    const panelTitle = document.getElementById('panel-title');
    const panelAuthor = document.getElementById('panel-author');
    const panelCategory = document.getElementById('panel-category');
    const panelStock = document.getElementById('panel-stock');
    const panelShowLink = document.getElementById('panel-show-link');
    const borrowForm = document.getElementById('borrow-form');
    const borrowBtn = document.getElementById('borrow-btn');

    let timer = null;
    let controller = null;

    const buildUrl = () => {
        const params = new URLSearchParams();
        const keyword = searchInput.value.trim();
        if (keyword) params.set('search', keyword);
        if (categoryInput.value) params.set('category_id', categoryInput.value);
        const query = params.toString();
        return grid.dataset.url + (query ? '?' + query : '');
    };

    const load = async url => {
        if (controller) controller.abort();
        const current = new AbortController();
        controller = current;
        grid.classList.add('is-loading');

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                signal: current.signal,
            });
            if (!response.ok) throw new Error(response.status);
            grid.innerHTML = await response.text();
            history.replaceState(null, '', url);
        } catch (error) {
            if (error.name === 'AbortError') return;
            grid.innerHTML = '<div class="empty-state"><i class="ri-error-warning-line"></i><p class="mb-0">Gagal memuat buku. Coba lagi.</p></div>';
        } finally {
            if (controller === current) grid.classList.remove('is-loading');
        }
    };

    searchInput.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => load(buildUrl()), 300);
    });

    form.addEventListener('submit', event => {
        event.preventDefault();
        clearTimeout(timer);
        load(buildUrl());
    });

    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            chips.forEach(item => item.classList.remove('active'));
            chip.classList.add('active');
            categoryInput.value = chip.dataset.category;
            load(buildUrl());
        });
    });

    const selectCard = card => {
        document.querySelectorAll('.book-card.selected').forEach(item => item.classList.remove('selected'));
        card.classList.add('selected');

        const { title, author, category, stock, tone, borrowAction, showUrl } = card.dataset;
        const available = Number(stock) > 0;

        panelCover.className = 'panel-cover tone-' + tone;
        panelCoverTitle.textContent = title;
        panelTitle.textContent = title;
        panelAuthor.textContent = author;
        panelCategory.textContent = category;
        panelStock.textContent = available ? stock + ' tersedia' : 'Habis';
        panelShowLink.href = showUrl;
        borrowForm.action = borrowAction;
        borrowBtn.disabled = !available;
        borrowBtn.innerHTML = available
            ? '<i class="ri-book-open-line me-1"></i> Pinjam Buku'
            : '<i class="ri-close-circle-line me-1"></i> Stok Habis';

        panelEmpty.hidden = true;
        panelContent.hidden = false;
    };

    grid.addEventListener('click', event => {
        const link = event.target.closest('.pagination a');
        if (link) {
            event.preventDefault();
            load(link.href);
            return;
        }

        const card = event.target.closest('.book-card');
        if (card) selectCard(card);
    });

    grid.addEventListener('keydown', event => {
        if (event.key !== 'Enter') return;
        const card = event.target.closest('.book-card');
        if (card) selectCard(card);
    });
})();
