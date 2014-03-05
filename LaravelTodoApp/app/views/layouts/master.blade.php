<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/css/application.css" />
		
		<script src="/js/jquery-2.0.3.min.js" type="text/javascript"></script>
		<script src="/js/application.js" type="text/javascript"></script>
	</head>
		
	<body>
		
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Laravel ToDo App</a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="/">All Tasks</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		
		<div class="container">
			@yield('content')
		</div>
		
	</body>
</html>