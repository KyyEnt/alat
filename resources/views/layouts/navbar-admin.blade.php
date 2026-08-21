<style>
    /* NAVBAR ADMIN STYLES (MONOCHROME MODERN) */
    :root {
        --nav-bg: #ffffff;
        --nav-border: #e2e8f0;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --accent-subtle: #f1f5f9;
        --border-hover: #cbd5e1;
    }

    .admin-navbar {
        width: 100%;
        background-color: var(--nav-bg);
        border-bottom: 1px solid var(--nav-border);
        padding: 14px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
        font-family: 'IBM Plex Mono', monospace;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .navbar-brand {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.5px;
    }

    .badge-admin {
        font-size: 10px;
        background-color: var(--text-main);
        color: #ffffff;
        padding: 3px 8px;
        border-radius: 20px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 8px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-link {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 6px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-link:hover {
        color: var(--text-main);
        background-color: var(--accent-subtle);
    }

    .nav-link.active {
        color: var(--text-main);
        background-color: var(--accent-subtle);
        font-weight: 600;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-left: 20px;
        margin-left: 12px;
        border-left: 1px solid var(--nav-border);
    }

    .user-name {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-main);
    }

    .btn-logout {
        background: var(--nav-bg);
        border: 1px solid var(--nav-border);
        color: var(--text-muted);
        padding: 7px 14px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-logout:hover {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #991b1b;
    }
</style>

<nav class="admin-navbar">
    <a href="{{ route('admin.index') }}" class="navbar-brand">
        SiAlat <span class="badge-admin">ADMIN</span>
    </a>

    <ul class="navbar-menu">
        <li><a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="#" class="nav-link">Data Alat</a></li>
        <li><a href="#" class="nav-link">Peminjaman</a></li>
        <li><a href="#" class="nav-link">User/Petugas</a></li>
        
        <li class="user-profile">
            <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
            
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    Keluar
                </button>
            </form>
        </li>
    </ul>
</nav>