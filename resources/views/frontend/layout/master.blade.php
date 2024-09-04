<!doctype html>
<html lang="en">

<head>
   @include('frontend.layout.head')

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Header Area -->
    <header class="header_area">
        <!-- Top Header Area -->
       @include('frontend.layout.header')
    </header>
    <!-- Header Area End -->

   @yield('content')
    <!-- Footer Area -->
    <footer class="footer_area section_padding_100_0">
        @include('frontend.layout.footer')
    </footer>
    <!-- Footer Area -->
{{-- script --}}
   @include('frontend.layout.script')
   {{--End script --}}
</body>

</html>
