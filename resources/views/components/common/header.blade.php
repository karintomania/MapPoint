<div class="py-4 text-white text-center bg-blue-600">
    <h1 class="text-3xl ">
        {{$slot}}
    </h1>
    <a class="" href="{{route('auth.logout')}}" >logout</a>
    <a class="" href="{{route('auth.register')}}" >register</a>
</div>