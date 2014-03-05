@extends('layouts.master')

@section('main')

    @include('partials.message')

    {{ Form::open(['route' => 'accounts.store']) }}

        <div>
            {{ Form::label('name', 'Account Name:') }} <br/>
            {{ Form::text('name') }}
            {{ $errors->first('name', '<div>:message</div>') }}
        </div>

        <div>
            {{ Form::label('balance', 'Opening Balance:') }} <br/>
            {{ Form::text('balance') }}
            {{ $errors->first('balance', '<div>:message</div>') }}
        </div>

        <div>
            {{ Form::button('Create Account', ['type' => 'submit']) }}
        </div>

    {{ Form::close() }}

@endsection
