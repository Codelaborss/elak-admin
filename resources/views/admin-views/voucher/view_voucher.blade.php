@extends('layouts.admin.app')

@section('title', translate('Item Preview'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title text-break">
                    <span class="page-header-icon">
                        <img src="{{ asset('public/assets/admin/img/items.png') }}" class="w--22" alt="">
                    </span>
                    <span>{{ $product['name'] }}</span>
                </h1>
                <div>

                </div>
            </div>
        </div>
        <!-- End Page Header -->


        <!-- Description Card Start -->
        <div class="card mb-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">{{ translate('short_description') }}</h4>
                                </th>
                                @if (in_array($product->module->module_type, ['food', 'grocery']))
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">{{ translate('Nutrition') }}</h4>
                                    </th>
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">{{ translate('Allergy') }}</h4>
                                    </th>
                                @endif
                                @if (Config::get('module.current_module_type') != 'food')
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">{{ translate('Stock') }}</h4>
                                    </th>
                                @endif

                                @if (in_array($product->module->module_type, ['pharmacy']))
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">{{ translate('Generic_Name') }}</h4>
                                    </th>
                                @endif

                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">{{ translate('price') }}</h4>
                                </th>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">{{ translate('variations') }}</h4>
                                </th>
                                @if ($product->module->module_type == 'food')
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">{{ translate('addons') }}</h4>
                                    </th>
                                @endif
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize">{{ translate('tags') }}</h4>
                                </th>
                                @if ($productWiseTax)
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize">{{ translate('Tax/Vat') }}</h4>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 max-w--220px">
                                    <div class="">
                                        {!! $product['description'] !!}
                                    </div>
                                </td>
                                @if (in_array($product->module->module_type, ['food', 'grocery']))
                                    <td class="px-4">
                                        @if ($product->nutritions)
                                            @foreach ($product->nutritions as $nutrition)
                                                {{ $nutrition->nutrition }}{{ !$loop->last ? ',' : '.' }}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="px-4">
                                        @if ($product->allergies)
                                            @foreach ($product->allergies as $allergy)
                                                {{ $allergy->allergy }}{{ !$loop->last ? ',' : '.' }}
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                                @if (Config::get('module.current_module_type') != 'food')
                                    <td class="px-4">{{ $product->stock }}</td>
                                @endif
                                @if (in_array($product->module->module_type, ['pharmacy']))
                                    <td class="px-4">
                                        @if ($product->generic->pluck('generic_name')->first())
                                            {{ $product->generic->pluck('generic_name')->first() }}
                                        @endif
                                    </td>

                                @endif
                                <td class="px-4">
                                    <span class="d-block mb-1">
                                        <span>{{ translate('messages.price') }} : </span>
                                        <strong>{{ \App\CentralLogics\Helpers::format_currency($product['price']) }}</strong>
                                    </span>
                                    <span class="d-block mb-1">
                                        <span>{{ translate('messages.discount') }} :</span>

                                        <strong>  {{$product['discount_type'] == 'percent' ? $product['discount'] . ' %' : \App\CentralLogics\Helpers::format_currency($product['discount']) }}   </strong>
                                    </span>
                                    @if (config('module.' . $product->module->module_type)['item_available_time'])
                                        <span class="d-block mb-1">
                                            {{ translate('messages.available_time_starts') }} :
                                            <strong>{{ date(config('timeformat'), strtotime($product['available_time_starts'])) }}</strong>
                                        </span>
                                        <span class="d-block mb-1">
                                            {{ translate('messages.available_time_ends') }} :
                                            <strong>{{ date(config('timeformat'), strtotime($product['available_time_ends'])) }}</strong>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4">
                                    @if ($product->module->module_type == 'food')
                                        @if ($product->food_variations && is_array(json_decode($product['food_variations'], true)))
                                            @foreach (json_decode($product->food_variations, true) as $variation)
                                                @if (isset($variation['price']))
                                                    <span class="d-block mb-1 text-capitalize">
                                                        <strong>
                                                            {{ translate('please_update_the_food_variations.') }}
                                                        </strong>
                                                    </span>
                                                    @break

                                                @else
                                                    <span class="d-block text-capitalize">
                                                        <strong>
                                                            {{ $variation['name'] }} -
                                                        </strong>
                                                        @if ($variation['type'] == 'multi')
                                                            {{ translate('messages.multiple_select') }}
                                                        @elseif($variation['type'] == 'single')
                                                            {{ translate('messages.single_select') }}
                                                        @endif
                                                        @if ($variation['required'] == 'on')
                                                            - ({{ translate('messages.required') }})
                                                        @endif
                                                    </span>

                                                    @if ($variation['min'] != 0 && $variation['max'] != 0)
                                                        ({{ translate('messages.Min_select') }}: {{ $variation['min'] }} -
                                                        {{ translate('messages.Max_select') }}: {{ $variation['max'] }})
                                                    @endif

                                                    @if (isset($variation['values']))
                                                        @foreach ($variation['values'] as $value)
                                                            <span class="d-block text-capitalize">
                                                                &nbsp; &nbsp; {{ $value['label'] }} :
                                                                <strong>{{ \App\CentralLogics\Helpers::format_currency($value['optionPrice']) }}</strong>
                                                            </span>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @else
                                        @if ($product->variations && is_array(json_decode($product['variations'], true)))
                                            @foreach (json_decode($product['variations'], true) as $variation)
                                                <span class="d-block mb-1 text-capitalize">
                                                    {{ $variation['type'] }} :
                                                    {{ \App\CentralLogics\Helpers::format_currency($variation['price']) }}
                                                </span>
                                            @endforeach
                                        @endif
                                </td>
                                @endif
                                @if ($product->module->module_type == 'food')

                                    <td class="px-4">
                                        @if (config('module.' . $product->module->module_type)['add_on'])
                                            @foreach (\App\Models\AddOn::whereIn('id', json_decode($product['add_ons'], true))->get() as $addon)
                                                <span class="d-block mb-1 text-capitalize">
                                                    {{ $addon['name'] }} :
                                                    {{ \App\CentralLogics\Helpers::format_currency($addon['price']) }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                                @if ($product->tags)
                                    <td>
                                        @foreach ($product->tags as $c)
                                            {{ $c->tag }}{{ !$loop->last ? ',' : '.' }}
                                        @endforeach
                                    </td>
                                @endif

                                @if ($productWiseTax)
                                    <td>

                                        <span class="d-block font-size-sm text-body">
                                            @forelse ($product?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray() as $key => $tax)
                                                <span> {{ $tax }} : <span class="font-bold">
                                                        ({{ $key }}%)
                                                    </span> </span>
                                                <br>
                                            @empty
                                                <span> {{ translate('messages.no_tax') }} </span>
                                            @endforelse
                                        </span>
                                    </td>
                                @endif

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Description Card End -->
        <!-- Card -->

        <!-- End Card -->
    </div>

    {{-- Add Quantity Modal --}}
    <div class="modal fade update-quantity-modal" id="update-quantity" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">

                    <form action="{{ route('admin.Voucher.stock-update') }}" method="post">
                        @csrf
                        <div class="mt-2 rest-part w-100"></div>
                        <div class="btn--container justify-content-end">
                            <button type="reset" data-dismiss="modal" aria-label="Close"
                                class="btn btn--reset">{{ translate('cancel') }}</button>
                            <button type="submit" id="submit_new_customer"
                                class="btn btn--primary">{{ translate('update_stock') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        "use strict";
        $(".status_form_alert").on("click", function(e) {
            const id = $(this).data('id');
            const message = $(this).data('message');
            e.preventDefault();
            Swal.fire({
                title: '{{ translate('messages.are_you_sure') }}',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{ translate('messages.no') }}',
                confirmButtonText: '{{ translate('messages.yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#' + id).submit()
                }
            })
        })

        $('.update-quantity').on('click', function() {
            let val = $(this).data('id');
            $.get({
                url: '{{ route('admin.Voucher.get_stock') }}',
                data: {
                    id: val
                },
                dataType: 'json',
                success: function(data) {
                    $('.rest-part').empty().html(data.view);
                    update_qty();
                },
            });
        })

        function update_qty() {
            let total_qty = 0;
            let qty_elements = $('input[name^="stock_"]');
            for (let i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", 'readonly');
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }
    </script>
@endpush
