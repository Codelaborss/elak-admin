@extends('layouts.admin.app')

@section('title', translate('messages.add_new_item'))
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush
  <style>
    .voucher-card.selected, .voucher-card_2.selected , .btns.selected  {
    border: 2px solid #10B981 !important;
    background-color: #f0fdf4 !important;
        }

    .range-slider {
      position: relative;
      width: 100%;
    }
    .range-slider input[type=range] {
      position: absolute;
      width: 100%;
      height: 0;
      pointer-events: none;
      -webkit-appearance: none;
      background: none;
    }
    .range-slider input[type=range]::-webkit-slider-thumb {
      pointer-events: auto;
      -webkit-appearance: none;
      height: 18px;
      width: 18px;
      border-radius: 50%;
      background: #fff;
      border: 2px solid #007bff;
      cursor: pointer;
    }
    .range-slider input[type=range]::-moz-range-thumb {
      pointer-events: auto;
      height: 18px;
      width: 18px;
      border-radius: 50%;
      background: #fff;
      border: 2px solid #007bff;
      cursor: pointer;
    }
    .range-slider .progress {
      position: absolute;
      height: 4px;
      background: #007bff;
      top: 7px;
      border-radius: 5px;
    }
  </style>
  <style>


        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .form-header h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
        }

        .form-header p {
            opacity: 0.9;
            font-size: 1.1em;
        }

        .form-container {
            background: white;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .form-section {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 1.4em;
            color: #5a67d8;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: #5a67d8;
            margin-right: 12px;
            border-radius: 2px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #5a67d8;
            box-shadow: 0 0 0 3px rgba(90, 103, 216, 0.1);
        }

        .bundle-type-description {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
            display: none;
        }

        .bundle-type-description.show {
            display: block;
        }

        .bundle-config-section {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9ff;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
        }

        .bundle-config-section.show {
            display: block;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background: #f8f9ff;
            border-radius: 6px;
            transition: background 0.2s ease;
        }

        .checkbox-item:hover {
            background: #edf2ff;
        }

        .checkbox-item input {
            margin-right: 10px;
            scale: 1.2;
        }

        .product-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fafbfc;
            transition: all 0.3s ease;
        }

        .product-card.selected {
            border-color: #5a67d8;
            background: #f0f4ff;
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 1.2em;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .product-price {
            color: #38a169;
            font-weight: 600;
            font-size: 1.1em;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #5a67d8;
            color: white;
        }

        .btn-primary:hover {
            background: #4c51bf;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #e53e3e;
            color: white;
        }

        .btn-danger:hover {
            background: #c53030;
        }

        .btn-success {
            background: #38a169;
            color: white;
            font-size: 1.1em;
            padding: 15px 30px;
        }

        .btn-success:hover {
            background: #2f855a;
            transform: translateY(-2px);
        }

        .variations-section {
            margin-top: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .variation-group {
            margin-bottom: 15px;
        }

        .variation-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: #4a5568;
        }

        .variation-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .variation-option {
            padding: 8px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }

        .variation-option:hover {
            border-color: #5a67d8;
        }

        .variation-option.selected {
            background: #5a67d8;
            color: white;
            border-color: #5a67d8;
        }

        .addons-section {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9ff;
            border-radius: 8px;
        }

        .addon-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .addon-item:last-child {
            border-bottom: none;
        }

        .price-calculator {
            /* background: #edf2ff; */
            padding: 20px;
            border-radius: 12px;
            /* margin-top: 20px; */
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .price-total {
            font-size: 1.3em;
            font-weight: bold;
            color: #38a169;
            border-top: 2px solid #38a169;
            padding-top: 10px;
        }

        .search-bar {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 25px;
            font-size: 16px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #5a67d8;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .voucher-preview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .voucher-code {
            font-family: 'Courier New', monospace;
            font-size: 1.8em;
            font-weight: bold;
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            letter-spacing: 2px;
        }

        .qr-code-placeholder {
            width: 150px;
            height: 150px;
            background: white;
            margin: 20px auto;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-weight: bold;
        }

        .voucher-details {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: left;
        }

        .voucher-details h4 {
            margin-bottom: 15px;
            color: #fff;
        }

        .voucher-details ul {
            list-style: none;
            padding: 0;
        }

        .voucher-details li {
            padding: 5px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .voucher-details li:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .checkbox-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
@section('content')

     <!-- Page Header -->

     <div class="container-fluid px-4 py-3">
      <div class="page-header d-flex flex-wrap __gap-15px justify-content-between align-items-center">
          <h1 class="page-header-title">
              <span class="page-header-icon">
                  <img src="{{ asset('public/assets/admin/img/items.png') }}" class="w--22" alt="">
              </span>
              <span>
                  {{ translate('messages.add_new_item') }}
              </span>
          </h1>
          <div class=" d-flex flex-sm-nowrap flex-wrap  align-items-end">
              <div class="text--primary-2 d-flex flex-wrap align-items-center mr-2">
                  <a href="{{ route('admin.Voucher.product_gallery') }}" class="btn btn-outline-primary btn--primary d-flex align-items-center bg-not-hover-primary-ash rounded-8 gap-2">
                      <img src="{{ asset('public/assets/admin/img/product-gallery.png') }}" class="w--22" alt="">
                      <span>{{translate('Add Info From Gallery')}}</span>
                  </a>
              </div>

              @if(Config::get('module.current_module_type') == 'food')
              <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center mb-3 foodModalShow"  type="button" >
                  <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                  <div>
                      <i class="tio-info-outined"></i>
                  </div>
              </div>
              @else
              <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center mb-3 attributeModalShow" type="button" >
                  <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                  <div>
                      <i class="tio-info-outined"></i>
                  </div>
              </div>
              @endif
          </div>
      </div>
        <div class="bg-white shadow rounded-lg p-4">
            <input type="hidden" name="hidden_value" id="hidden_value" value="1"/>
            <input type="hidden" name="hidden_bundel" id="hidden_bundel" value="simple"/>
            <input type="hidden" name="hidden_name" id="hidden_name" value="Delivery/Pickup"/>
            <div id="btn-group" class="flex items-center gap-1 bg-muted p-1 rounded-lg shadow-inner">
             <button onclick="bundle('simple')" class="border rounded p-4 text-center btns selected" data-testid="button-form-product">
            <i class="fas fa-shopping-bag mr-2"></i> Simple
            </button>

            <button onclick="bundle('bundle')" class="border rounded p-4 text-center btns" data-testid="button-form-bundle">
            <i class="fas fa-box mr-2"></i> Bundle
            </button>

            <button onclick="bundle('Flat discount')" class="border rounded p-4 text-center btns" data-testid="button-form-bundle">
            <i class="fas fa-tags mr-2"></i> Flat discount
            </button>

            <button onclick="bundle('Gift')" class="border rounded p-4 text-center btns" data-testid="button-form-bundle">
            <i class="fas fa-gift mr-2"></i> Gift
            </button>

            </div>

            <!-- Step 1: Select Voucher Type -->
            <div class="section-card rounded p-4 mb-4">
              <h2 class="fw-semibold h5 mb-4">
                <i class="fas fa-bullseye me-2"></i> Step 1: Select Voucher Type
                </h2>

                <div class="row g-3">
                @php $i = 1; @endphp
                @foreach (\App\Models\VoucherType::orderBy('name')->get() as $voucherType)
                    <div class="col-md-3">
                        <div class="voucher-card border rounded p-4 text-center h-100"
                            onclick="section_one('{{ $i }}' , '{{ $voucherType->id }}', '{{ $voucherType->name }}')"
                            data-value="{{ $voucherType->name }}">
                            <div class="display-4 mb-2">
                                <img src="{{ asset($voucherType->logo) }}" alt="{{ $voucherType->name }}" style="width: 40px;" />
                            </div>

                            <h6 class="fw-semibold">{{ $voucherType->name }}</h6>
                            <small class="text-muted">{{ $voucherType->desc }}</small>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach
                </div>
            </div>
            <!-- Step 2: Select Management Type -->
            <div class="section-card rounded p-4 mb-4" id="management_selection">
             <h2 class="fw-semibold h5 mb-4">
                <i class="fas fa-cog me-2"></i> Step 2: Select Management Type
                </h2>

                <div class="row g-3" id="append_all_data">

                </div>
            </div>
        <form action="javascript:" method="post" id="item_form" enctype="multipart/form-data">
            @csrf
            @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
            @php($language = $language->value ?? null)
            @php($defaultLang = str_replace('_', '-', app()->getLocale()))

                <!-- Basic Information one-->
                <div class="section-card rounded p-4 mb-4 d-none section3 one_four_complete" id="basic_info_main">
                    <h3 class="h5 fw-semibold mb-4"> Basic Information</h3>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                           <div class="form-group">
                                <label class="input-label"
                                    for="default_name">{{ translate('Client App Name') }}
                                </label>
                                <input type="text" name="name" id="default_name"  class="form-control" placeholder="{{ translate('Client App Name') }}" >
                            </div>
                        </div>
                           {{-- <div class="col-md-6">
                            <label class="form-label fw-medium">Client App Name</label>
                            <select
                                    name="name"
                                    id="name"
                                    class="form-control js-select2-custom "
                                    data-placeholder="-- Select Client --" multiple>
                                    <option>Select owner</option>
                                    @foreach (\App\Models\Client::all() as $item)
                                    <option value="{{ $item->id }}"
                                        @if(collect(old('name', []))->contains($item->id)) selected @endif>
                                            {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                           </div> --}}

                        <div class="col-md-6">
                            <label class="form-label fw-medium">Client  Name</label>
                            <select
                                    name="select_client"
                                    id="select_client"
                                    class="form-control Clients-select"
                                    data-placeholder="-- Select Client --">
                                    <option>Select owner</option>
                                    @foreach (\App\Models\Client::all() as $item)
                                    <option value="{{ $item->id }}"
                                        @if(collect(old('type', []))->contains($item->id)) selected @endif>
                                            {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                    <div class="valid-feedback">
                                    Great choice! Client selected successfully.
                                </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="input-label" for="segment_type">{{ translate('Segment') }}
                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                data-original-title="{{ translate('Segment') }}"></span>
                        </label>
                        <select name="segment_type[]" id="segment_type" required
                                class="form-control js-select2-custom" data-placeholder="{{ translate('Select Segment') }}" multiple>

                        </select>
                    </div>
                    {{--
                        <div class="mb-3">
                            <label class="form-label fw-medium">Short Description (Default) <span class="text-danger">*</span></label>
                        <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class=" h-100">
                                    <div class=" d-flex flex-wrap align-items-center">
                                        <div class="w-100 d-flex flex-wrap __gap-15px">
                                            <div class="flex-grow-1 mx-auto">
                                                <label class="text-dark d-block mb-4 mb-xl-5">
                                                    {{ translate('messages.item_image') }}
                                                    <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                                </label>
                                                <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba"></div>
                                            </div>
                                            <div class="flex-grow-1 mx-auto">
                                                <label class="text-dark d-block mb-4 mb-xl-5">
                                                    {{ translate('messages.item_thumbnail') }}
                                                    @if(Config::get('module.current_module_type') == 'food')
                                                    <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                                    @else
                                                    <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                                                    @endif
                                                </label>
                                                <label class="d-inline-block m-0 position-relative">
                                                    <img class="img--176 border" id="viewer" src="{{ asset('public/assets/admin/img/upload-img.png') }}" alt="thumbnail" />
                                                    <div class="icon-file-group">
                                                        <div class="icon-file"><input type="file" name="image" id="customFileEg1" class="custom-file-input d-none"
                                                        accept=".webp, .jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                                <i class="tio-edit"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                </div>
                <!-- Partner Information one-->
                <div class="section-card rounded p-4 mb-4 d-none section3 one_four_complete two_four_complete" id="store_category_main">
                    <h3 class="h5 fw-semibold mb-4"> {{ translate('Partner Information') }}</h3>
                    {{-- Store & Category Info --}}
                    <div class="col-md-12">
                        <div class="row g-2 align-items-end">
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="store_id">
                                        {{ translate('messages.store') }}
                                        <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.Required.') }}"> *
                                        </span>
                                    </label>
                                    <select name="store_id" id="store_id"
                                        data-placeholder="{{ translate('messages.select_store') }}"
                                        class="js-data-example-ajax form-control"
                                        onchange="findBranch(this.value)">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="category_id">{{ translate('messages.category') }}<span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                        </span></label>
                                    <select name="category_id" id="category_id" data-placeholder="{{ translate('messages.select_category') }}"
                                        class="js-data-example-ajax form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="sub-categories">{{ translate('messages.sub_category') }}<span
                                            class="input-label-secondary"
                                            title="{{ translate('messages.category_required_warning') }}"><img
                                                src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                alt="{{ translate('messages.category_required_warning') }}"></span></label>
                                    <select name="sub_category_id" class="js-data-example-ajax form-control" data-placeholder="{{ translate('messages.select_sub_category') }}"
                                        id="sub-categories">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="sub_branch_id">{{ translate('Branches') }}
                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('Branches') }}"></span>
                                    </label>
                                    <select name="sub_branch_id[]" id="sub-branch" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Branches') }}" multiple>
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-6 col-lg-3" id="condition_input">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="condition_id">{{ translate('messages.Suitable_For') }}<span
                                            class="input-label-secondary"></span></label>
                                    <select name="condition_id" id="condition_id"
                                        data-placeholder="{{ translate('messages.Select_Condition') }}" class="js-data-example-ajax form-control"
                                        oninvalid="this.setCustomValidity('{{ translate('messages.Select_Condition') }}')">

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3" id="brand_input">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="brand_id">{{ translate('messages.Brand') }}<span
                                            class="input-label-secondary"></span></label>
                                    <select name="brand_id" id="brand_id"
                                        data-placeholder="{{ translate('messages.Select_brand') }}" class="js-data-example-ajax form-control"
                                        oninvalid="this.setCustomValidity('{{ translate('messages.Select_brand') }}')">

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3" id="unit_input">
                                <div class="form-group mb-0">
                                    <label class="input-label text-capitalize"
                                        for="unit">{{ translate('messages.unit') }}</label>
                                    <select name="unit" id="unit" class="form-control js-select2-custom">
                                        @foreach (\App\Models\Unit::all() as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3" id="veg_input">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('messages.item_type') }} <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                        </span></label>
                                    <select name="veg" id="veg" class="form-control js-select2-custom"
                                        required>
                                        <option value="0">{{ translate('messages.non_veg') }}</option>
                                        <option value="1">{{ translate('messages.veg') }}</option>
                                    </select>
                                </div>
                            </div>
                            @if(Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food')

                                <div class="col-sm-6" id="nutrition">
                                    <label class="input-label" for="sub-categories">
                                        {{translate('Nutrition')}}
                                        <span class="input-label-secondary" title="{{ translate('Specify the necessary keywords relating to energy values for the item.') }}" data-toggle="tooltip">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <select name="nutritions[]" class="form-control multiple-select2" data-placeholder="{{ translate('messages.Type your content and press enter') }}" multiple>

                                        @foreach (\App\Models\Nutrition::select(['nutrition'])->get() as $nutrition)
                                            <option value="{{ $nutrition->nutrition }}">{{ $nutrition->nutrition }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-sm-6" id="allergy">
                                    <label class="input-label" for="sub-categories">
                                        {{translate('Allegren Ingredients')}}
                                        <span class="input-label-secondary" title="{{ translate('Specify the ingredients of the item which can make a reaction as an allergen.') }}" data-toggle="tooltip">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <select name="allergies[]" class="form-control multiple-select2" data-placeholder="{{ translate('messages.Type your content and press enter') }}" multiple>
                                        @foreach (\App\Models\Allergy::select(['allergy'])->get() as $allergy)
                                            <option value="{{ $allergy->allergy }}">{{ $allergy->allergy }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="col-sm-6 col-lg-3" id="organic">
                                <div class="form-check mb-sm-2 pb-sm-1">
                                    <input class="form-check-input" name="organic" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ translate('messages.is_organic') }}
                                    </label>
                                    </div>
                            </div>
                            <div class="col-sm-6 col-lg-3" id="basic">
                                <div class="form-check mb-sm-2 pb-sm-1">
                                    <input class="form-check-input" name="basic" type="checkbox" value="1" id="flexCheckDefaultBasic" checked>
                                    <label class="form-check-label" for="flexCheckDefaultBasic">
                                        {{ translate('messages.Is_Basic_Medicine') }}
                                    </label>
                                    </div>
                            </div>
                            @if(Config::get('module.current_module_type') == 'pharmacy')
                                <div class="col-sm-6 col-lg-3" id="is_prescription_required">
                                    <div class="form-check mb-sm-2 pb-sm-1">
                                        <input class="form-check-input" name="is_prescription_required" type="checkbox" value="1" id="flexCheckDefaultprescription" checked>
                                        <label class="form-check-label" for="flexCheckDefaultprescription">
                                            {{ translate('messages.is_prescription_required') }}
                                        </label>
                                        </div>
                                </div>
                                <div class="col-sm-6" id="generic_name">
                                    <label class="input-label" for="sub-categories">
                                        {{translate('generic_name')}}
                                        <span class="input-label-secondary" title="{{ translate('Specify the medicine`s active ingredient that makes it work') }}" data-toggle="tooltip">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="dropdown suggestion_dropdown">
                                        <input type="text" class="form-control" name="generic_name" autocomplete="off">
                                        @if(count(\App\Models\GenericName::select(['generic_name'])->get())>0)
                                        <div class="dropdown-menu">
                                            @foreach (\App\Models\GenericName::select(['generic_name'])->get() as $generic_name)
                                            <div class="dropdown-item">{{ $generic_name->generic_name }}</div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food')
                                <div class="col-sm-6 col-lg-3" id="halal">
                                    <div class="form-check mb-sm-2 pb-sm-1">
                                        <input class="form-check-input" name="is_halal" type="checkbox" value="1" id="flexCheckDefault1" checked>
                                        <label class="form-check-label" for="flexCheckDefault1">
                                            {{ translate('messages.Is_It_Halal') }}
                                        </label>
                                    </div>
                                </div>


                            @endif
                        </div>
                    </div>
                    <div class="col-md-6" id="addon_input">
                        <div class="c border-0">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <span class="card-header-icon"><i class="tio-dashboard-outlined"></i></span>
                                    <span>{{ translate('messages.addon') }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlSelect1">{{ translate('messages.addon') }}<span
                                            class="input-label-secondary"
                                            title="{{ translate('messages.addon') }}"><img
                                                src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                                alt="{{ translate('messages.store_required_warning') }}"></span></label>
                                    <select name="addon_ids[]" class="form-control js-select2-custom"
                                        multiple="multiple" id="add_on">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="time_input">
                        <div class="c border-0">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <span class="card-header-icon"><i class="tio-date-range"></i></span>
                                    <span>{{ translate('time_schedule') }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1">{{ translate('messages.available_time_starts') }}</label>
                                            <input type="time" name="available_time_starts" class="form-control"
                                                id="available_time_starts"
                                                placeholder="{{ translate('messages.Ex:') }} 10:30 am">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1">{{ translate('messages.available_time_ends') }}</label>
                                            <input type="time" name="available_time_ends" class="form-control"
                                                id="available_time_ends" placeholder="5:45 pm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== Delivery/Pickup  == Product ===================== --}}

                <!-- Voucher Details -->
                <div class="section-card rounded p-4 mb-4  d-none section" id="Product_voucher_fields_1_3">
                    <h3 class="h5 fw-semibold mb-4">Voucher Details</h3>

                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label fw-medium">Voucher Title</label>
                            <input type="text" class="form-control" placeholder="Voucher Title">
                        </div>
                    </div>

                         <div class="row g-3">
                        <div class="col-12">
                            <div class=" h-100">
                                <div class=" d-flex flex-wrap align-items-center">
                                    <div class="w-100 d-flex flex-wrap __gap-15px">
                                        <div class="flex-grow-1 mx-auto">
                                            <label class="text-dark d-block mb-4 mb-xl-5">
                                                {{ translate('messages.item_image') }}
                                                <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                            </label>
                                            <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba"></div>
                                        </div>
                                        <div class="flex-grow-1 mx-auto">
                                            <label class="text-dark d-block mb-4 mb-xl-5">
                                                {{ translate('messages.item_thumbnail') }}
                                                @if(Config::get('module.current_module_type') == 'food')
                                                <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                                @else
                                                <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                                                @endif
                                            </label>
                                            <label class="d-inline-block m-0 position-relative">
                                                <img class="img--176 border" id="viewer" src="{{ asset('public/assets/admin/img/upload-img.png') }}" alt="thumbnail" />
                                                <div class="icon-file-group">
                                                    <div class="icon-file"><input type="file" name="image" id="customFileEg1" class="custom-file-input d-none"
                                                    accept=".webp, .jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <i class="tio-edit"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-12 ">
                            <label class="form-label fw-medium">Short Description (Default) <span class="text-danger">*</span></label>
                            <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                        </div>
                    </div>

                     <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="form-group">
                                    <label class="input-label" for="food_add_one">{{ translate('Usage Limit per visit') }}
                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('Segment') }}"></span>
                                    </label>
                                    <select name="food_add_one[]" id="food_add_one" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Segment') }}" >
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="unlimited">unlimited</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Maximum Purchase Quantity Limit</label>
                            <input type="text" class="form-control" placeholder="Maximum Purchase Quantity Limit">
                        </div>
                    </div>

                       <div class="row g-3 mb-3">

                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="brand">{{ translate('Brand') }}
                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('Brand') }}"></span>
                                </label>
                                <select name="brand[]" id="brand" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Brand') }}" >
                                    @foreach (\App\Models\Brand::all() as $item)
                                    <option value="{{ $item->id }}"
                                        @if(collect(old('brand', []))->contains($item->id)) selected @endif>
                                            {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="input-label" for="Unit">{{ translate('Unit') }}
                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('Unit') }}"></span>
                                </label>
                                <select name="Unit[]" id="Unit" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Unit') }}" >
                                    @foreach (\App\Models\Unit::all() as $item)
                                    <option value="{{ $item->id }}"
                                        @if(collect(old('Unit', []))->contains($item->id)) selected @endif>
                                            {{ $item->unit }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="is-halal-food">
                            <label class="form-check-label" for="is-halal-food">Include Shipping</label>
                        </div>

                      <div class="row g-3 mb-3">
                            <h3 class="h5 fw-semibold col-12">Time Schedule</h3>
                        <div class="col-6 col-md-4">
                            <label class="form-label fw-medium">Available time starts</label>
                            <input type="time" class="form-control" >
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label fw-medium">Available time ends</label>
                            <input type="time" class="form-control" >
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label fw-medium">Valid Until</label>
                            <input type="date" class="form-control" >
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div>

                </div>
                <!--  Price Information -->
                <div class="section-card rounded p-4 mb-4 d-none section one_four_complete two_four_complete" id="product_voucher_price_info_1_3">
                    <h3 class="h5 fw-semibold mb-4">💰 {{ translate('Price Information') }}</h3>
                    {{-- Price Information --}}
                    <div class="col-md-12">
                            <div class="row g-2">
                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.price') }} <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.Required.')}}"> *
                                            </span></label>
                                        <input type="number" min="0" max="999999999999.99" step="0.01"
                                            value="1" name="price" class="form-control"
                                            placeholder="{{ translate('messages.Ex:') }} 100" required>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('Total Stock') }}
                                        </label>
                                        <input type="number" name="total_stock" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-6 col-md-3" id="stock_input">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="total_stock">{{ translate('messages.total_stock') }}</label>
                                        <input type="number" placeholder="{{ translate('messages.Ex:_10') }}" class="form-control" name="current_stock" min="0" id="quantity">
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('Offer Type') }} <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.Required.')}}"> *
                                            </span><span
                                                class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores') }}">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <select name="discount_type" id="discount_type"
                                            class="form-control js-select2-custom">
                                            <option value="percent">{{ translate('Direct discount') }}</option>
                                            <option value="cash back">{{ translate('Cash Back') }} </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="discount_type">{{ translate('messages.discount_type') }}
                                            <span class="form-label-secondary text-danger"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="{{ translate('messages.Required.')}}"> *
                                            </span>
                                            <span class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores') }}">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>

                                        <!-- Dropdown: Only Percent & Fixed -->
                                        <select name="discount_type" id="discount_type"
                                            class="form-control js-select2-custom">
                                            <option value="percent">{{ translate('messages.percent') }} (%)</option>
                                            <option value="fixed">{{ translate('Fixed') }} ({{ \App\CentralLogics\Helpers::currency_symbol() }})</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('discount Value') }}
                                            <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.Required.')}}"> *
                                            </span></label>
                                        <input type="number" min="0" max="9999999999999999999999" value="0"
                                            name="discount" class="form-control"
                                            placeholder="{{ translate('messages.Ex:') }} 100">
                                    </div>
                                </div>
                                <!-- Attributes same-->
                                <div class="col-12">
                                    <div class=" section " id="attributes">
                                        <h3 class="h5 fw-semibold mb-4">🏷️ {{ translate('attribute') }}</h3>
                                        <div class="row g-2">
                                            <div class="col-md-12" id="attribute_section">
                                                    <div class=" pb-0">
                                                        <div class="row g-2">
                                                            <div class="col-12">
                                                                <div class="form-group mb-0">
                                                                    <label class="input-label"
                                                                        for="exampleFormControlSelect1">{{ translate('messages.attribute') }}<span
                                                                            class="input-label-secondary"></span></label>
                                                                    <select name="attribute_id[]" id="choice_attributes"
                                                                        class="form-control js-select2-custom" multiple="multiple">
                                                                        @foreach (\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                                                            <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <div class="customer_choice_options d-flex __gap-24px"
                                                                    id="customer_choice_options">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="variant_combination" id="variant_combination">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>

                {{-- ==================== Delivery/Pickup  == Product ===================== --}}

                {{-- ==================== Delivery/Pickup  == Food ===================== --}}

                 <!-- Voucher Details -->
                <div class="section-card rounded p-4 mb-4 d-none section" id="food_voucher_fields_1_4">
                    <h3 class="h5 fw-semibold mb-4">Voucher Details</h3>
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label fw-medium">Voucher Title</label>
                            <input type="text" class="form-control" placeholder="Voucher Title">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class=" h-100">
                                <div class=" d-flex flex-wrap align-items-center">
                                    <div class="w-100 d-flex flex-wrap __gap-15px">
                                        <div class="flex-grow-1 mx-auto">
                                            <label class="text-dark d-block mb-4 mb-xl-5">
                                                {{ translate('messages.item_image') }}
                                                <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                            </label>
                                            <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba"></div>
                                        </div>
                                        <div class="flex-grow-1 mx-auto">
                                            <label class="text-dark d-block mb-4 mb-xl-5">
                                                {{ translate('messages.item_thumbnail') }}
                                                @if(Config::get('module.current_module_type') == 'food')
                                                <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                                @else
                                                <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                                                @endif
                                            </label>
                                            <label class="d-inline-block m-0 position-relative">
                                                <img class="img--176 border" id="viewer" src="{{ asset('public/assets/admin/img/upload-img.png') }}" alt="thumbnail" />
                                                <div class="icon-file-group">
                                                    <div class="icon-file"><input type="file" name="image" id="customFileEg1" class="custom-file-input d-none"
                                                    accept=".webp, .jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <i class="tio-edit"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-12 ">
                            <label class="form-label fw-medium">Short Description (Default) <span class="text-danger">*</span></label>
                            <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="input-label" for="food_add_one">{{ translate('Food Add One') }}
                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                    data-original-title="{{ translate('Segment') }}"></span>
                            </label>
                            <select name="food_add_one[]" id="food_add_one" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Segment') }}" multiple>
                                @foreach (\App\Models\Item::whereNull('voucher_type')->get() as $item)
                                <option value="{{ $item->id }}"
                                    @if(collect(old('food_add_one', []))->contains($item->id)) selected @endif>
                                        {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="is-halal-food">
                        <label class="form-check-label" for="is-halal-food">Is It Halal</label>
                    </div>
                </div>
                <!--  Price Information one-->
                <div class="section-card rounded p-4 mb-4 d-none section one_four_complete two_four_complete" id="food_voucher_price_info_1_4">
                    <h3 class="h5 fw-semibold mb-4">💰 {{ translate('Price Information') }}</h3>
                    {{-- Price Information --}}
                    <div class="col-md-12">
                        <div class="row g-2">
                            <div class="col-sm-{{ Config::get('module.current_module_type') == 'food' ? '4' :'3' }} col-6">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('messages.price') }} <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                        </span></label>
                                    <input type="number" min="0" max="999999999999.99" step="0.01"
                                        value="1" name="price" class="form-control"
                                        placeholder="{{ translate('messages.Ex:') }} 100" required>
                                </div>
                            </div>
                            <div class="col-sm-{{ Config::get('module.current_module_type') == 'food' ? '4' :'3' }} col-6" id="stock_input">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="total_stock">{{ translate('messages.total_stock') }}</label>
                                    <input type="number" placeholder="{{ translate('messages.Ex:_10') }}" class="form-control" name="current_stock" min="0" id="quantity">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="discount_type">{{ translate('messages.discount_type') }}
                                        <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.Required.')}}"> *
                                        </span>
                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="{{ translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>

                                    <!-- Dropdown: Only Percent & Fixed -->
                                    <select name="discount_type" id="discount_type"
                                        class="form-control js-select2-custom">
                                        <option value="percent">{{ translate('messages.percent') }} (%)</option>
                                        <option value="fixed">{{ translate('Fixed') }} ({{ \App\CentralLogics\Helpers::currency_symbol() }})</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Separate Switch Button for Cash Back -->
                            <div class="col-6 col-md-2">
                                <div class="form-group mb-0">
                                    <label class="input-label">{{ translate('Cash Back') }}</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="cash_back" class="custom-control-input" id="cash_back_switch">
                                        <label class="custom-control-label" for="cash_back_switch"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount') }}
                                        <span id=symble> (%) </span>
                                            <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="{{ translate('messages.Required.')}}"> *
                                            </span></label>
                                        <input type="number" min="0" max="9999999999999999999999" value="0"
                                            name="discount" class="form-control"
                                            placeholder="{{ translate('messages.Ex:') }} 100">
                                    </div>
                                </div>
                                <div class="col-6 col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('Valid Until') }}
                                        </label>
                                        <input type="date" name="valid_date" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <!-- Single slider example -->
                                    <div class="form-group">
                                    <label>Usage Limit per User: <span id="usageValue">20</span></label>
                                    <input type="range" class="custom-range" id="usageRange" min="0" max="100" value="20">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                    <label>Maximum Purchase Limit: <span id="maxValue">50</span></label>
                                    <input type="range" class="custom-range" id="maxRange" min="0" max="100" value="50">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                        <div class="form-group">
                                    <label>Current Stock Qty</label>
                                    <input type="text" class="form-control" value="795">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                    <label id="orderRangeLabel">Order Range: 31 - 100</label>
                                    <div class="position-relative w-100">
                                        <div id="progressBar"
                                            style="position:absolute; height:5px; background:#065c5c; top:50%; transform:translateY(-50%); border-radius:5px;">
                                        </div>
                                        <input type="range" class="custom-range" id="minRange" min="0" max="100" value="31" style="position:relative; z-index:2;">
                                        <input type="range" class="custom-range" id="maxRangex" min="0" max="100" value="100" style="position:relative; z-index:2;">
                                    </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                        <div class="form-group">
                                    <label>Time Schedule</label>
                                    <input type="datetime-local" class="form-control" value="795">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="form-check-input" type="checkbox" id="include_shipping">
                                    <label class="form-check-label" for="include_shipping">Include Shipping</label>
                                </div>

                                {{-- <div class="col-lg-12" id="food_variation_section"> --}}
                                <div class="col-lg-12" >
                                        <div class="card shadow--card-2 border-0">
                                            <div class="card-header flex-wrap">
                                                <h5 class="card-title">
                                                    <span class="card-header-icon mr-2">
                                                        <i class="tio-canvas-text"></i>
                                                    </span>
                                                    <span>{{ translate('messages.food_variations') }}</span>
                                                </h5>
                                                <a class="btn text--primary-2" id="add_new_option_button">
                                                    {{ translate('add_new_variation') }}
                                                    <i class="tio-add"></i>
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <!-- Empty Variation -->
                                                <div id="empty-variation">
                                                    <div class="text-center">
                                                        <img src="{{asset('/public/assets/admin/img/variation.png')}}" alt="">
                                                        <div>{{translate('No variation added')}}</div>
                                                    </div>
                                                </div>
                                                <div id="add_new_option">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
               {{-- ==================== Delivery/Pickup  == Food ===================== --}}


               {{-- ====================   Bundle Delivery/Pickup  == Food and Product Bundle ===================== --}}

                 <!-- Voucher Details -->
                <div class="section-card rounded p-4 mb-4 d-none section" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4">Voucher Details</h3>
                    {{-- Voucher Title --}}
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Voucher Title</label>
                            <input type="text" class="form-control" placeholder="Voucher Title">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Valid Until</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    {{-- images  --}}
                    <div class="row g-3">
                        <div class="col-12">
                            <div class=" h-100">
                                <div class=" d-flex flex-wrap align-items-center">
                                    <div class="w-100 d-flex flex-wrap __gap-15px">
                                        <div class="flex-grow-1 mx-auto">
                                            <label class="text-dark d-block mb-4 mb-xl-5">
                                                {{ translate('messages.item_image') }}
                                                <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                            </label>
                                            <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba"></div>
                                        </div>
                                        <div class="flex-grow-1 mx-auto">
                                            <label class="text-dark d-block mb-4 mb-xl-5">
                                                {{ translate('messages.item_thumbnail') }}
                                                @if(Config::get('module.current_module_type') == 'food')
                                                <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                                                @else
                                                <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                                                @endif
                                            </label>
                                            <label class="d-inline-block m-0 position-relative">
                                                <img class="img--176 border" id="viewer" src="{{ asset('public/assets/admin/img/upload-img.png') }}" alt="thumbnail" />
                                                <div class="icon-file-group">
                                                    <div class="icon-file"><input type="file" name="image" id="customFileEg1" class="custom-file-input d-none"
                                                    accept=".webp, .jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <i class="tio-edit"></i>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-12 ">
                            <label class="form-label fw-medium">Short Description (Default) <span class="text-danger">*</span></label>
                            <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                        </div>
                    </div>
                    {{-- Bundle Type Selection --}}
                    <div class="col-12 col-md-12">
                        <div class="form-group mb-0">
                            <h3 class="h5 fw-semibold mb-2">🎯 {{ translate('Bundle Type Selection') }}</h3>
                            <select name="bundle_offer_type" id="bundle_offer_type" class="form-control">
                            <option value="">Select Bundle Offer Type</option>
                            <option value="bogo_free">🔄 BOGO Free - Buy one get one free</option>
                            <option value="buy_x_get_y">🎁 Buy X Get Y - Free</option>
                            <option value="gift">💝 Free Gift with Purchase</option>
                            <option value="bundle">📦 Group Product Bundle</option>
                            <option value="mix_match">🔀 Mix & Match - Collect</option>
                            </select>
                        </div>
                    </div>
                    {{-- panel1 --}}
                    <div class="col-12 mt-5" id="panel1">
                        <div class="row g-3 bogo_free_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                    <div id="descriptionContent">
                                    <h4>📝 BOGO FREE</h4>
                                    <p><strong>Description:</strong> Buy one product, get another product completely free. Customer pays for the higher-priced item.</p>
                                    <p><strong>Example:</strong> Buy Large Pizza ($15), get Medium Pizza free (save $12)</p>
                                    <p><strong>Pricing Method:</strong> pay higher price</p>
                                </div>
                                </div>
                                <div id="bundleConfigSection" class="bundle-config-section show mt-4">
                                    <div id="configContent"><h4>⚙️ Bundle Configuration</h4>
                                        <div class="form-group">
                                            <p><strong>Instructions:</strong> Add products to bundle. First product will be "paid item", second will be "free item". Customer pays for higher-priced item.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body ">

                                    <!-- BOGO Configuration -->
                                    <div class="p-3 bg-white border rounded mb-4">
                                        <h4 class="mb-3">🔄 BOGO Configuration</h4>

                                        <!-- BOGO Product -->
                                        <div class="mb-3">
                                        <label class="form-label">BOGO Product</label>
                                        <div class="mb-2 d-flex flex-wrap gap-2">
                                            <!-- Dynamic product tags will appear here -->
                                        </div>
                                        <div class="input-group">
                                            <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Add products for BOGO offer..."
                                            data-testid="input-tag"
                                            >
                                            <button
                                            class="btn btn-primary"
                                            type="button"
                                            data-testid="button-add-tag"
                                            disabled
                                            >
                                            <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        </div>

                                        <!-- Buy & Get Quantity -->
                                        <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Buy Quantity</label>
                                            <input
                                            type="number"
                                            class="form-control"
                                            placeholder="1"
                                            value="1"
                                            data-testid="input-buy-quantity"
                                            >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Get Quantity</label>
                                            <input
                                            type="number"
                                            class="form-control"
                                            placeholder="1"
                                            value="1"
                                            data-testid="input-get-quantity"
                                            >
                                        </div>
                                        </div>
                                    </div>

                                    <!-- Valid Until -->
                                    <div class="mb-3">
                                        <label class="form-label" for="validUntilDate">Valid Until</label>
                                        <input
                                        type="date"
                                        class="form-control"
                                        id="validUntilDate"
                                        placeholder="mm/dd/yyyy"
                                        data-testid="input-bundle-valid-until"
                                        >
                                    </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row g-3 buy_x_get_y_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                <h4>📝 BUY X GET Y</h4>
                                <p><strong>Description:</strong> Buy specific products and get different products free or discounted.</p>
                                <p><strong>Example:</strong> Buy any Main Course, get free Drink or Dessert</p>
                                <p><strong>Pricing Method:</strong> conditional free</p>
                            </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show mt-4">
                                <div id="configContent"><h4>⚙️ Bundle Configuration</h4>
                                    <div class="form-group">
                                        <p><strong>Instructions:</strong> Add products customers must buy first, then add products they get free. Configure roles appropriately.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body ">
                                <!-- Buy X Get Y Configuration -->
                                <div class="p-3 bg-white border rounded mb-4">
                                    <h4 class="mb-3">🎁 Buy X Get Y Configuration</h4>

                                    <!-- Buy Products -->
                                    <div class="mb-3">
                                    <label class="form-label">Buy These Products</label>
                                    <div class="mb-2 d-flex flex-wrap gap-2">
                                        <!-- Added product tags dynamically -->
                                    </div>
                                    <div class="input-group">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Add products to purchase..."
                                        data-testid="input-tag"
                                        >
                                        <button
                                        class="btn btn-primary"
                                        type="button"
                                        data-testid="button-add-tag"
                                        disabled
                                        >
                                        <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    </div>

                                    <!-- Buy Qty / Get Qty / Max Uses -->
                                    <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Buy Quantity</label>
                                        <input
                                        type="number"
                                        class="form-control"
                                        placeholder="2"
                                        value="1"
                                        data-testid="input-buy-x-quantity"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Get Quantity</label>
                                        <input
                                        type="number"
                                        class="form-control"
                                        placeholder="1"
                                        value="1"
                                        data-testid="input-get-y-quantity"
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Max Uses</label>
                                        <input
                                        type="number"
                                        class="form-control"
                                        placeholder="5"
                                        value="1"
                                        data-testid="input-max-uses"
                                        >
                                    </div>
                                    </div>

                                    <!-- Free Product -->
                                    <div class="mb-3">
                                    <label class="form-label">Free Product</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Product that will be given for free"
                                        data-testid="input-free-product"
                                    >
                                    </div>
                                </div>

                                <!-- Valid Until -->
                                <div class="mb-3">
                                    <label class="form-label" for="validUntilDate">Valid Until</label>
                                    <input
                                    type="date"
                                    class="form-control"
                                    id="validUntilDate"
                                    placeholder="mm/dd/yyyy"
                                    data-testid="input-bundle-valid-until"
                                    >
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 gift_div" style="display:none;">
                             <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                <h4>Free Gift with Purchase</h4>
                                <p><strong>Description:</strong> Customer chooses specific number of items from different categories for a bundle price.</p>
                                <p><strong>Example:</strong> Choose 3 from Snacks + 2 from Drinks = $20</p>
                                <p><strong>Pricing Method:</strong> fixed bundle price</p>
                                </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show mt-4">
                                <div id="configContent"><h4>⚙️ Bundle Configuration</h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Total Items Customer Must Choose</label>
                                            <input type="number" id="totalItemsToChoose" class="form-control" min="2" value="5">
                                        </div>
                                        <div class="form-group">
                                            <label>Bundle Price</label>
                                            <input type="number" id="mixMatchPrice" class="form-control" step="0.01" placeholder="Total price for selection">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body ">
                                <!-- Free Gift Configuration -->
                                <div class="p-3 bg-white border rounded mb-4">
                                    <h4 class="mb-3">💝 Free Gift Configuration</h4>

                                    <!-- Min Spend + Free Gift Product -->
                                    <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Minimum Spend Amount</label>
                                        <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            placeholder="50.00"
                                            value="0"
                                            data-testid="input-minimum-spend"
                                        >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Free Gift Product</label>
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Gift product name"
                                        data-testid="input-gift-product"
                                        >
                                    </div>
                                    </div>

                                    <!-- Qualifying Products -->
                                    <div class="mb-3">
                                    <label class="form-label">Qualifying Products</label>
                                    <div class="mb-2 d-flex flex-wrap gap-2">
                                        <!-- Product tags dynamically show here -->
                                    </div>
                                    <div class="input-group">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Add products that qualify for free gift..."
                                        data-testid="input-tag"
                                        >
                                        <button
                                        class="btn btn-primary"
                                        type="button"
                                        data-testid="button-add-tag"
                                        disabled
                                        >
                                        <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    </div>
                                </div>

                                <!-- Valid Until -->
                                <div class="mb-3">
                                    <label class="form-label" for="validUntilDate">Valid Until</label>
                                    <input
                                    type="date"
                                    class="form-control"
                                    id="validUntilDate"
                                    placeholder="mm/dd/yyyy"
                                    data-testid="input-bundle-valid-until"
                                    >
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 bundle_div" style="display:none;">
                              <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                <h4>📦 Group Product Bundle</h4>
                                <p><strong>Description:</strong> Customer chooses specific number of items from different categories for a bundle price.</p>
                                <p><strong>Example:</strong> Choose 3 from Snacks + 2 from Drinks = $20</p>
                                <p><strong>Pricing Method:</strong> fixed bundle price</p>
                                </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show mt-4">
                                <div id="configContent"><h4>⚙️ Bundle Configuration</h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Total Items Customer Must Choose</label>
                                            <input type="number" id="totalItemsToChoose" class="form-control" min="2" value="5">
                                        </div>
                                        <div class="form-group">
                                            <label>Bundle Price</label>
                                            <input type="number" id="mixMatchPrice" class="form-control" step="0.01" placeholder="Total price for selection">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body ">
                                <!-- Group Product Bundle Configuration -->
                                <div class="p-3 bg-white border rounded mb-4">
                                    <h4 class="mb-3">📦 Group Product Bundle</h4>

                                    <!-- Bundle Products -->
                                    <div class="mb-3">
                                    <label class="form-label">Bundle Products</label>
                                    <div class="mb-2 d-flex flex-wrap gap-2">
                                        <!-- Added products will appear here -->
                                    </div>
                                    <div class="input-group">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Add products to the bundle..."
                                        data-testid="input-tag"
                                        >
                                        <button
                                        class="btn btn-primary"
                                        type="button"
                                        data-testid="button-add-tag"
                                        disabled
                                        >
                                        <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    </div>

                                    <!-- Discount Type + Discount Amount -->
                                    <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Bundle Discount Type</label>
                                        <select class="form-select" data-testid="select-bundle-discount-type">
                                        <option>% Percentage Off</option>
                                        <option>$ Fixed Amount Off</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Discount Amount</label>
                                        <input
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                        placeholder="10"
                                        data-testid="input-bundle-discount"
                                        value="0"
                                        >
                                    </div>
                                    </div>
                                </div>

                                <!-- Valid Until -->
                                <div class="mb-3">
                                    <label class="form-label" for="validUntilDate">Valid Until</label>
                                    <input
                                    type="date"
                                    class="form-control"
                                    id="validUntilDate"
                                    placeholder="mm/dd/yyyy"
                                    data-testid="input-bundle-valid-until"
                                    >
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mix_match_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                <h4>📝 MIX MATCH</h4>
                                <p><strong>Description:</strong> Customer chooses specific number of items from different categories for a bundle price.</p>
                                <p><strong>Example:</strong> Choose 3 from Snacks + 2 from Drinks = $20</p>
                                <p><strong>Pricing Method:</strong> fixed bundle price</p>
                                </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show mt-4">
                                <div id="configContent"><h4>⚙️ Bundle Configuration</h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Total Items Customer Must Choose</label>
                                            <input type="number" id="totalItemsToChoose" class="form-control" min="2" value="5">
                                        </div>
                                        <div class="form-group">
                                            <label>Bundle Price</label>
                                            <input type="number" id="mixMatchPrice" class="form-control" step="0.01" placeholder="Total price for selection">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body ">
                                    <!-- Mix and Match Collection -->
                                    <div class="p-3 bg-white border rounded mb-4">
                                        <h4 class="mb-3">🔀 Mix and Match Collection</h4>

                                        <!-- Collection Category -->
                                        <div class="mb-3">
                                        <label class="form-label">Collection Category</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="e.g., T-Shirts, Accessories, etc."
                                            data-testid="input-mix-match-category"
                                        >
                                        </div>

                                        <!-- Available Products -->
                                        <div class="mb-3">
                                        <label class="form-label">Available Products</label>
                                        <div class="mb-2 d-flex flex-wrap gap-2">
                                            <!-- Dynamic product tags will appear here -->
                                        </div>
                                        <div class="input-group">
                                            <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Add products available for mix and match..."
                                            data-testid="input-tag"
                                            >
                                            <button
                                            class="btn btn-primary"
                                            type="button"
                                            data-testid="button-add-tag"
                                            disabled
                                            >
                                            <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        </div>

                                        <!-- 3-column grid -->
                                        <div class="row g-3">
                                            <!-- Buy Quantity -->
                                            <div class="col-md-4">
                                                <label class="form-label">Buy Quantity</label>
                                                <input
                                                type="number"
                                                class="form-control"
                                                placeholder="3"
                                                value="1"
                                                data-testid="input-mix-match-quantity"
                                                >
                                            </div>

                                            <!-- Discount Amount -->
                                            <div class="col-md-4">
                                                <label class="form-label">Discount Amount</label>
                                                <input
                                                type="number"
                                                step="0.01"
                                                class="form-control"
                                                placeholder="5.00"
                                                value="0"
                                                data-testid="input-mix-match-discount"
                                                >
                                            </div>

                                            <!-- Max Uses Per Customer -->
                                            <div class="col-md-4">
                                                <label class="form-label">Max Uses Per Customer</label>
                                                <input
                                                type="number"
                                                class="form-control"
                                                placeholder="2"
                                                value="1"
                                                data-testid="input-mix-match-max-uses"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Valid Until -->
                                    <div class="mb-3">
                                        <label class="form-label" for="validUntilDate">Valid Until</label>
                                        <input
                                        type="date"
                                        class="form-control"
                                        id="validUntilDate"
                                        placeholder="mm/dd/yyyy"
                                        data-testid="input-bundle-valid-until"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- tags --}}
                     <div class="col-12 mt-3">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div>
                </div>
                <!--  Price Information one-->
                <div class="section-card rounded p-4 mb-4 d-none section one_four_complete two_four_complete"id="bundel_food_voucher_price_info_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4">💰 {{ translate('Price Information') }}</h3>
                    {{-- Price Information --}}
                    <div class="col-md-12">
                        <div class="row g-2">
                            <div class="col-6 col-md-3">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('messages.price') }} <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                        </span></label>
                                    <input type="number" min="0" max="999999999999.99" step="0.01"
                                        value="1" name="price" class="form-control"
                                        placeholder="{{ translate('messages.Ex:') }} 100" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="offer_type">{{ translate('Offer Type') }}
                                    </label>

                                    <!-- Dropdown: Only Percent & Fixed -->
                                    <select name="offer_type" id="offer_type"
                                        class="form-control js-select2-custom">
                                        <option value="direct discount">{{ translate('Direct Discount') }} </option>
                                        <option value="cash back">{{ translate('Cash back') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="discount_type">{{ translate('Discount Type') }}
                                    </label>

                                    <!-- Dropdown: Only Percent & Fixed -->
                                    <select name="discount_type" id="discount_type"
                                        class="form-control js-select2-custom">
                                        <option value="percent">{{ translate('messages.percent') }} (%)</option>
                                        <option value="fixed">{{ translate('Fixed') }} ({{ \App\CentralLogics\Helpers::currency_symbol() }})</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('Discount Value') }}
                                    </label>
                                        <input type="number" min="0" max="9999999999999999999999" value="0"
                                            name="discount" class="form-control"
                                            placeholder="{{ translate('messages.Ex:') }} 100">
                                    </div>
                                </div>
                            </div>
                            <!-- Example divs to show/hide panel2 -->
                            <div class="col-12">
                                <div class="row g-3 bogo_free_div" style="display:none;">
                                    <div class="container ">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body ">
                                            <h4 class="card-title mb-4">📦 Bundle Pricing Configuration</h4>

                                            <!-- BOGO Section -->
                                            <div class="mb-4">
                                                <h5 class="text-muted mb-3">🔄 BOGO Pricing Settings</h5>

                                                <div class="p-3 bg-white border rounded">
                                                <p class="small text-muted mb-3">
                                                    For BOGO offers, set the regular price for one item.
                                                    The system will automatically apply the free item.
                                                </p>

                                                <!-- Grid System -->
                                                <div class="row g-3">
                                                    <!-- Regular Item Price -->
                                                    <div class="col-md-6">
                                                    <label class="form-label">Regular Item Price</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="29.99"
                                                        step="0.01"
                                                        data-testid="input-bogo-price"
                                                        >
                                                    </div>
                                                    </div>

                                                    <!-- Total Available Sets -->
                                                    <div class="col-md-6">
                                                    <label class="form-label">Total Available Sets</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="50"
                                                        data-testid="input-bogo-stock"
                                                    >
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- /BOGO Section -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 buy_x_get_y_div" style="display:none;">
                                    <div class="container my-4">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body ">
                                            <h4 class="card-title mb-4">📦 Bundle Pricing Configuration</h4>

                                            <!-- Buy X Get Y Section -->
                                            <div class="mb-4">
                                                <h5 class="text-muted mb-3">🎁 Buy X Get Y Pricing</h5>

                                                <div class="p-3 bg-white border rounded">
                                                <!-- Grid System -->
                                                <div class="row g-3">
                                                    <!-- Price per Item (Buy) -->
                                                    <div class="col-md-4">
                                                    <label class="form-label">Price per Item (Buy)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="15.99"
                                                        step="0.01"
                                                        data-testid="input-buy-x-price"
                                                        >
                                                    </div>
                                                    </div>

                                                    <!-- Free Item Value -->
                                                    <div class="col-md-4">
                                                    <label class="form-label">Free Item Value</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="9.99"
                                                        step="0.01"
                                                        data-testid="input-free-item-value"
                                                        >
                                                    </div>
                                                    </div>

                                                    <!-- Available Offers -->
                                                    <div class="col-md-4">
                                                    <label class="form-label">Available Offers</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        placeholder="100"
                                                        data-testid="input-buy-x-get-y-stock"
                                                    >
                                                    </div>
                                                </div>

                                                <!-- Deal Summary -->
                                                <div class="mt-4 p-3 bg-light border rounded">
                                                    <p class="small fw-bold mb-1">💰 Deal Summary:</p>
                                                    <p class="small text-muted mb-1">
                                                    Please enter a valid price for Buy X Get Y offer
                                                    </p>
                                                    <p class="small mb-0">
                                                    Total Value: <span class="fw-semibold">$</span> |
                                                    Customer Pays: <span class="fw-semibold">$0.00</span> |
                                                    Savings: <span class="fw-semibold text-success">$0.00</span>
                                                    </p>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- /Buy X Get Y Section -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row g-3 gift_div" style="display:none;">
                                <div class="container my-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body ">
                                        <h4 class="card-title mb-4">📦 Bundle Pricing Configuration</h4>

                                        <!-- Free Gift Section -->
                                        <div class="mb-4">
                                            <h5 class="text-muted mb-3">💝 Free Gift Pricing</h5>

                                            <div class="p-3 bg-white border rounded">
                                            <!-- Grid System -->
                                            <div class="row g-3">
                                                <!-- Minimum Spend Required -->
                                                <div class="col-md-4">
                                                <label class="form-label">Minimum Spend Required</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="50.00"
                                                    step="0.01"
                                                    data-testid="input-min-spend-amount"
                                                    >
                                                </div>
                                                </div>

                                                <!-- Free Gift Value -->
                                                <div class="col-md-4">
                                                <label class="form-label">Free Gift Value</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="12.99"
                                                    step="0.01"
                                                    data-testid="input-gift-value"
                                                    >
                                                </div>
                                                </div>

                                                <!-- Available Gifts -->
                                                <div class="col-md-4">
                                                <label class="form-label">Available Gifts</label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="200"
                                                    data-testid="input-gift-stock"
                                                >
                                                </div>
                                            </div>

                                            <!-- Deal Summary -->
                                            <div class="mt-4 p-3 bg-light border rounded">
                                                <p class="small fw-bold mb-1">💰 Deal Summary:</p>
                                                <p class="small text-muted mb-1">
                                                Spend $0.00 get free gift worth $0.00
                                                </p>
                                                <p class="small mb-0">
                                                Total Value: <span class="fw-semibold">$0.00</span> |
                                                Free Gift Worth: <span class="fw-semibold text-success">$0.00</span>
                                                </p>
                                            </div>
                                            </div>
                                        </div>
                                        <!-- /Free Gift Section -->

                                        </div>
                                    </div>
                                </div>

                                </div>
                                <div class="row g-3 bundle_div" style="display:none;">
                                <div class="container my-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body ">
                                        <h4 class="card-title mb-4">📦 Bundle Pricing Configuration</h4>

                                        <!-- Group Product Bundle Section -->
                                        <div class="mb-4">
                                            <h5 class="text-muted mb-3">📦 Group Product Bundle Pricing</h5>

                                            <div class="p-3 bg-white border rounded">
                                            <!-- Grid System -->
                                            <div class="row g-3">
                                                <!-- Individual Items Total -->
                                                <div class="col-md-6">
                                                <label class="form-label">Individual Items Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="79.99"
                                                    step="0.01"
                                                    data-testid="input-bundle-total-price"
                                                    >
                                                </div>
                                                </div>

                                                <!-- Bundle Discount (%) -->
                                                <div class="col-md-6">
                                                <label class="form-label">Bundle Discount (%)</label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="15"
                                                    step="1"
                                                    data-testid="input-group-bundle-discount"
                                                >
                                                </div>
                                            </div>

                                            <!-- Bundle Summary -->
                                            <div class="mt-4 p-3 bg-light border rounded">
                                                <p class="small fw-bold mb-1">💰 Bundle Summary:</p>
                                                <p class="small text-muted mb-1">
                                                Please enter a valid total price for group bundle
                                                </p>
                                                <p class="small mb-0">
                                                Individual Total: <span class="fw-semibold">$</span> |
                                                Bundle Price: <span class="fw-semibold text-primary">$0.00</span> |
                                                You Save: <span class="fw-semibold text-success">$0.00</span>
                                                </p>
                                            </div>

                                            <!-- Available Bundles -->
                                            <div class="mt-4">
                                                <label class="form-label">Available Bundles</label>
                                                <input
                                                type="number"
                                                class="form-control"
                                                placeholder="25"
                                                data-testid="input-bundle-quantity"
                                                >
                                            </div>
                                            </div>
                                        </div>
                                        <!-- /Group Product Bundle Section -->

                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row g-3 mix_match_div" style="display:none;">

                                <div class="container my-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body ">
                                        <h4 class="card-title mb-4">📦 Bundle Pricing Configuration</h4>

                                        <!-- Mix & Match Section -->
                                        <div class="mb-4">
                                            <h5 class="text-muted mb-3">🔀 Mix and Match Pricing</h5>

                                            <div class="p-3 bg-white border rounded">
                                            <!-- Grid System -->
                                            <div class="row g-3">
                                                <!-- Regular Price Each -->
                                                <div class="col-md-4">
                                                <label class="form-label">Regular Price Each</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="24.99"
                                                    step="0.01"
                                                    data-testid="input-mix-match-regular-price"
                                                    >
                                                </div>
                                                </div>

                                                <!-- Mix & Match Discount -->
                                                <div class="col-md-4">
                                                <label class="form-label">Mix &amp; Match Discount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="5.00"
                                                    step="0.01"
                                                    data-testid="input-mix-match-discount"
                                                    >
                                                </div>
                                                </div>

                                                <!-- Required Quantity -->
                                                <div class="col-md-4">
                                                <label class="form-label">Required Quantity</label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="3"
                                                    data-testid="input-mix-match-quantity"
                                                >
                                                </div>
                                            </div>

                                            <!-- Mix & Match Summary -->
                                            <div class="mt-4 p-3 bg-light border rounded">
                                                <p class="small fw-bold mb-1">💰 Mix & Match Summary:</p>
                                                <p class="small text-muted mb-1">
                                                Please enter a valid price per item for mix &amp; match
                                                </p>
                                                <p class="small mb-0">
                                                Regular Price (1 items): <span class="fw-semibold">$</span> |
                                                Mix &amp; Match Price: <span class="fw-semibold text-primary">$0.00</span> |
                                                You Save: <span class="fw-semibold text-success">$0.00</span>
                                                </p>
                                            </div>
                                            </div>
                                        </div>
                                        <!-- /Mix & Match Section -->

                                        </div>
                                    </div>
                                    </div>



                            </div>
                        </div>
                    </div>
                </div>
           {{-- ====================   Bundle Delivery/Pickup  == Food and Product Bundle ===================== --}}



           {{-- Bundle Products Configuration --}}
             <div class="form-section form-section section-card rounded p-4 mb-4   d-none"  id="Bundle_products_configuration">
                 <h3 class="h5 fw-semibold mb-2">🛍️ {{ translate('Bundle Products Configuration') }}</h3>
                <div id="selectedProducts">
                    <p style="text-align: center; color: #666; padding: 20px;">No products added yet. Click "Add Product to Bundle" to start.</p>
                </div>
                <button type="button" class="btn btn-primary" id="addProductBtn">+ Add Product to Bundle</button>
                <!-- Available Products to Choose From -->
                <div id="availableProducts" style="display: none;">
                    <h3>Available Products:</h3>
                    <div class="product-card" data-id="1" data-name="Large Pizza" data-price="15.00">
                        <div class="product-header">
                            <div class="product-info">
                                <div class="product-name">Large Pizza</div>
                                <div class="product-price">$15.00</div>
                            </div>
                            <button type="button" class="btn btn-primary select-product-btn">Select</button>
                        </div>
                    </div>
                    <div class="product-card" data-id="2" data-name="Medium Pizza" data-price="12.00">
                        <div class="product-header">
                            <div class="product-info">
                                <div class="product-name">Medium Pizza</div>
                                <div class="product-price">$12.00</div>
                            </div>
                            <button type="button" class="btn btn-primary select-product-btn">Select</button>
                        </div>
                    </div>
                    <div class="product-card" data-id="3" data-name="Soft Drink" data-price="3.00">
                        <div class="product-header">
                            <div class="product-info">
                                <div class="product-name">Soft Drink</div>
                                <div class="product-price">$3.00</div>
                            </div>
                            <button type="button" class="btn btn-primary select-product-btn">Select</button>
                        </div>
                    </div>
                    <div class="product-card" data-id="4" data-name="Burger Deluxe" data-price="18.00">
                        <div class="product-header">
                            <div class="product-info">
                                <div class="product-name">Burger Deluxe</div>
                                <div class="product-price">$18.00</div>
                            </div>
                            <button type="button" class="btn btn-primary select-product-btn">Select</button>
                        </div>
                    </div>
                    <div class="product-card" data-id="5" data-name="French Fries" data-price="5.00">
                        <div class="product-header">
                            <div class="product-info">
                                <div class="product-name">French Fries</div>
                                <div class="product-price">$5.00</div>
                            </div>
                            <button type="button" class="btn btn-primary select-product-btn">Select</button>
                        </div>
                    </div>
                </div>


                <div class="container mt-5">
                    <div class="form-container">
                        <!-- Price Calculator -->
                        <div class="price-calculator" id="priceCalculator" style="display: none;">
                            <h3>💰 Bundle Price Calculation</h3>
                            <div id="priceBreakdown"></div>
                        </div>
                        <!-- Submit Button -->
                        <div class="form-section">
                            <button type="button" class="btn btn-success" id="saveBundleBtn">💾 Save Bundle & Generate Voucher</button>
                        </div>
                        <!-- Voucher Preview -->
                        <div class="voucher-preview" id="voucherPreview" style="display: none;">
                            <h2>🎫 Bundle Voucher Generated!</h2>

                            <div class="voucher-code" id="voucherCode">BUNDLE-2025-001</div>

                            <div class="qr-code-placeholder">
                                <div>📱 QR CODE</div>
                            </div>
                            <div class="voucher-details">
                                <h4>📋 Bundle Details:</h4>
                                <div id="bundleDetailsContent"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
             <!-- Section 6: Bundle Rules -->
            <div class="form-section section-card rounded p-4 mb-4   d-none" id="bundle_rule">
                  <h3 class="h5 fw-semibold mb-4">⚙️ {{ translate('Bundle Rules & Limitations') }}</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="maxPerCustomer">Max Uses Per Customer</label>
                        <input type="number" id="maxPerCustomer" class="form-control" min="1" placeholder="e.g., 1">
                    </div>
                    <div class="form-group">
                        <label for="maxTotal">Max Total Redemptions</label>
                        <input type="number" id="maxTotal" class="form-control" min="1" placeholder="e.g., 100">
                    </div>
                    <div class="form-group">
                        <label for="minOrderValue">Minimum Order Value</label>
                        <input type="number" id="minOrderValue" class="form-control" step="0.01" placeholder="0.00">
                    </div>
                </div>
                <div class="form-group">
                    <label>Valid for:</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="dineIn" value="dine_in" checked>
                            <label for="dineIn">Dine-in</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="takeaway" value="takeaway" checked>
                            <label for="takeaway">Takeaway</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="delivery" value="delivery" checked>
                            <label for="delivery">Delivery</label>
                        </div>
                    </div>
                </div>
            </div>

              {{-- How It Works --}}
             <div class="section-card rounded p-4 mb-4 d-none section3 two_four_complete" id="how_it_work_main">
                <h3 class="h5 fw-semibold mb-4">🏷️ {{ translate('How It Works') }}</h3>
                <p class="text-muted">Instructions for using your voucher</p>

                <div class="card border shadow-sm">
                    <div class="card-body">
                         <ol id="workList" class="pl-3 mb-0">
                            <!-- WorkManagement data will load here -->
                            </ol>
                    {{-- <ol class="pl-3 mb-0">
                        <li>Open the Arabi Value app and select the GiftCard Plus.</li>
                        <li>Choose a recipient from your contacts or select "Send to myself" if you want to use it personally.</li>
                        <li>Select the type of gift (Food, Mart, Transport, or Express) and the voucher amount.</li>
                        <li>Add a personalized message and choose a virtual card design.</li>
                        <li>Review the details, select your preferred payment method, and complete the purchase.</li>
                    </ol> --}}
                    </div>
                </div>
            </div>
            {{--  Terms & Conditions --}}
            <div class="section-card rounded p-4 mb-4  section3  d-none" id="term_condition_main">
                <h3 class="h5 fw-semibold mb-2">🏷️ {{ translate('Terms & Conditions') }}</h3>
                <p class="text-muted">Set your business terms</p>
                <div class="card border shadow-sm mt-3">
                    <div class="card-body">
                    <h5 class="text-center font-weight-bold mb-4">Usage Terms</h5>
                          <div id="usageTerms" class="row">
                            <!-- UsageTermManagement data will load here -->
                            </div>

                    {{-- <div class="row">
                        <!-- Non-refundable -->
                        <div class="col-md-4 mb-3">
                        <div class="border rounded p-5 d-flex align-items-center">
                            <input class="form-check-input mr-2" type="checkbox" id="nonRefundable">
                            <label class="form-check-label mb-0" for="nonRefundable">🚫 Non-refundable</label>
                        </div>
                        </div>

                        <!-- Excludes holidays -->
                        <div class="col-md-4 mb-3">
                        <div class="border rounded p-5 d-flex align-items-center">
                            <input class="form-check-input mr-2" type="checkbox" id="noHolidays">
                            <label class="form-check-label mb-0" for="noHolidays">🏖️ Excludes official holidays</label>
                        </div>
                        </div>

                        <!-- In-store only -->
                        <div class="col-md-4 mb-3">
                        <div class="border rounded p-5 d-flex align-items-center">
                            <input class="form-check-input mr-2" type="checkbox" id="inStoreOnly">
                            <label class="form-check-label mb-0" for="inStoreOnly">🏪 In-store only</label>
                        </div>
                        </div>
                    </div> --}}
                    </div>
                </div>
            </div>

            {{--  Review & Submit --}}
            <div class="section-card rounded p-4 mb-4 section3 d-none" id="review_submit_main">
                <h3 class="h5 fw-semibold mb-2">🏷️ {{ translate('Review & Submit') }}</h3>
                <p class="text-muted">Review your voucher before submitting</p>

                <div class="card border shadow-sm mt-3">
                    <div class="card-body">
                    <!-- MAIN REVIEW CONTENT (always visible) -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                        <h5 class="font-weight-bold mb-3">📋 Client Information</h5>
                        <p><strong>Client:</strong> Salvador Michael</p>
                        <p><strong>App:</strong> Maxine Solis</p>
                        <p><strong>Segment:</strong> Standard</p>
                        </div>
                        <div class="col-md-6 mb-4">
                        <h5 class="font-weight-bold mb-3">🤝 Partner Details</h5>
                        <p><strong>Partner Name:</strong> Casey Hahn</p>
                        <p><strong>Category:</strong> Desserts</p>
                        <p><strong>Sub Category:</strong> Not set</p>
                        <p><strong>Branches:</strong> Rem obcaecati sit s</p>
                        </div>
                        <div class="col-md-6 mb-4">
                        <h5 class="font-weight-bold mb-3">🎫 Voucher Info</h5>
                        <p><strong>Title:</strong> Accusamus cum rerum</p>
                        <p><strong>Thumbnail:</strong> https://www.kifatepy.me</p>
                        <p><strong>Image:</strong> https://www.sunyqylufyxisy.org.uk</p>
                        <p><strong>Food Add-ons:</strong> fdgdgfdg, dfjgbdf</p>
                        <p><strong>Tags:</strong> jdhjfd, dfgbjfdg</p>
                        </div>
                        <div class="col-md-6 mb-4">
                        <h5 class="font-weight-bold mb-3">💰 Pricing</h5>
                        <p><strong>Price:</strong> $435</p>
                        <p><strong>Discount:</strong> 30 $</p>
                        <p><strong>Valid Until:</strong> 1999-09-13</p>
                        <p><strong>Usage Limit:</strong> 20 per user</p>
                        <p><strong>Max Purchase:</strong> 50</p>
                        <p><strong>Stock:</strong> 795</p>
                        <p><strong>Order Range:</strong> 31 - 100</p>
                        <p><strong>Time Schedule:</strong> Sed eius distinctio</p>
                        </div>
                        <div class="col-md-6 mb-4">
                        <h5 class="font-weight-bold mb-3">⚙️ How It Works</h5>
                        <p><strong>Valid in Store Only:</strong> No</p>
                        </div>
                        <div class="col-md-6 mb-4">
                        <h5 class="font-weight-bold mb-3">📋 Terms</h5>
                        <p><strong>Non-refundable:</strong> No</p>
                        <p><strong>Excludes Holidays:</strong> No</p>
                        <p><strong>In-store Only:</strong> No</p>
                        </div>
                    </div>

                    <div class="border-top pt-3 mt-3">
                        <span class="badge badge-success">✅ Halal Certified</span>
                    </div>

                    <!-- Variations -->
                    <div class="border-top pt-4 mt-4">
                        <h5 class="font-weight-bold mb-3">🍽️ Variations (1)</h5>
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card border shadow-sm p-3">
                            <p class="font-weight-medium mb-1">Cillum aut et minus</p>
                            <p class="text-muted small mb-0">$31 • Stock: 31</p>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- TOGGLE BUTTON -->
                    <div class="text-center mt-4">
                        <button id="togglePreview" type="button" class="btn btn-secondary">
                        Show Preview 👁️
                        </button>
                    </div>

                    <!-- PREVIEW BLOCK (hide/show only this) -->
                    <div id="voucherPreview" class="card border-dashed mt-4 p-4" style="display: none;">
                        <h5 class="font-weight-bold mb-3">Voucher Preview</h5>
                        <div class="card bg-primary text-white p-4">
                        <h3 class="mb-2">Accusamus cum rerum</h3>
                        <p class="mb-3">Autem tenetur laboru</p>
                        <div class="bg-white text-dark rounded p-3">
                            <p class="h4 mb-0">$435</p>
                            <small>Save 30$</small>
                        </div>
                        <div class="mt-3">
                            <span class="badge badge-light">jdhjfd</span>
                            <span class="badge badge-light">dfgbjfdg</span>
                        </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-12">
                <div class="btn--container justify-content-end">
                    <button type="reset" id="reset_btn"
                        class="btn btn--reset">{{ translate('messages.reset') }}</button>
                    <button type="submit" id="submitButton"  class="btn btn--primary">{{ translate('messages.submit') }}</button>
                </div>
            </div>

        </form>
        </div>
      </div>


    <div class="modal" id="food-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close foodModalClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/IkoF9gPH6zs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="attribute-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close attributeModalClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/xG8fO7TXPbk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
        </div>
    </div>











