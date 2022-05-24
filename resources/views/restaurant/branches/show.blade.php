@php
$title = $branch->user->name;
@endphp
@extends('layout',['title'=>$title])

@section('css')
<link rel="stylesheet" href="/css/vendor/datatables.min.css" />
@endsection

@section('js_vendor')
<script src="/js/cs/responsivetab.js"></script>
<script src="/js/vendor/bootstrap-submenu.js"></script>
<script src="/js/vendor/datatables.min.js"></script>
<script src="/js/vendor/mousetrap.min.js"></script>
@endsection

@section('js_page')
<script src="/js/cs/datatable.extend.js"></script>
<script src="/js/plugins/datatable/subscriptions_datatable.ajax.js"></script>
@endsection

@section('content')
<input type="hidden" id="branch" value="{{ $branch->id }}">
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title Start -->
            <section class="scroll-section" id="title">
                <div class="page-title-container">
                    <h1 class="mb-0 pb-0 display-4">{{ __('Branch') .' | '. __($title) }}</h1>
                </div>
            </section>
            <!-- Title End -->


            <section class="scroll-section">
                <div class="row gx-4 gy-5">
                    <!-- Left Side Start -->
                    <div class="col-12 col-xl-4 col-xxl-3">
                        <!-- Biography Start -->
                        <div class="card">
                            <div class="card-body mb-n5">
                                <div class="d-flex align-items-center flex-column mb-3">
                                    <div class="mb-5 d-flex align-items-center flex-column">

                                        @if ($branch->user->avatar != NULL)
                                        <div class="sw-13 position-relative mb-3">
                                            <img src="{{ $branch->user->avatar }}" class="rounded-xl sh-13 sw-13"
                                                alt="thumb" />
                                        </div>
                                        @else
                                        <div
                                            class="sw-13 sh-13 mb-3 d-inline-block bg-separator d-flex justify-content-center align-items-center rounded-xl">
                                            <i class="bi-building icon icon-24" class="icon"></i>
                                        </div>
                                        @endif

                                        <div class="h5 mb-0">{{ $branch->user->name }}</div>
                                        <div class="text-muted">{{ $branch->code }}</div>
                                        <div class="text-muted">{{ $branch->city }}</div>
                                        <div class="text-muted">{{ $branch->address }}</div>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <p class="text-small text-uppercase text-muted mb-2">{{ __('contact') }}</p>
                                    <div class="d-block mb-1">
                                        <i data-acorn-icon="phone" class="me-2" data-acorn-size="17"></i>
                                        <span class="align-middle">{{ $branch->telephone }}</span>
                                    </div>
                                    <div class="d-block">
                                        <i data-acorn-icon="email" class="me-2" data-acorn-size="17"></i>
                                        <span class="align-middle">{{ $branch->user->email }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex flex-row justify-content-end w-100 w-sm-50 w-xl-100">
                                        <a href="{{ route('restaurant.branches.edit', $branch) }}" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
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
                    <div class="col-12 col-xl-8 col-xxl-9">
                        <!-- Title Tabs Start -->
                        <ul class="nav nav-tabs nav-tabs-title nav-tabs-line-title responsive-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab" role="tab"
                                    aria-selected="true">{{ __('Tab') }}</a>
                            </li>
                        </ul>
                        <!-- Title Tabs End -->

                        <div class="tab-content">
                            <!-- Payments Tab Start -->
                            <div class="tab-pane fade active show" id="tab" role="tabpanel">
                                contenido
                            </div>
                            <!-- Payments Tab End -->
                        </div>
                    </div>
                    <!-- Right Side End -->
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
