<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Helsingborg Boka Resurs - POC</title>
    <meta name="description" content="">

    <link rel="stylesheet" id="styleguide-css" type="text/css" href="/assets/dist/css/styleguide-css.min.css" type='text/css' media='all'>
    
    <script type='text/javascript' defer="defer" src='https://polyfill.io/v3/polyfill.js?features=es5,es6,es7&flags=gated'></script>

    <link rel='dns-prefetch' href='//cdn.polyfill.io' />

    <noscript>
        <style>
            .visible-noscript {display: block !important;}
        </style>
    </noscript>


    <style type="text/css">
        .progress {
            height: 16px; 
            width: 100%; 
            background: #f9abca; 
            overflow: hidden;
            border-radius: 5px; 
            margin-bottom: 32px;
        }
    
        .progress div {
            display: block;
            width: 25%; 
            height: inherit; 
            background: #fa0b6b; 
        }

        .s-group {
            display: flex;
        }

        .s-group > * {
            flex: 1;
        }

        .s-group > *:not(:first-child) {
            margin-left: 0;
            border-top-left-radius: 0; 
            border-bottom-left-radius: 0; 
        }

        .s-group > *:not(:last-child) {
            margin-right: 0;
            border-top-right-radius: 0; 
            border-bottom-right-radius: 0; 
        }

    </style>

</head>
<body class="no-js">
    
    @navbar([
        'logo' => '/assets/img/logotype.svg',
        'logoPosition' => 'left',
        'linksPosition' => 'right',
        'topAccent' => 'primary',
        'activeAccent' => 'primary',
        'items' => $topNavigation,
        'sidebar'   => ['trigger' => "js-mobile-sidebar"]
    ])
    @endnavbar
    
    @yield('content')

    @yield('bottom_hero')

    <!-- jQuery --> 
    <script
    src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
    crossorigin="anonymous"></script>

    <!-- Styleguide - js -->
    <script src="/assets/dist/js/styleguide-js.min.js"></script>

</body>
</html>
