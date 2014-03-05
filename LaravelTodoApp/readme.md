# Laravel ToDo Example Application
This is a basic example application using [laracasts.com](http://laracasts.com) series Digging In - which is a great start to Laravel development (check it out!).

I have taken the example a little further, and included some ajax goodness as well as taking advantage of Laravel soft deletes. I have also simplified the application, styled it a little further and made it just a list of todos, with no user filtering.

Example working version of the app is here: [laraveltodoapp.csoutham.com](http://laraveltodoapp.csoutham.com).

To get setup you'll need to clone this repo then...

1. Run "composer update"  
2. Create a database called "laravel-todo-app"  
3. Update the database configuration in "app/config/database.php" to match your MySQL details  
4. Run "php artisan migrate" to create the tasks and users tables  
5. Add a user to your users table in MySQL, password isn't important at this time  
6. Finally start the server using "php artisan serve"

Please let me know any issues, I can't make any promises - this is just test code really and a basic application, mostly thanks to Jeffrey Way of Laracasts.

### Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

### Official Documentation

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).

#### Contributing To Laravel

**All issues and pull requests should be filed on the [laravel/framework](http://github.com/laravel/framework) repository.**

#### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
