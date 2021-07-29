<div class="page-header">
    <div class="d-flex justify-content-between">
        <div>    
            <h2 class="header-title">@lang('labels.menus')</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('home') }}" class="breadcrumb-item"><i class="anticon anticon-dashboard m-r-5"></i>@lang('labels.dashboard')</a>
                    <a class="breadcrumb-item" href="#">@lang('labels.configuracoes')</a>
                    <span class="breadcrumb-item active">@lang('labels.menus')</span>
                </nav>
            </div>
        </div>
        @can('CriarMenu')
            @if(Route::currentRouteName() === 'menu.index')
                <div>
                    <a href="{{ route('menu.create') }}" class="btn btn-primary m-r-5" target="_blank">@lang('labels.novo_registro')</a>
                </div>
            @endif
        @endcan
    </div>
</div>