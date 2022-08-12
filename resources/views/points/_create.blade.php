<turbo-frame id="point-create" class="w-full bg-gray-100">
    <x-points.map lat="10" lng="-20" />
    <div class=" bg-gray-100">
        <form method="POST" action="{{route('points.store')}}" target="_top">
            @csrf
            <input type="text" name="note">
            <input type="text" name="lat" value="10" >
            <input type="text" name="lng" value="20" >
            <input type="submit">
        </form> 
    </div>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</turbo-frame>