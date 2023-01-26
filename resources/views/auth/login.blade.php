<x-common.layout lead="Login" class="flex flex-col items-center">
    <form class="px-4 w-full sm:w-1/2 lg:w-1/3 flex flex-col gap-y-4" method="post" action="{{route('auth.auth')}}">
        @csrf
		<x-form.text textId="email" textLabel="Email"></x-form.text>
		<x-form.password textId="password" textLabel="Password"></x-form.password>
		<div class="text-center">
			<input class="btn btn-primary" type="submit" value="Login"/>
		</div>
		<div class="text-center">
			<a class="underline" href="{{route('auth.register')}}">No Account? Sign In</a>
		</div>
    </form>
    <ol>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ol>
	<div class="h-0.5 my-8 border-0 w-2/3 bg-gray-300" ></div>
    <div class="w-full text-center">
		<a class="btn btn-primary" href="{{route('twitter.login')}}">Login with Twitter</a>
    </div>
</x-common.layout>
