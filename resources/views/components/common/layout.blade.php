@props([
    'showLogin' => !auth()->check(),
    'showLogout' => auth()->check(),
    'lead' => '',
])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    <x-common.header :showLogin="$showLogin" :showLogout="$showLogout"></x-common.header>
	<main {{$attributes}}>
        @if($lead !== '')
            <x-common.lead>{{$lead}}</x-common.lead>
        @endif
		{{$slot}}
	</main>
</body>
</html>
