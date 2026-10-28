<!-- Language Switcher Component -->
<div class="lang-switch-container" aria-label="Pilihan bahasa">
    <button type="button" id="{{ $id ?? 'lang-btn' }}-id" class="lang-btn active" data-lang="id" title="Bahasa Indonesia">
        IDN
    </button>
    <button type="button" id="{{ $id ?? 'lang-btn' }}-en" class="lang-btn" data-lang="en" title="English">
        ENG
    </button>
</div>

<style>
.lang-switch-container {
    display: inline-flex;
    background: rgba(255, 255, 255, 0.94);
    border-radius: 8px;
    padding: 3px;
    gap: 2px;
}

.lang-btn {
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 6px;
    color: #2D6B22;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.15s ease;
}

.lang-btn:hover {
    background: rgba(45, 107, 34, 0.12);
}

.lang-btn.active {
    background: #2D6B22;
    color: #ffffff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
</style>
