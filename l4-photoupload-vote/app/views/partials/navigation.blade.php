<nav>
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-contents">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a href="{{ url('/') }}" class="navbar-brand logo">
        render
      </a>
    </div> <!-- navbar-header -->

    <div class="navbar-collapse collapse" id="navbar-contents">
      <ul class="nav navbar-nav">

        {{ Navigation::make(Request::path()) }}

				@if(Auth::guest())
					<li class="visible-xs"><a href="{{ url('register') }}">Register</a></li>
					<li class="visible-xs"><a href="{{ url('login') }}">Login</a></li>
				@else
					<li class="visible-xs"><a href="{{ url('user') }}">My profile</a></li>
					<li class="visible-xs"><a id="logout" href="{{ url('logout') }}">Logout</a></li>
				@endif
      </ul>

      <ul class="nav navbar-nav navbar-right">
				@if(Auth::guest())
        <li><a href="{{ url('register') }}">Sign Up</a></li>
        <li><a href="{{ url('login') }}">Log In</a></li>
        @else
        
        @if(Auth::user()->isAdmin())
          <li><a href="{{ url('admin/users') }}">Users</a></li>
          <li><a href="{{ url('admin/tags') }}">Tags</a></li>
        @endif 
        <li class="dropdown {{( Request::segment(2) == 'settings' || Request::segment(2)=='favorites' ? 'active' : false )}}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ Auth::user()->photocss }}" class="nav-gravatar" alt="{{ Auth::user()->username}}">{{ Auth::user()->username}}<b class="caret"></b>
          </a>

          <ul class="dropdown-menu dropdown-with-icons {{( Request::segment('1') == 'user' && Request::segment('2') == '' ? 'active' : false )}}">
            <li class="{{( Request::segment('2') == 'favorites' ? 'active' : false )}}">
              <a href="{{ url('user')}}">
                <i class="icon-eye-open"></i>My Render
              </a>
            </li>

            <li class="{{( Request::segment('2') == 'favorites' ? 'active' : false )}}">
              <a href="{{ url('user/favorites')}}">
                <i class="icon-heart"></i> My Favorites
              </a>
            </li>

            <li class="{{( Request::segment('2') == 'settings' ? 'active' : false )}}">
              <a href="{{ url('user/settings')}}">
                <i class="icon-pencil"></i> Settings
              </a>
            </li>

            <li>
              <a id="logout" href="{{ url('logout')}}">
                <i class="icon-signout"></i> Log Out
              </a>
            </li>
          </ul>
        </li><!-- / #user-option -->
        @endif
        <!-- Search Bubble -->
        <li>
          <form id="navbar-search-form" class="navbar-form" role="search" action="/search" style="display: block;">
          <input type="text" class="search-query form-control" name="q" id="q" placeholder="Search..." value="{{{isset($term) ? $term : ''}}}">
	        <input style="display:none;" type="submit" value="search">
          </form>
        </li>
      </ul>
    </div> <!-- .collapse -->
  </div> <!-- .container -->
</nav><!-- / .navbar -->
