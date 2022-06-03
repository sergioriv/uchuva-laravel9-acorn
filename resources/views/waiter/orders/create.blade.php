@php
$title = __('Create order');
@endphp
@extends('layout',['title'=>$title])

@section('css')
@endsection

@section('js_vendor')
<script src="/js/vendor/input-spinner.min.js"></script>
@endsection

@section('js_page')
<script>
    jQuery('.add-table').click(function () {
        jQuery('#table').val( $(this).data('id') )
        $('.add-table .card').removeClass('border border-primary');
        $(this).children('.card').addClass('border border-primary');

    })
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ $title}}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">

                <!-- Validation Errors -->
                <x-validation-errors class="mb-4" :errors="$errors" />

                {{-- <form method="POST" action="{{ route('waiter.orders.create') }}" class="tooltip-end-bottom"
                    novalidate --}} {{-- autocomplete="off"> --}}
                    {{-- @csrf --}}


                    <!-- Table -->
                    <input type="hidden" name="table" id="table" />

                    <div class="mb-5">
                        <h2 class="small-title">{{ __('Tables') }}</h2>
                        <div class="row g-2">
                            @foreach ($tables as $table)
                            <div class="col-6 col-md-4 col-lg-2 add-table" data-id="{{ $table->id }}">
                                <div class="card hover-scale-up cursor-pointer">
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <div
                                            class="sw-8 sh-8 rounded-xl d-flex justify-content-center align-items-center h4 border border-primary">
                                            {{ $table->reference }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Menu -->
                    <section class="mb-5">
                        <h2 class="small-title">{{ __('Menu') }}</h2>
                        <div class="mb-n2" id="accordionCardsCategories">
                            @foreach ($categories as $category)
                            <div class="card d-flex mb-2">
                                <div class="d-flex flex-grow-1" role="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $category->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $category->id }}">
                                    <div class="card-body py-4">
                                        <div class="btn btn-link list-item-heading p-0 text-uppercase">{{
                                            $category->name }}</div>
                                    </div>
                                </div>
                                <div id="collapse{{ $category->id }}" class="collapse"
                                    data-bs-parent="#accordionCardsCategories">
                                    <div class="card-body accordion-content pt-0">
                                        <div class="data-table-rows slim">
                                            <table
                                                class="data-table nowrap w-100 dataTable no-footer text-center table-order">
                                                <tbody>
                                                    @foreach ($category->dishes as $dish)
                                                    <tr>
                                                        <td>
                                                            <text class="h4">{{ $dish->name }}</text>
                                                            <br>
                                                            <text class="text-small">@money($dish->price)</text>
                                                            <br>

                                                            <div class="input-group spinner" data-trigger="spinner">
                                                                <div class="input-group-text">
                                                                    <button type="button" class="spin-down single"
                                                                        data-spin="down">-</button>
                                                                </div>
                                                                <input type="text" class="form-control text-center"
                                                                    value="0" data-min="0" data-rule="quantity" />
                                                                <div class="input-group-text">
                                                                    <button type="button" class="spin-up single"
                                                                        data-spin="up">+</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- <x-button type="submit" class="btn-primary">{{ __('Create') }}</x-button> --}}

                    {{--
                </form> --}}
            </section>

        </div>
    </div>
</div>
@endsection
