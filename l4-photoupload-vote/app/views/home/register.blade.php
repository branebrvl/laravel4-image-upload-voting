@extends('layouts.main')

@section('title', 'Registration')

@section('content')
  <section class="registration-page">
    <div class="container">
      <div class="row">
        <article>
            <h2>Registration</h2>
            <div>
              @if(Session::get('errors'))
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <h5>There were errors during registration:</h5>
                   @foreach($errors->all('<li>:message</li>') as $message)
                      {{$message}}
                   @endforeach
                </div>
              @endif

              @if(Session::get('github_email_not_verified'))
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5>You don't have any verified emails in your Github profile, please register using email</h5>
                </div>
              @endif

              {{ Form::open(['route' => 'auth.register']) }}
                <div class="form-group">
                  {{ Form::label('username', 'Username', ['class'=>'control-label'])}}
                  {{ Form::text('username', null, ['class'=>'form-control','placeholder'=>'Username'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('email', 'E-mail', ['class'=>'control-label'])}}
                  {{ Form::text('email', null, ['class'=>'form-control','placeholder'=>'E-mail'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('password', 'Password', ['class'=>'control-label'])}}
                  {{ Form::password('password', ['class'=>'form-control','placeholder'=>'Password'])}}
                </div>
                <div class="form-group">
                  {{ Form::label('password_confirmation', 'Confirm Password', ['class'=>'control-label'])}}
                  {{ Form::password('password_confirmation', ['class'=>'form-control','placeholder'=>'Confirm Password'])}}
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block btn-login">Register</button>
                </div>
              {{ Form::close() }}

              <ul class="nav nav-list">
                <li class="text-center"><a href="{{ url('login') }}">Already have an account?</a></li>
              </ul>
            </div>
      </article>
    </div><!-- / .row -->
  </div><!-- / .container -->
</section>
@stop
