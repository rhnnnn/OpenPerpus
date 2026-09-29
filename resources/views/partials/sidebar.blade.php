<div class="sidebar collapsed position-fixed top-0 start-0 bottom-0 border-end">
    <div class="d-flex align-items-center p-3">
        <a class="sidebar-logo fw-bold text-decoration-none text-white fs-4" href="{{ url('/') }}">OpenPerpus</a>
        <div class="sidebar-toggle-wrapper ms-auto">
            <i class="sidebar-toggle ri-arrow-left-s-line fs-5"></i>
        </div>
    </div>

    @if (request()->is('admin/*'))
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Admin Menu</li>
            <li class="sidebar-menu-item has-dropdown {{ request()->is('admin/*') ? 'focused' : '' }}">
                <a href="#">
                    <i class="ri-book-2-line sidebar-menu-item-icon"></i>
                    Data Perpustakaan
                    <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <li class="sidebar-dropdown-menu-item {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <a href="{{ url('admin/categories') }}">
                            <i class="ri-price-tag-3-line sidebar-menu-item-icon"></i> Kategori
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item {{ request()->is('admin/books*') ? 'active' : '' }}">
                        <a href="{{ url('admin/books') }}">
                            <i class="ri-book-open-line sidebar-menu-item-icon"></i> Buku
                        </a>
                    </li>
                    <li class="sidebar-dropdown-menu-item {{ request()->is('admin/borrowings*') ? 'active' : '' }}">
                        <a href="{{ url('admin/borrowings') }}">
                            <i class="ri-exchange-line sidebar-menu-item-icon"></i> Peminjaman
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        @endif
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Perpustakaan</li>
            <li class="sidebar-menu-item {{ request()->is('books*') ? 'active' : '' }}">
                <a href="{{ url('books') }}">
                    <i class="ri-book-open-line sidebar-menu-item-icon"></i> Katalog Buku
                </a>
            </li>
            <li class="sidebar-menu-item {{ request()->is('borrowings*') ? 'active' : '' }}">
                <a href="{{ url('borrowings') }}">
                    <i class="ri-history-line sidebar-menu-item-icon"></i> Riwayat Saya
                </a>
            </li>
        </ul>

    <div class="sidebar-footer d-flex justify-content-center align-items-center p-3">
        <div class="dropdown pb-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('img/default-avatar.svg') }}" alt="profile_image" width="30" height="30" class="rounded-circle">
                <div class="sidebar-logo p-2">
                    <div class="text text-white h5 mb-0">{{ auth()->user()->name ?? 'Guest' }}</div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ url('profile') }}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ url('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Log Out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
