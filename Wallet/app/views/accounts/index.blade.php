@extends('layouts.master')

@section('main')

    <h1>All Accounts</h1>

    @include('partials.message')

    <p>
        {{ HTML::linkRoute('accounts.create', 'Create Account') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Account Name</th>
                <th>Current Balance</th>
            </tr>
        </thead>
        <tbody>
        @if ($accounts->count())
            @foreach ($accounts as $account)
            <tr>
                <td>{{ $account->name }}</td>
                <td>{{ $account->balance }}</td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>

@endsection
