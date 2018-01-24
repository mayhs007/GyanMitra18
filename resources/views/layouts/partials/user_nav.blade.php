<ul id="dropdown1" class="dropdown-content">
<li><a href="{{ route('auth.logout') }}">LOGOUT</a></li>
</ul>
<nav>
  <div class="nav-wrapper">
    <a href="#!" class="brand-logo">GyanMitra18</a>
    <ul class="right hide-on-med-and-down">
      <li><a href="{{ route('user_pages.home')}}">Home</a></li>
      <li><a href="{{ route('user_pages.about')}}">About</a></li>
      <li><a href="{{ route('user_pages.event')}}">Domain</a></li>
@if(!Auth::Check())
      <li><a href="{{ route('auth.login') }}">Login</a></li>
      <li><a href="{{ route('auth.register') }}">Register</a></li>
  <!-- Dropdown Trigger -->
@else
      <li><a href="{{ route('user_pages.dashboard')}}">Dashboard</a></li>
      <li><a href="{{ route('user_pages.hospitality')}}">Hospitality</a></li>
     <li><a class="dropdown-button" href="#!" data-activates="dropdown1">{{Auth::user()->first_name}}<i class="material-icons right">arrow_drop_down</i></a></li>
    </ul>
@endif
</div>
</nav>


   


