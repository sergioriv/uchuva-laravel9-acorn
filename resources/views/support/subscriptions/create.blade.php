@php
$title = __('Create payment');
@endphp
@extends('layout',['title'=>$title])

@section('css')
<link rel="stylesheet" href="/css/vendor/bootstrap-datepicker3.standalone.min.css" />
<link rel="stylesheet" href="/css/vendor/select2.min.css" />
<link rel="stylesheet" href="/css/vendor/select2-bootstrap4.min.css" />
@endsection

@section('js_vendor')
<script src="/js/vendor/select2.full.min.js"></script>
<script src="/js/vendor/input-spinner.min.js"></script>
<script src="/js/vendor/datepicker/bootstrap-datepicker.min.js"></script>
<script src="/js/vendor/datepicker/locales/bootstrap-datepicker.es.min.js"></script>
{{-- <script src="/js/vendor/timepicker.js"></script> --}}
@endsection

@section('js_page')
<script>
    //datetimepicker
    jQuery('div.form-date input').datepicker({
      language: 'es',
      format: 'yyyy-mm-dd',
      autoclose: true,
    });

    /* if (document.querySelector('div.form-time input')) {
      new TimePicker(document.querySelector('div.form-time input'));
    } */
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ $title . ' | ' . $restaurant->user->name}}</h1>
                </div>
            </section>
            <!-- Title End -->

            <section class="scroll-section">
                <div class="card mb-5">
                    <div class="card-body">

                        <!-- Validation Errors -->
                        <x-validation-errors class="mb-4" :errors="$errors" />

                        <form method="POST" action="{{ route('support.subscriptions.store', $restaurant) }}"
                            class="tooltip-end-bottom" novalidate autocomplete="off">
                            @csrf

                            <div class="row">
                                <!-- Subscription Mounth -->
                                <div class="col-12 col-xl-6">
                                    <div class="mb-3">
                                        <x-label>{{ __('Subscription') . ' (' . __('Months') . ')' }}</x-label>
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <input type="text" class="form-control text-center" id="quantity"
                                                name="quantity" value="1" data-rule="quantity" />
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

                                <div class="col-12 col-xl-6">
                                    <div class="mb-3 form-date">
                                        <label class="form-label">{{ __('Date start') }}</label>
                                        <input type="text" name="date" id="date" class="form-control" />
                                    </div>
                                </div>

                                {{-- <div class="col-12 col-sm-12 col-xl-2">
                                    <div class="time-picker-container mb-3 form-time">
                                        <label class="form-label">{{ __('Time') }}</label>
                                        <input class="form-control time-picker" name="time" id="time" />
                                    </div>
                                </div> --}}
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
