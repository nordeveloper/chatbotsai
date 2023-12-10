<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <title>Auth</title>
    <style>
    .auth-box{max-width: 500px; margin: 40px auto auto auto}
    .wrapper {
        min-width: 320px;
        margin: auto;
        background-color: #f5fff7;
        height: calc(100vh);
    }
    </style>
</head>
<body class="wrapper">
    <div class="container ">
        @yield('content')
    </div>
</body>
</html>