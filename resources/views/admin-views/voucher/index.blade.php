@extends('layouts.admin.app')

@section('title', translate('messages.add_new_item'))
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

@section('content')
  <link rel="stylesheet" href="{{asset('public/assets/admin/css/voucher.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/voucher.css')}}">
     <!-- Page Header -->
     <div class="container-fluid px-4 py-3">
          @include("admin-views.voucher.include_heading")
        <div class="bg-white shadow rounded-lg p-4">
            <input type="hidden" name="hidden_value" id="hidden_value" value="1"/>
            <input type="hidden" name="hidden_bundel" id="hidden_bundel" value="simple"/>
            <input type="hidden" name="hidden_name" id="hidden_name" value="Delivery/Pickup"/>

            {{-- Step 1: Select Voucher Type and Step 2: Select Management Type  --}}
             @include("admin-views.voucher.include_client_voucher_management")


            <form action="javascript:" method="post" id="item_form" enctype="multipart/form-data">
                @csrf
                @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
                @php($language = $language->value ?? null)
                @php($defaultLang = str_replace('_', '-', app()->getLocale()))

                {{-- Client Information and Partner Information --}}
                 @include("admin-views.voucher.include_client_partner_information")

                {{-- ==================== Delivery/Pickup  == Product ===================== --}}

                <!-- Voucher Details -->
                <div class="section-card rounded p-4 mb-4  d-none " id="Product_voucher_fields_1_3">
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
                                                    <div class="icon-file"><input type="file" name="image" id="customFileEg1" class="custom-file-input d-none" accept=".webp, .jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
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
                                    <select name="food_add_one[]" id="food_add_one" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Product') }}" >
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
                <div class="section-card rounded p-4 mb-4 d-none " id="product_voucher_price_info_1_3">
                    <h3 class="h5 fw-semibold mb-4">💰 {{ translate('Price Information') }}</h3>
                    {{-- Price Information --}}
                    <div class="col-md-12">
                        <div class="row g-2">
                            <div class="col-6 col-md-3">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="exampleFormControlInput1">{{ translate('messages.price') }} <span class="form-label-secondary text-danger" data-toggle="tooltip" data-placement="right"  data-original-title="{{ translate('messages.Required.')}}"> * </span></label>
                                    <input type="number" min="0" max="999999999999.99" step="0.01"value="1" name="price" class="form-control" placeholder="{{ translate('messages.Ex:') }} 100" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mb-0">
                                    <label class="input-label" for="exampleFormControlInput1">{{ translate('Total Stock') }} </label>
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
                                    <label class="input-label" for="exampleFormControlInput1">{{ translate('Offer Type') }} <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Required.')}}"> * </span>
                                        <span  class="input-label-secondary text--title" data-toggle="tooltip"  data-placement="right" data-original-title="{{ translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores') }}">
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
                                    <label class="input-label" for="exampleFormControlInput1">{{ translate('discount Value') }} <span class="form-label-secondary text-danger" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Required.')}}"> * </span></label>
                                    <input type="number" min="0" max="9999999999999999999999" value="0" name="discount" class="form-control"placeholder="{{ translate('messages.Ex:') }} 100">
                                </div>
                            </div>
                            <!-- Attributes same-->
                            <div class="col-12">
                                <div class=" section " id="attributes">
                                    <h3 class="h5 fw-semibold mb-4">🏷️ {{ translate('attribute') }}</h3>
                                    <div class="row g-2">
                                        <div class="col-md-12" id="attribute_section">
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label" for="exampleFormControlSelect1">{{ translate('messages.attribute') }}<span class="input-label-secondary"></span></label>
                                                        <select name="attribute_id[]" id="choice_attributes" class="form-control js-select2-custom" multiple="multiple">
                                                            @foreach (\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                                                <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <div class="customer_choice_options d-flex __gap-24px" id="customer_choice_options">

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

                {{-- ==================== Delivery/Pickup  == Product ===================== --}}

                {{-- ==================== Delivery/Pickup  == Food ===================== --}}

                <!-- Voucher Details -->
                <div class="section-card rounded p-4 mb-4 d-none " id="food_voucher_fields_1_4">
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
                            <label class="input-label" for="food_add_one">{{ translate('s') }}
                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                    data-original-title="{{ translate('Segment') }}"></span>
                            </label>
                            <select name="food_add_one[]" id="food_add_one" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Product') }}" multiple>
                                @foreach (\App\Models\Item::whereNull('voucher_type')->get() as $item)
                                <option value="{{ $item->id }}"
                                    @if(collect(old('food_add_one', []))->contains($item->id)) selected @endif>
                                        {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-12">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div> --}}
                    {{-- <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="is-halal-food">
                        <label class="form-check-label" for="is-halal-food">Is It Halal</label>
                    </div> --}}
                </div>
                <!--  Price Information one-->
                <div class="section-card rounded p-4 mb-4 d-none " id="food_voucher_price_info_1_4">
                    <h3 class="h5 fw-semibold mb-4"> {{ translate('Price Information') }}</h3>
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
                                    {{-- <input class="form-check-input" type="checkbox" id="include_shipping">
                                    <label class="form-check-label" for="include_shipping">Include Shipping</label>
                                </div> --}}

                                {{-- <div class="col-lg-12" id="food_variation_section"> --}}
                                {{-- <div class="col-lg-12" >
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
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
                {{-- ==================== Delivery/Pickup  == Food ===================== --}}

                {{-- ====================   Bundle Delivery/Pickup  == Food and Product Bundle ===================== --}}

                <!-- Voucher Details -->
                <div class="section-card rounded p-4 mb-4 d-none " id="bundel_food_voucher_fields_1_3_1_4">
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
                    {{-- <div class="col-12 col-md-12">
                        <div class="form-group mb-0">
                            <h3 class="h5 fw-semibold mb-2"> {{ translate('Bundle Type Selection') }}</h3>
                            <select name="bundle_offer_type" id="bundle_offer_type" class="form-control" onchange="tab_section_change()">
                            <option value="">Select Bundle Offer Type</option>
                            <option value="bundle"> Fixed Bundle - Specific products at set price</option>
                            <option value="bogo_free"> BOGO Free - Buy one get one free</option>
                            <option value="buy_x_get_y"> Buy X Get Y - Buy products get different product free</option>
                            <option value="mix_match"> Mix & Match - Customer chooses from categories</option>
                            </select>
                        </div>
                    </div> --}}
                    {{-- Bundle Type Selection --}}
                    <div class="col-12 col-md-12">
                        <div class="form-group mb-0">
                            <h3 class="h5 fw-semibold mb-2"> {{ translate('Bundle Type Selection') }}</h3>
                            <select name="bundle_offer_type" id="bundle_offer_type" class="form-control" onchange="tab_section_change()">
                                <option value="">Select Bundle Offer Type</option>
                                <option value="bundle" {{ old('bundle_offer_type') == 'bundle' ? 'selected' : '' }}>
                                    Fixed Bundle - Specific products at set price
                                </option>
                                <option value="bogo_free" {{ old('bundle_offer_type') == 'bogo_free' ? 'selected' : '' }}>
                                    BOGO Free - Buy one get one free
                                </option>
                                <option value="buy_x_get_y" {{ old('bundle_offer_type') == 'buy_x_get_y' ? 'selected' : '' }}>
                                    Buy X Get Y - Buy products get different product free
                                </option>
                                <option value="mix_match" {{ old('bundle_offer_type') == 'mix_match' ? 'selected' : '' }}>
                                    Mix & Match - Customer chooses from categories
                                </option>
                            </select>
                        </div>
                    </div>


                    {{-- panel1 --}}
                    <div class="col-12 mt-5" id="panel1">
                         <div class="row g-3 bundle_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                    <h4> FIXED BUNDLE</h4>
                                    <p><strong>Description:</strong> Create a bundle with specific products at a fixed price. Customer gets exactly these products for the set price.</p>
                                    <p><strong>Example:</strong> Phone + Case + Charger = $299 (instead of $335 individually)</p>
                                    <p><strong>Pricing Method:</strong> fixed price</p>
                                </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show my-4">
                                <div id="configContent"><h4> Bundle Configuration</h4>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Bundle Fixed Price</label>
                                            <input type="number" id="totalItemsToChoose" class="form-control" min="2" value="5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <!-- Group Product Bundle Configuration -->
                                <div class="p-3 bg-white mb-4">
                                    <h4 class="mb-3"> Group Product Bundle</h4>
                                    <!-- Bundle Products -->
                                    <div class="row">

                                        <div class="col-sm-12 col-lg-12">
                                              <div class="form-group">
                                                <label class="input-label" for="select_pro">{{ translate('Bundle Products') }}
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Bundle Products') }}"></span>
                                                </label>
                                                <select name="select_pro[]" id="select_pro" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label">Bundle Discount Type</label>
                                            <select class="form-control" data-testid="select-bundle-discount-type">
                                            <option>% Percentage Off</option>
                                            <option>$ Fixed Amount Off</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
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
                            </div>
                        </div>
                        <div class="row g-3 bogo_free_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                    <h4> BOGO FREE</h4>
                                    <p><strong>Description:</strong> Buy one product, get another product completely free. Customer pays for the higher-priced item.</p>
                                    <p><strong>Example:</strong> Buy Large Pizza ($15), get Medium Pizza free (save $12)</p>
                                    <p><strong>Pricing Method:</strong> pay higher price</p>
                                </div>
                                </div>
                                <div id="bundleConfigSection" class="bundle-config-section show my-4">
                                    <div id="configContent"><h4> Bundle Configuration</h4>
                                        <div class="form-group">
                                            <p><strong>Instructions:</strong> Add products to bundle. First product will be "paid item", second will be "free item". Customer pays for higher-priced item.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-sm">
                                    <!-- BOGO Configuration -->
                                    <div class="p-3 bg-white mb-4">
                                        <h4 class="mb-3"> BOGO Configuration</h4>
                                        <div class="row">
                                               <div class="col-sm-12 col-lg-12">
                                              <div class="form-group">
                                                <label class="input-label" for="select_bogo_product">{{ translate('BOGO Product') }}
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('BOGO Product') }}"></span>
                                                </label>
                                                <select name="select_bogo_product[]" id="select_bogo_product" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>

                                                </select>
                                            </div>
                                        </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="buy_quantity">{{ translate('Buy Quantity') }}
                                                    </label>
                                                    <input type="text" name="name" value="1" id="buy_quantity"  class="form-control" placeholder="{{ translate('Buy Quantity') }}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="get_quantity">{{ translate('Get Quantity') }}
                                                    </label>
                                                    <input type="text" name="name" value="1" id="get_quantity"  class="form-control" placeholder="{{ translate('Get Quantity') }}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row g-3 buy_x_get_y_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                    <h4> BUY X GET Y</h4>
                                    <p><strong>Description:</strong> Buy specific products and get different products free or discounted.</p>
                                    <p><strong>Example:</strong> Buy any Main Course, get free Drink or Dessert</p>
                                    <p><strong>Pricing Method:</strong> conditional free</p>
                                </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show my-4">
                                <div id="configContent"><h4> Bundle Configuration</h4>
                                    <div class="form-group">
                                        <p><strong>Instructions:</strong> Add products customers must buy first, then add products they get free. Configure roles appropriately.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-sm">
                                <!-- Buy X Get Y Configuration -->
                                    <div class="p-3 bg-white mb-4">
                                        <h4 class="mb-3"> Buy X Get Y Configuration</h4>
                                        <!-- Buy Products -->
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="input-label" for="select_bogo">{{ translate('BOGO Product') }}
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('BOGO Product') }}"></span>
                                                    </label>
                                                    <select name="select_bogo[]" id="select_bogo" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>
                                                    </select>
                                                </div>
                                           </div>
                                            <!-- Buy Qty / Get Qty / Max Uses -->
                                            <div class="col-md-4 mt-3">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="buy_quantity">{{ translate('Buy Quantity') }}
                                                    </label>
                                                    <input type="text" name="name" value="1" id="buy_quantity"  class="form-control" placeholder="{{ translate('Buy Quantity') }}" >
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="get_quantity">{{ translate('Get Quantity') }}
                                                    </label>
                                                    <input type="text" name="name" value="1" id="get_quantity"  class="form-control" placeholder="{{ translate('Get Quantity') }}" >
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="max_quantity">{{ translate('Max Uses') }}
                                                    </label>
                                                    <input type="text" name="name" value="1" id="max_quantity"  class="form-control" placeholder="{{ translate('Max Uses') }}" >
                                                </div>
                                            </div>
                                            <!-- Free Product -->
                                            <div class="col-sm-12 col-lg-12">
                                                 <div class="form-group">
                                                    <label class="input-label" for="select_free_product">{{ translate('Free Product') }}
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Free Product') }}"></span>
                                                    </label>
                                                    <select name="select_free_product[]" id="select_free_product" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>
                                                    </select>
                                                </div>
                                           </div>

                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div class="row g-3 mix_match_div" style="display:none;">
                            <div id="bundleTypeDescription" class="bundle-type-description show">
                                <div id="descriptionContent">
                                <h4> MIX MATCH</h4>
                                <p><strong>Description:</strong> Customer chooses specific number of items from different categories for a bundle price.</p>
                                <p><strong>Example:</strong> Choose 3 from Snacks + 2 from Drinks = $20</p>
                                <p><strong>Pricing Method:</strong> fixed bundle price</p>
                                </div>
                            </div>
                            <div id="bundleConfigSection" class="bundle-config-section show my-4">
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

                                    <!-- Mix and Match Collection -->
                                    <div class="p-3 bg-white mb-4">
                                        <h4 class="mb-3">🔀 Mix and Match Collection</h4>

                                        <!-- Collection Category -->

                                        <div class="row">
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="form-group mb-0">
                                                    <label class="input-label"
                                                        for="select_category_all">{{ translate('Collection Category') }}<span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="{{ translate('messages.Required.')}}"> *
                                                        </span></label>
                                                      <select name="select_category_all" id="select_category_all" class="form-control js-select2-custom" multiple>
                                                        @foreach (\App\Models\Category::all() as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-sm-12 col-lg-12">
                                                 <div class="form-group">
                                                    <label class="input-label" for="select_available_pro">{{ translate('Available Products') }}
                                                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Available Products') }}"></span>
                                                    </label>
                                                    <select name="select_available_pro[]" id="select_available_pro" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>
                                                    </select>
                                                </div>
                                           </div>
                                            <!-- 3-column grid -->
                                            <div class="col-md-4 mt-3">
                                                <label class="form-label">Buy Quantity</label>
                                                <input
                                                type="number"
                                                step="0.01"
                                                class="form-control"
                                                placeholder="10"
                                                data-testid="input-bundle-discount"
                                                value="0"
                                                >
                                            </div>
                                            <div class="col-md-4 mt-3">
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
                                            <div class="col-md-4 mt-3">
                                                <label class="form-label">Max Uses Per Customer</label>
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
                            </div>
                        </div>
                    </div>
                    <!-- Valid Until -->
                    <div class="col-12 mt-3">
                        <label class="form-label" for="validUntilDate">Valid Until</label>
                        <input
                        type="date"
                        class="form-control"
                        id="validUntilDate"
                        placeholder="mm/dd/yyyy"
                        data-testid="input-bundle-valid-until"
                        >
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
                <div class="section-card rounded p-4 mb-4 d-none "id="bundel_food_voucher_price_info_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4"> {{ translate('Price Information') }}</h3>
                    {{-- Price Information --}}
                    <div class="row g-2">
                        <div class="col-6 col-md-3">
                            <div class="form-group mb-0">
                                <label class="input-label"  for="exampleFormControlInput1">{{ translate('messages.price') }} <span class="form-label-secondary text-danger"  data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Required.')}}"> *  </span> </label>
                                <input type="number" min="0" max="999999999999.99" step="0.01" value="1" name="price" class="form-control"placeholder="{{ translate('messages.Ex:') }} 100" required>
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
                        <!-- Example divs to show/hide panel2 -->
                        <div class="col-12 mt-4" id="panel2">
                            <div class="row g-3 bogo_free_div" style="display:none;">
                                <div class="card border-0 shadow-sm">
                                    <h4 class="card-title mb-4"> Bundle Pricing Configuration</h4>
                                    <!-- BOGO Section -->
                                    <div class="mb-4">
                                        <h5 class="text-muted mb-3"> BOGO Pricing Settings</h5>
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
                            <div class="row g-3 buy_x_get_y_div" style="display:none;">
                                    <div class="card border-0 shadow-sm">
                                        <h4 class="card-title mb-4"> Bundle Pricing Configuration</h4>
                                        <!-- Buy X Get Y Section -->
                                        <div class="mb-4">
                                            <h5 class="text-muted mb-3"> Buy X Get Y Pricing</h5>
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
                                                    <p class="small fw-bold mb-1"> Deal Summary:</p>
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
                            <div class="row g-3 bundle_div" style="display:none;">
                                <div class="card border-0 shadow-sm">
                                    <h4 class="card-title mb-4"> Bundle Pricing Configuration</h4>
                                    <!-- Group Product Bundle Section -->
                                    <div class="mb-4">
                                        <h5 class="text-muted mb-3"> Group Product Bundle Pricing</h5>
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
                                                <p class="small fw-bold mb-1"> Bundle Summary:</p>
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
                            <div class="row g-3 mix_match_div" style="display:none;">
                                <div class="card border-0 shadow-sm">
                                    <h4 class="card-title mb-4"> Bundle Pricing Configuration</h4>
                                    <!-- Mix & Match Section -->
                                    <div class="mb-4">
                                        <h5 class="text-muted mb-3"> Mix and Match Pricing</h5>
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
                                                <p class="small fw-bold mb-1">Mix & Match Summary:</p>
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
                    {{-- ====================   Bundle Delivery/Pickup  == Food and Product Bundle ===================== --}}

               {{-- Bundle Products Configuration --}}
                <div class=" section-card rounded p-4 mb-4   d-none"  id="Bundle_products_configuration">
                    <h3 class="h5 fw-semibold mb-2"> {{ translate('Bundle Products Configuration') }}</h3>
                    <div id="selectedProducts">
                        <p style="text-align: center; color: #666; padding: 20px;">No products added yet. Click "Add Product to Bundle" to start.</p>
                    </div>
                    <button type="button" class="btn btn-primary" id="addProductBtn">+ Add Product to Bundle</button>
                    <!-- Available Products to Choose From -->
                    <div id="availableProducts" style="display: none;">
                        <h3 class="mt-3">Available Products:</h3>
                        <div class="row">
                     <?php $i = 1; ?>
                        @foreach (\App\Models\Item::all() as $item)
                            @php(
                                // Decode variations JSON to an array
                                $variations = json_decode($item->variations, true)
                            )

                            <div class="product-card col-12 " data-id="{{ $i }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">
                                <div class="product-header">
                                    <div class="product-info">
                                        <div class="product-name">{{ $item->name }}</div>
                                        <div class="product-price">${{ $item->price }}</div>
                                    </div>
                                    <button type="button" class="btn btn-primary select-product-btn">Select</button>
                                </div>
                            </div>

                            <div id="selectedProducts_{{$item->id}}" class="d-none col-12 col-md-5 mx-2">
                                <div class="product-card selected col-12 mx-2">
                                    <div class="product-header">
                                        <div class="product-info">
                                            <div class="product-name">{{ $item->name }}</div>
                                            <div class="product-price">Base Price: ${{ $item->price }}</div>
                                        </div>
                                        <div class="product-actions">
                                            <select class="form-control product-role-select" data-index="{{ $i }}" style="width: auto;">
                                                <option value="paid_item" selected>Paid Item</option>
                                                <option value="free_item">Free Item</option>
                                                  <option value="bundle_item" >Bundle Item</option>
                                            </select>
                                            <button type="button" class="btn btn-danger remove-product-btn" data-index="{{ $i }}">Remove</button>
                                        </div>
                                    </div>
                                    {{-- ✅ Variations Section --}}
                                        @if(!empty($variations))
                                            <div class="variations-section">
                                                <div class="variation-group">
                                                    <div class="variation-title">Available Variations:</div>
                                                    <div class="variation-options">
                                                        @foreach ($variations as $variation)
                                                            <div class="variation-option"
                                                                data-index="{{ $i }}"
                                                                data-type="{{ $variation['type'] ?? 'default' }}"
                                                                data-value="{{ $variation['type'] ?? '' }}"
                                                                data-price="{{ $variation['price'] ?? 0 }}">
                                                                {{ ucfirst($variation['type'] ?? 'Option') }} (${{ $variation['price'] ?? 0 }})
                                                                @if(isset($variation['stock']))
                                                                    <small>— Stock: {{ $variation['stock'] }}</small>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @php(
                                        // Decode variations JSON to an array
                                            $addonIds = json_decode($item->add_ons, true)

                                                )
                                    {{-- Add-ons example (optional) --}}
                                   @if(!empty($addonIds))
                                            <div class="addons-section">
                                                <div class="variation-title">Available Add-ons:</div>

                                                @foreach ($addonIds as $addonId)
                                                  @php(
                                                    // Fetch addon details from the AddOn model
                                                        $addon = \App\Models\AddOn::find($addonId)
                                                )


                                                    @if($addon)
                                                        <div class="addon-item">
                                                            <label>
                                                                <input type="checkbox"
                                                                    class="addon-checkbox"
                                                                    data-index="{{ $i }}"
                                                                    data-addon="{{ $addon->id }}"
                                                                    data-price="{{ $addon->price }}">
                                                                {{ $addon->name }} (+${{ $addon->price }})
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif

                                    <div style="margin-top: 15px; font-weight: bold; color: #38a169;">
                                        Item Total: ${{ $item->price }}
                                    </div>
                                </div>
                            </div>

                            <?php $i++; ?>
                        @endforeach

                    </div>
                    </div>


                    <div class="container mt-5">
                        <div class="form-container">
                            <!-- Price Calculator -->
                            <div class="price-calculator" id="priceCalculator" style="display: none;">
                                <h3> Bundle Price Calculation</h3>
                                <div id="priceBreakdown"></div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Section 6: Bundle Rules -->
                <div class=" section-card rounded p-4 mb-4   d-none" id="bundle_rule">
                    <h3 class="h5 fw-semibold mb-4"> {{ translate('Bundle Rules & Limitations') }}</h3>
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

                 @include("admin-views.voucher.include_voucher")

            </form>
        </div>
      </div>


      @include("admin-views.voucher.include_model")

@endsection


@push('script_2')
{{-- dashboard code --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/product-index.js"></script>

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
    {{-- findBranch --}}
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

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const managementSelection = document.querySelectorAll('#management_selection');
            const voucherCards = document.querySelectorAll('.voucher-card');
            const voucherCards2 = document.querySelectorAll('.voucher-card_2');
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
                                         showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,bundel_food_voucher_fields_1_3_1_4,bundel_food_voucher_price_info_1_3_1_4,Bundle_products_configuration]);
                                        hideElements([  Product_voucher_fields_1_3,product_voucher_price_info_1_3,food_voucher_fields_1_4,food_voucher_price_info_1_4]);
                                        // showShopFields();
                                        break;

                                    case "6": // Pharmacy + Delivery
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,bundel_food_voucher_fields_1_3_1_4,bundel_food_voucher_price_info_1_3_1_4,Bundle_products_configuration]);
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
                                        hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3, food_voucher_fields_1_4, food_voucher_price_info_1_4,Bundle_products_configuration]);
                                        showShopFields();
                                        break;

                                    case "6": // Pharmacy + Delivery
                                        showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main]);
                                        hideElements([Product_voucher_fields_1_3, product_voucher_price_info_1_3, food_voucher_fields_1_4, food_voucher_price_info_1_4,Bundle_products_configuration]);
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

