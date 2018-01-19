<!DOCTYPE Html>
<html>
<head> 
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