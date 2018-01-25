<!DOCTYPE Html>
<html>
<head>
{{ HTML::Script("js/jquery.min.js") }} 
{{ HTML::Style("css/materialize.min.css") }}
{{ HTML::Style("css/font-awesome.min.css") }}
{{ HTML::Style("css/material-icons.css") }}
{{ HTML::Style("css/materialize-stepper.min.css") }} 
{{ HTML::Style("css/app.css") }}
{{ HTML::Style("css/my.css") }}
{{ HTML::Style("css/nav.css") }}
{{ HTML::Script("js/materialize.min.js") }}
{{ HTML::Script("js/materialize-stepper.min.js") }}    
{{ HTML::Script("js/app.js") }}
<body>
@include('layouts.partials.auth_nav')
@include('layouts.partials.flash')
@yield('content')
@include('layouts.partials.footer')
</body>
</html>
