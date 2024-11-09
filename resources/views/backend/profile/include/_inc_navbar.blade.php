{{-- <ul class="nav nav-tab-profile">
    <li class="nav-item {{ Route::currentRouteName() == 'get_admin.profile.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get_admin.profile.index') }}">Thông tin cá nhân</a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'get_admin.profile.update_password' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('get_admin.profile.update_password') }}">Đổi mật khẩu</a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'get_admin.profile.update_email' ? 'active' : '' }}">
        <a class="nav-link" title="Đổi email" href="{{ Route('get_admin.profile.update_email') }}">Đổi email đăng nhập</a>
    </li>
</ul> --}}

{{-- Cách 2 --}}
<ul class="nav nav-tab-profile">
    @foreach(config('tab_nav.backend.profile.tab_nav') ?? [] as $item )
        <li class="nav-item {{ Route::currentRouteName() == $item['route'] ? 'active' : '' }}">
            <a class="nav-link" href="{{ route($item['route']) }}">{{ $item['name'] }}</a>
        </li>
    @endforeach
</ul>
