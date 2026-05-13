<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .alert-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 16px;
        border-radius: 12px;
        border: 1px solid transparent;
        border-left-width: 4px;
        font-size: 0.86rem;
        font-weight: 500;
        line-height: 1.4;
        margin-bottom: 8px;
    }

    .alert-modern-success {
        background: rgba(16, 185, 129, 0.07);
        border-color: rgba(16, 185, 129, 0.2);
        border-left-color: #10b981;
        color: #065f46;
    }

    .alert-modern-error {
        background: rgba(200, 16, 46, 0.06);
        border-color: rgba(200, 16, 46, 0.18);
        border-left-color: #C8102E;
        color: #C8102E;
    }

    .alert-modern .alert-modern-icon {
        font-size: 1rem;
        flex-shrink: 0;
    }

    .alert-modern .alert-modern-text { flex: 1; }

    .alert-modern .btn-close {
        margin-left: auto;
        flex-shrink: 0;
        opacity: 0.35;
        filter: none;
        font-size: 0.72rem;
    }

    .alert-modern-success .btn-close { color: #065f46; }
    .alert-modern-error .btn-close   { color: #C8102E; }

    .alert-modern .btn-close:hover { opacity: 0.85; }
</style>

<div class="pt-4">
    @if (session('success'))
        <div class="alert alert-modern alert-modern-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle alert-modern-icon"></i>
            <span class="alert-modern-text">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-modern alert-modern-error alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle alert-modern-icon"></i>
            <span class="alert-modern-text">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
