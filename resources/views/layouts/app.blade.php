<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <titel>@yield('title')</title>
        
            <link rel="stylesheet" href='/css/bootstrap.min.css'>

            {{ $styles }}

    </head>

    <body>
        <x-navbar></x-navbar>
        <div class="pt-4">
            {{ $slot }}
        </div>
        

        <script src="/js/bootstrap.min.js"></script>
    </body>
</html>
