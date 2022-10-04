@props(['avatar'])

@if ($avatar != NULL)
    <img class="profile" alt="profile" src="{{ config('app.url') .'/'. $avatar }}" />
@else
    <img class="profile" alt="profile" src="/img/profile/profile-9.webp" />
@endif
