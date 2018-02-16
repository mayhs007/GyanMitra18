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
                              <br>
                              <br>
                              <br>
                              <br>
                                    <h4 class="header red-text center">THE MOST AWAITED EVENT IS ONGOING</h4>
                                    <br>
                                    <h4 class="header yellow-text center">THANKS FOR THE OVERWHELMING SUPPORT</h4>
                                    <br>
                              </div>
                        </div>
                  </div>
            </div>
            <div class="hide-on-large-only">
                  <div class="row">
                        <div class="container">
                              <div class="col s4">
                              <br>
                              <h4 class="header red-text center">THE MOST AWAITED EVENT IS ONGOING</h4>
                              <br>
                              <h4 class="header yellow-text center">THANKS FOR THE OVERWHELMING SUPPORT</h4>
                              <br>
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








