@props([
    'showLogin' => false,
    'showLogout' => false,
])
<div class=" px-8 py-4 text-white font-bold bg-blue-600 flex justify-between">
    <h1 class="text-3xl ">
        MapPoint <i class="fa-solid fa-location-dot"></i>
    </h1>
    <div>
        @if($showLogin)
            <a class="" href="{{route('login')}}" >Login</a>
        @endif
        @if($showLogout)
            <a class="" href="{{route('auth.logout')}}" >Log out</a>
        @endif
    </div>
</div>
