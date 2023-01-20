<x-common.layout lead="Sign Up" class="flex justify-center">
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
</x-common.layout>
