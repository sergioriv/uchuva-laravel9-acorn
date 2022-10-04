@php
$title = $category->name;
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
                    <h1 class="mb-0 pb-0 display-4">{{ $title . ' | ' . __('Category') }}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('restaurant.categories.update', $category) }}"
                            class="tooltip-end-bottom" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-3">
                                <x-label>{{ __('Name') }}</x-label>
                                <x-input id="name" name="name" value="{{ $category->name }}" required autofocus />
                            </div>

                            <x-button type="submit" class="btn-primary">{{ __('Update') }}</x-button>

                        </form>
                    </div>
                </div>
            </section>

            @if ($category->dishes->count() === 0)
            <form action="{{ route('restaurant.categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="d-flex justify-content-end">
                    <x-button type="submit" class="btn-danger">{{ __('Delete category') }}</x-button>
                </div>

            </form>
            @endif


        </div>
    </div>
</div>
@endsection
