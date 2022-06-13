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
<script src="/js/plugins/datatable/branch_waiters_datatable.ajax.js"></script>
<script src="/js/plugins/datatable/branch_tables_datatable.ajax.js"></script>
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
                                            <img src="{{ $branch->user->avatar }}" class="img-fluid rounded-xl"
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
                                        <a href="{{ route('restaurant.branches.edit', $branch) }}"
                                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#menuTab" role="tab"
                                    aria-selected="true">{{
                                    __('Menu') }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#waitersTab" role="tab"
                                    aria-selected="false">{{
                                    __('Waiters') }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tablesTab" role="tab"
                                    aria-selected="false">{{
                                    __('Tables') }}</a>
                            </li>
                        </ul>
                        <!-- Title Tabs End -->

                        <div class="tab-content">

                            <!-- Menu Tab Start -->
                            <div class="tab-pane fade active show" id="menuTab" role="tabpanel">
                                <section class="mb-5">
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
                                                    <section class="scroll-section">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">&nbsp;</th>
                                                                    <th scope="col">{{ __('Name') }}</th>
                                                                    <th scope="col">{{ __('Price') }}</th>
                                                                    <th scope="col">{{ __('Quality') }}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($category->dishes as $dish)
                                                                <tr>
                                                                    <td scope="row">
                                                                        @if ($dish->available == 1) <i
                                                                            class="bi-check-circle-fill icon icon-14 text-success"></i>
                                                                        @else <i
                                                                            class="bi-x-circle-fill icon icon-14 text-danger"></i>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $dish->name }}</td>
                                                                    <td>@money($dish->price)</td>
                                                                    <td>{{ $dish->quality }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </section>
                            </div>
                            <!-- Menu Tab End -->

                            <!-- Waiters Tab Start -->
                            <div class="tab-pane fade" id="waitersTab" role="tabpanel">
                                {{-- <div class="data-table-rows slim"> --}}
                                    <!-- Table Start -->
                                    {{-- <div class="data-table-responsive-wrapper"> --}}
                                        <section class="scroll-section">
                                            <table class="table table-striped"> <!--  id="datatable_branch_waiters" -->
                                                <thead>
                                                    <tr>
                                                        <th class="text-muted text-small text-uppercase">&nbsp;</th>
                                                        <th class="text-muted text-small text-uppercase">{{ __('Name')
                                                            }}
                                                        </th>
                                                        <th class="text-muted text-small text-uppercase">{{ __('Email')
                                                            }}
                                                        </th>
                                                        <th class="text-muted text-small text-uppercase">{{
                                                            __('Telephone')
                                                            }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($branch->waiters as $waiter)
                                                    <tr>
                                                        <td>
                                                            <div class="sw-4 mb-1 d-inline-block">
                                                                <img src="{{ $waiter->user->avatar }}" class="rounded-xl sh-4 sw-4" />
                                                            </div>
                                                        </td>
                                                        <td>{{ $waiter->user->name }}</td>
                                                        <td>{{ $waiter->user->email }}</td>
                                                        <td>{{ $waiter->telephone }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </section>
                                        {{--
                                    </div> --}}
                                    <!-- Table End -->
                                    {{--
                                </div> --}}
                            </div>
                            <!-- Waiters Tab End -->

                            <!-- Tables Tab Start -->
                            <div class="tab-pane fade" id="tablesTab" role="tabpanel">
                                <!-- Table Start -->
                                <section class="scroll-section">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive-sm mb-5">
                                                <table class="table table-striped" id="datatable_branch_tables">
                                                    <!-- id="datatable_branch_tables" -->
                                                    <thead>
                                                        <tr>
                                                            <th class="text-muted text-small text-uppercase">{{
                                                                __('Reference')
                                                                }}</th>
                                                            <th class="text-muted text-small text-uppercase">{{
                                                                __('Created at')
                                                                }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($branch->tables as $table)
                                                        <tr>
                                                            <td>{{ $table->reference }}</td>
                                                            <td>{{ $table->created_at }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- Tables Tab End -->
                        </div>

                    </div>
                </div>
                <!-- Right Side End -->
            </section>
        </div>
    </div>
</div>
@endsection