@endsection


@push('script_2')
{{-- dashboard code --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/product-index.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const select = document.getElementById("bundle_offer_type");

        select.addEventListener("change", function () {
            // sab panels ke divs hide karo
            document.querySelectorAll(
            "#panel1 .bogo_free_div, #panel1 .buy_x_get_y_div, #panel1 .gift_div, #panel1 .bundle_div, #panel1 .mix_match_div,   #panel1 .fixed_bundle_div,  #panel1 .bogo_free" +
            "#panel2 .bogo_free_div, #panel2 .buy_x_get_y_div, #panel2 .gift_div, #panel2 .bundle_div, #panel2 .mix_match_div , #panel2 .fixed_bundle_div,#panel2 .fixed_bundle "
            ).forEach(div => div.style.display = "none");

            // selected value
            // fixed_bundle    bogo_free fixed_bundle

            const selected = this.value;

            if (selected) {
            document.querySelectorAll("#panel1 ." + selected + "_div, #panel2 ." + selected + "_div")
                .forEach(div => div.style.display = "block");
            }
        });
        });
    </script>

    <script>
       const buttons = document.querySelectorAll("#btn-group .btns");
            buttons.forEach(btn => {
                btn.addEventListener("click", () => {
                // sab se pehle purane selected hatao
                buttons.forEach(b => b.classList.remove("selected"));
                // jis par click hua usko selected do
                btn.classList.add("selected");
                });
            });
    </script>

    <script>
        function getDataFromServer(storeId) {
            $.ajax({
                url: "{{ route('admin.Voucher.get_document') }}",
                type: "GET",
                data: { store_id: storeId },
                dataType: "json",
                success: function(response) {
                console.log(response);

                // 🟢 WorkManagement (list items)
                let workHtml = "";
                $.each(response.work_management, function(index, item) {
                    workHtml += "<li>" + item.guid_title + "</li>";
                });
                $("#workList").html(workHtml);

                // 🟢 UsageTermManagement (checkboxes)
                let usageHtml = "";
                $.each(response.usage_term_management, function(index, term) {
                    usageHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-5 d-flex align-items-center">
                        <input class="form-check-input mr-2" type="checkbox" id="term${term.id}">
                        <label class="form-check-label mb-0" for="term${term.id}">
                            ${term.baseinfor_condition_title}
                        </label>
                        </div>
                    </div>
                    `;
                });
                $("#usageTerms").html(usageHtml);
                },
                error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Something went wrong!");
                }
            });
            }
    </script>

    <script>
        const toggleBtn = document.getElementById("togglePreview");
        const preview = document.getElementById("voucherPreview");
        let show = false;

        toggleBtn.addEventListener("click", () => {
        show = !show;
        preview.style.display = show ? "block" : "none";
        toggleBtn.textContent = show ? "Hide Preview 🙈" : "Show Preview 👁️";
        });
    </script>

    <script>
        // Single sliders
        const usageRange = document.getElementById("usageRange");
        const usageValue = document.getElementById("usageValue");
        usageRange.addEventListener("input", () => usageValue.textContent = usageRange.value);

        const maxRange = document.getElementById("maxRange");
        const maxValue = document.getElementById("maxValue");
        maxRange.addEventListener("input", () => maxValue.textContent = maxRange.value);


        const minRange = document.getElementById("minRange");
        const maxRangex = document.getElementById("maxRangex");
        const label = document.getElementById("orderRangeLabel");
        const progressBar = document.getElementById("progressBar");

        const minGap = 1;
        const sliderMax = parseInt(minRange.max);

        function updateLabel(e) {
        let minVal = parseInt(minRange.value);
        let maxVal = parseInt(maxRangex.value);

        // prevent overlap
        if (maxVal - minVal <= minGap) {
        if (e && e.target.id === "minRange") {
        minRange.value = maxVal - minGap;
        minVal = parseInt(minRange.value);
        } else {
        maxRangex.value = minVal + minGap;
        maxVal = parseInt(maxRangex.value);
        }
        }

        // update label
        label.textContent = `Order Range: ${minVal} - ${maxVal}`;

        // update progress bar (between two thumbs)
        let left = (minVal / sliderMax) * 100;
        let right = 100 - (maxVal / sliderMax) * 100;
        progressBar.style.left = left + "%";
        progressBar.style.right = right + "%";
        }

        minRange.addEventListener("input", updateLabel);
        maxRangex.addEventListener("input", updateLabel);

        // init
        updateLabel();
    </script>

    <script>
        function findBranch(storeId) {
        if (!storeId) {
            $('#sub-branch').empty().append('<option value="">{{ translate('messages.select_branch') }}</option>');
            return;
        }

        $.ajax({
            url: "{{ route('admin.Voucher.get_branches') }}",
            type: "GET",
            data: { store_id: storeId },
            success: function(response) {
                $('#sub-branch').empty().append('<option value="">{{ translate('messages.select_branch') }}</option>');
                $.each(response, function(key, branch) {
                    $('#sub-branch').append('<option value="'+ branch.id +'"> ' + branch.name + '  ('+ branch.type +')</option>');
                });
            },
            error: function() {
                toastr.error("{{ translate('messages.failed_to_load_branches') }}");
            }
        });
        }
    </script>
    <script>
        "use strict";
        $(document).on('change', '#discount_type', function () {
         let data =  document.getElementById("discount_type");
         if(data.value === 'amount'){
             $('#symble').text("({{ \App\CentralLogics\Helpers::currency_symbol() }})");
            }
            else{
             $('#symble').text("(%)");
         }
         });
        $(document).ready(function() {
            $("#add_new_option_button").click(function(e) {
                $('#empty-variation').hide();
                count++;
                let add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">{{ translate('Required') }}</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button"
                                        title="{{ translate('Delete') }}">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">{{ translate('name') }}</label>
                                    <input required name=options[` + count +
                    `][name] class="form-control new_option_name" type="text" data-count="`+
                    count +`">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">{{ translate('messages.selcetion_type') }} </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Multiple Selection') }}
                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="radio" value="single"
                    name="options[` + count + `][type]" id="type` + count +
                    `"
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Single Selection') }}
                    </span>
                </label>
            </div>
        </div>
        </div>
        <div class="col-xl-4 col-lg-6">
        <div class="row g-2">
            <div class="col-6">
                <label for="">{{ translate('Min') }}</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">{{ translate('Max') }}</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Option_name') }}</label>
                                                <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Additional_price') }}</label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                        <button type="button" class="btn btn--primary btn-outline-primary add_new_row_button" data-count="`+
                    count +`">{{ translate('Add_New_Option') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $("#add_new_option").append(add_option_view);
            });

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        function add_new_row_button(data) {
            count = data;
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            let add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Option_name') }}</label>
                        <input class="form-control" required type="text" name="options[` + count + `][values][` +
                countRow + `][label]" id="">
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Additional_price') }}</label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                count +
                `][values][` + countRow + `][optionPrice]" id="">
                    </div>
                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm deleteRow"
                                title="{{ translate('Delete') }}">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
            $('#option_price_view_' + data).append(add_new_row_view);

        }


        $('#store_id').on('change', function () {
            let route = '{{url('/')}}/admin/store/get-addons?data[]=0&store_id='+$(this).val();
            let id = 'add_on';
            getRestaurantData(route, id);
        });

        function modulChange(id) {
            $.get({
                url: "{{url('/')}}/admin/business-settings/module/show/"+id,
                dataType: 'json',
                success: function(data) {
                    module_data = data.data;
                    console.log(module_data)
                    stock = module_data.stock;
                    module_type = data.type;
                    if (stock) {
                        $('#stock_input').show();
                    } else {
                        $('#stock_input').hide();
                    }
                    if (module_data.add_on) {
                        $('#addon_input').show();
                    } else {
                        $('#addon_input').hide();
                    }

                    if (module_data.item_available_time) {
                        $('#time_input').show();
                    } else {
                        $('#time_input').hide();
                    }

                    if (module_data.veg_non_veg) {
                        $('#veg_input').show();
                    } else {
                        $('#veg_input').hide();
                    }
                    if (module_data.unit) {
                        $('#unit_input').show();
                    } else {
                        $('#unit_input').hide();
                    }
                    if (module_data.common_condition) {
                        $('#condition_input').show();
                    } else {
                        $('#condition_input').hide();
                    }
                    if (module_data.brand) {
                        $('#brand_input').show();
                    } else {
                        $('#brand_input').hide();
                    }
                    combination_update();
                    if (module_type == 'food') {
                        $('#food_variation_section').show();
                        $('#attribute_section').hide();
                    } else {
                        $('#food_variation_section').hide();
                        $('#attribute_section').show();
                    }
                    if (module_data.organic) {
                        $('#organic').show();
                    } else {
                        $('#organic').hide();
                    }
                    if (module_data.basic) {
                        $('#basic').show();
                    } else {
                        $('#basic').hide();
                    }
                    if (module_data.nutrition) {
                        $('#nutrition').show();
                    } else {
                        $('#nutrition').hide();
                    }
                    if (module_data.allergy) {
                        $('#allergy').show();
                    } else {
                        $('#allergy').hide();
                    }
                },
            });
            module_id = id;
        }

        modulChange({{Config::get('module.current_module_id')}});

        $('#condition_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/common-condition/get-all',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#brand_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/brand/get-all',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#store_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/store/get-stores',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:{{Config::get('module.current_module_id')}},
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#category_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/item/get-categories?parent_id=0',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:{{Config::get('module.current_module_id')}},
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#sub-categories').select2({
            ajax: {
                url: '{{ url('/') }}/admin/item/get-categories',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:{{Config::get('module.current_module_id')}},
                        parent_id: parent_category_id,
                        sub_category: true
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#choice_attributes').on('change', function() {
            if (module_id == 0) {
                toastr.error('{{ translate('messages.select_a_module') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
                $(this).val("");
                return false;
            }
            $('#customer_choice_options').html(null);
            $('#variant_combination').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                if ($(this).val().length > 50) {
                    toastr.error(
                        '{{ translate('validation.max.string', ['attribute' => translate('messages.variation'), 'max' => '50']) }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    return false;
                }
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;

            $('#customer_choice_options').append(
                `<div class="__choos-item"><div><input type="hidden" name="choice_no[]" value="${i}"><input type="text" class="form-control d-none" name="choice[]" value="${n}" placeholder="{{ translate('messages.choice_title') }}" readonly> <label class="form-label">${n}</label> </div><div><input type="text" class="form-control combination_update" name="choice_options_${i}[]" placeholder="{{ translate('messages.enter_choice_values') }}" data-role="tagsinput"></div></div>`
            );
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.Voucher.variant-combination') }}",
                data: $('#item_form').serialize() + '&stock=' + stock,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    console.log(data);
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length < 1) {
                        $('input[name="current_stock"]').attr("readonly", false);
                    }
                }
            });
        }

        // $('#item_form').on('keydown', function(e) {
        //     if (e.key === 'Enter') {
        //     e.preventDefault(); // Prevent submission on Enter
        //     }
        // });

        $('#item_form').on('submit', function(e) {
            $('#submitButton').attr('disabled', true);
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.Voucher.store') }}',
                data: $('#item_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success("{{ translate('messages.product_added_successfully') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                "{{ route('admin.Voucher.list') }}";
                        }, 1000);
                    }
                }
            });
        });


        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'item_images[]',
                maxCount: 5,
                rowHeight: '176px !important',
                groupClassName: 'spartan_item_wrapper min-w-176px max-w-176px',
                maxFileSize: '',
                placeholderImage: {
                    image: "{{ asset('public/assets/admin/img/upload-img.png') }}",
                    width: '176px'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                        "{{ translate('messages.please_only_input_png_or_jpg_type_file') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                },
                onSizeErr: function(index, file) {
                    toastr.error("{{ translate('messages.file_size_too_big') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('#reset_btn').click(function() {
            $('#module_id').val(null).trigger('change');
            $('#store_id').val(null).trigger('change');
            $('#category_id').val(null).trigger('change');
            $('#sub-categories').val(null).trigger('change');
            $('#unit').val(null).trigger('change');
            $('#veg').val(0).trigger('change');
            $('#add_on').val(null).trigger('change');
            $('#discount_type').val(null).trigger('change');
            $('#choice_attributes').val(null).trigger('change');
            $('#customer_choice_options').empty().trigger('change');
            $('#variant_combination').empty().trigger('change');
            $('#viewer').attr('src', "{{ asset('public/assets/admin/img/upload.png') }}");
            $('#customFileEg1').val(null).trigger('change');
            $("#coba").empty().spartanMultiImagePicker({
                fieldName: 'item_images[]',
                maxCount: 6,
                rowHeight: '176px !important',
                groupClassName: 'spartan_item_wrapper min-w-176px max-w-176px',
                maxFileSize: '',
                placeholderImage: {
                    image: "{{ asset('public/assets/admin/img/upload-img.png') }}",
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                        "{{ translate('messages.please_only_input_png_or_jpg_type_file') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                },
                onSizeErr: function(index, file) {
                    toastr.error("{{ translate('messages.file_size_too_big') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        })
    </script>

 {{--        --}}
   <script>
        function bundle(type) {
        // 1. Set the hidden input value
        document.getElementById('hidden_bundel').value = type;

        // 2. IDs of elements to hide
        const ids = [
            'management_selection',
            'basic_info_main',
            'store_category_main',
            'how_it_work_main',
            'term_condition_main',
            'review_submit_main',
            'Product_voucher_fields_1_3',
            'product_voucher_price_info_1_3',
            'food_voucher_fields_1_4',
            'food_voucher_price_info_1_4',
            'bundel_food_voucher_fields_1_3_1_4',
            'bundel_food_voucher_price_info_1_3_1_4'
        ];

        // Add d-none to each element if it's visible
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el && !el.classList.contains('d-none')) {
            el.classList.add('d-none');
            }
        });

        // 3. Remove "selected" from ALL voucher-card_2 sections
        document.querySelectorAll('.voucher-card').forEach(card => {
            card.classList.remove('selected');
        });
        }
   </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const managementSelection = document.querySelectorAll('#management_selection');
            const voucherCards = document.querySelectorAll('.voucher-card');
            const voucherCards2 = document.querySelectorAll('.voucher-card_2');
            // Get all elements by ID
            const basic_info_main = document.getElementById('basic_info_main');
            const store_category_main = document.getElementById('store_category_main');
            const how_it_work_main = document.getElementById('how_it_work_main');
            const term_condition_main = document.getElementById('term_condition_main');
            const review_submit_main = document.getElementById('review_submit_main');
            const bundle_rule = document.getElementById('bundle_rule');
            const Bundle_products_configuration = document.getElementById('Bundle_products_configuration');

            const Product_voucher_fields_1_3 = document.getElementById('Product_voucher_fields_1_3');
            const product_voucher_price_info_1_3 = document.getElementById('product_voucher_price_info_1_3');
            const food_voucher_fields_1_4 = document.getElementById('food_voucher_fields_1_4');
            const food_voucher_price_info_1_4 = document.getElementById('food_voucher_price_info_1_4');
            const bundel_food_voucher_fields_1_3_1_4 = document.getElementById('bundel_food_voucher_fields_1_3_1_4');
            const bundel_food_voucher_price_info_1_3_1_4 = document.getElementById('bundel_food_voucher_price_info_1_3_1_4');


            // Move these functions OUTSIDE of DOMContentLoaded to make them globally accessible
            function section_one(loopIndex, primaryId,name) {
                getDataFromServer(primaryId);
                // Set hidden input value
                document.getElementById('hidden_value').value = loopIndex;
                document.getElementById('hidden_name').value = name;

                const managementSelection = document.querySelectorAll('#management_selection');

                managementSelection.forEach(el => {
                    if (loopIndex === "1" || name === "Delivery/Pickup") {
                        submit_voucher_type(loopIndex, primaryId,name);
                        el.classList.remove('d-none');

                        // Hide discount-specific sections
                        const elementsToHide = [
                            document.getElementById('basic_info'),
                            document.getElementById('store_category'),
                            document.getElementById('price_info'),
                            document.getElementById('voucher_behavior'),
                            document.getElementById('usage_terms'),
                            document.getElementById('attributes'),
                            document.getElementById('tags')
                        ];

                        elementsToHide.forEach(element => {
                            if (element) element.classList.add('d-none');
                        });

                    } else if (loopIndex === "2" || name === "In-Store") {

                        submit_voucher_type(loopIndex, primaryId,name);
                        el.classList.remove('d-none');

                        // Show discount-specific sections
                        const elementsToShow = [
                            document.getElementById('basic_info'),
                            document.getElementById('store_category'),
                            document.getElementById('price_info'),
                            document.getElementById('voucher_behavior'),
                            document.getElementById('usage_terms'),
                            document.getElementById('attributes'),
                            document.getElementById('tags')
                        ];

                        elementsToShow.forEach(element => {
                            if (element) element.classList.remove('d-none');
                        });
                    }
                });
            }

            function section_second(value_two) {
                const hidden_value = document.getElementById('hidden_value').value;
                const hidden_bundel = document.getElementById('hidden_bundel').value;
                const hidden_name = document.getElementById('hidden_name').value;

                // Convert to strings for proper comparison
                const hiddenVal = String(hidden_value);
                const valueTwo = String(value_two);
                const hiddenBundel = String(hidden_bundel);

                // Get all elements
                const basic_info_main = document.getElementById('basic_info_main');
                const store_category_main = document.getElementById('store_category_main');
                const how_it_work_main = document.getElementById('how_it_work_main');
                const term_condition_main = document.getElementById('term_condition_main');
                const review_submit_main = document.getElementById('review_submit_main');

                const bundle_rule = document.getElementById('bundle_rule');
                const Bundle_products_configuration = document.getElementById('Bundle_products_configuration');

                const Product_voucher_fields_1_3 = document.getElementById('Product_voucher_fields_1_3');
                const product_voucher_price_info_1_3 = document.getElementById('product_voucher_price_info_1_3');

                const food_voucher_fields_1_4 = document.getElementById('food_voucher_fields_1_4');
                const food_voucher_price_info_1_4 = document.getElementById('food_voucher_price_info_1_4');

                const bundel_food_voucher_fields_1_3_1_4 = document.getElementById('bundel_food_voucher_fields_1_3_1_4');
                const bundel_food_voucher_price_info_1_3_1_4 = document.getElementById('bundel_food_voucher_price_info_1_3_1_4');
                // Helper function to show elements
                function showElements(elements) {
                    elements.forEach(el => {
                        if (el) el.classList.remove('d-none');
                    });
                }

                // Helper function to hide elements
                function hideElements(elements) {
                    elements.forEach(el => {
                        if (el) el.classList.add('d-none');
                    });
                }
                switch (hiddenBundel) {
                    case "simple":
                        switch (hidden_name) {
                            case "Delivery/Pickup": // Delivery/Pickup
                                switch (valueTwo) {
                                    case "5": // Shop + Delivery
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,Product_voucher_fields_1_3,product_voucher_price_info_1_3]);
                                        hideElements([bundel_food_voucher_fields_1_3_1_4, bundel_food_voucher_price_info_1_3_1_4, food_voucher_fields_1_4, food_voucher_price_info_1_4]);
                                        // showShopFields();
                                        break;

                                    case "6": // Pharmacy + Delivery
                                         showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,food_voucher_fields_1_4,food_voucher_price_info_1_4]);
                                        hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3,bundel_food_voucher_fields_1_3_1_4, bundel_food_voucher_price_info_1_3_1_4]);
                                        // showPharmacyFields();
                                        break;
                                }
                                break;

                            case "In-Store": // In-Store
                                switch (valueTwo) {
                                    case "5": // Shop + In-Store
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                          hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3,bundel_food_voucher_fields_1_3_1_4, bundel_food_voucher_price_info_1_3_1_4]);

                                        // showShopFields();
                                        break;

                                    case "6": // Pharmacy + In-Store
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                          hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3,bundel_food_voucher_fields_1_3_1_4, bundel_food_voucher_price_info_1_3_1_4]);

                                        // showPharmacyFields();
                                        break;


                                }
                                break;
                        }
                        break;

                    case "bundle":
                      switch (hidden_name) {
                            case "Delivery/Pickup": // Delivery/Pickup
                                switch (valueTwo) {
                                    case "5": // Shop + Delivery
                                         showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,bundel_food_voucher_fields_1_3_1_4,bundel_food_voucher_price_info_1_3_1_4]);
                                        hideElements([  Product_voucher_fields_1_3,product_voucher_price_info_1_3,food_voucher_fields_1_4,food_voucher_price_info_1_4]);
                                        // showShopFields();
                                        break;

                                    case "6": // Pharmacy + Delivery
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,bundel_food_voucher_fields_1_3_1_4,bundel_food_voucher_price_info_1_3_1_4]);
                                        hideElements([  Product_voucher_fields_1_3,product_voucher_price_info_1_3,food_voucher_fields_1_4,food_voucher_price_info_1_4]);
                                        // showPharmacyFields();
                                        break;

                                }
                                break;

                            case "In-Store": // In-Store
                                switch (valueTwo) {
                                    case "5": // Shop + In-Store
                                         showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);

                                        // showShopFields();
                                        break;

                                    case "6": // Pharmacy + In-Store
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);

                                        // showPharmacyFields();
                                        break;


                                }
                                break;
                            }
                        break;
                    case "Flat discount":
                        switch (hidden_name) {
                            case "Delivery/Pickup": // Delivery/Pickup
                                switch (valueTwo) {
                                    case "5": // Shop + Delivery
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                        hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3, food_voucher_fields_1_4, food_voucher_price_info_1_4]);
                                        showShopFields();
                                        break;

                                    case "6": // Pharmacy + Delivery
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                        hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3, food_voucher_fields_1_4, food_voucher_price_info_1_4]);
                                        // showPharmacyFields();
                                        break;


                                }
                                break;

                            case "In-Store": // In-Store
                                switch (valueTwo) {
                                    case "5": // Shop + In-Store
                                    showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);

                                        // showShopFields();
                                        break;

                                    case "6": // Pharmacy + In-Store
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);

                                        // showPharmacyFields();
                                        break;


                                }
                                break;
                            }
                        break;
                    case "Gift":
                      switch (hidden_name) {
                        case "Delivery/Pickup": // Delivery/Pickup
                            switch (valueTwo) {
                                case "5": // Shop + Delivery
                                showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                    // hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3, food_voucher_fields_1_4, food_voucher_price_info_1_4]);
                                    // showShopFields();
                                    break;

                                case "6": // Pharmacy + Delivery
                                    showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                    // hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3, food_voucher_fields_1_4, food_voucher_price_info_1_4]);
                                    // showPharmacyFields();
                                    break;


                            }
                            break;

                        case "In-Store": // In-Store
                            switch (valueTwo) {
                                case "5": // Shop + In-Store
                                    showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);

                                    break;

                                case "6": // Pharmacy + In-Store
                                    showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);

                                    break;

                            }
                            break;
                     }
                break;

                }
            }

            // Helper functions for showing specific field types
            function showShopFields() {
                const shopFields = document.getElementById('shop-category-fields');
                const pharmacyFields = document.getElementById('pharmacy-category-fields');
                const groceryFields = document.getElementById('grocery-category-fields');
                const foodFields = document.getElementById('food-category-fields');

                if (shopFields) shopFields.classList.remove('d-none');
                if (pharmacyFields) pharmacyFields.classList.add('d-none');
                if (groceryFields) groceryFields.classList.add('d-none');
                if (foodFields) foodFields.classList.add('d-none');
            }

            function showPharmacyFields() {
                const shopFields = document.getElementById('shop-category-fields');
                const pharmacyFields = document.getElementById('pharmacy-category-fields');
                const groceryFields = document.getElementById('grocery-category-fields');
                const foodFields = document.getElementById('food-category-fields');

                if (pharmacyFields) pharmacyFields.classList.remove('d-none');
                if (shopFields) shopFields.classList.add('d-none');
                if (groceryFields) groceryFields.classList.add('d-none');
                if (foodFields) foodFields.classList.add('d-none');
            }

            function showGroceryFields() {
                const shopFields = document.getElementById('shop-category-fields');
                const pharmacyFields = document.getElementById('pharmacy-category-fields');
                const groceryFields = document.getElementById('grocery-category-fields');
                const foodFields = document.getElementById('food-category-fields');

                if (groceryFields) groceryFields.classList.remove('d-none');
                if (shopFields) shopFields.classList.add('d-none');
                if (pharmacyFields) pharmacyFields.classList.add('d-none');
                if (foodFields) foodFields.classList.add('d-none');
            }

            function showFoodFields() {
                const shopFields = document.getElementById('shop-category-fields');
                const pharmacyFields = document.getElementById('pharmacy-category-fields');
                const groceryFields = document.getElementById('grocery-category-fields');
                const foodFields = document.getElementById('food-category-fields');

                if (foodFields) foodFields.classList.remove('d-none');
                if (shopFields) shopFields.classList.add('d-none');
                if (pharmacyFields) pharmacyFields.classList.add('d-none');
                if (groceryFields) groceryFields.classList.add('d-none');
            }

            // DOMContentLoaded event listener for initialization
            document.addEventListener("DOMContentLoaded", function () {
                const managementSelection = document.querySelectorAll('#management_selection');
                const voucherCards = document.querySelectorAll('.voucher-card');
                const voucherCards2 = document.querySelectorAll('.voucher-card_2');

                // Highlight selected voucher-card
                voucherCards.forEach(card => {
                    card.addEventListener('click', function () {
                        voucherCards.forEach(c => c.classList.remove('selected'));
                        this.classList.add('selected');
                    });
                });

                // Event delegation for dynamically created voucher-card_2 elements
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.voucher-card_2')) {
                        document.querySelectorAll('.voucher-card_2').forEach(card => {
                            card.classList.remove('selected');
                        });
                        e.target.closest('.voucher-card_2').classList.add('selected');
                    }
                });
            });
                 // Highlight selected voucher-card
            voucherCards.forEach(card => {
                card.addEventListener('click', function () {
                    voucherCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            // Make functions globally accessible
            window.section_one = section_one;
            window.section_second = section_second;
        });
    </script>

    <script>
        function submit_voucher_type(loopIndex,id,name) {
            var loopIndex = loopIndex;
            var primary_vouchertype_id = id;

            console.log("Sending ID:", primary_vouchertype_id);

            $.ajax({
                url: "{{ route('admin.Voucher.voucherType.store') }}", // <-- اپنے route کے حساب سے بدلیں
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // Laravel CSRF protection کیلئے ضروری
                    voucher_type_id: primary_vouchertype_id,
                    loopIndex: loopIndex
                },
                success: function(response) {
                    console.log("Success:", response);
                    // empty previous content
                    $("#append_all_data").empty();
                    // starting index (4 se start karna hai)
                    let index = 5;
                    // loop through modules
                    response.all_ids.forEach(function(module) {
                        let card = `
                            <div class="col-md-3">
                                <div class="voucher-card_2 border rounded p-4 text-center h-100"
                                    onclick="section_second(${index})">
                                     <div class="display-4 mb-2">
                                        <img src="${module.thumbnail}" alt="${module.module_name}" style="width:40px; height:auto;" />
                                    </div>

                                    <h6 class="fw-semibold">${module.module_name}</h6>
                                    <small class="text-muted">${module.description ?? ''}</small>
                                </div>
                            </div>

                        `;
                        $("#append_all_data").append(card);

                        index++; // next card ke liye +1
                    });
                },

                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Something went wrong!");
                }
            });
        }
        $(document).on('click', '.voucher-card_2', function () {
            $('.voucher-card_2').removeClass('selected');
            $(this).addClass('selected');
        });
    </script>

    <script>
        $(document).ready(function () {
            // -------------------- Segment Select2 --------------------
            $('.segment-select').select2({
                placeholder: "-- Select Segment --",
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                minimumResultsForSearch: 3,
                templateResult: formatOption,
                templateSelection: formatSelection
            });

            // -------------------- Client Select2 --------------------
            $('.Clients-select').select2({
                placeholder: "-- Select Clients --",
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                minimumResultsForSearch: 3,
                templateResult: formatOption,
                templateSelection: formatSelection
            });

            // -------------------- Option Formatter --------------------
            function formatOption(option) {
                if (!option.id) return option.text;

                const parts = option.text.split(' / ');
                if (parts.length === 2) {
                    const name = parts[0];
                    const type = parts[1];
                    const typeClass = type === 'free' ? 'success' : type === 'paid' ? 'primary' : 'warning';

                    return $(
                        '<div class="d-flex justify-content-between align-items-center">' +
                            '<span>' + name + '</span>' +
                            '<span class="badge bg-' + typeClass + '">' + type + '</span>' +
                        '</div>'
                    );
                }
                return option.text;
            }

            function formatSelection(option) {
                return option.text || option.placeholder;
            }

            // -------------------- Client Change => Load Segments --------------------
            $('.Clients-select').on('change', function () {
                let clientId = $(this).val();
                if (!clientId) return;
                // alert(clientId);
                let url = "{{ route('admin.client-side.getSegments', ':id') }}".replace(':id', clientId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (res) {
                        // Clear and refill segment dropdown
                        $('#segment_type').empty().append('<option></option>');

                        $.each(res, function (index, item) {
                            $('#segment_type').append(
                                '<option value="' + item.id + '">' + item.name + ' / ' + item.type + '</option>'
                            );
                        });

                        // Refresh Select2
                        $('#segment_type').trigger('change');
                    },
                    error: function () {
                        alert("Error loading segments!");
                    }
                });
            });

            // -------------------- Segment Select Validation --------------------
            $('.segment-select').on('select2:select', function (e) {
                const data = e.params.data;
                $('#selectedValue').removeClass('alert-info alert-warning')
                    .addClass('alert-success')
                    .html('<i class="fas fa-check-circle me-2"></i>Selected: <strong>' + data.text + '</strong>');
                $(this).addClass('is-valid');
            });

            $('.segment-select').on('select2:clear', function () {
                $('#selectedValue').removeClass('alert-success')
                    .addClass('alert-info')
                    .html('No segment selected yet');
                $(this).removeClass('is-valid');
            });

            // -------------------- Clients Select Validation --------------------
            $('.Clients-select').on('select2:select', function (e) {
                const data = e.params.data;
                $('#selectedValue').removeClass('alert-info alert-warning')
                    .addClass('alert-success')
                    .html('<i class="fas fa-check-circle me-2"></i>Selected: <strong>' + data.text + '</strong>');
                $(this).addClass('is-valid');
            });

            $('.Clients-select').on('select2:clear', function () {
                $('#selectedValue').removeClass('alert-success')
                    .addClass('alert-info')
                    .html('No Clients selected yet');
                $(this).removeClass('is-valid');
            });

            // -------------------- Submit Demo --------------------
            $('#submitBtn').on('click', function () {
                const selectedClients = $('.Clients-select').val();
                const selectedSegment = $('.segment-select').val();
                const clientName = $('#client_name').val();

                if (!selectedClients) {
                    alert('Please select a Client first!');
                    return;
                }

                if (!selectedSegment) {
                    alert('Please select a Segment first!');
                    return;
                }

                if (!clientName) {
                    alert('Please enter client name!');
                    return;
                }

                alert(
                    'Client saved successfully!\n' +
                    'Client: ' + $('.Clients-select option:selected').text() +
                    '\nSegment: ' + $('.segment-select option:selected').text() +
                    '\nName: ' + clientName
                );
            });
        });
    </script>

