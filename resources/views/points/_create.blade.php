<turbo-frame id="point-create" class="bg-gray-100">
    <div class="flex">
        <x-points.map class="w-2/5" lat="10" lng="-20" />
        <div class="p-4 w-3/5">
            <form method="POST" action="{{route('points.store')}}" target="_top">
                @csrf
                <textarea class="w-full form-input" name="note" rows="8" placeholder="Note for this point:"></textarea>
                <div class="text-center">
                <input class="btn btn-primary " type="submit">
                </div>
                <input type="hidden" name="lat" value="10" >
                <input type="hidden" name="lng" value="20" >
            </form> 
        </div>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
</turbo-frame>
