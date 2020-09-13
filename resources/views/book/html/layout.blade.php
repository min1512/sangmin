<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>
    <link rel="stylesheet" type="text/css" href="{{ url('https://unpkg.com/lightpick@latest/css/lightpick.css') }}" />
    <link rel="stylesheet" href="{{ asset('booking/css/_awesomeall.css') }}" />
    <link rel="stylesheet" href="{{ asset('booking/css/jquery.mCustomScrollbar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('booking/css/common.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('booking/css/reservation.min.css') }}" />
    @yield("scripts")
    @yield("styles")
    <script src="{{ url('https://code.jquery.com/jquery-3.5.1.min.js') }}"></script>
    
    <script src="{{ asset('booking/js/lib/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ asset('booking/js/lib/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ asset('booking/js/lib/moment.js') }}"></script>
    <script src="{{ asset('booking/js/lib/lightpick.js') }}"></script>
    <script src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('booking/js/common.js') }}"></script>

</head>
<body>
@yield("contents")
<div class="dim1"></div>
</body>
</html>
