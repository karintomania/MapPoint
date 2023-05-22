<turbo-frame id="@domid($point)" class="bg-gray-100 p-4">
    <div class="flex flex-col">
        <x-points.map lat="{{$point->lat}}" lng="{{$point->lng}}" />
        <div class=" bg-gray-100">
            <form method="put" action="{{route('points.update', ['point' => $point])}}" >
                @csrf
                <textarea class="w-full form-input" name="note" rows="4" placeholder="Note for this point:" value="{{$point->note}}"></textarea>
                <input class="btn btn-primary" type="submit" value="save" />
            </form>
        </div>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
</turbo-frame>
