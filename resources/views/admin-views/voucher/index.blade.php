@extends('layouts.admin.app')

@section('title', translate('messages.add_new_item'))
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

<style>
#selectedItemsSection .badge {
    font-size: 0.9rem;
    padding: 0.4rem 0.8rem;
}

#selectedItemsSection {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

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

                   <!-- Voucher Details  Bundle Delivery/Pickup  == Food and Product Bundle-->
                <div class="section-card rounded p-4 mb-4  " id="bundel_food_voucher_fields_1_3_1_4">
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
                         {{-- images --}}
                    <div class="row g-3">
                        <div class="col-12" >
                            @include("admin-views.voucher.include_images")
                        </div>
                    </div>
                    {{-- images  --}}
                    <div class="row g-3">
                        <div class="mb-3 col-12 ">
                            <label class="form-label fw-medium">Short Description (Default) <span class="text-danger">*</span></label>
                            <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                        </div>
                    </div>
                    {{-- Bundle Type Selection --}}
                    <div class="col-12 col-md-12">
                        <div class="form-group mb-0">
                            <h3 class="h5 fw-semibold mb-2"> {{ translate('Bundle Type Selection') }}</h3>
                            <select name="bundle_offer_type" id="bundle_offer_type" class="form-control" onchange="tab_section_change()">
                                <option value="">Select Bundle Offer Type</option>
                                <option value="simple" {{ old('simple') == 'simple' ? 'selected' : '' }}>
                                    Simple
                                </option>
                                <option value="bundle" {{ old('bundle_offer_type') == 'bundle' ? 'selected' : '' }}>
                                    Fixed Bundle - Specific products at set price
                                </option>
                                <option value="bogo_free" {{ old('bundle_offer_type') == 'bogo_free' ? 'selected' : '' }}>
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

                                        {{-- <div class="col-sm-12 col-lg-12">
                                              <div class="form-group">
                                                <label class="input-label" for="select_pro">{{ translate('Bundle Products') }}
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Bundle Products') }}"></span>
                                                </label>
                                                <select name="select_pro[]" id="select_pro" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" >

                                                </select>
                                            </div>
                                        </div> --}}
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
                            <div class="card border-0 shadow-sm">
                                <!-- BOGO Configuration -->
                                <div class="p-3 bg-white mb-4">
                                    <h4 class="mb-3"> BOGO Configuration</h4>
                                    <div class="row">
                                        {{-- <div class="col-sm-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="input-label" for="select_bogo_product">{{ translate('BOGO Product') }}
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('BOGO Product') }}"></span>
                                                </label>
                                                <select name="select_bogo_product[]" id="select_bogo_product" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>

                                                </select>
                                            </div>
                                        </div> --}}
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

                        <div class="row g-3 mix_match_div" style="display:none;">
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
                                        {{-- <div class="col-sm-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="input-label" for="select_available_pro">{{ translate('Available Products') }}
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Available Products') }}"></span>
                                                </label>
                                                <select name="select_available_pro[]" id="select_available_pro" required class="form-control js-select2-custom all_product_list" data-placeholder="{{ translate('Select Product') }}" multiple>
                                                </select>
                                            </div>
                                        </div> --}}
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

               {{-- Bundle Products Configuration --}}
                <div class=" section-card rounded p-4 mb-4   "  id="Bundle_products_configuration">
                    <h3 class="h5 fw-semibold mb-2"> {{ translate('Bundle Products Configuration') }}</h3>
                    <div id="selectedProducts">
                        <p style="text-align: center; color: #666; padding: 20px;">No products added yet. Click "Add Product to Bundle" to start.</p>
                    </div>
                    <button type="button" class="btn btn--primary" id="addProductBtn">+ Add Product to Bundle</button>
                    <!-- Available Products to Choose From -->
                    <div id="availableProducts" style="display: none;">
                        <h3 class="mt-3">Available Products:</h3>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <select name="select_pro" id="select_pro" class="form-control js-select2-custom" data-placeholder="{{ translate('Select Product') }}" >
                                        <option value="" disabled selected>{{ translate('Select a Product') }}</option>
                                        @foreach (\App\Models\Item::whereIn('food_and_product_type', ['Food','Product'])->get() as $item)
                                            @php(
                                                $variations = json_decode($item->variations, true) ?? []
                                            )
                                            @php(
                                                $addonIds = json_decode($item->add_ons, true) ?? []
                                            )
                                            @php(
                                                $addonDetails = []
                                            )
                                            @if(!empty($addonIds))
                                                @foreach($addonIds as $addonId)
                                                    @php(
                                                        $addon = \App\Models\AddOn::find($addonId)
                                                    )
                                                    @if($addon)
                                                        @php(
                                                            $addonDetails[] = [
                                                                'id' => $addon->id,
                                                                'name' => $addon->name,
                                                                'price' => $addon->price
                                                            ]
                                                        )
                                                    @endif
                                                @endforeach
                                            @endif
                                            <option value="{{ $item->id }}"
                                                    data-name="{{ $item->name }}"
                                                    data-price="{{ $item->price }}"
                                                    data-variations='@json($variations)'
                                                    data-addons='@json($addonDetails)'>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Product selection area --}}
                                <div id="productDetails" class="mt-3 row "></div>

                                {{-- Selected items display section --}}
                                <div id="selectedItemsSection" class="mt-4" style="display: none;">
                                    <div class="card p-3 shadow-sm bg-light">
                                        <h5 class="mb-3">Selected Configuration</h5>

                                        <div id="selectedProductInfo" class="mb-2"></div>

                                        <div id="selectedVariationInfo" class="mb-2" style="display: none;">
                                            <strong>Selected Variation:</strong>
                                            <div id="selectedVariationDetails" class="ml-3"></div>
                                        </div>

                                        <div id="selectedAddonsInfo" class="mb-2" style="display: none;">
                                            <strong>Selected Add-ons:</strong>
                                            <div id="selectedAddonsDetails" class="ml-3"></div>
                                        </div>

                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>Final Total:</strong>
                                            <h5 class="text-success mb-0" id="finalTotalPrice">$0.00</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                   <!--  Price Information one  Bundle Delivery/Pickup  == Food and Product Bundle-->
                <div class="section-card rounded p-4 mb-4  "id="bundel_food_voucher_price_info_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4"> {{ translate('Price Information') }}</h3>
                    {{-- Price Information --}}
                    <div class="row g-2">
                        <div class="col-6 col-md-3" id="price_input_hide">
                            <div class="form-group mb-0">
                                <label class="input-label"  for="exampleFormControlInput1">{{ translate('messages.price') }} <span class="form-label-secondary text-danger"  data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.Required.')}}"> *  </span> </label>
                                <input type="number" min="0" id="price" max="999999999999.99" step="0.01" value="1" name="price" class="form-control"placeholder="{{ translate('messages.Ex:') }} 100" required>
                                <input type="hidden"  id="price_hidden"name="price_hidden" >
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
                        <div class="col-6 col-md-3" id="discount_input_hide">
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
                        <div class="col-6 col-md-3" id="discount_value_input_hide">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('Discount Value') }}
                                    </label>
                                    <input type="number" min="0" max="9999999999999999999999" value="0"
                                        name="discount" id="discount" class="form-control"
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




