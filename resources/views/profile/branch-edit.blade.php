@php
$title = $branch->user->name;
@endphp
@extends('layout',['title'=>$title])

@section('css')
<link rel="stylesheet" href="/css/vendor/select2.min.css" />
<link rel="stylesheet" href="/css/vendor/select2-bootstrap4.min.css" />
@endsection

@section('js_vendor')
<script src="/js/cs/scrollspy.js"></script>
<script src="/js/vendor/select2.full.min.js"></script>
@endsection

@section('js_page')
<script src="/js/form/avatar.js"></script>
<script>
    jQuery('#city').select2({placeholder: ''});
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ $title . ' | ' . __('Edit') }}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('user.profile.update') }}"
                            class="tooltip-end-bottom" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12 col-xl-3 col-xxl-12">

                                    <!-- Avatar -->
                                    <div class="mb-3 d-flex align-items-center flex-column">
                                        <label>
                                            <div id="preview">
                                                <x-avatar :avatar="$branch->user->avatar" class="bi-collection" />
                                            </div>

                                            <x-input type="file" name="avatar" id="avatar"
                                                accept="image/jpg, image/jpeg, image/png, image/webp" />
                                        </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="col-12 col-xl-12 col-xxl-12">

                                        <!-- Name -->
                                        <div class="mb-3">
                                            <x-label>{{ __('Name') }}</x-label>
                                            <x-input id="name" name="name" value="{{ $branch->user->name }}" required
                                                autofocus />
                                        </div>

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <x-label>{{ __('Email') }}</x-label>
                                            <x-input disabled value="{{ $branch->user->email }}"
                                                required />
                                        </div>

                                        <!-- Telephone -->
                                        <div class="mb-3">
                                            <x-label>{{ __('Telephone') }}</x-label>
                                            <x-input id="telephone" name="telephone" value="{{ $branch->telephone }}"
                                                required />
                                        </div>

                                        <!-- City -->
                                        <div class="mb-3 w-100">
                                            <x-label>{{ __('City') }}</x-label>
                                            <select name="city" id="city" required>
                                                <option value="" selected disabled></option>
                                                @foreach ($deps as $dep)
                                                @foreach ($dep['ciudades'] as $city)
                                                @php
                                                $depCity = $dep['departamento'] .' - '. $city;
                                                @endphp
                                                <option value="{{ $depCity }}"
                                                    {{ $branch->city === $depCity ? 'selected' : '' }} >
                                                    {{ $depCity }}
                                                </option>
                                                @endforeach
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Address -->
                                        <div class="mb-3">
                                            <x-label>{{ __('Address') }}</x-label>
                                            <x-input id="address" name="address" value="{{ $branch->address }}"
                                                required />
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <x-button type="submit" class="btn-primary">{{ __('Update') }}</x-button>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
