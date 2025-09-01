@extends('layouts.admin.app')
@section('title', 'Banner List')
@section('content')

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .select2-selection--single {
            height: 42px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 8px 12px !important;
            font-size: 1rem;
            background-color: #fff;
            transition: all 0.15s ease-in-out;
        }

        .select2-selection--single:focus,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
            outline: none !important;
        }

        .select2-selection__rendered {
            padding: 0 !important;
            line-height: 24px !important;
            color: #495057;
        }

        .select2-selection__placeholder {
            color: #000000 !important;
        }

        .select2-selection__arrow {
            height: 40px !important;
            right: 10px !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .select2-results__option {
            padding: 12px 16px;
            font-size: 1rem;
            transition: background-color 0.15s ease-in-out;
        }

        .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: white !important;
        }

        .select2-results__option--selected {
            background-color: #e7f3ff;
            color: #0d6efd;
            font-weight: 500;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 8px 12px;
            font-size: 1rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Success state */
        .select2-container.is-valid .select2-selection--single {
            border-color: #198754 !important;
        }

        .is-valid~.valid-feedback {
            display: block;
        }

        .valid-feedback {
            color: #198754;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/condition.png') }}" class="w--26" alt="">
                </span>
                <span>
                    Banner List
                </span>
            </h1>
        </div>
        @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.client-side.banner') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <div class="row">
                                               <div class="col-12">
                                                <div class="lang_form" id="default-form">
                                                       <div class="form-group">
                                                            <label class="input-label" for="title">App Owner Name</label>
                                                            <select name="client_id" id="client_id" class="form-control js-select2-custom">
                                                                <option disabled selected>---select App Owner Name---</option>
                                                                @foreach($clients as $client)
                                                                        <option value="{{$client['id']}}">{{$client['name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="lang_form" id="default-form">
                                                    <div class="form-group">
                                                        <label class="input-label" for="title_name"> Title
                                                        </label>
                                                        <input type="text" name="title_name"
                                                            value="{{ request('title_name') }}" id="title_name"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="lang_form" id="default-form">
                                                    <div class="form-group">
                                                        <label class="input-label" for="zone_id">{{translate('messages.zone')}}</label>
                                                        <select name="zone_id" id="zone_id" class="form-control js-select2-custom">
                                                            <option disabled selected>---{{translate('messages.select')}}---</option>
                                                            @foreach($zones as $zone)
                                                                @if(isset(auth('admin')->user()->zone_id))
                                                                    @if(auth('admin')->user()->zone_id == $zone->id)
                                                                        <option value="{{$zone->id}}" selected>{{$zone->name}}</option>
                                                                    @endif
                                                                @else
                                                                    <option value="{{$zone['id']}}">{{$zone['name']}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1">{{ translate('messages.banner_type') }}</label>
                                                    <select name="banner_type" id="banner_type" class="form-control">
                                                        <option value="store_wise"> Store </option>
                                                        <option value="voucher">Voucher</option>
                                                        <option value="category">Category</option>
                                                        <option value="voucher_type">Voucher Type</option>
                                                        <option value="external_link">External link</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="lang_form" id="default-form">
                                                        <div class="form-group">
                                                            <label class="input-label"
                                                                for="display_number"> Display Number (Banner Position Show )
                                                            </label>
                                                            <input type="Number" name="display_number" value="{{ request('display_number') }}" id="display_number" class="form-control"  >
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-12">
                                                <div class="form-group mb-0" id="store_wise">
                                                    <label class="input-label"
                                                        for="exampleFormControlSelect1">{{ translate('messages.store') }}<span
                                                            class="input-label-secondary"></span></label>
                                                    <select name="store_id" id="store_id"
                                                        class="js-data-example-ajax form-control"
                                                        title="{{ translate('messages.select_store') }}">
                                                        <option disabled selected>
                                                            ---{{ translate('messages.select_store') }}---</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group mb-0 mt-3" id="external_link">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1">External Link</label>
                                                    <select name="external_link" id="external_link"
                                                        class="form-control js-select2-custom"
                                                        placeholder="External Link">
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-12">
                                                    <div class="form-group mb-0 mt-3" id="category">
                                                        <label class="input-label"
                                                            for="exampleFormControlInput1">Category</label>
                                                        <select name="category" id="category"
                                                            class="form-control js-select2-custom">
                                                                <option disabled selected>---select App Owner Name---</option>
                                                                @foreach($category as $category_item)
                                                                        <option value="{{$category_item['id']}}">{{$category_item['name']}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                              <div class="col-12">
                                                    <div class="form-group mb-0 mt-3" id="voucher">
                                                        <label class="input-label"
                                                            for="exampleFormControlInput1">Voucher</label>
                                                        <select name="voucher" id="voucher"
                                                            class="form-control js-select2-custom">
                                                                <option disabled selected>---select Voucher---</option>
                                                                <option value="Voucher_1" >Voucher 1</option>
                                                                <option value="Voucher_2" >Voucher 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                              <div class="col-12">
                                                    <div class="form-group mb-0 mt-3" id="voucher_type">
                                                        <label class="input-label"
                                                            for="exampleFormControlInput1">Voucher Type</label>
                                                        <select name="voucher_type" id="voucher_type"
                                                            class="form-control js-select2-custom">
                                                                <option disabled selected>---select Voucher Type---</option>
                                                                <option value="Voucher_type_1" >Voucher type 1</option>
                                                                <option value="Voucher_type_2" >Voucher type 2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-12">
                                            <div class="h-100 d-flex flex-column">
                                                <label
                                                    class="mt-auto mb-0 d-block text-center">{{ translate('messages.banner_image') }}
                                                    <small class="text-danger">* ( {{ translate('messages.ratio') }} 3:1
                                                        )</small></label>
                                                <div class="text-center py-3 my-auto">
                                                    <img class="img--vertical" id="viewer"
                                                        src="{{ asset('public/assets/admin/img/900x400/img1.jpg') }}"
                                                        alt="banner image" />
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="image" id="customFileEg1"
                                                        class="custom-file-input"
                                                        accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                        required>
                                                    <label class="custom-file-label"
                                                        for="customFileEg1">{{ translate('messages.choose_file') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="btn--container justify-content-end mt-5">
                                <button type="reset" class="btn btn--reset">{{ translate('messages.reset') }}</button>
                                <button type="submit"
                                    class="btn btn--primary">{{ translate('messages.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                Banner List<span class="badge badge-soft-dark ml-2" id="itemCount"></span>
                            </h5>
                            <form class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search"
                                        name="search" class="form-control" placeholder="Ex: Banner"
                                        aria-label="Search">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            @if (request()->get('search'))
                                <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                    data-url="{{ url()->full() }}">{{ translate('messages.reset') }}</button>
                            @endif

                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th class="border-0">{{ translate('sl') }}</th>
                                    <th class="border-0">Title</th>
                                    <th class="border-0">Type</th>
                                    <th class="border-0">Display Number</th>
                                    <th class="border-0">Image</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Action</th>
                                </tr>

                            </thead>

                            <tbody id="set-rows">
                                @foreach ($Banners as $key => $Banner)
                                    <tr>
                                        {{-- Serial No --}}
                                        <td class="text-center">
                                            <span class="mr-3">
                                                {{ $key + 1 }}
                                            </span>
                                        </td>
                                        {{-- Client Email --}}
                                        <td class="text-center">
                                            <span class="bg-gradient-light text-dark">
                                                {{ $Banner->title }}
                                            </span>
                                              <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                                <img src="{{ asset($Banner->image_or_video) }}"
                                                    class="img-fluid rounded open-image-modal" alt="Client Logo"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                               </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="bg-gradient-light text-dark">
                                                {{ $Banner->type }}
                                            </span>
                                        </td>

                                        {{-- Client Created At --}}
                                        <td class="text-center">
                                            <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                                <img src="{{ asset($Banner->image) }}"
                                                    class="img-fluid rounded open-image-modal" alt="Client Logo"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            </div>
                                        </td>

                                        {{-- Status Toggle (Active/Inactive) --}}
                                        <td class="text-center">
                                            <label class="toggle-switch toggle-switch-sm"
                                                for="status-{{ $Banner->id }}">
                                                <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                                    {{ $Banner->status == '1' ? 'checked' : '' }}
                                                    data-id="status-{{ $Banner->id }}" data-type="status"
                                                    id="status-{{ $Banner->id }}">
                                                <span class="toggle-switch-label mx-auto">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="{{ route('admin.client-side.status', [$Banner->id]) }}"
                                                method="post" id="status-{{ $Banner->id }}_form">
                                                @csrf
                                            </form>
                                        </td>
                                        {{-- Action Buttons --}}
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary"
                                                    href="{{ route('admin.client-side.edit_banner', [$Banner->id]) }}"
                                                    title="Edit">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                    href="javascript:" data-id="client-{{ $Banner->id }}"
                                                    data-message="Want to delete this client ?" title="Delete">
                                                    <i class="tio-delete-outlined"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin.client-side.delete_banner', [$Banner->id]) }}"
                                                    method="post" id="client-{{ $Banner->id }}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @if (count($Banners) !== 0)
                        <hr>
                    @endif
                    <div class="page-area">
                        {!! $Banners->links() !!}
                    </div>
                    @if (count($Banners) === 0)
                        <div class="empty--data">
                            <img src="{{ asset('/public/assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                            <h5>
                                {{ translate('no_data_found') }}
                            </h5>
                        </div>
                    @endif
                </div>
            </div>

            <!-- End Table -->
        </div>
    </div>




@endsection

@push('script_2')
    <script src="{{ asset('public/assets/admin') }}/js/view-pages/banner-index.js"></script>
    <script>
        "use strict";
        var module_id = {{ Config::get('module.current_module_id') }};

        function get_items() {
            var nurl = '{{ url('/') }}/admin/item/get-items?module_id=' + module_id;

            if (!Array.isArray(zone_id)) {
                nurl += '&zone_id=' + zone_id;
            }

            $.get({
                url: nurl,
                dataType: 'json',
                success: function(data) {
                    $('#choice_item').empty().append(data.options);
                }
            });
        }

        $(document).on('ready', function() {

            module_id = {{ Config::get('module.current_module_id') }};
            get_items();

            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{ url('/') }}/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            zone_ids: [zone_id],
                            page: params.page,
                            module_id: module_id
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });

        });

        $('#banner_form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: "{{ route('admin.banner.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate('messages.banner_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href = '{{ route('admin.banner.add-new') }}';
                        }, 2000);
                    }
                }
            });
        });



        $('#reset_btn').click(function() {
            $('#module_select').val(null).trigger('change');
            $('#zone').val(null).trigger('change');
            $('#store_id').val(null).trigger('change');
            $('#choice_item').val(null).trigger('change');
            // $('#viewer').attr('src', '{{ asset('public/assets/admin/img/900x400/img1.jpg') }}');
              $('#viewer').replaceWith('<img class="img--vertical" id="viewer" src="{{ asset('public/assets/admin/img/900x400/img1.jpg') }}" alt="banner image" />');
        })

    </script>
@endpush
