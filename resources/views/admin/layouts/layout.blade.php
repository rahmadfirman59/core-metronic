<!DOCTYPE html>
<html lang="en">
<head>
    <base href="{{ url('/') }}" />
    <title>@yield('title') {{ env('APP_NAME') }}</title>
    <meta charset="utf-8" />
    <meta name="token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('css_plugins')
    <link href="{{ asset('assets_admin/plugins/custom/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets_admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
    @stack('styles')
</head>

<body id="kt_body" class="@yield('body-class')">
<script>let defaultThemeMode = "light"; let themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>

@yield('body')

@stack('modals')

<div id="error_log_display"></div>

<script>const hostUrl = "{{ asset('assets') }}/";</script>
<script src="{{ asset('assets_admin/plugins/global/plugins.bundle.js') }}"></script>
@stack('js_plugins')
<script src="{{ asset('assets_admin/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets_admin/plugins/custom/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets_admin/js/auto-numeric.js') }}"></script>
<script src="{{ asset('assets_admin/js/io.js') }}"></script>
<script>
    @if(session()->has('success'))
        swal.fire('{{ session('success') }}');
    @endif
    @if(session()->has('error'))
    Swal.fire({
        icon: "error",
        title: "{{ session('error') }}",
    });
    @endif
</script>
@stack('scripts')
</body>
</html>
