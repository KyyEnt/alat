<style>
    /* NAVBAR ADMIN STYLES */
    .admin-navbar {
        width: 100%;
        background-color: #0f172a; /* Slate 900 */
        border-bottom: 1px solid #14b8a6; /* Teal border */
        padding: 12px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-sizing: border-box;
        font-family: 'IBM Plex Mono', monospace;
    }

    .navbar-brand {
        font-size: 16px;
        font-weight: 700;
        color: #2dd4bf; /* Teal 400 */
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .badge-admin {
        font-size: 10px;
        background-color: rgba(245, 158, 11, 0.15);
        color: #fbbf24; /* Amber */
        border: 1px solid rgba(245, 158, 11, 0.4);
        padding: 2px 6px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 20px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-link {
        font-size: 13px;
        color: #cbd5e1;
        text-decoration: none;
        transition: color 0.2s;
    }

    .nav-link:hover, .nav-link.active {
        color: #2dd4bf;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-left: 12px;
        border-left: 1px solid #334155;
    }

    .user-name {
        font-size: 12px;
        color: #94a3b8;
    }

    .btn-logout {
        background: none;
        border: 1px solid #f43f5e;
        color: #f43f5e;
        padding: 6px 12px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-logout:hover {
        background-color: #f43f5e;
        color: #ffffff;
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