{{-- <script>

    $(document).ready(function() {
    // Initialize Select2
    $('#select_pro').select2({
        width: '100%',
        placeholder: 'Select a Product'
    });

    // Store selected products
    let selectedProductsArray = [];
    let productCounter = 0;

    // When "Add Product to Bundle" button is clicked
    $('#addProductBtn').on('click', function() {
        $('#availableProducts').slideToggle();
    });

    // When user selects a product
    $('#select_pro').on('change', function() {
        let selected = $(this).find('option:selected');
        let productId = selected.val();
        let productName = selected.data('name');
        let basePrice = parseFloat(selected.data('price')) || 0;
        let variations = selected.data('variations') || [];
        let addons = selected.data('addons') || [];

        if (!productId) return;

        // Get bundle offer type
        let bundleOfferType = $('#bundle_offer_type').val();

        // CONDITION 1: Simple type - only 1 product allowed
        if (bundleOfferType === 'simple') {
            // Clear previous products
            $('#productDetails .card').fadeOut(300, function() {
                $(this).remove();
            });
            selectedProductsArray = [];
        }
        // CONDITION 2: Bundle type - check for duplicates
        else {
            // Check if product is already selected (only for bundle type)
            if (selectedProductsArray.includes(productId)) {
                alert(`"${productName}" is already added to the bundle!`);
                $('#select_pro').val('').trigger('change');
                return;
            }
        }

        // Add to selected products array
        selectedProductsArray.push(productId);

        // Create product card with variations and addons
        let html = `
        <div class="card p-3 shadow-sm mb-3" data-product-temp-id="${productCounter}" data-product-id="${productId}">
            <div class="d-flex justify-content-between align-items-start">
                <h5>${productName}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-product-btn" data-temp-id="${productCounter}" data-product-id="${productId}">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </div>
            <p class="text-muted mb-2">Base Price: ${basePrice}</p>
            <input type="hidden" class="product-id" value="${productId}">
            <input type="hidden" class="product-name" value="${productName}">
            <input type="hidden" class="product-base-price" value="${basePrice}">
        `;

        // Add variations section
        if (variations && variations.length > 0) {
            html += `<div class="mt-2">
                <strong>Variations:</strong><br>`;
            variations.forEach((v, i) => {
                html += `
                    <label class="d-block small mt-1">
                        <input type="radio"
                            name="variation_${productCounter}"
                            class="variation-checkbox"
                            value="${v.type || ''}"
                            data-price="${v.price || 0}"
                            data-type="${v.type || 'Option'}">
                        ${v.type || 'Option'} - $${v.price || 0}
                        ${v.stock ? ` (Stock: ${v.stock})` : ''}
                    </label>`;
            });
            html += `</div>`;
        }

        // Add addons section
        if (addons && addons.length > 0) {
            html += `<div class="mt-3">
                <strong>Add-ons:</strong><br>`;
            addons.forEach(addon => {
                html += `
                    <label class="d-block small mt-1">
                        <input type="checkbox"
                            class="addon-checkbox"
                            value="${addon.id}"
                            data-price="${addon.price || 0}"
                            data-name="${addon.name}">
                        ${addon.name} (+$${addon.price || 0})
                    </label>`;
            });
            html += `</div>`;
        }

        // Add quantity selector
        html += `
            <div class="mt-3">
                <label><strong>Quantity:</strong></label>
                <input type="number" class="form-control product-quantity" value="1" min="1" style="width: 100px;">
            </div>
        `;

        // Product total
        html += `
            <div class="mt-3 p-2 bg-light border rounded">
                <strong>Product Total: </strong>
                <span class="product-total text-success">$${basePrice.toFixed(2)}</span>
            </div>
        </div>`;

        $('#productDetails').append(html);
        productCounter++;

        // Clear selection
        $('#select_pro').val('').trigger('change');

        // Update calculations when variations/addons/quantity change
        updateProductCalculations();
    });

    // Function to update product calculations
    function updateProductCalculations() {
        $(document).on('change', '.variation-checkbox, .addon-checkbox, .product-quantity', function() {
            let productCard = $(this).closest('.card');
            let basePrice = parseFloat(productCard.find('.product-base-price').val()) || 0;
            let quantity = parseInt(productCard.find('.product-quantity').val()) || 1;
            let total = basePrice;

            // Add variation price
            let selectedVariation = productCard.find('.variation-checkbox:checked');
            if (selectedVariation.length) {
                total += parseFloat(selectedVariation.data('price')) || 0;
            }

            // Add addon prices
            productCard.find('.addon-checkbox:checked').each(function() {
                total += parseFloat($(this).data('price')) || 0;
            });

            // Multiply by quantity
            total = total * quantity;

            // Update product total
            productCard.find('.product-total').text('$' + total.toFixed(2));

            // Update overall bundle calculation
            updateBundleTotal();
        });
    }

    // Remove product from bundle
    $(document).on('click', '.remove-product-btn', function() {
        let tempId = $(this).data('temp-id');
        let productId = $(this).data('product-id');

        // Remove from selected products array
        selectedProductsArray = selectedProductsArray.filter(id => id !== productId);

        $(`[data-product-temp-id="${tempId}"]`).fadeOut(300, function() {
            $(this).remove();
            updateBundleTotal();

            // If no products left, show placeholder
            if ($('#productDetails .card').length === 0) {
                $('#selectedProducts p').show();
            }
        });
    });

    // Update overall bundle total
    function updateBundleTotal() {
        let bundleTotal = 0;
        let productCount = 0;
        let breakdownHTML = '<h5>Bundle Price Breakdown:</h5><ul class="list-group">';

        $('#productDetails .card').each(function() {
            let productName = $(this).find('.product-name').val();
            let productTotal = parseFloat($(this).find('.product-total').text().replace('$', '')) || 0;
            let quantity = parseInt($(this).find('.product-quantity').val()) || 1;

            bundleTotal += productTotal;
            productCount++;

            // Add to breakdown
            breakdownHTML += `
                <li class="list-group-item d-flex justify-content-between">
                    <span>${productName} (x${quantity})</span>
                    <strong>$${productTotal.toFixed(2)}</strong>
                </li>`;
        });

        // Apply discount if any
        let discount = parseFloat($('#discount').val()) || 0;
        let discountType = $('#discount_type').val();
        let discountAmount = 0;

        if (discountType === 'percent') {
            discountAmount = (bundleTotal * discount) / 100;
        } else {
            discountAmount = discount;
        }

        let finalTotal = Math.max(bundleTotal - discountAmount, 0);

        breakdownHTML += `
            <li class="list-group-item">
                <strong>Subtotal: </strong>$${bundleTotal.toFixed(2)}
            </li>`;

        if (discountAmount > 0) {
            breakdownHTML += `
                <li class="list-group-item text-danger">
                    <strong>Discount (${discountType === 'percent' ? discount + '%' : '$' + discount}): </strong>
                    -$${discountAmount.toFixed(2)}
                </li>`;
        }

        breakdownHTML += `
            <li class="list-group-item bg-success text-white">
                <strong>Final Bundle Total: </strong>
                <strong>$${finalTotal.toFixed(2)}</strong>
            </li>
        </ul>`;

        // Update price calculator
        if (productCount > 0) {
            $('#priceCalculator').show();
            $('#priceBreakdown').html(breakdownHTML);
            $('#selectedProducts p').hide();
        } else {
            $('#priceCalculator').hide();
            $('#selectedProducts p').show();
        }

        // Update hidden price field
        $('#price').val(finalTotal.toFixed(2));
        $('#price_hidden').val(bundleTotal.toFixed(2));
    }

    // Update when discount changes
    $('#discount, #discount_type').on('change input', function() {
        let discount = parseFloat($('#discount').val()) || 0;
        let discountType = $('#discount_type').val();
        let bundleTotal = parseFloat($('#price_hidden').val()) || 0;

        // Validation
        if (discountType === 'percent' && discount > 100) {
            alert('Discount percentage cannot exceed 100%');
            $('#discount').val(0);
            return;
        }

        if (discountType !== 'percent' && discount > bundleTotal) {
            alert(`Discount amount ($${discount}) cannot exceed bundle total ($${bundleTotal})`);
            $('#discount').val(0);
            return;
        }

        updateBundleTotal();
    });

    // Clear products when bundle type changes
    $('#bundle_offer_type').on('change', function() {
        let bundleType = $(this).val();

        // Clear all products when switching types
        $('#productDetails .card').fadeOut(300, function() {
            $(this).remove();
        });
        selectedProductsArray = [];
        productCounter = 0;
        updateBundleTotal();

        // Show appropriate message
        // if (bundleType === 'simple') {
        //     alert('Simple mode: Only 1 product can be selected at a time.');
        // }
    });
});
</script> --}}


