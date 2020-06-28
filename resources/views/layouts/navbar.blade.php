<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                onclick="document.querySelector('#navbarSupportedContent').classList.toggle('collapse');">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ \Route::current()->getName() == 'texts-context' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('texts-context') }}">@lang('html.navbar.context')</a>
                </li>
                <li class="nav-item {{ \Route::current()->getName() == 'texts-what-we-do' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('texts-what-we-do') }}">@lang('html.navbar.what-we-do')</a>
                </li>
                <li class="nav-item {{ \Route::current()->getName() == 'france' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('france') }}">@lang('html.navbar.france')</a>
                </li>
                <li class="nav-item {{ \Route::current()->getName() == 'texts-how-to-help' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('texts-how-to-help') }}">@lang('html.navbar.how-to-help')</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

