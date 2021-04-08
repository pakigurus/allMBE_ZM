<!doctype html>
<html lang="en">
@include('layouts.head')
<body>

<div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed">
@include('layouts.sideOverlay')

@include('layouts.sidebar')

@include('layouts.navbar')

<!-- Main Container -->
    <main id="main-container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

        <div class="content content-narrow">
        <!-- Page Content -->

            @yield('content')

        <!-- END Page Content -->
        </div>
    </main>
    <!-- END Main Container -->

    @include('layouts.footer')


</div>
<!-- END Page Container -->

@include('layouts.scripts')
</body>
</html>
