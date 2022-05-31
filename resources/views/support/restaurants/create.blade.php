@php
$title = __('Create restaurant');
@endphp
@extends('layout',['title'=>$title])

@section('css')
@endsection

@section('js_vendor')
    <script src="/js/cs/scrollspy.js"></script>
    <script src="/js/vendor/input-spinner.min.js"></script>
@endsection

@section('js_page')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ $title }}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('support.restaurants.store') }}" class="tooltip-end-bottom" novalidate>
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <x-label>{{ __('Name') }}</x-label>
                                <x-input id="name" name="name" :value="old('name')" required autofocus />
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <x-label>{{ __('Email') }}</x-label>
                                <x-input id="email" name="email" :value="old('email')" required />
                            </div>

                            <!-- Nit -->
                            <div class="mb-3">
                                <x-label>{{ __('Nit') }}</x-label>
                                <x-input id="nit" name="nit" :value="old('nit')" required />
                            </div>

                            <!-- Telephone -->
                            <div class="mb-3">
                                <x-label>{{ __('Telephone') }}</x-label>
                                <x-input id="telephone" name="telephone" :value="old('telephone')" required />
                            </div>

                            <!-- Subscription Mounth -->
                            <div class="mb-3">
                                <x-label>{{ __('Subscription') . ' (' . __('Months') . ')' }}</x-label>
                                <div class="input-group spinner" data-trigger="spinner">
                                    <x-input type="text" class="text-center" id="subscription" name="subscription" value="1" data-rule="quantity" />
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

                            <x-button type="submit" class="btn-primary">{{ __('Create') }}</x-button>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection
