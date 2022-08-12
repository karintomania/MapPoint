<turbo-frame id="@domid($point)" class="w-full bg-gray-100">
    <x-points.map lat="{{$point->lat}}" lng="{{$point->lng}}" />
    <div class=" bg-gray-100">
        <form method="put" action="{{route('points.update', ['point' => $point])}}" >
            @csrf
            <input type="text" name="note" value="{{$point->note}}" />
            <input type="submit" value="save" />
        </form>
    </div>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</turbo-frame>