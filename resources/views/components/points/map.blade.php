@props(
    ['lat' => null, 'lng' => null]
)
<iframe
    x-data="{
        position:{
            lat: {{$lat?:'null'}},
            lng: {{$lng?:'null'}}
        },
        urlTemplate: 'https://www.google.com/maps/embed/v1/place?key={{config('services.googleMap.apiKey')}}&q=',
        get srcUrl(){return this.urlTemplate + this.position.lat + ',' + this.position.lng}
    }"
    @if($lat === null)
    {{-- if lat and lng is not initialized by blade, get it from parent alpine --}}
    x-modelable="position"
    x-model="currentLocation"
    @endif
    {{ $attributes->merge(['class' => 'h-60 w-full']) }}
    loading="lazy"
    allowfullscreen
    referrerpolicy="no-referrer-when-downgrade"
    x-bind:src="srcUrl">
    </iframe>
