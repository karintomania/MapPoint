@props(
    ['lat' => 0, 'lng' => 0, 'apiKey']
)
    <iframe class="h-60 w-full"
        loading="lazy"
        allowfullscreen
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed/v1/place?key={{config('services.googleMap.apiKey')}}
        &q={{$lat}},{{$lng}}">
    </iframe>