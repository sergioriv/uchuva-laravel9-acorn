@php
$title = $restaurant->user->name;
@endphp
@extends('layout',['title'=>$title])

@section('css')
<link rel="stylesheet" href="/css/vendor/datatables.min.css" />
@endsection

@section('js_vendor')
<script src="/js/vendor/datatables.min.js"></script>
@endsection

@section('js_page')
<script src="/js/cs/datatable.extend.js"></script>
<script src="/js/plugins/datatable/datatable_standard.js?r=1664915426"></script>
@endsection

@section('content')
<input type="hidden" id="restaurant" value="{{ $restaurant->id }}">
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ $title . ' | '. __('Profile') }}</h1>
                </div>
            </section>
            <!-- Title End -->


            <section class="scroll-section">
                <div class="row gx-4 gy-5">
                    <!-- Left Side Start -->
                    <div class="col-12 col-xl-3">
                        <!-- Biography Start -->
                        <div class="card">
                            <div class="card-body mb-n5">
                                <div class="d-flex align-items-center flex-column mb-3">
                                    <div class="mb-5 d-flex align-items-center flex-column">

                                        @if ($restaurant->user->avatar != NULL)
                                        <div class="sw-13 position-relative mb-3">
                                            <img src="{{ config('app.url') .'/'. $restaurant->user->avatar }}" class="rounded-xl sh-13 sw-13"
                                                alt="thumb" />
                                        </div>
                                        @else
                                        <div
                                            class="sw-13 sh-13 mb-3 d-inline-block bg-separator d-flex justify-content-center align-items-center rounded-xl">
                                            <i class="bi-building icon icon-24" class="icon"></i>
                                        </div>
                                        @endif

                                        <div class="h5 mb-0">{{ $restaurant->name }}</div>
                                        <div class="text-muted">{{ $restaurant->nit }}</div>
                                        <div class="mt-1 text-muted">{{ $restaurant->slug }}</div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <p class="text-small text-uppercase text-muted mb-2">{{ __('contact') }}</p>
                                    <div class="d-block mb-1">
                                        <i data-acorn-icon="phone" class="me-2" data-acorn-size="17"></i>
                                        <span class="align-middle">{{ $restaurant->telephone }}</span>
                                    </div>
                                    <div class="d-block">
                                        <i data-acorn-icon="email" class="me-2" data-acorn-size="17"></i>
                                        <span class="align-middle">{{ $restaurant->user->email }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex flex-row justify-content-end w-100 w-sm-50 w-xl-100">
                                        <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
                                            <i data-acorn-icon="edit"></i>
                                            <span>{{ __('Edit') }}</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Biography End -->
                    </div>
                    <!-- Left Side End -->

                    <!-- Right Side Start -->
                    <div class="col-12 col-xl-9">

                        <h4 class="small-title">{{ __("Payments") }}</h4>
                            <!-- Payments Tab Start -->
                                <div class="data-table-rows slim">
                                    <!-- Table Start -->
                                    <div class="data-table-responsive-wrapper">
                                        <table DataTable="true" class="data-table nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="text-muted text-small text-uppercase">{{ __('Months') }}</th>
                                                    <th class="text-muted text-small text-uppercase">{{ __('Start date') }}</th>
                                                    <th class="text-muted text-small text-uppercase">{{ __('Unsubscribe') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($restaurant->subscriptions as $subscription)
                                                <tr>
                                                    <td>{{ $subscription->quantity }}</td>
                                                    <td class="text-small">{{ $subscription->payment_date }}</td>
                                                    <td class="text-small">{{ $subscription->unsubscribe }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Table End -->
                                </div>

                            <!-- Payments Tab End -->
                    </div>
                    <!-- Right Side End -->
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
