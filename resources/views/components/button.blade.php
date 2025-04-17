@props(['link','color'])
    <a href="{{$link}}" {{ $attributes->merge(['class' =>'rounded-xl p-2 block w-min']) }}>
        {{$slot}}
    </a>
