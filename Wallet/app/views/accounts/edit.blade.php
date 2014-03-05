@extends('layouts.master')

@section('main')

    @include('partials.message')

    {{ Form::model($account, ['route' => ['accounts.update', $account->id], 'method' => 'PUT']) }}

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
            {{ Form::button('Update Account', ['type' => 'submit']) }}
        </div>

    {{ Form::close() }}

@endsection