<script>

$(document).ready(function() {
    // Initialize Select2
    $('#select_pro').select2({
        width: '100%',
        placeholder: 'Select a Product'
    });

            // Add Product Button Click Handler


    // Store selected products
    let selectedProductsArray = [];
    let productCounter = 0;

    // On page load, check bundle type
    let bundleType = $('#bundle_offer_type').val();
    updateFieldsVisibility(bundleType);

    // When "Add Product to Bundle" button is clicked
    $('#addProductBtn').on('click', function() {

        // const addProductBtn = document.getElementById('addProductBtn');
        // if (addProductBtn) {
            // addProductBtn.addEventListener('click', function() {
                const bundleOfferType = document.getElementById('bundle_offer_type')?.value;
                const availableProducts = document.getElementById('availableProducts');

                // Check if bundle offer type is selected
                if (!bundleOfferType || bundleOfferType === "") {
                    alert("Please select a bundle offer type first!");
                    return;
                }else{
                    $('#availableProducts').slideToggle();
                }

                // Toggle available products visibility
                if (availableProducts) {
                    if (availableProducts.style.display === "none" || !availableProducts.style.display) {
                        availableProducts.style.display = "block";
                    } else {
                        availableProducts.style.display = "none";
                    }
                }
            // });
        // }

    });

    // When user selects a product
    $('#select_pro').on('change', function() {
        let selected = $(this).find('option:selected');
        let productId = selected.val();
        let productName = selected.data('name');
        let basePrice = parseFloat(selected.data('price')) || 0;
        let variations = selected.data('variations') || [];
        let addons = selected.data('addons') || [];

        if (!productId) return;

        // Get bundle offer type
        let bundleOfferType = $('#bundle_offer_type').val();

        // CONDITION 1: Simple type - only 1 product allowed
        if (bundleOfferType === 'simple') {
            // Clear previous products immediately
            $('#productDetails .card').remove();
            selectedProductsArray = [];
            productCounter = 0;

            // Reset price calculator
            $('#priceCalculator').hide();
            $('#price').val('0.00');
            $('#price_hidden').val('0.00');
        }
        // CONDITION 2: Bundle - check for duplicates
        else if (bundleOfferType === 'bundle') {
            // Check if product is already selected
            if (selectedProductsArray.includes(productId)) {
                alert(`"${productName}" is already added to the bundle!`);
                $('#select_pro').val('').trigger('change');
                return;
            }
        }
        // CONDITION 4: BOGO_FREE - only 2 products allowed
        else if (bundleOfferType === 'bogo_free') {
            // Check if already 2 products are selected
            if (selectedProductsArray.length >= 2) {
                alert('BOGO offer allows only 2 products! Please remove one product to add another.');
                $('#select_pro').val('').trigger('change');
                return;
            }
            // Check if product is already selected
            if (selectedProductsArray.includes(productId)) {
                alert(`"${productName}" is already added to the bundle!`);
                $('#select_pro').val('').trigger('change');
                return;
            }
        }
        // CONDITION 3: Mix & Match - check for duplicates
        else if (bundleOfferType === 'mix_match') {
            if (selectedProductsArray.includes(productId)) {
                alert(`"${productName}" is already added to the bundle!`);
                $('#select_pro').val('').trigger('change');
                return;
            }
        }

        // Add to selected products array
        selectedProductsArray.push(productId);

        // Create product card with variations and addons
        let html = `
        <div class="card p-3 shadow-sm mb-3  col-12 col-md-6" data-product-temp-id="${productCounter}" data-product-id="${productId}">
            <div class="d-flex justify-content-between align-items-start">
                <h5>${productName}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-product-btn" data-temp-id="${productCounter}" data-product-id="${productId}">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </div>
            <p class="text-muted mb-2">Base Price: $${basePrice.toFixed(2)}</p>
            <input type="hidden" class="product-id" value="${productId}">
            <input type="hidden" class="product-name" value="${productName}">
            <input type="hidden" class="product-base-price" value="${basePrice}">
        `;

        // Add variations section
        if (variations && variations.length > 0) {
            html += `<div class="mt-2">
                <strong>Variations:</strong><br>`;
            variations.forEach((v, i) => {
                html += `
                    <label class="d-block small mt-1">
                        <input type="checkbox"
                            name="variation_${productCounter}"
                            class="variation-checkbox"
                            value="${v.type || ''}"
                            data-price="${v.price || 0}"
                            data-type="${v.type || 'Option'}">
                        ${v.type || 'Option'} - $${v.price || 0}
                        ${v.stock ? ` (Stock: ${v.stock})` : ''}
                    </label>`;
            });
            html += `</div>`;
        }

        // Add addons section
        if (addons && addons.length > 0) {
            html += `<div class="mt-3">
                <strong>Add-ons:</strong><br>`;
            addons.forEach(addon => {
                html += `
                    <label class="d-block small mt-1">
                        <input type="checkbox"
                            class="addon-checkbox"
                            value="${addon.id}"
                            data-price="${addon.price || 0}"
                            data-name="${addon.name}">
                        ${addon.name} (+$${addon.price || 0})
                    </label>`;
            });
            html += `</div>`;
        }

        // Add quantity selector
        html += `
            <div class="mt-3">
                <label><strong>Quantity:</strong></label>
                <input type="number" class="form-control product-quantity" value="1" min="1" style="width: 100px;">
            </div>
        `;

        // Product total
        html += `
            <div class="mt-3 p-2 bg-light border rounded">
                <strong>Product Total: </strong>
                <span class="product-total text-success font-weight-bold" style="font-size: 1.2em;">$${basePrice.toFixed(2)}</span>
            </div>
        </div>`;

        $('#productDetails').append(html);
        productCounter++;

        // Clear selection
        $('#select_pro').val('').trigger('change');

        // Hide placeholder if products exist
        $('#selectedProducts p').hide();

        // Update calculations immediately
        updateBundleTotal();
    });

    // Function to update product calculations
    $(document).on('change', '.variation-checkbox, .addon-checkbox, .product-quantity', function() {
        let productCard = $(this).closest('.card');
        let basePrice = parseFloat(productCard.find('.product-base-price').val()) || 0;
        let quantity = parseInt(productCard.find('.product-quantity').val()) || 1;
        let total = basePrice;

        // Add variation price
        let selectedVariation = productCard.find('.variation-checkbox:checked');
        if (selectedVariation.length) {
            total += parseFloat(selectedVariation.data('price')) || 0;
        }

        // Add addon prices
        productCard.find('.addon-checkbox:checked').each(function() {
            total += parseFloat($(this).data('price')) || 0;
        });

        // Multiply by quantity
        total = total * quantity;

        // Update product total with animation
        productCard.find('.product-total').fadeOut(200, function() {
            $(this).text('$' + total.toFixed(2)).fadeIn(200);
        });

        // Update overall bundle calculation
        updateBundleTotal();
    });

    // Remove product from bundle
    $(document).on('click', '.remove-product-btn', function() {
        let tempId = $(this).data('temp-id');
        let productId = $(this).data('product-id');

        // Remove from selected products array
        selectedProductsArray = selectedProductsArray.filter(id => id !== productId);

        $(`[data-product-temp-id="${tempId}"]`).fadeOut(300, function() {
            $(this).remove();
            updateBundleTotal();

            // If no products left, show placeholder
            if ($('#productDetails .card').length === 0) {
                $('#selectedProducts p').show();
            }
        });
    });

    // Update overall bundle total
    function updateBundleTotal() {
        let bundleType = $('#bundle_offer_type').val();
        let bundleTotal = 0;
        let productCount = 0;
        let breakdownHTML = '<h5>Bundle Price Breakdown:</h5><ul class="list-group">';

        $('#productDetails .card').each(function() {
            let productName = $(this).find('.product-name').val();
            let basePrice = parseFloat($(this).find('.product-base-price').val()) || 0;
            let productTotal = parseFloat($(this).find('.product-total').text().replace('$', '')) || 0;
            let quantity = parseInt($(this).find('.product-quantity').val()) || 1;

            bundleTotal += productTotal;
            productCount++;

            // Get selected variation
            let selectedVariation = $(this).find('.variation-checkbox:checked');
            let variationText = '';
            let variationPrice = 0;
            if (selectedVariation.length) {
                let varType = selectedVariation.data('type');
                variationPrice = parseFloat(selectedVariation.data('price')) || 0;
                variationText = `<div class="small text-muted ml-3">└ ${varType} (+$${variationPrice.toFixed(2)})</div>`;
            }

            // Get selected addons
            let addonsText = '';
            let addonsTotal = 0;
            $(this).find('.addon-checkbox:checked').each(function() {
                let addonName = $(this).data('name');
                let addonPrice = parseFloat($(this).data('price')) || 0;
                addonsTotal += addonPrice;
                addonsText += `<div class="small text-muted ml-3">└ ${addonName} (+$${addonPrice.toFixed(2)})</div>`;
            });

            // Calculate per-item price
            let perItemPrice = productTotal / quantity;

            // Add to breakdown with details
            breakdownHTML += `
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong>${productName}</strong> (x${quantity})
                            <div class="small text-muted">Base: $${basePrice.toFixed(2)}</div>
                            ${variationText}
                            ${addonsText}
                            ${quantity > 1 ? `<div class="small text-info mt-1">Per item: $${perItemPrice.toFixed(2)}</div>` : ''}
                        </div>
                        <strong class="text-success ml-3">$${productTotal.toFixed(2)}</strong>
                    </div>
                </li>`;
        });

        // Apply discount if any
        let discount = parseFloat($('#discount').val()) || 0;
        let discountType = $('#discount_type').val();
        let discountAmount = 0;

        if (discountType === 'percent') {
            discountAmount = (bundleTotal * discount) / 100;
        } else {
            discountAmount = discount;
        }

        let finalTotal = Math.max(bundleTotal - discountAmount, 0);

        breakdownHTML += `
            <li class="list-group-item">
                <strong>Subtotal: </strong><span class="text-primary">$${bundleTotal.toFixed(2)}</span>
            </li>`;

        if (discountAmount > 0) {
            breakdownHTML += `
                <li class="list-group-item text-danger">
                    <strong>Discount (${discountType === 'percent' ? discount + '%' : '$' + discount}): </strong>
                    -$${discountAmount.toFixed(2)}
                </li>`;
        }

        breakdownHTML += `
            <li class="list-group-item bg-success text-white">
                <strong>Final Bundle Total: </strong>
                <strong style="font-size: 1.3em;">$${finalTotal.toFixed(2)}</strong>
            </li>
        </ul>`;

        // Update price calculator
        if (productCount > 0) {
            $('#priceCalculator').show();
            $('#priceBreakdown').html(breakdownHTML);
            $('#selectedProducts p').hide();
        } else {
            $('#priceCalculator').hide();
            $('#selectedProducts p').show();
        }

        // Update hidden price fields based on bundle type
        if (bundleType === 'bogo_free' || bundleType === 'mix_match') {
            // For BOGO and Mix & Match, use final total (with discount)
            $('#price').val(finalTotal.toFixed(2));
            $('#price_hidden').val(finalTotal.toFixed(2));
        } else {
            // For Simple and Bundle, use original logic
            $('#price').val(finalTotal.toFixed(2));
            $('#price_hidden').val(bundleTotal.toFixed(2));
        }
    }

    // Update when discount changes
    $('#discount, #discount_type').on('change input', function() {
        let discount = parseFloat($('#discount').val()) || 0;
        let discountType = $('#discount_type').val();
        let bundleTotal = parseFloat($('#price_hidden').val()) || 0;

        // Validation
        if (discountType === 'percent' && discount > 100) {
            alert('Discount percentage cannot exceed 100%');
            $('#discount').val(0);
            return;
        }

        if (discountType !== 'percent' && discount > bundleTotal) {
            alert(`Discount amount ($${discount}) cannot exceed bundle total ($${bundleTotal})`);
            $('#discount').val(0);
            return;
        }

        updateBundleTotal();
    });

    // Function to update field visibility based on bundle type
    function updateFieldsVisibility(bundleType) {
        if (bundleType === 'mix_match') {
            // CONDITION 3: Hide price, show discount fields
            $('#price_input_hide').addClass('d-none');
            $('#discount_input_hide').removeClass('d-none');
            $('#discount_value_input_hide').removeClass('d-none');
        } else if (bundleType === 'bogo_free') {
            // CONDITION 4: Hide price, hide discount fields for BOGO
            $('#price_input_hide').addClass('d-none');
            $('#discount_input_hide').addClass('d-none');
            $('#discount_value_input_hide').addClass('d-none');
        } else if (bundleType === 'simple' || bundleType === 'bundle') {
            // CONDITION 1 & 2: Show all fields
            $('#price_input_hide').removeClass('d-none');
            $('#discount_input_hide').removeClass('d-none');
            $('#discount_value_input_hide').removeClass('d-none');
        } else {
            // Default: Show all fields
            $('#price_input_hide').removeClass('d-none');
            $('#discount_input_hide').removeClass('d-none');
            $('#discount_value_input_hide').removeClass('d-none');
        }
    }

    // Handle bundle type changes
    $('#bundle_offer_type').on('change', function() {
        let bundleType = $(this).val();

        // Update field visibility
        updateFieldsVisibility(bundleType);

        // Clear all products for any type change
        $('#productDetails .card').fadeOut(300, function() {
            $(this).remove();
            $('#selectedProducts p').show();
        });
        selectedProductsArray = [];
        productCounter = 0;

        // Reset price calculator
        $('#priceCalculator').hide();
        $('#price').val('0.00');
        $('#price_hidden').val('0.00');
        $('#discount').val('0');
    });

    // Reset when fixed price option is selected
    $('#price_type, input[name="price_type"]').on('change', function() {
        let priceType = $(this).val() || $('input[name="price_type"]:checked').val();

        // If fixed price is selected, reset all products
        if (priceType === 'fixed') {
            // Clear all products
            $('#productDetails .card').fadeOut(300, function() {
                $(this).remove();
                $('#selectedProducts p').show();
            });
            selectedProductsArray = [];
            productCounter = 0;

            // Reset price calculator
            $('#priceCalculator').hide();
            $('#price').val('0.00');
            $('#price_hidden').val('0.00');

            // Show message
            alert('Fixed price selected. All product selections have been reset.');
        }
    });
});
    </script>





































