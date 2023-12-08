<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Bots AI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" media="all" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" media="all" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" media="all" href="{{asset('css/hljs.min.css')}}">
    

    <script type="text/javascript" src="{{asset('js/jquery-3.7.0.min.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script> --}}
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script> 
    
    {{-- <script type="text/javascript" src="{{asset('js/highlight.min.js')}}"></script>   --}}
    <script type="text/javascript" src="{{asset('js/scripts.js')}}"></script>

    @yield('scripts')

</head>
<body>

<x-navbar />
<div class="container container-lg wrapper">    
    @yield('content')
</div>
</body>
</html>