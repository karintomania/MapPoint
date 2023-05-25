<x-common.layout lead="Save Any Places" class="m-24">

    <script>
    </script>
    <div x-data="{
            getCurrentLocation(callback) {
                // Get the user's current location.
                navigator.geolocation.getCurrentPosition(function(position) {
                  // Get the user's latitude and longitude.
                  let lat = position.coords.latitude;
                  let lng = position.coords.longitude;
                  callback(lat, lng)
                });
            }
        }">
        <div class="flex flex-col gap-8">
            @include('points._create')
            <x-common.lead>Your Saved Places</x-common.lead>
            <turbo-frame id="point-list" src="{{route('points.index')}}"  class="grid grid-cols-3 gap-4">
                <p>Loading...</p>
            </turbo-frame>
        </div>
    </div>
</x-common.layout>
