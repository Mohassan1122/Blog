
<!doctype html>
<html lang="en">

<head>
@include('backend.layout.header')
</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src=" {{ asset('backend/assets/images/logo-icon.svg') }} width="48" height="48" alt="Lucid"></div>
        <p>Please wait...</p>
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

   @include('backend.layout.navbar')

   @include('backend.layout.sidebar')

@yield('content')

</div>

@include('backend.layout.footer')
</body>
</html>
