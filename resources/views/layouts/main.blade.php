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
                <h5 class="white-text">CONTACT US</h5>
                <ul>
                  <li><p>CIVIL:97862 78347     MAILID:gyanmitra18.civil@mepcoeng.ac.in</p></li>
                  <li><p>EEE:75980 11050       MAILID:gyanmitra18.eee@mepcoeng.ac.in</p></li>
                  <li><p>ECE:94424 46593       MAILID:gyanmitra18.ece@mepcoeng.ac.in</p> </li>
                  <li><p>CSE/IT:99945 40905    MAILID:gyanmitra18.cse.it@mepcoeng.ac.in</p></li>
                  <li><p>MECH:96779 13395      MAILID:gyanmitra18.mech@mepcoeng.ac.in</p></li>
                  <li><p>BIO-TECH:74023 89414  MAILID:gyanmitra18.biotech@mepcoeng.ac.in</p></li>
                  <li><p>MCA:99408 40671       MAILID:gyanmitra18.mca@mepcoeng.ac.in</p></li>
                  <li><p>MATHS/SCI:94860 26054 MAILID:gyanmitra18.maths@mepcoeng.ac.in</p></li>
                </ul>
               
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">STUDENTS PROFESSIONAL SOCIETIES</h5>
              

<div class="row">
<div class="card">
    <div class="card-image">
    {!! HTML::image('image/logo.png') !!}
    </div>
               
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2018 MEPCO SCHLENK ENGG COLLEGE,SIVAKASI
            
            </div>
          </div>
        </footer>
</body>
</html>