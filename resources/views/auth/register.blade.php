<x-common.layout lead="Sign Up" class="flex flex-col items-center">
    <form class="px-4 w-full sm:w-1/2 flex flex-col gap-y-4" method="post" action="{{route('auth.store')}}">
        @csrf
		<x-form.text textId="name" textLabel="User Name"></x-form.text>
		<x-form.text textId="email" textLabel="Email"></x-form.text>
		<x-form.password textId="password" textLabel="Password"></x-form.password>
		<div class="text-center">
			<input class="btn btn-primary text-white" type="submit" value="Sign Up"/>
		</div>
    </form>
    <ol>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ol>
	<div class="h-0.5 my-8 border-0 w-2/3 bg-gray-300" ></div>
    <div class="w-full text-center">
		<a class="btn btn-primary" href="{{route('twitter.login')}}">Sign in with Twitter</a>
    </div>
</x-common.layout>
