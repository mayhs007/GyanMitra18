<!DOCTYPE Html>
<html>
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ HTML::Style("css/materialize.min.css") }}
        {{ HTML::Style("css/font-awesome.min.css") }} 
        {{ HTML::Style("css/app.css") }}
        {{ HTML::Style("css/nav.css") }}                     
        {{ HTML::Style("css/material-icons.css") }}                                              
        {{ HTML::Script("js/jquery.min.js") }}   
        {{ HTML::Script("js/materialize.min.js") }} 
        {{ HTML::Script("js/app.js") }}   
        

<body>
@include('layouts.partials.admin_nav')
@include('layouts.partials.flash')
<div class="container">
@yield('content')
</div>
</body>

</html>
