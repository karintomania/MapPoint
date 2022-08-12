<x-common.layout>
    <form method="post" action="{{route('auth.store')}}">
        @csrf
        <label for="name">name</label><input type="text" id="name" name="name">
        <label for="name">email</label><input type="text" name="email">
        <label for="name">password</label><input type="password" name="password">
        <input type="submit">
    </form>
    <ol>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ol>
</x-common.layout>