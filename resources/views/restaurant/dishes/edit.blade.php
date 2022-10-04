@php
$title = $dish->name;
@endphp
@extends('layout',['title'=>$title])

@section('css')
<link rel="stylesheet" href="/css/vendor/select2.min.css" />
<link rel="stylesheet" href="/css/vendor/select2-bootstrap4.min.css" />
@endsection

@section('js_vendor')
<script src="/js/cs/scrollspy.js"></script>
<script src="/js/vendor/input-spinner.min.js"></script>
<script src="/js/vendor/select2.full.min.js"></script>
@endsection

@section('js_page')
<script>
    jQuery('#category').select2({placeholder: ''});
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ $title .' | '. __('Dish')}}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('restaurant.dishes.update', $dish) }}" class="tooltip-end-bottom"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row g-3 mb-3">

                                <!-- Category -->
                                <div class="col-md-6">
                                    <div class="w-100 form-group position-relative">
                                        <x-label>{{ __('Category') }}</x-label>
                                        <select name="category" id="category" required>
                                            <option value="" selected disabled></option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $dish->category_id==$category->id ? 'selected' : '' }} >
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <x-label>{{ __('Name') }}</x-label>
                                        <x-input id="name" name="name" value="{{ $dish->name }}" required autofocus />
                                    </div>
                                </div>

                            </div>

                            <div class="row g-3 mb-3">

                                <!-- Price -->
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <x-label>{{ __('Price') }}</x-label>
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <x-input type="text" id="price" name="price" value="{{ $dish->price }}" class="text-center" data-min="0" data-step="100" data-rule="currency" />
                                            <div class="input-group-text">
                                                <button type="button" class="spin-up" data-spin="up">
                                                    <span class="arrow"></span>
                                                </button>
                                                <button type="button" class="spin-down" data-spin="down">
                                                    <span class="arrow"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quality -->
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <x-label>{{ __('Quality') }}</x-label>
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <x-input type="text" id="quality" name="quality" value="{{ $dish->quality }}" class="text-center" data-min="0" data-rule="quantity" />
                                            <div class="input-group-text">
                                                <button type="button" class="spin-up" data-spin="up">
                                                    <span class="arrow"></span>
                                                </button>
                                                <button type="button" class="spin-down" data-spin="down">
                                                    <span class="arrow"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row g-3">

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="form-group position-relative">
                                        <x-label>{{ __('Description') }}</x-label>
                                        <textarea id="description" name="description" class="form-control">{{ $dish->description }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <!-- Available -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="available" name="available" value="1"
                                    @if ($dish->available === 1)
                                        checked
                                    @endif />
                                    <label class="form-check-label" for="available">{{ __('Available') }}</label>
                                </div>
                            </div>

                            <x-button type="submit" class="btn-primary">{{ __('Update') }}</x-button>

                        </form>
                    </div>
                </div>
            </section>

            @if ($dish->orders->count() === 0)
            <form action="{{ route('restaurant.dishes.destroy', $dish->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="d-flex justify-content-end">
                    <x-button type="submit" class="btn-danger">{{ __('Delete dish') }}</x-button>
                </div>

            </form>
            @endif

        </div>
    </div>
</div>
@endsection
