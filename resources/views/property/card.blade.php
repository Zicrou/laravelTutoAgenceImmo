<div @class(['card', 'sold' => $property->sold == 1]) style="m-0 p-0 min-width: 124px;">
    <div class="card-body">
        <h5 class="card-title">
            <a
                href="{{ route('property.show', ['slug' => $property->getSlug(), 'property' => $property]) }}">{{ $property->title }}</a>
        </h5>
        <p class="card-text">{{ $property->surface }} m² - {{ $property->city }} ({{ $property->postal_code }})</p>
        <div class="text-primary fw-bold" style="font-size: 1.4rem;">{!! $property->getFormatedPrice() !!}</div>
    </div>
</div>