{{-- domo --}}
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
            // function initializeProductSelection() {
            //     const selectProductBtns = document.querySelectorAll('.select-product-btn');

            //     selectProductBtns.forEach(btn => {
            //         btn.addEventListener('click', function(e) {
            //             e.preventDefault();

            //             const productCard = this.closest('.product-card');
            //             if (productCard) {
            //                 const productId = productCard.getAttribute('data-id');
            //                 const productName = productCard.getAttribute('data-name');
            //                 const productPrice = parseFloat(productCard.getAttribute('data-price'));

            //                 // Add product to bundle
            //                 addProductToBundle(productId, productName, productPrice);
            //             }
            //         });
            //     });
            // }

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
                'bundel_food_voucher_price_info_1_3_1_4',
                'Bundle_products_configuration'
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
        // -------------------- Client Change => Load Segments --------------------
        $(document).ready(function () {
            $('.Clients_select_new').on('change', function () {
                let clientId = $(this).val();
                if (!clientId) return;
                // alert(clientId);
                let url = "{{ route('admin.client-side.getSegments', ':id') }}".replace(':id', clientId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (res) {
                        // Clear and refill segment dropdown
                        $('#segment_type').empty().append('<option value="">Select Product</option>');
                        // Agar res ek array hai to loop karo
                        if (Array.isArray(res) && res.length > 0) {
                            $.each(res, function (index, item) {
                                $('#segment_type').append(
                                    '<option value="' + item.id + '">' + item.name + ' / ' + item.type + '</option>'
                                );
                            });
                        } else {
                            $('#segment_type').append('<option value="">No segments found</option>');
                        }

                        // Refresh Select2
                        $('#segment_type').trigger('change');
                    },
                    error: function () {
                        // alert("Error loading segments!");
                    }
                });

            });
        });

        function submit_voucher_type(loopIndex,id,name) {
            var loopIndex = loopIndex;
            var primary_vouchertype_id = id;

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

        function get_product() {
            var category_id = $("#category_id").val();
            var store_id = $("#store_id").val();

            if (store_id == "") {
                alert("Please select store");
            } else {
                $.ajax({
                    url: "{{ route('admin.Voucher.get_product') }}",
                    type: "GET",
                    data: {
                        store_id: store_id,
                        category_id: category_id  // optional agar zaroori ho
                    },
                    success: function(response) {
                        console.log(response);
                        $('.all_product_list')
                            .empty()
                            .append('<option value="">{{ translate("Select Product") }}</option>');

                        $.each(response, function(key, product) {
                            $('.all_product_list')
                                .append('<option value="'+ product.id +'">'
                                + product.name + '</option>');
                        });
                    },
                    error: function() {
                        toastr.error("{{ translate('messages.failed_to_load_branches') }}");
                    }
                });
            }
        }

        // Product Selection and Variation Handler with Bundle Calculation
        $(document).ready(function() {

            // Store selected products data
            let selectedProducts = [];

            // When "Select" button is clicked
            $(document).on('click', '.select-product-btn', function() {
                const card = $(this).closest('.product-card');
                const productIndex = card.attr('data-id');
                const productName = card.attr('data-name');
                const productPrice = parseFloat(card.attr('data-price'));

                // Hide the available product card
                card.hide();

                // Find and show the corresponding selected product div
                const selectedDiv = $(`#selectedProducts_${productIndex}`).length ?
                    $(`#selectedProducts_${productIndex}`) :
                    $(`[id^="selectedProducts_"]`).eq(productIndex - 1);

                selectedDiv.removeClass('d-none').show();

                // Add to selected products array
                selectedProducts.push({
                    index: productIndex,
                    name: productName,
                    basePrice: productPrice,
                    variationPrice: 0,
                    addonPrice: 0,
                    role: 'paid_item'
                });

                // Update bundle calculation and display
                updateBundleDisplay();

                // Show the entire availableProducts section if hidden
                $('#availableProducts').show();
            });

            // When "Remove" button is clicked
            $(document).on('click', '.remove-product-btn', function() {
                const index = $(this).attr('data-index');
                const selectedDiv = $(this).closest('[id^="selectedProducts_"]');

                // Hide the selected product div
                selectedDiv.addClass('d-none').hide();

                // Show back the available product card
                $(`.product-card[data-id="${index}"]`).show();

                // Reset all selections
                selectedDiv.find('.variation-option').removeClass('selected');
                selectedDiv.find('.addon-checkbox').prop('checked', false);
                selectedDiv.find('.addon-item').removeClass('selected');

                // Remove from selected products array
                selectedProducts = selectedProducts.filter(p => p.index !== index);

                // Update bundle display
                updateBundleDisplay();

                // Reset item total
                updateItemTotal(index);
            });

            // When product role is changed (Paid Item / Free Item / Bundle Item)
            $(document).on('change', '.product-role-select', function() {
                const index = $(this).attr('data-index');
                const role = $(this).val();

                // Update role in selected products array
                const product = selectedProducts.find(p => p.index === index);
                if (product) {
                    product.role = role;
                }

                // Update bundle display
                updateBundleDisplay();
            });

            // When a variation option is clicked
            $(document).on('click', '.variation-option', function() {
                const index = $(this).attr('data-index');
                const variationPrice = parseFloat($(this).attr('data-price')) || 0;
                const variationType = $(this).attr('data-type') || 'default';

                // Remove 'selected' class from siblings in the same group
                $(this).siblings('.variation-option').removeClass('selected');

                // Toggle selection on clicked option
                const wasSelected = $(this).hasClass('selected');
                $(this).toggleClass('selected');

                // Update variation price in selected products array
                const product = selectedProducts.find(p => p.index === index);
                if (product) {
                    product.variationPrice = wasSelected ? 0 : variationPrice;
                    product.variationType = wasSelected ? '' : variationType;
                }

                // Update item total and bundle display
                updateItemTotal(index);
                updateBundleDisplay();
            });

            // When an addon checkbox is changed
            $(document).on('change', '.addon-checkbox', function() {
                const index = $(this).attr('data-index');
                const addonItem = $(this).closest('.addon-item');

                // Add/remove background highlight based on checkbox state
                if ($(this).is(':checked')) {
                    addonItem.addClass('selected');
                } else {
                    addonItem.removeClass('selected');
                }

                // Calculate total addon price for this product
                const selectedDiv = $(this).closest('[id^="selectedProducts_"]');
                let totalAddonPrice = 0;
                let selectedAddons = [];

                selectedDiv.find('.addon-checkbox:checked').each(function() {
                    const addonPrice = parseFloat($(this).attr('data-price')) || 0;
                    const addonName = $(this).parent().text().trim().split('(+$')[0].trim();
                    totalAddonPrice += addonPrice;
                    selectedAddons.push({
                        name: addonName,
                        price: addonPrice
                    });
                });

                // Update addon price in selected products array
                const product = selectedProducts.find(p => p.index === index);
                if (product) {
                    product.addonPrice = totalAddonPrice;
                    product.selectedAddons = selectedAddons;
                }

                // Update item total and bundle display
                updateItemTotal(index);
                updateBundleDisplay();
            });

            // Function to calculate and update item total
            function updateItemTotal(index) {
                const selectedDiv = $(`[data-index="${index}"]`).first().closest('[id^="selectedProducts_"]');

                // Get base price from the product card
                const basePriceText = selectedDiv.find('.product-price').text();
                const basePrice = parseFloat(basePriceText.replace('Base Price: $', '').replace('$', '')) || 0;

                let total = basePrice;

                // Add selected variation price
                selectedDiv.find('.variation-option.selected').each(function() {
                    const varPrice = parseFloat($(this).attr('data-price')) || 0;
                    total += varPrice;
                });

                // Add checked addon prices
                selectedDiv.find('.addon-checkbox:checked').each(function() {
                    const addonPrice = parseFloat($(this).attr('data-price')) || 0;
                    total += addonPrice;
                });

                // Update the item total display
                selectedDiv.find('div[style*="Item Total"]').html(
                    `Item Total: $${total.toFixed(2)}`
                );
            }

            // Function to update bundle display (Left: Paid/Bundle, Right: Free)
            function updateBundleDisplay() {
                if (selectedProducts.length === 0) {
                    $('#priceCalculator').hide();
                    return;
                }

                $('#priceCalculator').show();

                // Separate products by role
                const paidAndBundleProducts = selectedProducts.filter(p =>
                    p.role === 'paid_item' || p.role === 'bundle_item'
                );
                const freeProducts = selectedProducts.filter(p => p.role === 'free_item');

                // Build left column (Paid + Bundle Items)
                let leftColumnHTML = '';
                paidAndBundleProducts.forEach((product, idx) => {
                    const itemTotal = product.basePrice + product.variationPrice + product.addonPrice;
                    const roleLabel = product.role === 'bundle_item' ? 'Bundle Item' : 'Paid Item';

                    leftColumnHTML += `
                        <div class="product-detail-card">
                            <h5>${product.name} <span class="badge bg-primary">${roleLabel}</span></h5>
                            <p><strong>Base Price:</strong> $${product.basePrice.toFixed(2)}</p>
                            ${product.variationType ? `<p><strong>Variation:</strong> ${product.variationType} (+$${product.variationPrice.toFixed(2)})</p>` : ''}
                            ${product.selectedAddons && product.selectedAddons.length > 0 ? `
                                <p><strong>Add-ons:</strong></p>
                                <ul>
                                    ${product.selectedAddons.map(addon => `<li>${addon.name} (+$${addon.price.toFixed(2)})</li>`).join('')}
                                </ul>
                            ` : ''}
                            <p><strong>Item Total:</strong> $${itemTotal.toFixed(2)}</p>
                        </div>
                        ${idx < paidAndBundleProducts.length - 1 ? '<hr/>' : ''}
                    `;
                });

                // Build right column (Free Items)
                let rightColumnHTML = '';
                freeProducts.forEach((product, idx) => {
                    const itemTotal = product.basePrice + product.variationPrice + product.addonPrice;
                    const addonTotal = product.addonPrice;

                    rightColumnHTML += `
                        <div class="product-detail-card">
                            <h5>${product.name} <span class="badge bg-success">Free Item</span></h5>
                            <p><strong>Base Price:</strong> $${product.basePrice.toFixed(2)} <span class="text-success">(FREE)</span></p>
                            ${product.variationType ? `<p><strong>Variation:</strong> ${product.variationType} <span class="text-success">(FREE)</span></p>` : ''}
                            ${product.selectedAddons && product.selectedAddons.length > 0 ? `
                                <p><strong>Add-ons (Chargeable):</strong></p>
                                <ul>
                                    ${product.selectedAddons.map(addon => `<li>${addon.name} (+$${addon.price.toFixed(2)})</li>`).join('')}
                                </ul>
                                <p><strong>Add-ons Total:</strong> $${addonTotal.toFixed(2)}</p>
                            ` : '<p class="text-success"><strong>No chargeable add-ons</strong></p>'}
                        </div>
                        ${idx < freeProducts.length - 1 ? '<hr/>' : ''}
                    `;
                });

                // Calculate totals
                let originalTotal = 0;
                let paidTotal = 0;
                let freeItemsAddonTotal = 0;

                selectedProducts.forEach(product => {
                    const itemTotal = product.basePrice + product.variationPrice + product.addonPrice;
                    originalTotal += itemTotal;

                    if (product.role === 'paid_item' || product.role === 'bundle_item') {
                        paidTotal += itemTotal;
                    } else {
                        // For free items, only count addon price
                        freeItemsAddonTotal += product.addonPrice;
                    }
                });

                const bundleTotal = paidTotal + freeItemsAddonTotal;
                const savings = originalTotal - bundleTotal;

                // Build the complete display HTML
                const displayHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-3">Paid & Bundle Items</h4>
                            ${leftColumnHTML || '<p class="text-muted">No paid items selected</p>'}
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-3">Free Items</h4>
                            ${rightColumnHTML || '<p class="text-muted">No free items selected</p>'}
                        </div>
                    </div>
                    <hr style="border: 2px solid #333; margin: 20px 0;"/>

                `;

                $('#priceBreakdown').html(displayHTML);
            }
        });

        function tab_section_change() {
            const value = document.getElementById("bundle_offer_type").value;

            // dono panels
            const panels = [document.getElementById("panel1"), document.getElementById("panel2")];

            // ⭐ PEHLE SAB RESET KARO - YE NAYA CODE HAI
            resetAllSelections();

            // pehle sab hide karo
            function hideAll(panel) {
                panel.querySelectorAll(".bundle_div, .bogo_free_div, .buy_x_get_y_div, .mix_match_div")
                    .forEach(div => div.style.display = "none");
            }

            panels.forEach(panel => {
                if (!panel) return;

                // sab hide kardo
                hideAll(panel);

                // ab switch chalao
                switch (value) {
                    case "bundle":
                        panel.querySelectorAll(".bundle_div").forEach(div => div.style.display = "block");
                        setupRoleSelect("bundle");
                        break;

                    case "bogo_free":
                        panel.querySelectorAll(".bogo_free_div").forEach(div => div.style.display = "block");
                        setupRoleSelect("bogo_free");
                        break;

                    case "buy_x_get_y":
                        panel.querySelectorAll(".buy_x_get_y_div").forEach(div => div.style.display = "block");
                        setupRoleSelect("buy_x_get_y");
                        break;

                    case "mix_match":
                        panel.querySelectorAll(".mix_match_div").forEach(div => div.style.display = "block");
                        setupRoleSelect("mix_match");
                        break;

                    default:
                        // agar koi value na ho to kuch bhi mat show karo
                        break;
                }
            });
        }

        /**
         * Product Role dropdown adjuster
         */
        function setupRoleSelect(type) {
            document.querySelectorAll(".product-role-select").forEach(select => {
                select.innerHTML = ""; // sab options reset kar do

                if (type === "bogo_free" || type === "buy_x_get_y") {
                    // Paid aur Free dono options
                    select.innerHTML = `
                        <option value="paid_item" selected>Paid Item</option>
                        <option value="free_item">Free Item</option>
                    `;
                    select.style.display = "inline-block"; // show
                } else {
                    // sirf Bundle Item
                    select.innerHTML = `
                        <option value="bundle_item" selected>Bundle Item</option>
                    `;
                    select.style.display = "inline-block"; // visible rahega
                }
            });
        }

        /**
         * ⭐ YE NAYA FUNCTION - SAB SELECTIONS RESET KARTA HAI
         */
        function resetAllSelections() {
            // 1. jQuery selectedProducts array ko khali karo (agar tumhara code use kar raha ho)
            if (typeof selectedProducts !== 'undefined') {
                selectedProducts = [];
            }

            // 2. Sab selected product divs ko hide karo
            $('[id^="selectedProducts_"]').each(function() {
                $(this).addClass('d-none').hide();
            });

            // 3. Sab available product cards ko wapis show karo
            $('.product-card[data-id]').each(function() {
                $(this).show();
            });

            // 4. Sab variations ki selection hatao
            $('.variation-option').removeClass('selected');

            // 5. Sab addon checkboxes uncheck karo
            $('.addon-checkbox').prop('checked', false);
            $('.addon-item').removeClass('selected');

            // 6. Sab product role selects ko reset karo
            $('.product-role-select').val('paid_item');

            // 7. Price calculator hide karo
            $('#priceCalculator').hide();
            $('#priceBreakdown').html('');

            // 8. Available products section hide karo
            $('#availableProducts').hide();

            // 9. Item totals ko reset karo
            // $('div[style*="Item Total"]').each(function() {
            //     const parentDiv = $(this).closest('[id^="selectedProducts_"]');
            //     const basePriceText = parentDiv.find('.product-price').first().text();
            //     const basePrice = parseFloat(basePriceText.replace('Base Price: $', '').replace('$', '')) || 0;
            //     $(this).html(`Item Total: $${basePrice.toFixed(2)}`);
            // });

            // 10. "No products added yet" message wapis lao (agar hai to)
            const noProductsMsg = '<p style="text-align: center; color: #666; padding: 20px;">No products added yet. Click "Add Product to Bundle" to start.</p>';
            if ($('#selectedProducts').length && $('#selectedProducts').children().length === 0) {
                $('#selectedProducts').html(noProductsMsg);
            }

            console.log('✅ All selections reset successfully!');
        }

        // ⭐ Page load par bundle_offer_type change event listener lagao
        $(document).ready(function() {
            $('#bundle_offer_type').on('change', function() {
                tab_section_change();
            });

            // Optional: Agar koi manual reset button banana ho
            $('#resetBundleBtn').on('click', function() {
                resetAllSelections();
            });
        });

    </script>
@endpush
