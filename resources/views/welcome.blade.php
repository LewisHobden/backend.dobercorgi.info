@extends('layouts/app')

@section('title','Home')

@section('content')
    <div class="da-main-title m-b-md">
        <h1 class="da-main-heading">Welcome!</h1>
        <p>This is a site for Shulk Discord admins to update and manage the Dobercorgi Resources.</p>

        <hr/>
        @auth
            <h1>You're logged in {{ auth()->user()->name }}!</h1>
            <p>Get started with management by choosing a section in the toolbar above.</p>
        @else
            <a class="da-btn--discord-login" href="{{ route("login") }}">Login with Discord</a>
        @endauth

    </div>
@endsection