{{-- domo --}}

{{-- <script>
    document.getElementById("addProductBtn").addEventListener("click", function() {
        var bundleOffer = document.getElementById("bundle_offer_type").value;
        var availableProducts = document.getElementById("availableProducts");


        if (bundleOffer === "") {
            alert("Please select an offer type first!");
            return;
        }

        if (availableProducts.style.display === "none") {
            availableProducts.style.display = "block";
        } else {
            availableProducts.style.display = "none";
        }
    });
</script> --}}

    <script>
       // Bundle Products Configuration Complete JavaScript
document.addEventListener('DOMContentLoaded', function() {
    let selectedBundleProducts = [];
    let bundleProductCounter = 1;

    // Add Product Button Click Handler
    const addProductBtn = document.getElementById('addProductBtn');
    if (addProductBtn) {
        addProductBtn.addEventListener('click', function() {
            const bundleOfferType = document.getElementById('bundle_offer_type')?.value;
            const availableProducts = document.getElementById('availableProducts');

            // Check if bundle offer type is selected
            if (!bundleOfferType || bundleOfferType === "") {
                alert("Please select a bundle offer type first!");
                return;
            }

            // Toggle available products visibility
            if (availableProducts) {
                if (availableProducts.style.display === "none" || !availableProducts.style.display) {
                    availableProducts.style.display = "block";
                } else {
                    availableProducts.style.display = "none";
                }
            }
        });
    }

    // Select Product Button Click Handler
    function initializeProductSelection() {
        const selectProductBtns = document.querySelectorAll('.select-product-btn');

        selectProductBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const productCard = this.closest('.product-card');
                if (productCard) {
                    const productId = productCard.getAttribute('data-id');
                    const productName = productCard.getAttribute('data-name');
                    const productPrice = parseFloat(productCard.getAttribute('data-price'));

                    // Add product to bundle
                    addProductToBundle(productId, productName, productPrice);
                }
            });
        });
    }

    // Add Product to Bundle Function
    function addProductToBundle(id, name, price) {
        // Check if product already exists
        const existingProduct = selectedBundleProducts.find(product => product.id === id);
        if (existingProduct) {
            alert('This product is already added to the bundle!');
            return;
        }

        const bundleOfferType = document.getElementById('bundle_offer_type')?.value;
        let productRole = 'bundle_item';

        // Determine product role based on bundle type
        switch(bundleOfferType) {
            case 'bogo_free':
                productRole = selectedBundleProducts.length === 0 ? 'paid_item' : 'free_item';
                break;
            case 'buy_x_get_y':
                productRole = selectedBundleProducts.length === 0 ? 'paid_item' : 'free_item';
                break;
            case 'fixed_bundle':
            case 'bundle':
                productRole = 'bundle_item';
                break;
            case 'gift':
                productRole = selectedBundleProducts.length === 0 ? 'qualifying_item' : 'gift_item';
                break;
            case 'mix_match':
                productRole = 'mix_match_item';
                break;
            default:
                productRole = 'bundle_item';
        }

        // Create product object
        const product = {
            id: id,
            name: name,
            basePrice: price,
            role: productRole,
            quantity: 1,
            selectedVariations: {},
            selectedAddons: {},
            finalPrice: price
        };

        selectedBundleProducts.push(product);
        renderBundleProducts();
        calculateBundlePrice();

        // Hide available products after selection
        const availableProducts = document.getElementById('availableProducts');
        if (availableProducts) {
            availableProducts.style.display = 'none';
        }
    }

    // Render Bundle Products Function
    function renderBundleProducts() {
        const selectedProductsContainer = document.getElementById('selectedProducts');
        if (!selectedProductsContainer) return;

        selectedProductsContainer.innerHTML = '';

        if (selectedBundleProducts.length === 0) {
            selectedProductsContainer.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">No products added yet. Click "Add Product to Bundle" to start.</p>';
            return;
        }

        selectedBundleProducts.forEach((product, index) => {
            const productCard = createProductCard(product, index);
            selectedProductsContainer.appendChild(productCard);
        });

        // Initialize event listeners for the rendered products
        initializeProductEventListeners();
    }

    // Create Product Card Function
    function createProductCard(product, index) {
        const productCard = document.createElement('div');
        productCard.className = 'product-card selected';

        const bundleOfferType = document.getElementById('bundle_offer_type')?.value;
        let roleOptions = generateRoleOptions(bundleOfferType, product.role);

        productCard.innerHTML = `
            <div class="product-header">
                <div class="product-info">
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">Base Price: $${product.basePrice.toFixed(2)}</div>
                </div>
                <div class="product-actions">
                    <select class="form-control product-role-select" data-index="${index}" style="width: auto; margin-right: 10px;">
                        ${roleOptions}
                    </select>
                    <button class="btn btn-danger remove-product-btn" data-index="${index}">Remove</button>
                </div>
            </div>

            <div class="variations-section">
                <div class="variation-group">
                    <div class="variation-title">Size Options:</div>
                    <div class="variation-options">
                        <div class="variation-option ${product.selectedVariations.size === 'small' ? 'selected' : ''}"
                             data-index="${index}" data-type="size" data-value="small" data-price="0">
                             Small (+$0)
                        </div>
                        <div class="variation-option ${product.selectedVariations.size === 'medium' ? 'selected' : ''}"
                             data-index="${index}" data-type="size" data-value="medium" data-price="2">
                             Medium (+$2)
                        </div>
                        <div class="variation-option ${product.selectedVariations.size === 'large' ? 'selected' : ''}"
                             data-index="${index}" data-type="size" data-value="large" data-price="5">
                             Large (+$5)
                        </div>
                    </div>
                </div>

                <div class="variation-group">
                    <div class="variation-title">Add-ons:</div>
                    <div class="addons-section">
                        <div class="addon-item">
                            <label>
                                <input type="checkbox" class="addon-checkbox" data-index="${index}"
                                       data-addon="extra_cheese" data-price="2"
                                       ${product.selectedAddons.extra_cheese ? 'checked' : ''}>
                                Extra Cheese (+$2)
                            </label>
                        </div>
                        <div class="addon-item">
                            <label>
                                <input type="checkbox" class="addon-checkbox" data-index="${index}"
                                       data-addon="extra_sauce" data-price="1"
                                       ${product.selectedAddons.extra_sauce ? 'checked' : ''}>
                                Extra Sauce (+$1)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 15px; font-weight: bold; color: #38a169;">
                Item Total: $${product.finalPrice.toFixed(2)}
                ${product.role === 'free_item' ? ' (FREE)' : ''}
                ${product.role === 'gift_item' ? ' (GIFT)' : ''}
            </div>
        `;

        return productCard;
    }

    // Generate Role Options Function
    function generateRoleOptions(bundleType, currentRole) {
        let options = '';

        switch(bundleType) {
            case 'bogo_free':
            case 'buy_x_get_y':
                options = `
                    <option value="paid_item" ${currentRole === 'paid_item' ? 'selected' : ''}>Paid Item</option>
                    <option value="free_item" ${currentRole === 'free_item' ? 'selected' : ''}>Free Item</option>
                `;
                break;
            case 'gift':
                options = `
                    <option value="qualifying_item" ${currentRole === 'qualifying_item' ? 'selected' : ''}>Qualifying Item</option>
                    <option value="gift_item" ${currentRole === 'gift_item' ? 'selected' : ''}>Gift Item</option>
                `;
                break;
            case 'fixed_bundle':
            case 'bundle':
            case 'mix_match':
            default:
                options = `<option value="bundle_item" selected>Bundle Item</option>`;
        }

        return options;
    }

    // Initialize Product Event Listeners Function
    function initializeProductEventListeners() {
        // Role select change handlers
        document.querySelectorAll('.product-role-select').forEach(select => {
            select.addEventListener('change', function() {
                const index = parseInt(this.dataset.index);
                selectedBundleProducts[index].role = this.value;
                calculateBundlePrice();
            });
        });

        // Remove product handlers
        document.querySelectorAll('.remove-product-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                selectedBundleProducts.splice(index, 1);
                renderBundleProducts();
                calculateBundlePrice();
            });
        });

        // Variation selection handlers
        document.querySelectorAll('.variation-option').forEach(option => {
            option.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                const type = this.dataset.type;
                const value = this.dataset.value;
                const extraPrice = parseFloat(this.dataset.price);

                selectVariation(index, type, value, extraPrice);
            });
        });

        // Addon checkbox handlers
        document.querySelectorAll('.addon-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const index = parseInt(this.dataset.index);
                const addon = this.dataset.addon;
                const price = parseFloat(this.dataset.price);

                toggleAddon(index, addon, price, this.checked);
            });
        });
    }

    // Select Variation Function
    function selectVariation(productIndex, variationType, value, extraPrice) {
        const product = selectedBundleProducts[productIndex];
        product.selectedVariations[variationType] = value;

        // Recalculate price
        let newPrice = product.basePrice;

        // Add variation price
        if (product.selectedVariations.size) {
            if (product.selectedVariations.size === 'medium') newPrice += 2;
            else if (product.selectedVariations.size === 'large') newPrice += 5;
        }

        // Add addon prices
        Object.values(product.selectedAddons).forEach(addonPrice => {
            newPrice += addonPrice;
        });

        product.finalPrice = newPrice;
        renderBundleProducts();
        calculateBundlePrice();
    }

    // Toggle Addon Function
    function toggleAddon(productIndex, addonName, price, isChecked) {
        const product = selectedBundleProducts[productIndex];

        if (isChecked) {
            product.selectedAddons[addonName] = price;
        } else {
            delete product.selectedAddons[addonName];
        }

        // Recalculate price
        let newPrice = product.basePrice;

        // Add variation price
        if (product.selectedVariations.size) {
            if (product.selectedVariations.size === 'medium') newPrice += 2;
            else if (product.selectedVariations.size === 'large') newPrice += 5;
        }

        // Add addon prices
        Object.values(product.selectedAddons).forEach(addonPrice => {
            newPrice += addonPrice;
        });

        product.finalPrice = newPrice;
        renderBundleProducts();
        calculateBundlePrice();
    }

    // Calculate Bundle Price Function
    function calculateBundlePrice() {
        const bundleOfferType = document.getElementById('bundle_offer_type')?.value;
        let totalOriginalPrice = 0;
        let totalBundlePrice = 0;

        selectedBundleProducts.forEach(product => {
            totalOriginalPrice += product.finalPrice;
        });

        switch(bundleOfferType) {
            case 'bogo_free':
                const paidItems = selectedBundleProducts.filter(p => p.role === 'paid_item');
                const freeItems = selectedBundleProducts.filter(p => p.role === 'free_item');

                if (paidItems.length > 0 && freeItems.length > 0) {
                    totalBundlePrice = Math.max(...paidItems.map(p => p.finalPrice));
                    // Add addon costs from free items
                    freeItems.forEach(item => {
                        totalBundlePrice += Object.values(item.selectedAddons).reduce((sum, price) => sum + price, 0);
                    });
                } else {
                    totalBundlePrice = totalOriginalPrice;
                }
                break;

            case 'fixed_bundle':
                const fixedPrice = document.getElementById('fixedBundlePrice')?.value || 0;
                totalBundlePrice = parseFloat(fixedPrice) || totalOriginalPrice;
                break;

            case 'buy_x_get_y':
                const buyItems = selectedBundleProducts.filter(p => p.role === 'paid_item');
                totalBundlePrice = buyItems.reduce((sum, item) => sum + item.finalPrice, 0);
                break;

            case 'gift':
                const qualifyingItems = selectedBundleProducts.filter(p => p.role === 'qualifying_item');
                totalBundlePrice = qualifyingItems.reduce((sum, item) => sum + item.finalPrice, 0);
                break;

            default:
                totalBundlePrice = totalOriginalPrice;
        }

        // Update price display if exists
        updatePriceDisplay(totalOriginalPrice, totalBundlePrice);
    }

    // Update Price Display Function
    function updatePriceDisplay(originalPrice, bundlePrice) {
        const priceCalculator = document.getElementById('priceCalculator');
        const priceBreakdown = document.getElementById('priceBreakdown');

        if (priceCalculator && priceBreakdown && selectedBundleProducts.length > 0) {
            priceCalculator.style.display = 'block';

            const savings = originalPrice - bundlePrice;
            let breakdownHTML = `
                <div class="price-row">
                    <span>Original Total:</span>
                    <span>$${originalPrice.toFixed(2)}</span>
                </div>
                <div class="price-row">
                    <span>Bundle Price:</span>
                    <span>$${bundlePrice.toFixed(2)}</span>
                </div>
                <div class="price-row">
                    <span>You Save:</span>
                    <span style="color: #e53e3e;">$${savings.toFixed(2)}</span>
                </div>
                <div class="price-row price-total">
                    <span>Final Total:</span>
                    <span>$${bundlePrice.toFixed(2)}</span>
                </div>
            `;

            priceBreakdown.innerHTML = breakdownHTML;
        } else if (priceCalculator) {
            priceCalculator.style.display = 'none';
        }
    }

    // Save Bundle Function
    const saveBundleBtn = document.getElementById('saveBundleBtn');
    if (saveBundleBtn) {
        saveBundleBtn.addEventListener('click', function() {
            if (selectedBundleProducts.length === 0) {
                alert('Please add at least one product to the bundle!');
                return;
            }

            const bundleOfferType = document.getElementById('bundle_offer_type')?.value;
            if (!bundleOfferType) {
                alert('Please select a bundle offer type!');
                return;
            }

            // Generate voucher code
            const voucherCode = `BUNDLE-${new Date().getFullYear()}-${bundleProductCounter.toString().padStart(3, '0')}`;
            bundleProductCounter++;

            // Show success message
            alert(`Bundle saved successfully! Voucher Code: ${voucherCode}`);

            // You can add more logic here to save the bundle data
            console.log('Bundle Data:', {
                voucherCode: voucherCode,
                bundleType: bundleOfferType,
                products: selectedBundleProducts
            });

            // Show voucher preview if it exists
            showVoucherPreview(voucherCode, bundleOfferType, selectedBundleProducts);
        });
    }

    // Show Voucher Preview Function
    function showVoucherPreview(voucherCode, bundleType, products) {
        const voucherPreview = document.getElementById('voucherPreview');
        const voucherCodeEl = document.getElementById('voucherCode');
        const bundleDetailsContent = document.getElementById('bundleDetailsContent');

        if (voucherPreview && voucherCodeEl && bundleDetailsContent) {
            voucherCodeEl.textContent = voucherCode;

            let detailsHTML = `
                <ul>
                    <li><strong>Bundle Type:</strong> ${bundleType.replace(/_/g, ' ').toUpperCase()}</li>
                    <li><strong>Products Count:</strong> ${products.length}</li>
                </ul>
                <h4>Products Included:</h4>
                <ul>
            `;

            products.forEach(product => {
                detailsHTML += `<li>${product.name} (${product.role.replace(/_/g, ' ')}) - $${product.finalPrice.toFixed(2)}</li>`;
            });

            detailsHTML += '</ul>';
            bundleDetailsContent.innerHTML = detailsHTML;
            voucherPreview.style.display = 'block';

            // Scroll to preview
            voucherPreview.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Initialize product selection when page loads
    initializeProductSelection();

    // Re-initialize when new products are added dynamically
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                initializeProductSelection();
            }
        });
    });

    const availableProducts = document.getElementById('availableProducts');
    if (availableProducts) {
        observer.observe(availableProducts, { childList: true, subtree: true });
    }
});

// Expose functions globally if needed
window.bundleProductsManager = {
    getSelectedProducts: function() {
        return selectedBundleProducts || [];
    },
    clearProducts: function() {
        selectedBundleProducts = [];
        const container = document.getElementById('selectedProducts');
        if (container) {
            container.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">No products added yet. Click "Add Product to Bundle" to start.</p>';
        }
    }
};
    </script>
@endpush
