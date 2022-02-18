{{-- @component('mail::message')
# Pour la partie : {{ $user->type }}

## De la part de : 
{{ $user->name }} | {{ $user->email }}

##

## Message : 
{{ $user->message }}

<br>
{{ config('app.name') }}
@endcomponent --}}

<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    <h1>Pour la partie : {{ $user->type }}</h1>

    <p> <b>De la part de : </b> {{ $user->name }} | {{ $user->email }}</p>
    
    <p>{{ $user->message }}</p>
</body>
</html>