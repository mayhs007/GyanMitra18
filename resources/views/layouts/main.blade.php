<!DOCTYPE Html>
<html>
<head>
{{ HTML::Script("js/jquery.min.js") }}   
{{ HTML::Style("css/materialize.min.css") }}
{{ HTML::Style("css/font-awesome.min.css") }} 
{{ HTML::Style("css/materialize-stepper.min.css") }}                       
{{ HTML::Style("css/material-icons.css") }} 
{{ HTML::Style("css/app.css") }}                                              
{{ HTML::Script("js/materialize.min.js") }} 
{{ HTML::Script("js/materialize-stepper.min.js") }} 
{{ HTML::Script("js/app.js") }}
{{ HTML::Script("js/select.js") }}
{{ HTML::Style("css/my.css") }}
{{ HTML::Script("js/timer.js") }}
</head>
<body>
<style>
.time{
      font-size:100px;
}
.word{
      font-size:40px;
      color:white;
}
.image{
      position:relative;
      text-align:center;
}
</style>
      <div class='image'>
      <img src="/image/countdown.jpg">
      <div class="centered">Centered</div>
      </div>
      @include('layouts.partials.user_nav')
      @include('layouts.partials.flash')
      <br>
      <div class="container">
      <div class="col m1 s6">
      <div class="time">
      <span id=days class="header red-text"></span>
      &nbsp
      <span id=hours class="header yellow-text"></span>
      &nbsp
      &nbsp
      <span id=minutes class="header blue-text"></span>
      &nbsp
      &nbsp
      <span id=seconds class="header green-text"></span>
      </div>
      </div>
      <br>
      <div class="word">
      <span class="header red-text">DAYS</span>
      &nbsp
      &nbsp
      <span class="header yellow-text">HOURS </span>
      &nbsp
      &nbsp
      <span class="header blue-text">MINUTES</span>
      &nbsp
      &nbsp
      <span class="header green-text">SECONDS</span>
      </div>
      </div>
</div>
 @yield('content')
</body>
</html>