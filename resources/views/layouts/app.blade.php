<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/gif" sizes="16x16">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSRF Token -->
    <title> منظومة الشحن والتفريغ </title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <style>
        .toast {
            font-size: 1.5rem;
        }

        .toast-success {
            background-color: #278a27 !important;
        }

    </style>
    @yield('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('a6bf85244260ce098471', {
            cluster: 'eu'
        });

        var pusher2 = new Pusher('027ae0da475a8bfb329b', {
            cluster: 'eu'
        });
    </script>
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}">
        <p> منظومة الشحن والتفريغ </p>
    </div>

    <video autoplay muted loop id="myVideo">
        <source src="{{ asset('images/background.mp4') }}" type="video/mp4">
    </video>
    {{-- @auth --}}
        <div class="nav">
            <div class="container_nav">
                <div id="mainListDiv" class="main_list">
                    <ul class="navlinks">
                        <li><a href="/logout">تسجيل الخروج</a></li>
                    </ul>
                </div>
                <div class="logo">
                    <a href="/">الشَركةُ البَحرية</a>
                </div>
                <span class="navTrigger">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </div>
        </div>
    {{-- @endauth --}}

    @yield('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/715e93c83e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script>
    
        $('.navTrigger').click(function() {
            $(this).toggleClass('active');
            $("#mainListDiv").toggleClass("show_list");
            $(".logo").toggleClass("logo_none");
            $("#mainListDiv").fadeIn();

        });
    </script>
    <script src="https://kit.fontawesome.com/715e93c83e.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/mgalante/jquery.redirect@master/jquery.redirect.js"></script>

    @yield('scripts')

</body>

</html>
