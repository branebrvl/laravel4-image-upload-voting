@extends('layouts.main')

@section('title','Error')

@section('content')
<section class="page-wrap">
    <div class="container">
        <div class="row push-down">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                <h2 class="page-title">Whoops... That's an error...</h2>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        </div>
    </div>
</section>
@stop
