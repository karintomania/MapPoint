<turbo-frame id="@domid($point)" class="bg-gray-100">
    <div class="flex flex-col">
        <x-points.map lat="{{$point->lat}}" lng="{{$point->lng}}" />
        <div class="p-4">
            <form method="put" action="{{route('points.update', ['point' => $point])}}" >
                @csrf
                <textarea class="w-full form-input" name="note" rows="4" placeholder="Note for this point:" >{{$point->note}}</textarea>
                @foreach ($errors->all() as $error)
                        <div class="text-red-400">
                            <li>{{ $error }}</li>
                        </div>
                @endforeach
                <input class="btn btn-primary" type="submit" value="save" />
            </form>
        </div>
    </div>
</turbo-frame>
