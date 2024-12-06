@include('layout.header')
@yield('content')
{{ isset($slot) ? $slot : null}}
@include('layout.footer')