<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('assets/css/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/animate.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/animsition.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/daterangepicker.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/hamburgers.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/magnific-popup.css') }}">
    </link>
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/material-design-iconic-font.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/perfect-scrollbar.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/select2.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/slick.css') }}">
    </link>
    </link>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-4.6.2/css/bootstrap.min.css') }}">
    </link>
    <link rel="stylesheet" href="{{ asset('assets/css/portal/util.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/portal/main.css') }}">
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-4.6.2/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/animsition.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/portal/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/parallax100.js') }}"></script>
    <script src="{{ asset('assets/js/portal/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/portal/wow.min.js') }}"></script>


    <script>
        const url_assets = "{{ asset('') }}";
        var mapa_id = "MAP_ID";
        var interval_notificacions = null;
        // 1fb896f332f7b53c
    </script>

    @php
        $api = App\Models\Api::first();
    @endphp
    @if ($api)
        <script>
            mapa_id = "{{ $api->map_id }}";
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ $api->google_maps }}"></script>
    @else
        <script src="https://maps.googleapis.com/maps/api/js?key=INSERT_YOUR_API_KEY"></script>
    @endif

    <!-- Scripts -->
    @routes
    @vite(['resources/js/portal.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body>
    @inertia
    <script></script>

</body>

</html>
