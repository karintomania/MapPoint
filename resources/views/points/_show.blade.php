<turbo-frame id="@domid($point)" class="bg-gray-100 p-4">
    <div class="flex flex-col">
        <x-points.map lat="{{$point->lat}}" lng="{{$point->lng}}" />
        <div class=" bg-gray-100">
            <p class="text-gray-500 text-sm mb-4">{{$point->created_at}}</p>
            <p class="mb-2 text-lg">{{$point->note}}</p>
            <div class="flex justify-between">
            <form method="get" action="{{route('points.edit', ['point' => $point])}}" class="text-center" >
                <input class="btn btn-primary" type="submit" value="edit" />
            </form>
            <form method="delete" action="{{route('points.destroy', ['point' => $point])}}" >
                @csrf
                    <button type="submit" class="text-gray-500">
                        <i class="fa-solid fa-trash"></i>
                    </button>
            </form>
            </div>
        </div>
    </div>
</turbo-frame>
