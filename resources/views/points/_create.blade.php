<turbo-frame id="point-create" class="bg-gray-100">
    <div 
        class="flex"
        x-data="{
            currentLocation:{
                lat: 0,
                lng: 0,
            },
            init(){
                getCurrentLocation((lt, lg) => {
                    this.currentLocation.lat = lt;
                    this.currentLocation.lng = lg;
            })}
        }"
    >
        <x-points.map class="w-2/5" />
        <div class="p-4 w-3/5">
            <form method="POST" action="{{route('points.store')}}" target="_top">
                @csrf
                <textarea class="w-full form-input" name="note" rows="8" placeholder="Note for this point:"></textarea>
                @foreach ($errors->all() as $error)
                        <div class="text-red-400">
                            <li>{{ $error }}</li>
                        </div>
                @endforeach
                <div class="text-center">
                    <input class="btn btn-primary " type="submit">
                </div>
                <input type="hidden" name="lat" x-model="currentLocation.lat" >
                <input type="hidden" name="lng" x-model="currentLocation.lng" >
            </form> 

        </div>
    </div>
</turbo-frame>
