<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-5">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ \Route::current()->getName() == 'home' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">@lang('html.navbar.home')</a>
        </li>
        <li class="nav-item {{ \Route::current()->getName() == 'france' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('france') }}">@lang('html.navbar.france')</a>
        </li>
    </ul>
</nav>
