{{-- ユーザー画面の共通レイアウト --}}
<!DOCTYPE HTML>
<html lang="ja">
<head>
    <script src="{{ asset('js/old/lib/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/old/lib/jquery-migrate-1.4.1.js') }}"></script>
    <script>
        $(function() {
            $('html,body').animate({ scrollTop: 0 }, '1');
        });
    </script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link rel="stylesheet" type="text/css" href="/css/User/header_menu.css">
    <script src="/js/User/header.js"></script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .space {
            margin-top: 50px;
            background-color: silver;
        }
    </style>
    <title>{{ $title }}</title>
</head>

@yield('header')

<body class="space">

@yield('content')
</body>

@yield('footer')

</html>