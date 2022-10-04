@php
$title = __('Waiters list');
@endphp
@extends('layout',['title'=>$title])

@section('css')
<link rel="stylesheet" href="/css/vendor/datatables.min.css" />
@endsection

@section('js_vendor')
<script src="/js/vendor/bootstrap-submenu.js"></script>
<script src="/js/vendor/datatables.min.js"></script>
<script src="/js/vendor/mousetrap.min.js"></script>
@endsection

@section('js_page')
<script src="/js/cs/datatable.extend.js"></script>
<script src="/js/plugins/datatable/datatable_standard.js?r=1664915426"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Title and Top Buttons Start -->
            <div class="page-title-container">
                <div class="row">
                    <!-- Title Start -->
                    <div class="col-12 col-md-7">
                        <h1 class="mb-0 pb-0 display-4" id="title">{{ $title }}</h1>
                    </div>
                    <!-- Title End -->

                    <!-- Top Buttons Start -->
                    <div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
                        <!-- Add New Button Start -->
                        <a href="{{ route('restaurant.waiters.create') }}"
                            class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                            <i data-acorn-icon="plus"></i>
                            <span>{{ __('Add New') }}</span>
                        </a>
                        <!-- Add New Button End -->
                    </div>
                    <!-- Top Buttons End -->
                </div>
            </div>
            <!-- Title and Top Buttons End -->

            <!-- Content Start -->
            <div class="data-table-rows slim">
                <!-- Controls Start -->
                <div class="row">
                    <!-- Search Start -->
                    <div class="col-sm-12 col-md-5 col-lg-3 col-xxl-2 mb-1">
                        <div
                            class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground">
                            <input class="form-control datatable-search" placeholder="Search"
                                data-datatable="#datatable_waiters" />
                            <span class="search-magnifier-icon">
                                <i data-acorn-icon="search"></i>
                            </span>
                            <span class="search-delete-icon d-none">
                                <i data-acorn-icon="close"></i>
                            </span>
                        </div>
                    </div>
                    <!-- Search End -->
                </div>
                <!-- Controls End -->

                <!-- Table Start -->
                <div class="data-table-responsive-wrapper">
                    <table DataTable="true" class="data-table nowrap w-100">
                        <thead>
                            <tr>
                                <th class="empty">&nbsp;</th>
                                <th class="text-muted text-small text-uppercase">{{ __('Name') }}</th>
                                <th class="text-muted text-small text-uppercase">{{ __('Email') }}</th>
                                <th class="text-muted text-small text-uppercase">{{ __('Telephone') }}</th>
                                <th class="text-muted text-small text-uppercase">{{ __('Created at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($waiters as $waiter)
                            <tr>
                                <td>
                                    @if ($waiter->user->avatar !== NULL)
                                    <div class="sw-4 mb-1 d-inline-block"><img src="{{ $waiter->user->avatar }}" class="rounded-xl sh-4 sw-4" alt="thumb" /></div>
                                    @else
                                    <div class="sw-4 sh-4 me-1 mb-1 d-inline-block bg-separator d-flex justify-content-center align-items-center rounded-xl"><i class="bi-collection icon icon-18" class="icon"></i></div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('restaurant.waiters.edit', $waiter->id) }}">
                                        {{ $waiter->name }}
                                    </a>
                                </td>
                                <td>{{ $waiter->user->email }}</td>
                                <td>{{ $waiter->telephone }}</td>
                                <td class="text-small">{{ $waiter->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Table End -->
            </div>
            <!-- Content End -->
        </div>
    </div>
</div>
@endsection
