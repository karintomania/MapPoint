<turbo-frame id="@domid($point)" class="bg-gray-100">
    <div class="flex flex-col">
        <x-points.map lat="{{$point->lat}}" lng="{{$point->lng}}" />
        <div class=" bg-gray-100">
            <p>{{$point->created_at}}</p>
            <p>{{$point->note}}</p>
            <form method="get" action="{{route('points.edit', ['point' => $point])}}" >
                <input class="btn btn-primary" type="submit" value="edit" />
            </form>
            <form method="delete" action="{{route('points.destroy', ['point' => $point])}}" >
                @csrf
                <input type="submit" value="delete" />
            </form>
        </div>
    </div>
</turbo-frame>
