<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GyanMitra18</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
.times{
      font-size:50px;
}
.words{
      font-size:20px;
      display:flex;
      flex-flow:row nowrap;
      justify-content:center;
      align-items:center;

}
.item
{
      flex:1 1 auto;
}

</style>
      <div class="parallax-container">
            <div class="parallax">{!! Html::image('image/countdown.jpg') !!}
            </div>        
            @include('layouts.partials.user_nav')
            @include('layouts.partials.flash')
            <div class="hide-on-med-and-down">
                  <div class="row">
                        <div class="container">
                              <div class="col m12">
                                    <div class="time">
                                          <span id="days" class="header red-text"></span>
                                          &nbsp
                                          
                                          <span id="hours" class="header yellow-text"></span>
                                          &nbsp
                                          &nbsp
                                          <span id="minutes" class="header blue-text"></span>
                                          &nbsp
                                          &nbsp
                                          <span id="seconds" class="header green-text"></span>
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
                                    <div class="row">
                                    <br>
                                    <br>
                                    <h4 class="header deep-orange-text  text-accent-3 center">THE MOST AWAITED EVENT IS ONGOING</h4s>
                                    <br>
                                    <h4 class="header cyan-text  text-lighten-1 center">THANK YOU FOR OVERWHELMING SUPPORT</h4>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <div class="hide-on-large-only">
                  <div class="row">
                        <div class="container">
                              <div class="col s4">
                                    <div class="words">
                                          <p class="header red-text item">DAYS &nbsp<div id="dayss" class="header red-text "></div></p>
                                    
                                          <p class="header yellow-text item">HOURS &nbsp<div id="hourss" class="header yellow-text "></div></p>
                                      
                                          <p class="header blue-text item">MINUTES &nbsp<div id="minutess" class="header blue-text "></div></p>
                                        
                                          <p class="header green-text item">SECONDS &nbsp<div id="secondss" class="header green-text "></div></p>
                                    </div>
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
       @yield('footer')
     </div>
     <div class="col l4 offset-l2 s12">
       <h5 class="white-text">Contact Mail id</h5>
       <ul>
         <li>gyanmitra18@mepcoeng.ac.in</a></li>
       </ul>
     </div>
   </div>
 </div>
@include('layouts.partials.footer')
 </div>
</footer>








