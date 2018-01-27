<nav>
        <div class="nav-wrapper">
            <a href="{{ route('user_pages.home') }}" class="brand-logo"> GyanMitra18</a>
            <ul class="left hide-on-large-only">
                <li>
                    <a href="#" class="btn-collapse-sidebar" data-activates="slide-out"><i class="material-icons">menu</i></a>
                </li>
            </ul>
            <ul class="side-nav" id="slide-out">
                <li><a href="{{ route('user_pages.home') }}"><i class="fa fa-2x fa-home"></i>Home</a></li>
                <li><a href="{{ route('user_pages.event') }}"><i class="fa fa-2x fa-tasks"></i> Domain</a></li>
                <li><a href="{{ route('user_pages.about') }}"><i class="fa fa-2x fa-child"></i> About</a></li>
                <li><a href="{{ route('user_pages.schedule') }}"><i class="fa fa-2x fa-calendar"></i>Schedule</a></li>
                <li><a href="{{ route('user_pages.guestLecture') }}"><i class="fa fa-2x fa-graduation-cap"></i>Special Lecture</a></li>
                <li><a href="{{ route('user_pages.help') }}"><i class="fa fa-2x fa-info-circle"></i>Instruction</a></li>     
                <li><a href="{{ route('user_pages.contact') }}"><i class="fa fa-2x fa-phone"></i> Contact Us</a></li> 
                
                @if(Auth::Check())
                    <li><a href="{{ route('user_pages.dashboard') }}"><i class="fa fa-2x fa-shopping-cart"></i> Dashboard</a></li>  
                    <li><a href="{{ route('user_pages.hospitality') }}"><i class="fa fa-2x fa-bed"></i> Hospitality</a></li>
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><i class="fa fa-2x fa-user"></i> {{ Auth::user()->first_name }} <i class="material-icons right">arrow_drop_down
                                </i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>{{ link_to_route('auth.changePassword', 'Change Password') }}</li>
                                        <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('auth.login') }}"><i class="fa fa-2x fa-key"></i> Login</a></li>
                    <li><a href="{{ route('auth.register') }}"><i class="fa fa-2x fa-user"></i> Register</a></li>                                     
                @endif
            </ul>
            <ul class="right hide-on-med-and-down">
                <li><a href="{{ route('user_pages.home') }}">Home</a></li>
                <li><a href="{{ route('user_pages.event') }}"> Domain</a></li>
                <li><a href="{{ route('user_pages.about') }}"> About</a></li>
                <li><a href="{{ route('user_pages.schedule') }}"> Schedule</a></li> 
                <li><a href="{{ route('user_pages.guestLecture') }}">Special Lecture</a></li> 
                <li><a href="{{ route('user_pages.help') }}">Instruction</a></li> 
                <li><a href="{{ route('user_pages.contact') }}"> Contact Us</a></li> 
   
                @if(Auth::Check())
                    <li><a href="{{ route('user_pages.dashboard') }}"> Dashboard</a></li>  
                    <li><a href="{{ route('user_pages.hospitality') }}"> Hospitality</a></li>
                    <li>
                        <a href="#" class="dropdown-button" data-activates="user-dropdown">Hi, {{ Auth::user()->first_name }} <i class="material-icons right">arrow_drop_down</i></a>
                        <ul id="user-dropdown" class="dropdown-content">
                            <li>{{ link_to_route('auth.changePassword', 'Change Password') }}</li>            
                            <li>{{ link_to_route('auth.logout', 'Logout') }}</li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('auth.login') }}"> Login</a></li>
                    <li><a href="{{ route('auth.register') }}"> Register</a></li>  
                @endif
            </ul>
        </div>
</nav>
