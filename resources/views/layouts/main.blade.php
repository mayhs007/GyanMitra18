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
}

</style>
      <div class="parallax-container">
            <div class="parallax">{!! Html::image('image/countdown.jpg') !!}
            </div>        
            @include('layouts.partials.user_nav')
            @include('layouts.partials.flash')
            <div class="row">
                  <div class="container">
                        <div col s12 m12>
                              <div class="time">
                                    <span id=days class="header red-text"></span>
                                    &nbsp
                                    <span id=hours class="header yellow-text"></span>
                                    &nbsp
                                    &nbsp
                                    &nbsp
                                    <span id=minutes class="header blue-text"></span>
                                    &nbsp
                                    &nbsp
                                    &nbsp
                                    <span id=seconds class="header green-text"></span>
                              </div>
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
            </div>
      </div>

 @yield('content')
 
 <footer class="page-footer blue-grey darken-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2014 Copyright Text
            <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
          </div>
        </footer>
</body>
</html>