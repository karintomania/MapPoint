<x-common.layout lead="Login" class="flex justify-center">
    <form class="w-1/2 flex flex-col gap-y-4" method="post" action="{{route('auth.auth')}}">
        @csrf
		<x-form.text textId="email" textLabel="Email"></x-form.text>
		<x-form.password textId="password" textLabel="Password"></x-form.password>
        <input type="submit">
    </form>
    <ol>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ol>
</x-common.layout>
