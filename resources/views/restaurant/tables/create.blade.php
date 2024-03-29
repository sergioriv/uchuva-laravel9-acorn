@php
$title = __('Create table');
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
                    <h1 class="mb-0 pb-0 display-4">{{ $title }}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('restaurant.tables.store') }}" class="tooltip-end-bottom"
                            novalidate>
                            @csrf

                            <!-- Reference -->
                            <div class="mb-3">
                                <x-label>{{ __('Reference') }}</x-label>
                                <x-input id="reference" name="reference" :value="old('reference')" class="text-uppercase" maxlength="3" aria-describedby="referenceHelpBlock" required autofocus />
                                <div id="referenceHelpBlock" class="form-text">
                                    {{ __('The reference must be 3 characters max, contain letters and numbers.') }}
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