{{--

    <script>
        $(document).ready(function() {
            $('#select_pro').select2({
                width: '100%',
                placeholder: 'Select a Product'
            });
            const price = document.querySelectorAll('#price');
            const discount_type = document.querySelector('#discount_type').value;
        //    const discount_type = $('#select2-discount_type-container').text().trim(); // "percent" or "fixed"
            const discount = parseFloat($('#discount').val()) || 0; // get discount value

            let currentBasePrice = 0;
            let currentProductName = '';
            // When user selects a product
            $('#select_pro').on('change', function () {
                let selected = $(this).find('option:selected');
                currentProductName = selected.data('name');
                currentBasePrice = selected.data('price') || 0;
                let variations = selected.data('variations') || [];
                let addons = selected.data('addons') || [];



                // Reset selected items section
                $('#selectedItemsSection').hide();
                $('#selectedVariationInfo').hide();
                $('#selectedAddonsInfo').hide();

                let html = `<div class="card p-3 shadow-sm">
                    <h5>${currentProductName}</h5>
                    <p class="text-muted mb-3">Base Price: $${currentBasePrice}</p>`;

                // Show variations
                if (variations && variations.length > 0) {
                    html += `<div class="mt-2">
                        <strong>Available Variations:</strong><br>`;
                    variations.forEach((v, i) => {
                        html += `
                            <label class="d-block small mt-1">
                                <input type="checkbox"
                                    name="variation"
                                    value="${v.type || ''}"
                                    data-price="${v.price || 0}"
                                    data-type="${v.type || 'Option'}">
                                ${v.type || 'Option'} - $${v.price || 0}
                                ${v.stock ? ` (Stock: ${v.stock})` : ''}
                            </label>`;
                    });
                    html += `</div>`;
                }

                // Show addons
                if (addons && addons.length > 0) {
                    html += `<div class="mt-3">
                        <strong>Available Add-ons:</strong><br>`;
                    addons.forEach(addon => {
                        html += `
                            <label class="d-block small mt-1">
                                <input type="checkbox"
                                    name="addons[]"
                                    value="${addon.id}"
                                    data-price="${addon.price || 0}"
                                    data-name="${addon.name}">
                                ${addon.name} (+$${addon.price || 0})
                            </label>`;
                    });
                    html += `</div>`;
                }

                html += `</div>`;

                $('#productDetails').html(html);

                // Update selected items when variation/addon changes
                updateSelectedItems();
            });

            // Update selected items display
            function updateSelectedItems() {
                $(document).on('change', 'input[name="variation"], input[name="addons[]"]', function() {
                    let total = parseFloat(currentBasePrice);

                    // Show selected items section
                    $('#selectedItemsSection').show();

                    // Display product info
                    $('#selectedProductInfo').html(`
                        <strong>Product:</strong> ${currentProductName}<br>
                        <strong>Base Price:</strong> $${currentBasePrice}
                    `);

                    // Handle selected variation
                    let selectedVariation = $('input[name="variation"]:checked');
                    if (selectedVariation.length) {
                        let varPrice = parseFloat(selectedVariation.data('price')) || 0;
                        let varType = selectedVariation.data('type');
                        total += varPrice;

                        $('#selectedVariationInfo').show();
                        $('#selectedVariationDetails').html(`
                            <span class="badge badge-info">${varType} (+$${varPrice})</span>
                        `);
                    } else {
                        $('#selectedVariationInfo').hide();
                    }

                    // Handle selected addons
                    let selectedAddons = [];
                    $('input[name="addons[]"]:checked').each(function() {
                        let addonPrice = parseFloat($(this).data('price')) || 0;
                        let addonName = $(this).data('name');
                        total += addonPrice;
                        selectedAddons.push({
                            name: addonName,
                            price: addonPrice
                        });
                    });

                    if (selectedAddons.length > 0) {
                        $('#selectedAddonsInfo').show();
                        let addonsHTML = '';
                        selectedAddons.forEach(addon => {
                            addonsHTML += `<span class="badge badge-success mr-1">${addon.name} (+$${addon.price})</span>`;
                        });
                        $('#selectedAddonsDetails').html(addonsHTML);
                    } else {
                        $('#selectedAddonsInfo').hide();
                    }

                    // Update final total
                    $('#finalTotalPrice').text('$' + total.toFixed(2));
                    $('#price').val(total.toFixed(2));
                    $('#price_hidden').val(total.toFixed(2));


                    //     if(discount_type == "percent"){
                    //             discount
                    //     }else{


                    //     }

                    // Get values

                    // let total = parseFloat($('#total').val()) || 0; // your original total

                    // Apply discount
                    // let finalTotal = total.toFixed(2);

                    // if (discount_type === "percent") {
                    //     // Subtract percentage from total
                    //     finalTotal = total - (total * (discount / 100));
                    // } else {
                    //     // Subtract fixed amount
                    //     finalTotal = total - discount;
                    // }

                    // // Ensure final total doesn't go below 0
                    // if (finalTotal < 0) finalTotal = 0;

                    // // Update final total on page
                    // $('#finalTotalPrice').text('$' + finalTotal.toFixed(2));



                    // alert(finalTotal.toFixed(2));


                    // Call discount calculation if needed
                    all_value(total, select2_discount_type_container, discount);
                });
            }

            // Price Discount Calculation Function
            function all_value(originalPrice, discountType, discountValue) {
                originalPrice = parseFloat(originalPrice) || 0;
                discountValue = parseFloat(discountValue) || 0;

                let discountAmount = 0;
                let finalPrice = originalPrice;

                if (discountType === 'percent' || discountType === 'Percent (%)') {
                    discountAmount = (originalPrice * discountValue) / 100;
                } else if (discountType === 'fixed' || discountType === 'Fixed ($)') {
                    discountAmount = discountValue;
                }

                finalPrice = originalPrice - discountAmount;

                if (finalPrice < 0) {
                    finalPrice = 0;
                }

                return {
                    originalPrice: originalPrice.toFixed(2),
                    discountType: discountType,
                    discountValue: discountValue,
                    discountAmount: discountAmount.toFixed(2),
                    finalPrice: finalPrice.toFixed(2),
                    savedAmount: discountAmount.toFixed(2)
                };
            }
        });
    </script>


    <script>

        $(function() {
            function updateFinalTotal() {
                let price_hidden = parseFloat($('#price_hidden').val()) || 0;
                let discount = parseFloat($('#discount').val()) || 0;
                let type = $('#discount_type').val();

                let finalTotal = price_hidden;

                // Validation
                if (type === "percent" && discount > 100) {
                    alert("Discount percentage cannot exceed 100%");
                    $('#discount').val(''); // clear input
                    return;
                }
                if (type !== "percent" && discount > price_hidden) {
                    alert(`Your total value is ${price_hidden}, but you entered ${discount}`);
                    $('#discount').val(''); // clear input
                    return;
                }

                // Apply discount
                if (type === "percent") {
                    finalTotal -= price_hidden * (discount / 100);
                } else {
                    finalTotal -= discount;
                }

                // Prevent negative
                finalTotal = Math.max(finalTotal, 0);

                // Update UI
                $('#finalTotalPrice').text(`$${finalTotal.toFixed(2)}`);
                $('#price').val(finalTotal.toFixed(2));
            }

            // Trigger update on input, change, or enter
            $('#discount, #discount_type, #price').on('input change keypress', function(e) {
                if (e.type === 'keypress' && e.which !== 13) return;
                e.preventDefault();
                updateFinalTotal();
            });
        });

    </script> --}}








    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const managementSelection = document.querySelectorAll('#management_selection');
            const voucherCards = document.querySelectorAll('.voucher-card');
            const voucherCards2 = document.querySelectorAll('.voucher-card_2');
             const allimages = document.getElementById('allimages');
            // Move these functions OUTSIDE of DOMContentLoaded to make them globally accessible
            function section_one(loopIndex, primaryId,name) {
                getDataFromServer(primaryId);
                  get_product();
                // Set hidden input value
                document.getElementById('hidden_value').value = loopIndex;
                document.getElementById('hidden_name').value = name;

                const managementSelection = document.querySelectorAll('#management_selection');



                     // Get all elements
                const basic_info_main = document.getElementById('basic_info_main');
                const store_category_main = document.getElementById('store_category_main');
                const how_it_work_main = document.getElementById('how_it_work_main');
                const term_condition_main = document.getElementById('term_condition_main');
                const review_submit_main = document.getElementById('review_submit_main');
                const allimages = document.getElementById('allimages');

                const bundle_rule = document.getElementById('bundle_rule');
                const Bundle_products_configuration = document.getElementById('Bundle_products_configuration');

                const Product_voucher_fields_1_3 = document.getElementById('Product_voucher_fields_1_3');
                const product_voucher_price_info_1_3 = document.getElementById('product_voucher_price_info_1_3');

                const food_voucher_fields_1_4 = document.getElementById('food_voucher_fields_1_4');
                const food_voucher_price_info_1_4 = document.getElementById('food_voucher_price_info_1_4');

                const bundel_food_voucher_fields_1_3_1_4 = document.getElementById('bundel_food_voucher_fields_1_3_1_4');
                const bundel_food_voucher_price_info_1_3_1_4 = document.getElementById('bundel_food_voucher_price_info_1_3_1_4');





                managementSelection.forEach(el => {
                    if (loopIndex === "1" || name === "Delivery/Pickup") {
                        submit_voucher_type(loopIndex, primaryId,name);
                        el.classList.remove('d-none');

                              showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,Product_voucher_fields_1_3,product_voucher_price_info_1_3,allimages]);
                            hideElements([bundel_food_voucher_fields_1_3_1_4, bundel_food_voucher_price_info_1_3_1_4, food_voucher_fields_1_4, food_voucher_price_info_1_4]);


                        // Hide discount-specific sections
                        const elementsToHide = [
                            document.getElementById('basic_info'),
                            document.getElementById('store_category'),
                            document.getElementById('price_info'),
                            document.getElementById('voucher_behavior'),
                            document.getElementById('usage_terms'),
                            document.getElementById('attributes'),
                            document.getElementById('tags'),
                            document.getElementById('allimages')
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
                            document.getElementById('tags'),

                        ];

                        elementsToShow.forEach(element => {
                            if (element) element.classList.remove('d-none');
                        });
                    }
                });
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
        getDataFromServer(4)

        function getDataFromServer(storeId) {
            $.ajax({
                url: "{{ route('admin.Voucher.get_document') }}",
                type: "GET",
                data: { store_id: storeId },
                dataType: "json",
                success: function(response) {
                console.log(response);

                // 🟢 WorkManagement (list items)
                // let workHtml = "";
                // $.each(response.work_management, function(index, item) {
                //     workHtml += "<li>" + item.guid_title + "</li>";
                // });
                // $("#workList").html(workHtml);

                // 🟢 WorkManagement (show all details)
            let workHtml = "";

                $.each(response.work_management, function(index, item) {
                    workHtml += `
                        <div class="work-item  mb-4 rounded-lg ">
                            <h3 class="font-bold text-lg mb-2">${item.guid_title}</h3>

                            <div class="mb-3">
                                <strong>Purchase Process:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.purchase_process.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Payment Confirm:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.payment_confirm.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Voucher Deliver:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.voucher_deliver.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Redemption Process:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.redemption_process.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Account Management:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.account_management.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                    `;
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
                'Bundle_products_configuration',
                'allimages'
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
                                <div class="voucher-card_2 border rounded py-4 text-center h-70" onclick="section_second(${index}, ${module.id}, '${module.module_name}')">
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
            // var _product_name = _product_name;

            if (store_id == "") {
                alert("Please select store");
            } else {
                $.ajax({
                    url: "{{ route('admin.Voucher.get_product') }}",
                    type: "GET",
                    data: {
                        store_id: store_id,
                        category_id: category_id , // optional agar zaroori ho
                        // product_name: _product_name  // optional agar zaroori ho
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

    </script>

    {{-- <script>
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
        });

    </script> --}}

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
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="checkbox" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Multiple Selection') }}
                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="checkbox" value="single"
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


@endpush
