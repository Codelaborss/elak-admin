@extends('layouts.admin.app')

@section('title', $store->name . "'s " . translate('messages.items'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/admin/css/croppie.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        @include('admin-views.vendor.view.partials._header', ['store' => $store])
        <!-- Page Heading -->
          <form class="search-form">
              <input type="hidden" name="store_id" value="{{ $store->id }}">
        <div class="row my-4">
            <div class="col-sm-6 col-md-3">
                <div class="select-item">
                    <select name="voucher_ids" class="form-control js-select2-custom set-filter"
                            data-url="{{url()->full()}}" data-filter="voucher_ids">
                        <option value="" {{!request('voucher_ids')?'selected':''}}>{{ translate('All Voucher Types') }}</option>
                        @foreach(\App\Models\VoucherType::orderBy('name')->get(['id','name']) as $voucher)
                            <option
                                value="{{$voucher['name']}}" {{request()?->voucher_ids == $voucher['name']?'selected':''}}>
                                {{$voucher['name']}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="select-item">
                    @php(
                        // Custom static array of voucher types
                        $voucherTypes = [
                            'simple' => 'Simple',
                            'simple x' => 'Simple X',
                            'bundle' => 'Fixed Bundle - Specific products at set price',
                            'bogo_free' => 'Buy X Get Y - Buy products get different product free',
                            'mix_match' => 'Mix & Match - Customer chooses from categories',
                        ]
                    )

                    <select name="bundle_type" class="form-control js-select2-custom set-filter"
                            data-url="{{ url()->full() }}" data-filter="bundle_type">
                        <option value="" {{ !request('bundle_type') ? 'selected' : '' }}>
                            {{ translate('Bundle Name') }}
                        </option>

                        @foreach($voucherTypes as $value => $label)
                            <option value="{{ $value }}" {{ request()?->bundle_type == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
          </form>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="product">

                <div class="col-12 mb-3">
                    <div class="row g-2">
                        @php($item = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id])->count())
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="{{ route('admin.store.view', ['store' => $store->id, 'tab' => 'item']) }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{ asset('/public/assets/admin/img/store_items/fi_9752284.png') }}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{ translate('All Voucher') }}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{ $item }}
                                    </span>
                                </div>
                            </a>
                        </div>

                        @php( $item = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'status' => 1])->count())
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="{{ route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'active-items']) }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{ asset('/public/assets/admin/img/store_items/fi_10608883.png') }}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{ translate('Active Voucher') }}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{ $item }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @php( $item = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'status' => 0])->count())
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="{{ route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'inactive-items']) }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{ asset('/public/assets/admin/img/store_items/fi_10186054.png') }}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{ translate('Inactive Voucher') }}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{ $item }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @php($item = \App\Models\TempProduct::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'is_rejected' => 0])->count())
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="{{ route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'pending-items']) }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{ asset('/public/assets/admin/img/store_items/fi_5106700.png') }}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{ translate('messages.Pending_for_Approval') }}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{ $item }}
                                    </span>
                                </div>
                            </a>
                        </div>
                        @php($item = \App\Models\TempProduct::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'is_rejected' => 1])->count())
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="{{ route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'rejected-items']) }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{ asset('/public/assets/admin/img/store_items/image 89.png') }}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{ translate('Rejected Voucher') }}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{ $item }}
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>


                <?php
                $item = match ($sub_tab) {
                    'active-items' => translate('messages.Active'),
                    'inactive-items' => translate('messages.Inactive'),
                    'pending-items' => translate('messages.Pending'),
                    'rejected-items' => translate('messages.Rejected'),
                    default => '',
                };
                ?>

                <div class="card">
                    <div class="card-header border-0 py-2">
                        <div class="search--button-wrapper">
                            <h3 class="card-title"> {{ $item ?? '' }} {{ translate('Vouchers') }} <span
                                    class="badge badge-soft-dark ml-2"><span
                                        class="total_items">{{ $foods->total() }}</span></span>
                            </h3>

                            <form class="search-form">
                                <input type="hidden" name="store_id" value="{{ $store->id }}">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" name="search" value="{{ request()?->search ?? null }}"
                                        type="search" class="form-control h--40px"
                                        placeholder="{{ translate('Search by name...') }}"
                                        aria-label="{{ translate('messages.search_here') }}">
                                    <button type="submit" class="btn btn--secondary h--40px"><i
                                            class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>

                            <!-- Unfold -->
                            <div class="hs-unfold mr-2">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                                    href="javascript:;"
                                    data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                                    <i class="tio-download-to mr-1"></i> {{ translate('messages.export') }}
                                </a>

                                <div id="usersExportDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                                    <span class="dropdown-header">{{ translate('messages.download_options') }}</span>
                                    <a id="export-excel" class="dropdown-item"
                                        href="{{ route('admin.item.store-item-export', ['type' => 'excel', 'table' => isset($sub_tab) && ($sub_tab == 'pending-items' || $sub_tab == 'rejected-items') ? 'TempProduct' : null, 'sub_tab' => $sub_tab ?? null, 'store_id' => $store->id, request()->getQueryString()]) }}">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                            alt="Image Description">
                                        {{ translate('messages.excel') }}
                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                        href="{{ route('admin.item.store-item-export', ['type' => 'csv', 'table' => isset($sub_tab) && ($sub_tab == 'pending-items' || $sub_tab == 'rejected-items') ? 'TempProduct' : null, 'sub_tab' => $sub_tab ?? null, 'store_id' => $store->id, request()->getQueryString()]) }}">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                            alt="Image Description">
                                        .{{ translate('messages.csv') }}
                                    </a>

                                </div>
                            </div>
                            <!-- End Unfold -->
                            <a href="{{ route('admin.Voucher.add-new') }}" class="btn btn--primary pull-right"><i
                                    class="tio-add-circle"></i> {{ translate('Add New Voucher') }}</a>
                        </div>
                    </div>
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                "order": [],
                                "orderCellsTop": true,
                                "paging": false
                            }'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">{{ translate('sl') }}</th>
                                    <th class="border-0">{{ translate('messages.name') }}</th>
                                    <th class="border-0">{{ translate('messages.type') }}</th>
                                    <th class="border-0">{{ translate('Segment') }}</th>
                                    <th class="border-0">{{ translate('discount') }}</th>
                                    <th class="border-0">{{ translate('Discount Type') }}</th>
                                    <th class="border-0">{{ translate('Bundle Type') }}</th>
                                    <th class="border-0">{{ translate('Voucher Name') }}</th>
                                    <th class="border-0">{{ translate('messages.price') }}</th>
                                    <th class="border-0">{{ translate('messages.status') }}</th>
                                    <th class="border-0 text-center">{{ translate('messages.action') }}</th>
                                </tr>
                            </thead>

                            <tbody id="setrows">

                                @foreach ($foods as $key => $food)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a class="media align-items-center"
                                                    href="{{ route('admin.item.view', [$food['id']]) }}">
                                                    <img class="avatar avatar-lg mr-3 onerror-image"
                                                        src="{{ $food['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg') }}"
                                                        data-onerror-image="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}"
                                                        alt="{{ $food->name }} image">

                                                    <div class="media-body">
                                                        <h5 class="text-hover-primary mb-0">
                                                            {{ Str::limit($food['name'], 20, '...') }}</h5>
                                                    </div>
                                                </a>
                                            </td>


                                             @php( $categories = \App\Models\Category::whereIn('id', json_decode($food->category_ids))->pluck('name')->toArray()  )

                                            <td>
                                                {!! implode('<br>,', $categories) !!}
                                            </td>
                                             @php( $Segment = \App\Models\Segment::whereIn('id', json_decode($food->segment_ids))->pluck('name')->toArray())
                                            <td>
                                                  {!! implode('<br>,', $Segment) !!}
                                            </td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <h5 class="text-hover-primary fw-medium mb-0">{{ $food->discount }}%
                                                        </h5>
                                                        {{-- <span data-toggle="modal" data-id="{{ $food->id }}"
                                                            data-target="#update-quantity"
                                                            class="text-primary tio-add-circle fs-22 cursor-pointer update-quantity"></span> --}}
                                                    </div>
                                                </td>
                                            <td> {{ $food->discount_type }}</td>
                                            <td> {{ $food->bundle_type }}</td>

                                            {{-- @php( $voucher = \App\Models\VoucherType::find($food->voucher_ids))
                                            <td>
                                                {{ $voucher?->name }}
                                            </td> --}}
                                             <td>
                                                {{ $food->voucher_ids ?? "" }}
                                            </td>

                                            <td> {{ $food->price }}</td>

                                            <td>
                                                <label class="toggle-switch toggle-switch-sm"
                                                    for="stocksCheckbox{{ $food->id }}">
                                                    <input type="checkbox" class="toggle-switch-input redirect-url"
                                                        data-url="{{ route('admin.item.status', [$food['id'], $food->status ? 0 : 1]) }}"
                                                        id="stocksCheckbox{{ $food->id }}"
                                                        {{ $food->status ? 'checked' : '' }}>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="btn--container justify-content-center">
                                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                                        href="{{ route('admin.item.edit', [$food['id']]) }}"
                                                        title="{{ translate('messages.edit_item') }}"><i
                                                            class="tio-edit"></i>
                                                    </a>
                                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                        href="javascript:" data-id="food-{{ $food['id'] }}"
                                                        data-message="{{ translate('messages.Want to delete this item ?') }}"
                                                        title="{{ translate('messages.delete_item') }}"><i
                                                            class="tio-delete-outlined"></i>
                                                    </a>
                                                </div>
                                                <form action="{{ route('admin.item.delete', [$food['id']]) }}"
                                                    method="post" id="food-{{ $food['id'] }}">
                                                    @csrf @method('delete')
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (count($foods) !== 0)
                        <hr>
                    @endif
                    <div class="page-area">
                        {!! $foods->links() !!}
                    </div>
                    @if (count($foods) === 0)
                        <div class="empty--data">
                            <img src="{{ asset('/public/assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                            <h5>
                                {{ translate('no_data_found') }}
                            </h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
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

                    <form action="{{ route('admin.item.stock-update') }}" method="post">
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
    <!-- Page level plugins -->
    <script>
        "use script";
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function() {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function() {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });

        });
        $('.update-quantity').on('click', function() {
            let val = $(this).data('id');
            $.get({
                url: '{{ route('admin.item.get_stock') }}',
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
