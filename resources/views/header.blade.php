<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        rel="apple-touch-icon"
        sizes="76x76"
        href="{{ asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
    <title>Argon Dashboard 2 by Creative Tim</title>
    <!--     Fonts and icons     -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
        rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
        src="https://kit.fontawesome.com/42d5adcbca.js"
        crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link
        id="pagestyle"
        href="{{ asset('css/argon-dashboard.css?v=2.0.4') }}"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        .autocomplete-list {
            border: 1px solid #ccc;
            border-top: none;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background: white;
            width: 100%;
            z-index: 1000;
        }

        .autocomplete-list div {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-list div:hover {
            background-color: #e9e9e9;
        }
    </style>

</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>