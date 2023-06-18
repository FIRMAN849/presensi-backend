<aside class="sidebar">
    <a href="#" class="sidebar-logo">
        <div class="d-flex justify-content-start align-items-center">
            <img src="/img/global/logo.png" alt="" width="50px">
            <span>SMKN 2 <br> KRAKSAAN</span>
        </div>

        <button id="toggle-navbar" onclick="toggleNavbar()">
            <img src="img/global/navbar-times.svg" alt="">
        </button>
    </a>

    <h5 class="sidebar-title">Daily Use</h5>

    <a href="/dashboard" class="sidebar-item {{ $active === 'dashboard' ? 'active' : '' }}"
        onclick="toggleActive(this)">
        <!-- <img src="./assets/img/global/grid.svg" alt=""> -->

        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 14H14V21H21V14Z" stroke="white" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            <path d="M10 14H3V21H10V14Z" stroke="white" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            <path d="M21 3H14V10H21V3Z" stroke="white" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            <path d="M10 3H3V10H10V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <span>Dashboard</span>
    </a>

    <!-- <a href="./employees.html" class="sidebar-item"> -->
    <!-- <img src="./assets/img/global/users.svg" alt=""> -->
    <a href="/user" class="sidebar-item {{ $active === 'datauser' ? 'active' : '' }}" onclick="toggleActive(this)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <span>Data User</span>
    </a>

    <a href="/siswa" class="sidebar-item {{ $active === 'datasiswa' ? 'active' : '' }}" onclick="toggleActive(this)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <span>Data Siswa</span>
    </a>

    <a href="/kelas" class="sidebar-item {{ $active === 'kelas' ? 'active' : '' }}" onclick="toggleActive(this)">
        <i class='bx bx-home'></i>

        <span>Kelas</span>
    </a>

    <a href="/mapel" class="sidebar-item {{ $active === 'mapel' ? 'active' : '' }}" onclick="toggleActive(this)">
        <!-- <img src="./assets/img/global/dollar-sign.svg" alt=""> -->
        {{-- <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 1V23" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            <path
                d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg> --}}

        <i class='bx bx-book'></i>

        <span>Mapel</span>
    </a>

    <a href="/guru" class="sidebar-item {{ $active === 'guru' ? 'active' : '' }}" onclick="toggleActive(this)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z"
                stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <span>Data Guru</span>
    </a>

    <a href="/jadwal" class="sidebar-item {{ $active === 'jadwal' ? 'active' : '' }}" onclick="toggleActive(this)">
        <i class='bx bx-calendar'></i>

        <span>Jadwal</span>
    </a>

    <a href="/izin" class="sidebar-item {{ $active === 'izin' ? 'active' : '' }}" onclick="toggleActive(this)">
        <i class='bx bx-envelope'></i>

        <span>Izin</span>
    </a>

    <a href="/qrcode" class="sidebar-item {{ $active === 'qrcode' ? 'active' : '' }}" onclick="toggleActive(this)">
        <i class='bx bx-qr-scan'></i>
        <span>QR Presensi</span>
    </a>

    <a href="/absensi" class="sidebar-item {{ $active === 'absensi' ? 'active' : '' }}" onclick="toggleActive(this)">
        <i class='bx bx-qr-scan'></i>
        <span>Manajemen Presensi</span>
    </a>

    <h5 class="sidebar-title">Others</h5>

    <a href="/setting" class="sidebar-item {{ $active === 'setting' ? 'active' : '' }}" onclick="toggleActive(this)">
        <i class='bx bx-cog'></i>
        <span>Pengaturan</span>
    </a>

    <form action="/logout" method="post">
        @csrf
        <button type="submit" class="sidebar-item" style="border: none; width: 100%;">
            <!-- <img src="./assets/img/global/log-out.svg" alt=""> -->

            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M16 17L21 12L16 7" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M21 12H9" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9"
                    stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>Logout</span>
        </button>
    </form>

</aside>
