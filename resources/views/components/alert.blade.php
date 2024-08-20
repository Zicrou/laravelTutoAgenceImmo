<div {{ $attributes->merge(['class' => "alert alert-$type"]) }}>
    {{$prefix}} {{ $slot }}
</div>