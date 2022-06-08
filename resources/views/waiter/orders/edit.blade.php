@php
$title = $order->code;
@endphp
@extends('layout', ['title' => $title])

@section('css')
@endsection

@section('js_vendor')
<script src="/js/vendor/input-spinner.min.js"></script>
@endsection

@section('js_page')
<script src="/js/pages/confirm_order.js"></script>
<script>
    @foreach ($order->dishes as $oldDish)
            dishes_selected.push({{ $oldDish->dish_id }});
        @endforeach
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <div class="row">
                        <!-- Title Start -->
                        <div class="col-12 col-md-7">
                            <h1 class="mb-0 pb-0 display-4">{{ $title . ' | ' . __('Order') }}</h1>
                        </div>
                        <!-- Title End -->

                        <!-- Top Buttons Start -->
                        <form method="POST" action="{{ route('waiter.orders.update', $order) }}"
                            class="col-12 col-md-5 d-flex align-items-start justify-content-end">
                            <!-- Order delivered Button Start -->
                            @csrf
                            @method('PUT')

                            <x-button type="button" name="finished" value="1" class="btn-outline-info w-100 w-md-auto"
                                data-bs-toggle="modal" data-bs-target="#modalConfirmDelivered">
                                {{ '¿'. __('Order delivered') .'?'}}
                            </x-button>
                            <!-- Order delivered Button End -->

                            <!-- Modal Delivered Start -->
                            <x-modal id="modalConfirmDelivered">
                                @section('title', '¿'. __('Order delivered') .'?')
                                <p>
                                    {{ __('Confirm order delivered') }}
                                </p>
                                @section('button-confirm')
                                    <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                                @endsection
                            </x-modal>
                            <!-- Modal Delivered End -->
                        </form>
                        <!-- Top Buttons End -->
                    </div>
                </div>


            </section>
            <!-- Title End -->

            <section class="scroll-section">

                <!-- Validation Errors -->
                <x-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('waiter.orders.update', $order) }}" class="tooltip-end-bottom"
                    novalidate autocomplete="off">
                    @csrf
                    @method('PUT')

                    <!-- Table -->
                    <input type="hidden" name="table" id="table" value="{{ $order->table->id }}"
                        data-reference="{{ $order->table->reference }}" />

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
                                        <div class="btn btn-link list-item-heading p-0 text-uppercase">
                                            {{ $category->name }}</div>
                                    </div>
                                </div>
                                <div id="collapse{{ $category->id }}" class="collapse show"
                                    data-bs-parent="#accordionCardsCategories">
                                    <div class="card-body accordion-content pt-0">
                                        <div class="data-table-rows slim">
                                            <table
                                                class="data-table nowrap w-100 dataTable no-footer text-center table-order">
                                                <tbody>
                                                    @foreach ($category->dishes as $dish)
                                                    @php
                                                    $dish_quality = 0;
                                                    $dish_note = '';
                                                    @endphp
                                                    @foreach ($order->dishes as $oldDish)
                                                    @if ($oldDish->dish_id == $dish->id)
                                                    @php
                                                    $dish->price = $oldDish->price;
                                                    $dish_quality = $oldDish->quality;
                                                    $dish_note = $oldDish->note;
                                                    @endphp
                                                    @endif
                                                    @endforeach
                                                    @if ($dish->available != null || $dish_quality > 0)
                                                    <tr>
                                                        <td>
                                                            <text class="h6">{{ $dish->quality }}</text>
                                                            <br>
                                                            <text class="h4" id="dish-name-{{ $dish->id }}">{{
                                                                $dish->name }}</text>
                                                            <br>
                                                            <text class="text-small"
                                                                id="dish-price-{{ $dish->id }}">@money($dish->price)</text>
                                                            <br>
                                                            <div class="input-group spinner" data-trigger="spinner">
                                                                <div class="input-group-text">
                                                                    <button type="button"
                                                                        class="spin-down single btn-quality"
                                                                        data-id="{{ $dish->id }}"
                                                                        data-spin="down">-</button>
                                                                </div>
                                                                <x-input type="text" name="dish-quality-{{ $dish->id }}"
                                                                    id="dish-quality-{{ $dish->id }}"
                                                                    data-id="{{ $dish->id }}"
                                                                    class="text-center dish-quality"
                                                                    value="{{ $dish_quality }}" data-min="0"
                                                                    data-max="{{ $dish->quality }}"
                                                                    data-rule="quantity" />
                                                                <div class="input-group-text">
                                                                    <button type="button"
                                                                        class="spin-up single btn-quality"
                                                                        data-id="{{ $dish->id }}"
                                                                        data-spin="up">+</button>
                                                                </div>
                                                            </div>
                                                            <div id="note-{{ $dish->id }}"
                                                                class="mt-2 @if ($dish_quality == 0) d-none @endif">
                                                                <textarea name="dish-note-{{ $dish->id }}"
                                                                    id="dish-note-{{ $dish->id }}" class="form-control"
                                                                    rows="2"
                                                                    placeholder="{{ __('add note') }}">{{ $dish_note }}</textarea>
                                                            </div>
                                                            <input type="hidden" name="dish-price-{{ $dish->id }}"
                                                                value="{{ $dish->price }}">
                                                        </td>
                                                    </tr>
                                                    @endif
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

                    <button type="button" id="order-confirm" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalConfirmOrder">{{ __('Continue') }}</button>

                    <!-- Modal Confirm Start -->
                    <x-modal id="modalConfirmOrder">
                        @section('title', __('Confirm Order'))
                        <section id="dish-confirm">
                        </section>
                    </x-modal>
                    <!-- Modal Confirm End -->

                </form>
            </section>

        </div>
    </div>

</div>
@endsection
