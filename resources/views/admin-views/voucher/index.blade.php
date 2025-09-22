@extends('layouts.admin.app')

@section('title', translate('messages.add_new_item'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush
  <style>
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

            <!-- Step 1: Select Voucher Type -->


            <div class="section-card rounded p-4 mb-4">
                <h2 class="fw-semibold h5 mb-4">🎯 Step 1: Select Voucher Type</h2>
                <div class="row g-3">
                @php $i = 1; @endphp
                @foreach (\App\Models\VoucherType::orderBy('name')->get() as $voucherType)
                    <div class="col-md-3">
                        <div class="voucher-card border rounded p-4 text-center h-100"
                            onclick="section_one('{{ $i }}' , '{{ $voucherType->id }}')"
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

                    {{-- <div class="col-md-4">
                        <div class="voucher-card border rounded p-4 text-center h-100"
                            onclick="section_one('1')"
                            data-value="Delivery">
                            <div class="display-4 mb-2">🚚</div>
                            <h6 class="fw-semibold">Delivery/Pickup</h6>
                            <small class="text-muted">E-commerce style vouchers with cart functionality</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="voucher-card border rounded p-4 text-center h-100"
                        onclick="section_one('2')"
                        data-value="Store">
                        <div class="display-4 mb-2">🏪</div>
                        <h6 class="fw-semibold">In-Store</h6>
                        <small class="text-muted">Instant purchase with QR/Barcode redemption</small>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="voucher-card border rounded p-4 text-center h-100"
                        onclick="section_one('3')"
                        data-value="Discount">
                        <div class="display-4 mb-2">💵</div>
                        <h6 class="fw-semibold">Flat Discount</h6>
                        <small class="text-muted">Percentage-based discount on bill amount</small>
                    </div>
                    </div> --}}
                </div>
            </div>

            <!-- Step 2: Select Management Type -->
            <div class="section-card rounded p-4 mb-4" id="management_selection">
                <h2 class="fw-semibold h5 mb-4">⚙️ Step 2: Select Management Type</h2>
                <div class="row g-3" id="append_all_data">
                    {{-- <div class="col-md-3">
                        <div class="voucher-card_2 border rounded p-4 text-center h-100" onclick="section_second('4')">
                            <div class="display-4 mb-2">🛒</div>
                            <h6 class="fw-semibold">Shop</h6>
                            <small class="text-muted">General retail products management</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="voucher-card_2 border rounded p-4 text-center h-100" onclick="section_second('5')">
                            <div class="display-4 mb-2">💊</div>
                            <h6 class="fw-semibold">Pharmacy</h6>
                            <small class="text-muted">Medicine and health products</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="voucher-card_2 border rounded p-4 text-center h-100" onclick="section_second('6')">
                            <div class="display-4 mb-2">🛒</div>
                            <h6 class="fw-semibold">Grocery</h6>
                            <small class="text-muted">Food and daily essentials</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="voucher-card_2 border rounded p-4 text-center h-100" onclick="section_second('7')">
                            <div class="display-4 mb-2">🍽️</div>
                            <h6 class="fw-semibold">Food</h6>
                            <small class="text-muted">Restaurant and food delivery</small>
                        </div>
                    </div> --}}
                </div>
            </div>

        <form action="javascript:" method="post" id="item_form" enctype="multipart/form-data">
            @csrf
            @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
            @php($language = $language->value ?? null)
            @php($defaultLang = str_replace('_', '-', app()->getLocale()))

            <!-- Basic Information  same-->
            <div class="section-card rounded p-4 mb-4 d-none section3 one_four_complete" id="basic_info">
                <h3 class="h5 fw-semibold mb-4"> Basic Information</h3>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                      <div class="form-group">
                            <label class="input-label"
                                for="default_name">{{ translate('Client App Name') }}
                            </label>
                            <input type="text" name="name[]" id="default_name"  class="form-control" placeholder="{{ translate('Client App Name') }}" >
                        </div>
                    </div>
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
            <!--  Store & Category Info same -->
            <div class="section-card rounded p-4 mb-4 d-none section3" id="discount_store_category">
                <h3 class="h5 fw-semibold mb-4">🏪 Store & Category Info</h3>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Partner Store <span class="text-danger">*</span></label>
                        <select class="form-select form-control">
                            <option>Select partner store</option>
                            <option>Teh Kotjok - SGC Cikarang</option>
                            <option>McDonald's Riyadh</option>
                            <option>Burger King Jeddah</option>
                            <option>Pizza Hut Dammam</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-control">
                            <option>Select category</option>
                            <option>Restaurant</option>
                            <option>Cafe</option>
                            <option>Fast Food</option>
                            <option>Fine Dining</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Service Type</label>
                        <select class="form-select form-control">
                            <option>Dine In Only</option>
                            <option>Delivery Only</option>
                            <option>Dine In & Delivery</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Location/Branch</label>
                        <select class="form-select form-control">
                            <option>All Branches</option>
                            <option>Specific Branch</option>
                            <option>Multiple Selected Branches</option>
                        </select>
                    </div>
                </div>
            </div>


            <!-- Discount Settings -->
            <div class="section-card rounded p-4 mb-4 d-none section3" id="discount_settings">
                <h3 class="h5 fw-semibold mb-4">💰 Discount Configuration</h3>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Discount Type <span class="text-danger">*</span></label>
                        <select class="form-select form-control">
                            <option>Percentage (%)</option>
                            <option>Fixed Amount (SAR)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Ex: 15" step="0.01">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Minimum Bill Amount (SAR) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" placeholder="Ex: 20000" step="0.01">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Maximum Discount Cap (SAR)</label>
                        <input type="number" class="form-control" placeholder="Leave empty for unlimited" step="0.01">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Valid Until Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" value="2025-12-31">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Usage Limit per User</label>
                        <input type="number" class="form-control" placeholder="Ex: 1 (leave empty for unlimited)">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="no-discount-cap" checked>
                            <label class="form-check-label" for="no-discount-cap">No discount cap (like Grab example)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="unlimited-redemptions" checked>
                            <label class="form-check-label" for="unlimited-redemptions">Unlimited redemptions</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="stackable-offers">
                            <label class="form-check-label" for="stackable-offers">Check with outlet if stackable with other offers</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="anytime-redemption" checked>
                            <label class="form-check-label" for="anytime-redemption">Redeemable anytime during opening hours</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Store Category Info -->
            <div class="section-card rounded p-4 mb-4 d-none section3 one_four_complete two_four_complete" id="store_category">
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

                        {{-- <div class="col-sm-6 col-lg-3" id="maximum_cart_quantity">
                            <div class="form-group mb-0">
                                <label class="input-label"
                                    for="maximum_cart_quantity">{{ translate('messages.Maximum_Purchase_Quantity_Limit') }}
                                    <span
                                    class="input-label-secondary text--title" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="{{ translate('If_this_limit_is_exceeded,_customers_can_not_buy_the_item_in_a_single_purchase.') }}">
                                    <i class="tio-info-outined"></i>
                                </span>
                                </label>
                                <input type="number"  placeholder="{{ translate('messages.Ex:_10') }}" class="form-control" name="maximum_cart_quantity" min="0" id="cart_quantity">
                            </div>
                        </div> --}}
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
                 {{-- Store & Category Info --}}


                {{--
                <!-- Shop Fields -->
                <div class="d-none" id="shop-category-fields">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Store <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select store</option>
                                <option>Main Store</option>
                                <option>Branch 1</option>
                                <option>Branch 2</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select category</option>
                                <option>Electronics</option>
                                <option>Fashion</option>
                                <option>Home & Garden</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sub Category</label>
                            <select class="form-select form-control">
                                <option>Select sub category</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Brand</label>
                            <select class="form-select form-control">
                                <option>Select brand</option>
                                <option>Brand A</option>
                                <option>Brand B</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Pharmacy Fields -->
                <div class="d-none" id="pharmacy-category-fields">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Store <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select store</option>
                                <option>Main Pharmacy</option>
                                <option>Branch Pharmacy</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select category</option>
                                <option>Prescription Medicine</option>
                                <option>Over Counter</option>
                                <option>Health Products</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sub Category</label>
                            <select class="form-select form-control">
                                <option>Select sub category</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Suitable For</label>
                            <select class="form-select form-control">
                                <option>Select Condition</option>
                                <option>Adults</option>
                                <option>Children</option>
                                <option>Elderly</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Unit</label>
                            <select class="form-select form-control">
                                <option>Kg</option>
                                <option>Piece</option>
                                <option>Box</option>
                                <option>Bottle</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Grocery Fields -->
                <div class="d-none" id="grocery-category-fields">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Store <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select store</option>
                                <option>Main Grocery</option>
                                <option>Supermarket Branch</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select category</option>
                                <option>Fresh Produce</option>
                                <option>Dairy</option>
                                <option>Packaged Foods</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sub Category</label>
                            <select class="form-select form-control">
                                <option>Select sub category</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Unit</label>
                            <select class="form-select form-control">
                                <option>Kg</option>
                                <option>Piece</option>
                                <option>Package</option>
                                <option>Liter</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Food Fields -->
                <div class="d-none" id="food-category-fields">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Store <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select store</option>
                                <option>Main Restaurant</option>
                                <option>Food Court</option>
                                <option>Delivery Kitchen</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Select category</option>
                                <option>Main Dishes</option>
                                <option>Appetizers</option>
                                <option>Desserts</option>
                                <option>Beverages</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sub Category</label>
                            <select class="form-select form-control">
                                <option>Select sub category</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Item Type <span class="text-danger">*</span></label>
                            <select class="form-select form-control">
                                <option>Non veg</option>
                                <option>Veg</option>
                                <option>Halal</option>
                            </select>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!-- Shop Management Settings -->
            <div class="section-card rounded p-4 mb-4 d-none section" id="shop_fields">
                <h3 class="h5 fw-semibold mb-4">🛒 Shop Management Settings</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Maximum Purchase Quantity Limit</label>
                        <input type="number" class="form-control" placeholder="Ex: 10">
                    </div>
                </div>
            </div>
            <!-- Pharmacy Management Fields -->
            <div class="section-card rounded p-4 mb-4 d-none section one_four_complete" id="pharmacy_fields">
                <h3 class="h5 fw-semibold mb-4">💊 Pharmacy Management Settings</h3>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Maximum Purchase Quantity Limit</label>
                        <input type="number" class="form-control" placeholder="Ex: 10">
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="is-basic-medicine">
                        <label class="form-check-label" for="is-basic-medicine">Is Basic Medicine</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is-prescription-required">
                        <label class="form-check-label" for="is-prescription-required">Is prescription required</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Generic name</label>
                    <input type="text" class="form-control" placeholder="Enter generic name">
                </div>
            </div>
            <!-- Grocery Management Fields -->
            <div class="section-card rounded p-4 mb-4 d-none section" id="grocery_fields">
                <h3 class="h5 fw-semibold mb-4">🛒 Grocery Management Settings</h3>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nutrition</label>
                        <textarea class="form-control" rows="4" placeholder="Type your content and press enter"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Allergen Ingredients</label>
                        <textarea class="form-control" rows="4" placeholder="Type your content and press enter"></textarea>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Maximum Purchase Quantity Limit</label>
                        <input type="number" class="form-control" placeholder="Ex: 10">
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is-organic">
                            <label class="form-check-label" for="is-organic">Is organic</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is-halal">
                            <label class="form-check-label" for="is-halal">Is It Halal</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Food Management Fields -->
            <div class="section-card rounded p-4 mb-4 d-none section" id="food_fields">
                <h3 class="h5 fw-semibold mb-4">Voucher Details</h3>

                {{-- <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nutrition</label>
                        <textarea class="form-control" rows="4" placeholder="Type your content and press enter"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Allergen Ingredients</label>
                        <textarea class="form-control" rows="4" placeholder="Type your content and press enter"></textarea>
                    </div>
                </div> --}}

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

                    {{-- <div class="form-group">
                        <h3 class="h5 fw-semibold "> {{ translate('Food Add One') }}</h3>
                        <input type="text" class="form-control" name="food_add_one" placeholder="{{translate('Search Food Add One')}}" data-role="tagsinput">
                    </div> --}}
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

                <!-- Addon Section -->
                {{-- <div class="border-top pt-4 mb-4">
                    <h4 class="h6 fw-semibold mb-3">🧩 Addon</h4>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Addon</label>
                        <select class="form-select form-control">
                            <option>Select addon</option>
                            <option>Extra Cheese</option>
                            <option>Extra Sauce</option>
                        </select>
                    </div>
                </div> --}}

                <!-- Time Schedule Section -->
                {{-- <div class="border-top pt-4 mb-4">
                    <h4 class="h6 fw-semibold mb-3">⏰ Time Schedule</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Available time starts</label>
                            <input type="time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Available time ends</label>
                            <input type="time" class="form-control">
                        </div>
                    </div>
                </div> --}}

                <!-- Food Variations Section -->
                {{-- <div class="border-top pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="h6 fw-semibold mb-0">🔄 Food Variations</h4>
                        <button type="button" class="btn btn-primary btn-sm">Add new variation +</button>
                    </div>
                    <div class="text-center text-muted">
                        <div class="display-1 mb-2">📦</div>
                        <div>No variation added</div>
                    </div>
                </div> --}}
            </div>

            <!-- Price Information  same-->
            <div class="section-card rounded p-4 mb-4 d-none section one_four_complete two_four_complete" id="price_info">
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
                            {{-- <div class="col-sm-{{ Config::get('module.current_module_type') == 'food' ? '4' :'3' }} col-6">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('messages.discount_type') }} <span class="form-label-secondary text-danger"
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
                                        <option value="percent">{{ translate('messages.percent') }} (%)</option>
                                        <option value="fixed">{{ translate('Fixed') }} ({{ \App\CentralLogics\Helpers::currency_symbol() }})
                                        <option value="cash back">{{ translate('Cash Back') }}
                                        </option>
                                    </select>
                                </div>
                            </div> --}}

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

             <div class="section-card rounded p-4 mb-4 d-none section3 two_four_complete" id="how_it_work">
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
            <div class="section-card rounded p-4 mb-4  section3  d-none" id="term_condition">
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
            <div class="section-card rounded p-4 mb-4 section3 d-none" id="review_submit">
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


            <!-- Voucher Behavior Settings same-->
            {{-- <div class="section-card rounded p-4 mb-4 d-none section3 two_four_complete" id="voucher_behavior">
                <h3 class="h5 fw-semibold mb-4">⚙️ Voucher Behavior Settings</h3>

                <!-- Delivery/Pickup Specific -->
                <div id="delivery-behavior">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enable-cart">
                                <label class="form-check-label" for="enable-cart">Enable Cart Functionality</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enable-tracking">
                                <label class="form-check-label" for="enable-tracking">Enable Order Tracking</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allow-scheduled">
                                <label class="form-check-label" for="allow-scheduled">Allow Scheduled Delivery</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Delivery Areas</label>
                            <select class="form-select form-control" multiple>
                                <option>Central Riyadh</option>
                                <option>North Riyadh</option>
                                <option>East Riyadh</option>
                                <option>West Riyadh</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Delivery Fee (SAR)</label>
                            <input type="number" class="form-control" placeholder="Ex: 15">
                        </div>
                    </div>
                </div>

                <!-- In-Store Specific -->
                <div class="d-none" id="instore-behavior">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">QR Code Type</label>
                            <select class="form-select form-control">
                                <option>Dynamic QR</option>
                                <option>Static QR</option>
                                <option>QR + Barcode</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Redemption Method</label>
                            <select class="form-select form-control">
                                <option>Scan to Redeem</option>
                                <option>Code Entry</option>
                                <option>Both</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="instant-redeem">
                                <label class="form-check-label" for="instant-redeem">Allow Instant Redemption</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="partial-redeem">
                                <label class="form-check-label" for="partial-redeem">Allow Partial Redemption</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="buy-now-only">
                                <label class="form-check-label" for="buy-now-only">Buy Now Only (No Cart)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Discount Behavior -->
                <div id="discount-behavior">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Discount Type</label>
                            <select class="form-select form-control">
                                <option>Percentage (%)</option>
                                <option>Fixed Amount (SAR)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Discount Value</label>
                            <input type="number" class="form-control" placeholder="Ex: 15">
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Minimum Bill Amount (SAR)</label>
                            <input type="number" class="form-control" placeholder="Ex: 20000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Maximum Discount Cap (SAR)</label>
                            <input type="number" class="form-control" placeholder="Leave empty for no cap">
                        </div>
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="cashless-only" checked disabled>
                                <label class="form-check-label" for="cashless-only">Cashless Payment Only (Required)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bill-calculator" checked>
                                <label class="form-check-label" for="bill-calculator">Enable Bill Calculator Interface</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="auto-calculation">
                                <label class="form-check-label" for="auto-calculation">Auto Calculate Discounted Amount</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="show-breakdown">
                                <label class="form-check-label" for="show-breakdown">Show Payment Breakdown</label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="border-top pt-4 mb-4">
                        <h4 class="h6 fw-semibold mb-3">💳 Allowed Payment Methods (Cashless Only)</h4>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="credit-debit-cards" checked>
                                    <label class="form-check-label" for="credit-debit-cards">Credit/Debit Cards (Visa, MasterCard, Mada)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="apple-pay" checked>
                                    <label class="form-check-label" for="apple-pay">Apple Pay</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wallet-payment" checked>
                                    <label class="form-check-label" for="wallet-payment">Digital Wallet</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="bank-transfer">
                                    <label class="form-check-label" for="bank-transfer">Bank Transfer</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="stc-pay">
                                    <label class="form-check-label" for="stc-pay">STC Pay</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Voucher Display Settings -->
                    <div class="border-top pt-4 mb-4">
                        <h4 class="h6 fw-semibold mb-3">🎨 Voucher Display Settings</h4>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Display Title Template</label>
                                <input type="text" class="form-control" value="{discount}% off total bill">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Subtitle Template</label>
                                <input type="text" class="form-control" value="SAR{minimum} minimum spend">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Cashless Payment Notice</label>
                            <textarea class="form-control" rows="2">Cashless Payment Only - Credit/Debit Cards, Apple Pay, and Digital Wallet accepted</textarea>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-partner-logo" checked>
                                    <label class="form-check-label" for="show-partner-logo">Show Partner Logo on Voucher</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-cashless-badge" checked>
                                    <label class="form-check-label" for="show-cashless-badge">Show "Cashless Only" Badge</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bill Input Settings -->
                    <div class="border-top pt-4">
                        <h4 class="h6 fw-semibold mb-3">🧮 Bill Input Interface Settings</h4>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Bill Input Label</label>
                                <input type="text" class="form-control" value="Enter amount on receipt">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Currency Symbol</label>
                                <select class="form-select form-control">
                                    <option>SAR</option>
                                    <option>USD</option>
                                    <option>AED</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Number Pad Style</label>
                                <select class="form-select form-control">
                                    <option>Full Screen Calculator</option>
                                    <option>Compact Keyboard</option>
                                    <option>Native Input</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Decimal Places</label>
                                <select class="form-select form-control">
                                    <option>0</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show-calculation-preview" checked>
                                    <label class="form-check-label" for="show-calculation-preview">Show Real-time Calculation Preview</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="highlight-savings">
                                    <label class="form-check-label" for="highlight-savings">Highlight Savings Amount</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- Usage Terms & Conditions same-->
            {{-- <div class="section-card rounded p-4 mb-4 d-none section3 one_four_complete two_four_complete" id="usage_terms">
                <h3 class="h5 fw-semibold mb-4">📋 Usage Terms & Conditions</h3>
                <div class="row g-2 mb-4">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="valid-in-store">
                            <label class="form-check-label" for="valid-in-store">Valid in-store only</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="redeem-schedule">
                            <label class="form-check-label" for="redeem-schedule">Redeem on Mon–Sun 10:00am – 10:00pm. Including public holidays</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="valid-30-days">
                            <label class="form-check-label" for="valid-30-days">Valid for 30 days after purchase</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="one-per-bill">
                            <label class="form-check-label" for="one-per-bill">Limited to 1 voucher per bill</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="non-refundable">
                            <label class="form-check-label" for="non-refundable">Non-refundable</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="unlimited-purchase">
                            <label class="form-check-label" for="unlimited-purchase">Unlimited purchase for user</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="prior-booking">
                            <label class="form-check-label" for="prior-booking">Prior booking is required</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="no-holidays">
                            <label class="form-check-label" for="no-holidays">Offers does not include official holidays</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="no-ramadan">
                            <label class="form-check-label" for="no-ramadan">Offers does not include Ramadan</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="included-brands">
                            <label class="form-check-label" for="included-brands">Included brands</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="higher-price-apply">
                            <label class="form-check-label" for="higher-price-apply">The higher price will apply if the products do not match</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="redeemable-branches">
                            <label class="form-check-label" for="redeemable-branches">Redeemable at 4 branches</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Valid Until Date</label>
                        <input type="date" class="form-control" value="2025-12-31">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Usage Limit per User</label>
                        <input type="number" class="form-control" placeholder="Ex: 1">
                    </div>
                </div>
            </div> --}}
            <!-- Attributes same-->
            {{-- <div class="section-card rounded p-4 mb-4 d-none section one_four_complete two_four_complete" id="attributes">
                <h3 class="h5 fw-semibold mb-4">🏷️ {{ translate('attribute') }}</h3>

            <div class="row g-2">

                <div class="col-md-12" id="attribute_section">
                    <div class="c border-0">
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
            </div> --}}
            <!-- Tags same-->
            {{-- <div class="section-card rounded p-4 mb-4 d-none section3 two_four_complete" id="tags">
                <h3 class="h5 fw-semibold mb-4">🏷️ {{ translate('tags') }}</h3>
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                    workHtml += "<li>" + item.title + "</li>";
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
                            ${term.name}
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


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const managementSelection = document.querySelectorAll('#management_selection');
            const voucherCards = document.querySelectorAll('.voucher-card');
            const voucherCards2 = document.querySelectorAll('.voucher-card_2');
            // Get all elements by ID
            const basic_info = document.getElementById('basic_info');
            const discount_store_category = document.getElementById('discount_store_category');
            const discount_settings = document.getElementById('discount_settings');
            const store_category = document.getElementById('store_category');
            const shop_fields = document.getElementById('shop_fields');
            const pharmacy_fields = document.getElementById('pharmacy_fields');
            const grocery_fields = document.getElementById('grocery_fields');
            const food_fields = document.getElementById('food_fields');
            const price_info = document.getElementById('price_info');
            const voucher_behavior = document.getElementById('voucher_behavior');
            const usage_terms = document.getElementById('usage_terms');
            const attributes = document.getElementById('attributes');
            const tags = document.getElementById('tags');
            const how_it_work = document.getElementById('how_it_work');
            const term_condition = document.getElementById('term_condition');
            const review_submit = document.getElementById('review_submit');

            function section_one(loopIndex, primaryId) {

                getDataFromServer(primaryId)
                // اگر hidden input میں primary id رکھنی ہے:
                document.getElementById('hidden_value').value = loopIndex;
                managementSelection.forEach(el => {
                    if (loopIndex === "1" || loopIndex === "2") {
                        submit_voucher_type(loopIndex,primaryId); // اب اصل primary id pass کر رہے ہیں
                        el.classList.remove('d-none');
                        // Hide discount-specific sections
                        [basic_info, discount_store_category, discount_settings, store_category, voucher_behavior, usage_terms, tags].forEach(el => {
                            if (el) el.classList.add('d-none');
                        });

                    } else if (loopIndex === "3") {
                        submit_voucher_type(loopIndex,primaryId);
                        el.classList.add('d-none');

                        // Show discount-specific sections
                        [basic_info, discount_store_category, discount_settings, store_category, voucher_behavior, usage_terms, tags].forEach(el => {
                            if (el) el.classList.remove('d-none');
                        });
                    }
                });
            }
            function section_second(value_two) {
                const hidden_value = document.getElementById('hidden_value').value;
                // Convert to strings for proper comparison
                const hiddenVal = String(hidden_value);
                const valueTwo = String(value_two);
                // Get all elements
                const basic_info = document.getElementById('basic_info');
                const discount_store_category = document.getElementById('discount_store_category');
                const discount_settings = document.getElementById('discount_settings');
                const store_category = document.getElementById('store_category');
                const shop_fields = document.getElementById('shop_fields');
                const pharmacy_fields = document.getElementById('pharmacy_fields');
                const grocery_fields = document.getElementById('grocery_fields');
                const food_fields = document.getElementById('food_fields');
                const price_info = document.getElementById('price_info');
                const voucher_behavior = document.getElementById('voucher_behavior');
                const usage_terms = document.getElementById('usage_terms');
                const attributes = document.getElementById('attributes');
                const tags = document.getElementById('tags');
                const how_it_work = document.getElementById('how_it_work');
                const term_condition = document.getElementById('term_condition');
                const review_submit = document.getElementById('review_submit');
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

                // Main logic based on voucher type and management type
                switch (hiddenVal) {
                    case "1": // Delivery/Pickup
                        switch (valueTwo) {
                            case "4": // Shop + Delivery
                                showElements([basic_info, store_category, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, shop_fields, pharmacy_fields, grocery_fields, food_fields]);
                                showShopFields();
                                break;

                            case "5": // Pharmacy + Delivery
                                showElements([basic_info, store_category, pharmacy_fields, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, shop_fields, grocery_fields, food_fields]);
                                showPharmacyFields();
                                break;

                            case "6": // Grocery + Delivery
                                showElements([basic_info, store_category, grocery_fields, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, shop_fields, pharmacy_fields, food_fields]);
                                showGroceryFields();
                                break;

                            case "7": // Food + Delivery
                                showElements([basic_info, store_category, food_fields, price_info, voucher_behavior, usage_terms, attributes, tags,how_it_work,term_condition,review_submit]);
                                hideElements([discount_store_category, discount_settings, shop_fields, pharmacy_fields, grocery_fields]);
                                showFoodFields();
                                break;
                        }
                        break;

                    case "2": // In-Store
                        switch (valueTwo) {
                            case "4": // Shop + In-Store
                                showElements([basic_info, store_category, shop_fields, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, pharmacy_fields, grocery_fields, food_fields]);
                                showShopFields();
                                break;

                            case "5": // Pharmacy + In-Store
                                showElements([basic_info, store_category, pharmacy_fields, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, shop_fields, grocery_fields, food_fields]);
                                showPharmacyFields();
                                break;

                            case "6": // Grocery + In-Store
                                showElements([basic_info, store_category, grocery_fields, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, shop_fields, pharmacy_fields, food_fields]);
                                showGroceryFields();
                                break;

                            case "7": // Food + In-Store
                                showElements([basic_info, store_category, food_fields, price_info, voucher_behavior, usage_terms, attributes, tags]);
                                hideElements([discount_store_category, discount_settings, shop_fields, pharmacy_fields, grocery_fields]);
                                showFoodFields();
                                break;
                        }
                        break;

                    case "3": // Flat Discount
                        if (valueTwo === "4") {
                            showElements([basic_info, discount_store_category, discount_settings, voucher_behavior, usage_terms, tags]);
                            hideElements([store_category, shop_fields, pharmacy_fields, grocery_fields, food_fields, price_info, attributes]);
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
            // Highlight selected voucher-card
            voucherCards.forEach(card => {
                card.addEventListener('click', function () {
                    voucherCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            // Highlight selected management voucher-card
            // voucherCards2.forEach(card => {
            //     card.addEventListener('click', function () {
            //         voucherCards2.forEach(c => c.classList.remove('selected'));
            //         this.classList.add('selected');
            //     });
            // });
            // Make functions globally accessible
            window.section_one = section_one;
            window.section_second = section_second;
        });
    </script>

    <script>
        function submit_voucher_type(loopIndex,id) {
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
                    let index = 4;
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


@endpush
