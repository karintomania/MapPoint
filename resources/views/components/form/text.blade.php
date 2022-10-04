@props([
    "textId",
    "textLabel",
])
<div class="flex w-2/3">
    <label class="w-1/3" for="{{$textId}}">{{$textLabel}}:</label>
    <input class="w-2/3 border border-gray-200" type="text" name="{{$textId}}">
</div>