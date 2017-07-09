<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="/">

    <script>
        window.Laravel = {
            googleClientID: "{{ env('GOOGLE_CLIENT_ID') }}"
        };
    </script>

    <title>CantonRES</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400i|Material+Icons">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div id="app"></div>
    <script src="https://apis.google.com/js/platform.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
