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

    var dishes_selected = [];

    jQuery('.add-table').click(function () {
        jQuery('#table').val( $(this).data('id') ).data('reference', $(this).data('reference'));
        $('.add-table .card').removeClass('border border-primary');
        $(this).children('.card').addClass('border border-primary');
    });

    jQuery('.dish-quality').keyup(function () {

        var id = $(this).data('id');

        if($(this).val() > 0) {
            $( '#note-' + id ).removeClass('d-none');

            if (!dishes_selected.includes(id))
                dishes_selected.push(id);

        } else {
            $( '#note-' + id ).addClass('d-none').children('textarea').val('');

            dishes_selected.splice( $.inArray(id, dishes_selected), 1 );
        }
    });

    jQuery('.btn-quality').click(function () {

        var id = $(this).data('id');

        var dishQuality = $( '#dish-quality-' + id ).val();

        dishQuality = $(this).data('spin') == 'up' ? dishQuality+= 1 : dishQuality-= 1;

        if(dishQuality > 0) {
            $( '#note-' + id ).removeClass('d-none');

            if (!dishes_selected.includes(id))
                dishes_selected.push(id);

        } else {
            $( '#note-' + id ).addClass('d-none').children('textarea').val('');

            dishes_selected.splice( $.inArray(id, dishes_selected), 1 );
        }
    });

    jQuery('#order-confirm').click(function () {
        var inner_dishes = '';

        if ( !$('#table').val() ) {
            $('#dish-confirm').html(`Debe seleccionar una mesa`);
            return;
        }

        if ( dishes_selected.length == 0 ) {
            $('#dish-confirm').html(`Debe seleccionar platos`);
            return;
        }

        $('#footer-order-confirm').html(`<button type="submit" class="btn btn-primary">Crear</button>`);

        inner_dishes += `<div class="text-center h4 mb-5">Mesa: ` + $('#table').data('reference') + `</div>`;
        inner_dishes += `<div class="data-table-rows slim">`;
        inner_dishes += `<table class="data-table nowrap w-100 dataTable no-footer text-center table-order">`;
        inner_dishes += `<tbody>`;

        dishes_selected.forEach(dish_id => {
            inner_dishes += `<tr><td>`;
            inner_dishes += `<text class="h4">` + $('#dish-name-' + dish_id).html() + `</text><br>`;
            inner_dishes += `<text class="text-small">` + $('#dish-price-' + dish_id).html() +`</text><br>`;
            inner_dishes += `<text class="h5">` + $('#dish-quality-' + dish_id).val() + `</text><br>`;
            inner_dishes += `<text class="text-small">` + $('#dish-note-' + dish_id).val() + `</text><br>`;
            inner_dishes += `</td></tr>`;
        });

        inner_dishes += `</tbody>`;
        inner_dishes += `</table>`;
        inner_dishes += `</div>`;

        $('#dish-confirm').html(inner_dishes);
    });

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

            <form method="POST" action="{{ route('waiter.orders.store') }}" class="tooltip-end-bottom" novalidate
               autocomplete="off">
               @csrf

               <!-- Table -->
               <input type="hidden" name="table" id="table" value="{{ old('table') }}" />

               <div class="mb-5">
                  <h2 class="small-title">{{ __('Tables') }}</h2>
                  <div class="row g-2">
                     @foreach ($tables as $table)
                     <div class="col-6 col-md-4 col-lg-2 add-table" data-id="{{ $table->id }}" data-reference="{{ $table->reference }}">
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
                        <div id="collapse{{ $category->id }}" class="collapse show"
                           data-bs-parent="#accordionCardsCategories">
                           <div class="card-body accordion-content pt-0">
                              <div class="data-table-rows slim">
                                 <table class="data-table nowrap w-100 dataTable no-footer text-center table-order">
                                    <tbody>
                                       @foreach ($category->dishes as $dish)
                                       @if ($dish->available != NULL)
                                       <tr>
                                          <td>
                                             <text class="h6">{{ $dish->quality }}</text>
                                             <br>
                                             <text class="h4" id="dish-name-{{ $dish->id }}">{{ $dish->name }}</text>
                                             <br>
                                             <text class="text-small" id="dish-price-{{ $dish->id }}">@money($dish->price)</text>
                                             <br>
                                             <div class="input-group spinner" data-trigger="spinner">
                                                <div class="input-group-text">
                                                   <button type="button" class="spin-down single btn-quality" data-id="{{ $dish->id }}"
                                                      data-spin="down">-</button>
                                                </div>
                                                <x-input type="text" name="dish-quality-{{ $dish->id }}" id="dish-quality-{{ $dish->id }}" data-id="{{ $dish->id }}" class="text-center dish-quality"
                                                   value="{{ old('dish-'.$dish->id) }}" data-min="0" data-max="{{ $dish->quality }}"
                                                   data-rule="quantity" />
                                                <div class="input-group-text">
                                                   <button type="button" class="spin-up single btn-quality" data-id="{{ $dish->id }}"
                                                      data-spin="up">+</button>
                                                </div>
                                             </div>
                                             <div id="note-{{ $dish->id }}" class="mt-2 d-none">
                                                <textarea name="dish-note-{{ $dish->id }}" id="dish-note-{{ $dish->id }}" class="form-control" rows="2" placeholder="{{ __('add note') }}"></textarea>
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

               {{-- <x-button type="submit" class="btn-primary">{{ __('Continue') }}</x-button> --}}
               <button type="button" id="order-confirm" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#openModal">{{ __('Continue') }}</button>

               <x-modal id="openModal">
                <section id="dish-confirm">

                </section>
               </x-modal>
            </form>
         </section>

      </div>
   </div>

   <!-- Modal -->

</div>
@endsection
