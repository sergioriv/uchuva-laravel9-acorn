@props(['avatar'])

@if ($avatar != NULL)
<div class="sw-13 position-relative mb-3">
    <img src="{{ config('app.url') .'/'. $avatar }}" class="rounded-xl sh-13 sw-13" alt="thumb" />
</div>
@else
<div class="sw-13 position-relative mb-3">
    <img src="{{ config('app.url') .'/img/other/profile-11.webp' }}" class="rounded-xl sh-13 sw-13" alt="thumb" />
</div>
@endif
