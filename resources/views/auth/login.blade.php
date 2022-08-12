<x-common.layout>
    Login
    <form method="post" action="{{route('auth.auth')}}">
        @csrf
        <label for="name">email</label><input type="text" name="email">
        <label for="password">password</label><input type="password" name="password">
        <input type="submit">
    </form>
    <ol>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ol>
</x-common.layout>