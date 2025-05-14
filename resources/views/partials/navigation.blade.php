<nav>
    <div>
        <a href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
    </div>
    <div>
        @auth
            <span>Halo, {{ Auth::user()->name }}!</span>

            @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                <a href="{{ route('admin.karyawan.index') }}">Kelola Karyawan</a>
                <a href="{{ route('admin.absensi.index') }}">Rekap Absensi</a>
                <a href="{{ route('admin.gaji.index') }}">Penggajian</a>
            @elseif(Auth::user()->role == 'karyawan')
                <a href="{{ route('karyawan.dashboard') }}">Dashboard</a>
                <a href="{{ route('karyawan.absensi.riwayat') }}">Riwayat Absensi</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>