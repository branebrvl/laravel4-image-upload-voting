<!DOCTYPE html>
<html>
<head>
  <title>Awesome Book Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="styles/css/index.css" rel="stylesheet">
  <!-- <link href="//netdna.bootstrapcdn.com/twitter&#45;bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>
<div class="navbar navbar-inverse" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Book Store</a>
        </div>
        <div class="navbar-collapse collapse">
          @if(!Auth::check())
          <form class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
          @else
          <li><a href="/cart"><i class="icon-shopping-cart icon-white"></i> Your Cart</a></li>
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, {{Auth::user()->name}} <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li><a href="/user/orders"><i class="icon-envelope"></i> My Orders</a></li>
                      <li class="divider"></li>
                      <li><a href="/user/logout"><i class="icon-off"></i> Logout</a></li>
                  </ul>
              </li>
          @endif
        </div><!--/.navbar-collapse -->
      </div>
    </div>
@yield('content')

  <script src="http://code.jquery.com/jquery.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  $(function() {
    // Setup drop down menu
    $('.dropdown-toggle').dropdown();
   
    // Fix input element click problem
    $('.dropdown input, .dropdown label').click(function(e) {
      e.stopPropagation();
    });
  });
  
  @if(isset($error))
    alert("{{$error}}");
  @endif

  @if(Session::has('error'))
    alert("{{Session::get('error')}}");
  @endif
  
  @if(Session::has('message'))
    alert("{{Session::get('message')}}");
  @endif
  </script>
</body>
</html>
