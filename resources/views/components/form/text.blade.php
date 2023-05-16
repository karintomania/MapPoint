@props([
    "textId",
    "textLabel",
])
<div class="flex justify-center items-center">
    <label class="w-1/4" for="{{$textId}}">{{$textLabel}}:</label>
    <input class="w-3/4 form-input" type="text" name="{{$textId}}">
</div>
