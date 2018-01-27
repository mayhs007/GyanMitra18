<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GyanMitra18</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
{{ HTML::Style("css/home.css") }}
{{ HTML::Style("css/materialize.min.css") }}
{{ HTML::Style("css/font-awesome.min.css") }} 
</head>
<body>
@yield('content')
{{ HTML::Script("js/jquery.min.js") }}   
{{ HTML::Script("js/home.js") }}
{{ HTML::Script("js/materialize.min.js") }} 
</body>
</html>