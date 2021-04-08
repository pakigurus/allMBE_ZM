<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
@include('layouts.appNavbar')
<div class="container-fluid p-5">
    @yield('content')
</div>

@include('layouts.scripts')

</html>
