@extends('emails.base')

@section('subject', 'CHIL Password Reset Email');

@section('content')
    <h1>Dear User</h1>
    <p>Here's the password reset code: {{ $code }}</p>
@endsection
