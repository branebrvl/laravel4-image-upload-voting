<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<head>                         
  <meta charset="utf-8">       
  <title>Render</title>
    
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Stylesheets -->         
  <link rel="stylesheet" href="styles/css/index.css" />
  
  <!--[if lt IE 9]>            
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->                 
</head>
<body>
  <nav>
    <div class="container">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-contents">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a href="/" class="navbar-brand logo">
          render
        </a>
      </div> <!-- navbar-header -->

      <div class="navbar-collapse collapse" id="navbar-contents">
        <ul class="nav navbar-nav">
          <!-- Browse -->
          <li class="animated slideInDown">
            <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown">Browse</a>
          </li>

          <!-- Tags -->
          <li class="animated slideInDown">
            <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown">Tags</a>
          </li>

          <!-- Create New-->
          <li class="animated slideInDown">
            <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown">Create New</a>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class=" divided-list"><a href="https://laracasts.com/join">Sign Up</a></li>
          <li class=""><a href="https://laracasts.com/login">Log In</a></li>

          <li class="dropdown" id="user-options">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="http://placehold.it/30x30" class="nav-gravatar" alt="Branislav">                            Branislav <b class="caret"></b>
            </a>

            <ul class="dropdown-menu dropdown-with-icons">
              <li class="">
                <a href="/@Branislav">
                  <i class="icon-eye-open"></i> Profile
                </a>
              </li>

              <li class="">
                <a href="/all">
                  <i class="icon-tasks"></i> Checklist
                </a>
              </li>

              <li class="">
                <a href="/admin/account">
                  <i class="icon-pencil"></i> Settings
                </a>
              </li>

              <li>
                <a href="//laracasts.uservoice.com/">
                 <i class="icon-comment"></i> Requests
                </a>
              </li>

              <li>
                <a href="/logout">
                  <i class="icon-signout"></i> Log Out
                </a>
              </li>
            </ul>
          </li><!-- / #user-option -->

          <!-- Search Bubble -->
          <li>
            <form id="navbar-search-form" class="navbar-form" role="search" action="/search" style="display: block;">
            <input type="text" class="search-query form-control" name="q" id="q" placeholder="Search...">
            </form>
          </li>
        </ul>
      </div> <!-- .collapse -->
    </div> <!-- .container -->
  </nav><!-- / .navbar -->

  <section class="home-banner">
    <div class="container">
      <header class="introduction">
        <h1>If you have to think about a technique you haven't done it enough.</h1>
        <div class="home-banner-links">
          <div>Sign Up</div>
          <div>Start Browsing</div>
        </div>
      </header><!-- / .introduction -->
    </div>
  </section><!-- / .home-banner -->

  <section class="home-popular">
      <div class="container">
        <h2 class="text-center">Latest Renders</h2>
        <div class="row">
          <article class="render">
            <div class="render-shot">
              <div class="render-img">
                <a href="" class="render-link"><img src="http://placehold.it/200x150" alt=""></a>
              </div><!-- render-img -->
              <ul class="render-tools">
                <li class="fav"><span>300</span></li>
                <li class="views"><span>300</span></li>
              </ul><!-- render-tools -->
            </div><!-- / .render-shot -->
            <div class="render-user">
              <a href=""><img class="render-user-img" src="http://placehold.it/16x16" alt=""></a>
              <a href=""><span class="render-user-link">User Name</span></a>
            </div><!-- / .render-user -->
          </article><!-- / .render -->
          <article class="render">
            <div class="render-shot">
              <div class="render-img">
                <a href="" class="render-link"><img src="http://placehold.it/200x150" alt=""></a>
              </div><!-- render-img -->
              <ul class="render-tools">
                <li class="fav"><span>300</span></li>
                <li class="views"><span>300</span></li>
              </ul><!-- / .render-tools -->
            </div><!-- / .render-shot -->
            <div class="render-user">
              <a href=""><img class="render-user-img" src="http://placehold.it/16x16" alt=""></a>
              <a href=""><span class="render-user-link">User Name</span></a>
            </div><!-- / .render-user -->
          </article><!-- / .render -->
        </div><!-- / .row -->
      </div><!-- / .container -->
  </section><!-- / .home-popular -->

  <footer>
    <div class="container">
      <div class="row">
        <section>
          <ul class="footer-nav">
            <li>Built with Laravel. Find out more on SI Wiki</li>
          </ul><!-- / .footer-nav -->
        </section><!-- / .side-bar -->
        <section>
          <a class="logo" href="">render</a>
         </section>
      </div><!-- / .row -->
    </div><!-- / .container -->
  </footer><!-- / .footer -->

  <!-- SCRIPTS -->
  <script src="vendor/bower_components/jquery/dist/jquery.js"></script>
  <script src="vendor/bower_components/bootstrap/dist/js/bootstrap.js"></script>
</body>
