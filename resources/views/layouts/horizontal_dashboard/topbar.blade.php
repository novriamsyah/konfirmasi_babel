<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <!-- Dashboards -->
            <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ route('landing') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Beranda">Beranda</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('hubungi-kami') ? 'active' : '' }}">
                <a href="{{ route('contact') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-address-book"></i>
                    <div data-i18n="Hubungi kami">Hubungi kami</div>
                </a>
            </li>

            <li class="menu-item {{ request()->is('peserta/kartu-peserta') ? 'active' : '' }}">
                <a href="{{ route('get.kartu.peserta') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-id-badge"></i>
                    <div data-i18n="Cetak Kartu">Cetak Kartu</div>
                </a>
            </li>

            @if (Session::get('login') == 'login')
            <li class="menu-item {{ request()->is('scan_qrcode') ? 'active' : '' }}">
                <a href="{{ route('scan-qr') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-camera"></i>
                    <div data-i18n="Scan QR">Scan QR</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('acara*') ? 'active' : '' }}">
                <a href="{{ route('acara.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-calendar"></i>
                    <div data-i18n="Acara">Acara</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('report*') ? 'active' : '' }}">
                <a href="{{ route('get.halaman.report') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-folder"></i>
                    <div data-i18n="Report">Report</div>
                </a>
            </li>
            @endif

            @if (!Session::get('login') == 'login')
            <li class="menu-item">
                <a href="{{ route('login') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-key"></i>
                    <div data-i18n="Login">Login</div>
                </a>
            </li>
            
            @else
            <li class="menu-item">
                <a href="{{ route('logout') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-key"></i>
                    <div data-i18n="Logout">Logout</div>
                </a>
            </li>
            @endif
            <!-- <li class="menu-item">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-report"></i>
                    <div data-i18n="Report">Report</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-chart-pie-2"></i>
                            <div data-i18n="All">All</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-3d-cube-sphere"></i>
                            <div data-i18n="Energi Listrik">Energi Listrik</div>
                        </a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</aside>