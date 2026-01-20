<style>
    :root{
        --accent1: #4ade80; /* light green */
        --accent2: #16a34a; /* deep green */
        --btn-gradient: linear-gradient(90deg,var(--accent1),var(--accent2));
        --card-bg: #ffffff;
        --card-radius: 14px;
        --muted: #6b7280;
    }

    /* Page body */
    body, body.auth-page {
        background: linear-gradient(120deg, rgba(255,255,255,0.03), rgba(0,0,0,0.02)), url('{{ asset('assets/images/my/desa-sid.png') }}') center/cover no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    /* base font size for auth pages */
    body, .auth-card { font-size: 16px; }

    /* Card */
    .auth-card{
        position: relative;
        overflow: visible;
        background: var(--card-bg);
        border-radius: var(--card-radius);
        width: 100%;
        box-shadow: 0 12px 40px rgba(12, 34, 63, 0.12);
        border: none;
        color: #0b2545;
    }

    .auth-card h3{ font-size: 1.6rem; margin-bottom:0.25rem; }
    .auth-card h5{ font-size: 1.05rem; }

    .auth-card.small{ max-width: 480px; }
    .auth-card.wide{ max-width: 900px; }

    /* Accent bar for visual identity */
    .auth-card::before{
        content: '';
        position: absolute;
        left: 0;
        top: -8px;
        width: 80px;
        height: 8px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        background: var(--btn-gradient);
        box-shadow: 0 8px 26px rgba(22,163,74,0.12);
    }

    .form-label{ color:#0b2545; font-weight:600; }
    .form-label{ color:#0b2545; font-weight:600; font-size:1.05rem; }
    .form-control{ background:#f7fbff; border:1px solid #eef6ff; color:#0b2545; border-radius:8px; height:54px; font-size:1.02rem; padding:0.6rem 0.85rem; }
    .form-control:focus{ border-color: var(--accent2); box-shadow: 0 6px 18px rgba(22,163,74,0.12); background:#fff; }

    .btn-primary{ background: var(--btn-gradient); border:none; color:#fff; height:56px; border-radius:10px; font-weight:700; box-shadow:0 10px 32px rgba(22,163,74,0.12); font-size:1.08rem; padding:0 1.25rem; }
    .btn-primary:hover{ transform: translateY(-1px); }

    .link-primary, .text-secondary, .text-primary{ color: var(--accent2) !important; }

    .alert{ border-radius:10px; }

    .saprator{ text-align:center; margin:1rem 0; position:relative; }
    .saprator span{ background: var(--card-bg); padding:0 10px; color: var(--muted); font-size:1rem; }
    .saprator::before{ content:''; position:absolute; width:100%; height:1px; top:50%; left:0; background:#e6eef9; z-index:-1; }

    @media (max-width: 800px){ .auth-card{ max-width:100%; } }

    /* SSO button styles to match theme image */
    .sso-btn{
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: #fbfdff;
        border: 1px solid #eef6fb;
        color: #0b2545 !important;
        border-radius: 8px;
        box-shadow: 0 6px 18px rgba(12,34,63,0.04);
        text-align: left;
        font-weight: 600;
        font-size: 1rem;
    }

    .sso-btn img{ width:20px; height:20px; object-fit:contain; }

    .sso-btn:hover{
        background:#ffffff;
        transform: translateY(-1px);
    }

    .btn-light-primary, .btn-light-secondary, .btn-light-dark{ padding:0; }

    /* make small links (e.g. 'Belum punya akun?') easier to read */
    .link-primary.small, .link-primary{ font-size:1rem; font-weight:600; }
</style>
