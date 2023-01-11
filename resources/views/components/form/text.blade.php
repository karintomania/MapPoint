@props([
    "textId",
    "textLabel",
])
<div class="flex justify-center">
    <label class="w-1/4" for="{{$textId}}">{{$textLabel}}:</label>
    <input class="w-3/4 border border-gray-200" type="text" name="{{$textId}}">
</div>
