<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Unbounded:wght@500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --rn-font: 'Manrope', system-ui, -apple-system, sans-serif;
        --rn-font-display: 'Unbounded', var(--rn-font);

        --rn-50:  #fff6f9;
        --rn-100: #ffe9f1;
        --rn-200: #ffd4e3;
        --rn-300: #ffb3cd;
        --rn-400: #ff85ae;
        --rn-500: #ff5792;
        --rn-600: #f5327a;
        --rn-700: #d61d66;
        --rn-800: #a8134e;
        --rn-900: #7c0e3a;

        --rn-primary: var(--rn-600);
        --rn-primary-hover: var(--rn-700);
        --rn-secondary: var(--rn-100);
        --rn-secondary-hover: var(--rn-200);

        --rn-bg: var(--rn-50);
        --rn-surface: #ffffff;
        --rn-ink: #4a0f26;
        --rn-ink-soft: #6d2440;
        --rn-muted: #a86a84;
        --rn-border: var(--rn-200);
        --rn-border-soft: var(--rn-100);

        --rn-grad: linear-gradient(135deg, #ff85ae 15%, #e976a0 50%, #e97ca7 100%);
        --rn-grad-soft: linear-gradient(135deg, #fff6f9 10%, #ffe9f1 100%);

        --rn-shadow-sm: 0 2px 10px rgba(214, 29, 102, .06);
        --rn-shadow: 0 10px 30px rgba(214, 29, 102, .12);
        --rn-shadow-lg: 0 20px 50px rgba(214, 29, 102, .18);

        --rn-radius: 1rem;
        --rn-radius-lg: 1.5rem;
        --rn-radius-xl: 2rem;

        --bs-primary: var(--rn-600);
        --bs-primary-rgb: 245, 50, 122;
        --bs-body-bg: var(--rn-bg);
        --bs-body-color: var(--rn-ink);
        --bs-border-radius: var(--rn-radius);
        --bs-border-radius-lg: var(--rn-radius-lg);
        --bs-font-sans-serif: var(--rn-font);
    }

    body {
        font-family: var(--rn-font);
        background-color: var(--rn-bg);
        color: var(--rn-ink);
        min-height: 100vh;
        -webkit-font-smoothing: antialiased;
        background-image:
            radial-gradient(60rem 30rem at 110% -10%, rgba(255, 179, 205, .22), transparent 60%),
            radial-gradient(50rem 26rem at -10% 0%, rgba(255, 179, 205, .16), transparent 60%);
        background-attachment: fixed;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 800;
        color: var(--rn-ink);
        letter-spacing: -.02em;
    }

    main.container {
        padding-bottom: 5rem;
        padding-top: 2.5rem;
    }

    ::selection {
        background: var(--rn-300);
        color: var(--rn-900);
    }

    .navbar-salon {
        background: rgba(255, 255, 255, .85) !important;
        backdrop-filter: blur(14px) saturate(1.4);
        -webkit-backdrop-filter: blur(14px) saturate(1.4);
        border-bottom: 1px solid var(--rn-border-soft);
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .navbar-salon .navbar-brand {
        font-family: var(--rn-font-display);
        background: var(--rn-grad);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent !important;
        font-weight: 700;
        font-size: 1.35rem;
    }

    .navbar-salon .nav-link {
        color: var(--rn-ink-soft) !important;
        font-weight: 700;
        font-size: .9rem;
        padding: .5rem .95rem !important;
        border-radius: 3rem;
        margin-left: .15rem;
        transition: all .2s ease;
    }

    .navbar-salon .nav-link i {
        color: var(--rn-primary);
        margin-right: .4rem;
    }

    .navbar-salon .nav-link:hover {
        color: var(--rn-700) !important;
        background: var(--rn-100);
    }

    .navbar-salon .nav-link.active {
        background: var(--rn-grad);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(245, 50, 122, .35);
    }

    .navbar-salon .nav-link.active i {
        color: #ffffff;
        opacity: .9;
    }

    .navbar-salon .btn-link.nav-link {
        color: var(--rn-muted) !important;
    }

    .navbar-salon .btn-link.nav-link:hover {
        color: var(--rn-700) !important;
        background: var(--rn-100);
    }

    .footer-salon {
        background: var(--rn-100);
        border-top: 1px solid var(--rn-border-soft);
        color: var(--rn-800);
        padding: 2.5rem 0;
        text-align: center;
        font-size: .9rem;
    }

    .footer-salon .brand-line {
        font-family: var(--rn-font-display);
        background: var(--rn-grad);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: .5rem;
    }

    .footer-salon .text-muted {
        color: var(--rn-muted) !important;
    }

    .card {
        border: 1px solid var(--rn-border-soft);
        border-radius: var(--rn-radius-lg);
        box-shadow: var(--rn-shadow-sm);
        background-color: var(--rn-surface);
        color: var(--rn-ink);
        overflow: hidden;
        transition: box-shadow .25s ease, transform .25s ease;
    }

    .card:hover {
        box-shadow: var(--rn-shadow);
    }

    .card-header {
        background-color: var(--rn-surface) !important;
        border-bottom: 1px solid var(--rn-border-soft) !important;
        color: var(--rn-ink) !important;
        font-weight: 800;
        padding: 1.4rem 1.6rem;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
        gap: .6rem;
    }

    .card-header i {
        color: var(--rn-primary);
    }

    .card-body {
        padding: 1.6rem;
    }

    .card-header.bg-primary,
    .card-header.bg-success,
    .card-header.bg-info,
    .card-header.bg-warning,
    .card-header.bg-secondary,
    .card-header.bg-dark {
        background: var(--rn-grad) !important;
        color: #ffffff !important;
        border-bottom: none !important;
    }

    .card-header.bg-primary i,
    .card-header.bg-success i,
    .card-header.bg-info i,
    .card-header.bg-warning i,
    .card-header.bg-secondary i,
    .card-header.bg-dark i {
        color: #ffffff;
        opacity: .9;
    }

    .btn {
        font-family: var(--rn-font);
        font-weight: 800;
        border-radius: 3rem;
        padding: .65rem 1.6rem;
        transition: all .2s;
        font-size: .92rem;
        letter-spacing: .01em;
    }

    .btn-primary {
        background: var(--rn-grad);
        border: none;
        color: #ffffff !important;
        box-shadow: 0 2px 18px rgba(245, 50, 122, .35);
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: var(--rn-grad);
        filter: brightness(1.06);
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(245, 50, 122, .45);
    }

    .btn-outline-primary {
        color: var(--rn-700) !important;
        border: 2px solid var(--rn-300);
        background-color: #ffffff;
    }

    .btn-outline-primary:hover {
        background-color: var(--rn-100);
        border-color: var(--rn-500);
        color: var(--rn-800) !important;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: var(--rn-100);
        border: 1px solid var(--rn-100);
        color: var(--rn-700) !important;
    }

    .btn-secondary:hover {
        background-color: var(--rn-200);
        color: var(--rn-800) !important;
    }

    .btn-danger {
        background: var(--rn-700);
        border: none;
        color: #ffffff !important;
    }

    .btn-danger:hover {
        background: var(--rn-800);
    }

    .btn-warning {
        background: var(--rn-100);
        border: 1px solid var(--rn-200);
        color: var(--rn-700) !important;
    }

    .btn-warning:hover {
        background: var(--rn-200);
        color: var(--rn-800) !important;
    }

    .btn-sm.btn-warning,
    .btn-sm.btn-danger {
        width: 2.4rem;
        height: 2.4rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: .85rem;
    }

    .form-control,
    .form-select {
        border-radius: .9rem;
        border: 2px solid var(--rn-border-soft);
        padding: .75rem 1.15rem;
        font-family: var(--rn-font);
        font-weight: 600;
        color: var(--rn-ink) !important;
        background-color: #ffffff !important;
        transition: all .2s;
    }

    .form-control::placeholder {
        color: var(--rn-muted);
        opacity: .7;
        font-weight: 500;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--rn-400);
        box-shadow: 0 0 0 4px rgba(255, 133, 174, .22);
        background-color: #ffffff !important;
    }

    .form-label {
        font-weight: 800;
        color: var(--rn-ink-soft);
        font-size: .85rem;
        margin-bottom: .45rem;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .form-text {
        color: var(--rn-muted);
    }

    .form-check-input:checked {
        background-color: var(--rn-primary);
        border-color: var(--rn-primary);
    }

    .form-check-input:focus {
        border-color: var(--rn-400);
        box-shadow: 0 0 0 3px rgba(255, 133, 174, .25);
    }

    .table-responsive {
        border-radius: var(--rn-radius-lg);
        background-color: var(--rn-surface);
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        color: var(--rn-ink) !important;
    }

    .table thead th {
        background-color: var(--rn-50) !important;
        color: var(--rn-muted) !important;
        font-weight: 800;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        border-bottom: 1px solid var(--rn-border-soft) !important;
        padding: .95rem 1.25rem;
        white-space: nowrap;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1.15rem 1.25rem;
        border-bottom: 1px solid var(--rn-border-soft);
        color: var(--rn-ink) !important;
        background-color: var(--rn-surface) !important;
        font-weight: 600;
    }

    .table tbody tr {
        transition: background .15s;
    }

    .table tbody tr:hover td {
        background-color: var(--rn-50) !important;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: var(--rn-surface) !important;
        box-shadow: none !important;
    }

    .table .text-muted {
        color: var(--rn-muted) !important;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem 1rem;
        border-radius: 2rem;
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
        white-space: nowrap;
    }

    .status-badge::before {
        content: '';
        width: .45rem;
        height: .45rem;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        background: var(--rn-100);
        color: var(--rn-700);
    }

    .status-confirmed {
        background: var(--rn-grad);
        color: #ffffff;
    }

    .status-completed {
        background: var(--rn-200);
        color: var(--rn-900);
    }

    .status-cancelled {
        background: var(--rn-100);
        color: var(--rn-muted);
    }

    .page-heading {
        font-family: var(--rn-font-display);
        font-weight: 700;
        color: var(--rn-ink) !important;
        margin-bottom: 0;
        font-size: clamp(1.4rem, 3vw, 2rem);
        letter-spacing: -.01em;
    }

    .page-heading i {
        color: var(--rn-primary);
    }

    .page-subtitle {
        color: var(--rn-muted);
        font-weight: 600;
        margin-top: .35rem;
        font-size: .98rem;
    }

    .rn-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: var(--rn-grad);
        color: #ffffff;
        font-family: var(--rn-font-display);
        font-size: 2rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(245, 50, 122, .35);
    }

    .rn-role-pill {
        display: inline-block;
        background: var(--rn-grad);
        color: #ffffff;
        padding: .35rem 1.1rem;
        border-radius: 3rem;
        font-size: .75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        box-shadow: 0 4px 12px rgba(245, 50, 122, .3);
    }

    .rn-price {
        font-family: var(--rn-font-display);
        font-weight: 700;
        color: var(--rn-700);
        font-size: 1.05rem;
        white-space: nowrap;
    }

    .rn-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: var(--rn-100);
        color: var(--rn-700);
        padding: .3rem .85rem;
        border-radius: 3rem;
        font-size: .78rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .rn-chip-dark {
        background: var(--rn-grad);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(245, 50, 122, .3);
    }

    .rn-discount {
        background: var(--rn-grad);
        color: #ffffff;
        padding: .3rem .8rem;
        border-radius: 3rem;
        font-size: .78rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .old-price {
        text-decoration: line-through;
        color: var(--rn-muted);
        font-size: .85rem;
        font-weight: 600;
    }

    .hero-salon {
        background: #ffffff;
        border: 1px solid var(--rn-border-soft);
        padding: 5rem 2rem;
        margin: 2.5rem auto 4rem;
        border-radius: var(--rn-radius-xl);
        text-align: center;
        box-shadow: var(--rn-shadow);
        position: relative;
        overflow: hidden;
    }

    .hero-salon::before {
        content: '';
        position: absolute;
        width: 24rem;
        height: 24rem;
        border-radius: 50%;
        background: radial-gradient(circle, var(--rn-200), transparent 70%);
        top: -12rem;
        right: -7rem;
        opacity: .55;
        pointer-events: none;
    }

    .hero-salon::after {
        content: '';
        position: absolute;
        width: 20rem;
        height: 20rem;
        border-radius: 50%;
        background: radial-gradient(circle, var(--rn-100), transparent 70%);
        bottom: -10rem;
        left: -6rem;
        opacity: .8;
        pointer-events: none;
    }

    .hero-salon > * {
        position: relative;
        z-index: 1;
    }

    .hero-overline {
        display: inline-block;
        background: var(--rn-100);
        color: var(--rn-700);
        padding: .45rem 1.2rem;
        border-radius: 3rem;
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .18em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .hero-salon h1 {
        background: var(--rn-grad);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent !important;
        font-family: var(--rn-font-display);
        font-size: clamp(1.7rem, 4.5vw, 3rem);
        font-weight: 700;
        margin-bottom: 1.5rem;
        line-height: 1.15;
    }

    .hero-salon .lead {
        color: var(--rn-ink-soft) !important;
        font-size: 1.15rem;
        font-weight: 600;
        max-width: 620px;
        margin: 0 auto 2.5rem;
        line-height: 1.6;
    }

    .dash-welcome-card {
        background: var(--rn-grad) !important;
        border: none;
        box-shadow: var(--rn-shadow-lg);
        border-radius: var(--rn-radius-xl) !important;
    }

    .dash-welcome-card h4 {
        color: #ffffff !important;
        font-family: var(--rn-font-display);
        font-weight: 700;
        font-size: 1.6rem;
        margin-bottom: .5rem;
    }

    .dash-welcome-card p {
        color: rgba(255, 255, 255, .92) !important;
        font-size: 1.05rem;
        font-weight: 600;
    }

    .stat-card-soft {
        background-color: var(--rn-surface) !important;
        border: 1px solid var(--rn-border-soft) !important;
        box-shadow: var(--rn-shadow-sm) !important;
        border-radius: var(--rn-radius-lg) !important;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card-soft:hover {
        transform: translateY(-4px);
        box-shadow: var(--rn-shadow) !important;
    }

    .stat-card-soft .card-body {
        color: var(--rn-ink) !important;
        padding: 1.6rem;
    }

    .stat-card-soft h5 {
        color: var(--rn-muted) !important;
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-bottom: .9rem;
    }

    .stat-card-soft .display-4 {
        font-family: var(--rn-font-display);
        font-weight: 700;
        background: var(--rn-grad);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent !important;
        font-size: 2.6rem;
        line-height: 1;
    }

    .stat-card-soft.bg-info,
    .stat-card-soft.bg-warning,
    .stat-card-soft.bg-success,
    .stat-card-soft.bg-primary,
    .stat-card-soft.bg-secondary,
    .stat-card-soft.bg-dark {
        background-color: var(--rn-surface) !important;
    }

    .quick-actions .btn {
        background-color: var(--rn-surface);
        border: 2px solid var(--rn-border-soft);
        color: var(--rn-ink) !important;
        text-align: left;
        padding: 1.2rem 1.5rem;
        font-weight: 800;
        border-radius: var(--rn-radius);
        transition: all .2s;
        box-shadow: var(--rn-shadow-sm);
    }

    .quick-actions .btn:hover {
        background: var(--rn-100);
        border-color: var(--rn-300);
        color: var(--rn-700) !important;
        transform: translateY(-3px);
        box-shadow: var(--rn-shadow);
    }

    #map {
        border-radius: 0 0 var(--rn-radius-lg) var(--rn-radius-lg);
        min-height: 440px;
        width: 100%;
        border: none;
    }

    .promo-section {
        margin-bottom: 4rem;
    }

    .promo-card {
        border: 1px solid var(--rn-border-soft);
        border-radius: var(--rn-radius-lg);
        background-color: var(--rn-surface);
        height: 100%;
        overflow: hidden;
        box-shadow: var(--rn-shadow-sm);
        transition: transform .2s, box-shadow .2s;
        padding: 0;
    }

    .promo-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--rn-shadow);
    }

    .promo-card-header {
        padding: 1.5rem 1.75rem 0;
    }

    .promo-card-body {
        padding: .9rem 1.75rem 1.1rem;
    }

    .promo-card-footer {
        padding: 0 1.75rem 1.6rem;
    }

    .promo-card-desc {
        color: var(--rn-muted);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .promo-price-row {
        display: flex;
        align-items: baseline;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .promo-save-badge {
        background: var(--rn-grad);
        color: #ffffff;
        padding: .25rem .75rem;
        border-radius: 3rem;
        font-weight: 800;
        font-size: .78rem;
    }

    .promo-meta {
        color: var(--rn-muted);
        font-size: .85rem;
        font-weight: 600;
        margin: .6rem 0 0;
    }

    .promo-combo-items {
        list-style: none;
        padding: 0;
        margin: 0 0 1rem;
    }

    .promo-combo-items li {
        position: relative;
        padding-left: 1.4rem;
        font-weight: 700;
        margin-bottom: .35rem;
    }

    .promo-combo-items li::before {
        content: '';
        position: absolute;
        left: 0;
        top: .48em;
        width: .5rem;
        height: .5rem;
        border-radius: 50%;
        background: var(--rn-grad);
    }

    .promo-label {
        background: var(--rn-grad);
        color: #ffffff;
        padding: .35rem .9rem;
        border-radius: 3rem;
        font-weight: 800;
        font-size: .72rem;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .promo-card-title {
        font-weight: 800;
        font-size: 1.3rem;
        color: var(--rn-ink);
        margin-bottom: .25rem;
    }

    .promo-price-new {
        background: var(--rn-grad);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 800;
        font-size: 1.8rem;
    }

    .promo-price-old {
        text-decoration: line-through;
        color: var(--rn-muted);
        font-size: 1rem;
        font-weight: 600;
    }

    .service-card {
        transition: all .2s;
        border-radius: var(--rn-radius-lg) !important;
        border: 1px solid var(--rn-border-soft);
    }

    .service-card:hover {
        border-color: var(--rn-300);
        box-shadow: var(--rn-shadow);
        transform: translateY(-3px);
    }

    .modal-content {
        border: none;
        border-radius: var(--rn-radius-lg);
        box-shadow: var(--rn-shadow-lg);
        overflow: hidden;
    }

    .modal-header {
        background: var(--rn-grad);
        color: #ffffff;
        border-bottom: none;
        padding: 1.4rem 1.6rem;
    }

    .modal-header .modal-title {
        color: #ffffff;
        font-weight: 800;
    }

    .modal-header .btn-close {
        filter: invert(1) grayscale(100%);
        opacity: .85;
    }

    .modal-footer {
        border-top: 1px solid var(--rn-border-soft);
    }

    .alert {
        border: none;
        border-radius: var(--rn-radius);
        font-weight: 700;
    }

    .alert-success {
        background: var(--rn-100);
        color: var(--rn-800);
    }

    .alert-danger {
        background: var(--rn-200);
        color: var(--rn-900);
    }

    @media (min-width: 768px) {
        .rn-sticky {
            position: sticky;
            top: 6rem;
        }
    }

    .rn-section-title {
        font-family: var(--rn-font-display);
        font-size: 1.15rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: .75rem;
        margin: 0 0 1.25rem;
    }

    .rn-section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--rn-200), transparent);
    }

    .rn-section-title i {
        width: 2.4rem;
        height: 2.4rem;
        border-radius: .8rem;
        background: var(--rn-grad);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .rn-tabs .nav-link {
        color: var(--rn-ink-soft) !important;
        font-weight: 800;
        border-radius: 3rem !important;
        padding: .6rem 1.5rem;
        border: 2px solid var(--rn-border-soft) !important;
        background: #ffffff;
        margin-right: .5rem;
    }

    .rn-tabs .nav-link:hover {
        background: var(--rn-100);
        color: var(--rn-700) !important;
    }

    .rn-tabs .nav-link.active {
        background: var(--rn-grad) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(245, 50, 122, .35);
    }
</style>