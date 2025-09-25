<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8" />
<title>@yield('title', ' | FabKin Admin & Dashboards Template')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta content="Admin & Dashboards Template" name="description" />
<meta content="Pixeleyez" name="author" />

<!-- layout setup -->
<script type="module" src="assets/js/layout-setup.js" data-no-cache="1"></script>

<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/k_favicon_32x.png">

@yield('css')
@include('partials.head-css')
<link rel="stylesheet" href="assets/css/custom.css">

<style>
	/* Hide header brand logo in vertical layout to avoid double logos */
	[data-layout="vertical"] .app-header .fs-18.fw-semibold { display: none !important; }
	
</style>

<body>

    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-wrapper">
        <div class="container-fluid">
            @include('partials.page-title')

            @yield('content')

            @include('partials.switcher')
            @include('partials.scroll-to-top')
            @include('partials.footer')

            @include('partials.vendor-scripts')

            @yield('js')

</body>

</html>
