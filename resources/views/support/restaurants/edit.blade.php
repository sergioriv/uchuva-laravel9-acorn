@php
$title = 'Edit restaurant';
@endphp
@extends('layout',['title'=>$title])

@section('css')
@endsection

@section('js_vendor')
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
                    <h1 class="mb-0 pb-0 display-4">{{ $title .' | '. $restaurant->user->name }}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('support.restaurants.update', $restaurant) }}" class="tooltip-end-bottom" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-3">
                                <x-label>{{ __('Name') }}</x-label>
                                <x-input id="name" name="name" value="{{ $restaurant->user->name }}" required autofocus />
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <x-label>{{ __('Email') }}</x-label>
                                <x-input id="email" name="email"  value="{{ $restaurant->user->email }}" required />
                            </div>

                            <!-- Nit -->
                            <div class="mb-3">
                                <x-label>{{ __('Nit') }}</x-label>
                                <x-input id="nit" name="nit"  value="{{ $restaurant->nit }}" required />
                            </div>

                            <!-- Telephone -->
                            <div class="mb-3">
                                <x-label>{{ __('Telephone') }}</x-label>
                                <x-input id="telephone" name="telephone"  value="{{ $restaurant->telephone }}" required />
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
