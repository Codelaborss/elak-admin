<div class="col-md-6">
    <div class="card h-100">
        <div class="card-body">
            @if ($language)
                <ul class="nav nav-tabs border-0 mb-3">
                    <li class="nav-item">
                        <a class="nav-link lang_link active" href="#"
                            id="default-link">{{ translate('messages.default') }}</a>
                    </li>
                    @foreach (json_decode($language) as $lang)
                        <li class="nav-item">
                            <a class="nav-link lang_link" href="#"
                                id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if ($language)
                <div class="lang_form" id="default-form">
                    <div class="form-group">
                        <label class="input-label" for="default_name">{{ translate('messages.name') }}
                            ( {{ translate('messages.Default') }}) <span
                                class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span>

                        </label>
                        <input type="text" name="name[]" id="default_name" class="form-control"
                            placeholder="{{ translate('messages.new_item') }}">
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{ translate('messages.short_description') }}
                            ({{ translate('messages.default') }})<span
                                class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span></label>
                        <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                    </div>
                </div>
                @foreach (json_decode($language) as $lang)
                    <div class="d-none lang_form" id="{{ $lang }}-form">
                        <div class="form-group">
                            <label class="input-label"
                                for="{{ $lang }}_name">{{ translate('messages.name') }}
                                ({{ strtoupper($lang) }})
                            </label>
                            <input type="text" name="name[]" id="{{ $lang }}_name"
                                class="form-control" placeholder="{{ translate('messages.new_item') }}">
                        </div>
                        <input type="hidden" name="lang[]" value="{{ $lang }}">
                        <div class="form-group mb-0">
                            <label class="input-label"
                                for="exampleFormControlInput1">{{ translate('messages.short_description') }}
                                ({{ strtoupper($lang) }})</label>
                            <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                        </div>
                    </div>
                @endforeach
            @else
                <div id="default-form">
                    <div class="form-group">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{ translate('messages.name') }}
                            ({{ translate('messages.default') }})</label>
                        <input type="text" name="name[]" class="form-control"
                            placeholder="{{ translate('messages.new_item') }}">
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{ translate('messages.short_description') }}</label>
                        <textarea type="text" name="description[]" class="form-control min-h-90px ckeditor"></textarea>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card h-100">
        <div class="card-body d-flex flex-wrap align-items-center">
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
                        @if (Config::get('module.current_module_type') == 'food')
                            <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                        @else
                            <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                        @endif
                    </label>
                    <label class="d-inline-block m-0 position-relative">
                        <img class="img--176 border" id="viewer"
                            src="{{ asset('public/assets/admin/img/upload-img.png') }}"
                            alt="thumbnail" />
                        <div class="icon-file-group">
                            <div class="icon-file"><input type="file" name="image"
                                    id="customFileEg1" class="custom-file-input d-none"
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

<div class="col-md-12">
    <div class="card shadow--card-2 border-0">
        <div class="card-header">
            <h5 class="card-title">
                <span class="card-header-icon mr-2">
                    <i class="tio-tune-horizontal"></i>
                </span>
                <span> {{ translate('Store_&_Category_Info') }} </span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group mb-0">
                        <label class="input-label" for="store_id">{{ translate('messages.store') }} <span
                                class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span><span class="input-label-secondary"></span></label>
                        <select name="store_id" id="store_id"
                            data-placeholder="{{ translate('messages.select_store') }}"
                            class="js-data-example-ajax form-control"
                            oninvalid="this.setCustomValidity('{{ translate('messages.please_select_store') }}')">

                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="category_id">{{ translate('messages.category') }}<span
                                class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span></label>
                        <select name="category_id" id="category_id"
                            data-placeholder="{{ translate('messages.select_category') }}"
                            class="js-data-example-ajax form-control">
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="sub-categories">{{ translate('messages.sub_category') }}<span
                                class="input-label-secondary"
                                title="{{ translate('messages.category_required_warning') }}"><img
                                    src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                                    alt="{{ translate('messages.category_required_warning') }}"></span></label>
                        <select name="sub_category_id" class="js-data-example-ajax form-control"
                            data-placeholder="{{ translate('messages.select_sub_category') }}"
                            id="sub-categories">

                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" id="condition_input">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="condition_id">{{ translate('messages.Suitable_For') }}<span
                                class="input-label-secondary"></span></label>
                        <select name="condition_id" id="condition_id"
                            data-placeholder="{{ translate('messages.Select_Condition') }}"
                            class="js-data-example-ajax form-control"
                            oninvalid="this.setCustomValidity('{{ translate('messages.Select_Condition') }}')">
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3" id="brand_input">
                    <div class="form-group mb-0">
                        <label class="input-label" for="brand_id">{{ translate('messages.Brand') }}<span
                                class="input-label-secondary"></span></label>
                        <select name="brand_id" id="brand_id"
                            data-placeholder="{{ translate('messages.Select_brand') }}"
                            class="js-data-example-ajax form-control" multiple
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
                            for="exampleFormControlInput1">{{ translate('messages.item_type') }} <span
                                class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span></label>
                        <select name="veg" id="veg" class="form-control js-select2-custom"
                            required>
                            <option value="0">{{ translate('messages.non_veg') }}</option>
                            <option value="1">{{ translate('messages.veg') }}</option>
                        </select>
                    </div>
                </div>
                {{-- @dd(Config::get('module.current_module_type')) --}}
                @if (Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food'  || Config::get('module.current_module_type') == 'voucher')

                    {{-- <div class="col-sm-6" id="nutrition">
                        <label class="input-label" for="sub-categories">
                            {{ translate('Nutrition') }}
                            <span class="input-label-secondary"
                                title="{{ translate('Specify the necessary keywords relating to energy values for the item.') }}"
                                data-toggle="tooltip">
                                <i class="tio-info-outined"></i>
                            </span>
                        </label>
                        <select name="nutritions[]" class="form-control multiple-select2"
                            data-placeholder="{{ translate('messages.Type your content and press enter') }}"
                            multiple>

                            @foreach (\App\Models\Nutrition::select(['nutrition'])->get() as $nutrition)
                                <option value="{{ $nutrition->nutrition }}">{{ $nutrition->nutrition }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}


                    {{-- <div class="col-sm-6" id="allergy">
                        <label class="input-label" for="sub-categories">
                            {{ translate('Allegren Ingredients') }}
                            <span class="input-label-secondary"
                                title="{{ translate('Specify the ingredients of the item which can make a reaction as an allergen.') }}"
                                data-toggle="tooltip">
                                <i class="tio-info-outined"></i>
                            </span>
                        </label>
                        <select name="allergies[]" class="form-control multiple-select2"
                            data-placeholder="{{ translate('messages.Type your content and press enter') }}"
                            multiple>
                            @foreach (\App\Models\Allergy::select(['allergy'])->get() as $allergy)
                                <option value="{{ $allergy->allergy }}">{{ $allergy->allergy }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                @endif

                <div class="col-sm-6 col-lg-3" id="maximum_cart_quantity">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="maximum_cart_quantity">{{ translate('messages.Maximum_Purchase_Quantity_Limit') }}
                            <span class="input-label-secondary text--title" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('If_this_limit_is_exceeded,_customers_can_not_buy_the_item_in_a_single_purchase.') }}">
                                <i class="tio-info-outined"></i>
                            </span>
                        </label>
                        <input type="number" placeholder="{{ translate('messages.Ex:_10') }}"
                            class="form-control" name="maximum_cart_quantity" min="0"
                            id="cart_quantity">
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" id="organic">
                    <div class="form-check mb-sm-2 pb-sm-1">
                        <input class="form-check-input" name="organic" type="checkbox" value="1"
                            id="flexCheckDefault" checked>
                        <label class="form-check-label" for="flexCheckDefault">
                            {{ translate('messages.is_organic') }}
                        </label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" id="basic">
                    <div class="form-check mb-sm-2 pb-sm-1">
                        <input class="form-check-input" name="basic" type="checkbox" value="1"
                            id="flexCheckDefaultBasic" checked>
                        <label class="form-check-label" for="flexCheckDefaultBasic">
                            {{ translate('messages.Is_Basic_Medicine') }}
                        </label>
                    </div>
                </div>
                @if (Config::get('module.current_module_type') == 'pharmacy' )
                    <div class="col-sm-6 col-lg-3" id="is_prescription_required">
                        <div class="form-check mb-sm-2 pb-sm-1">
                            <input class="form-check-input" name="is_prescription_required"
                                type="checkbox" value="1" id="flexCheckDefaultprescription" checked>
                            <label class="form-check-label" for="flexCheckDefaultprescription">
                                {{ translate('messages.is_prescription_required') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6" id="generic_name">
                        <label class="input-label" for="sub-categories">
                            {{ translate('generic_name') }}
                            <span class="input-label-secondary"
                                title="{{ translate('Specify the medicine`s active ingredient that makes it work') }}"
                                data-toggle="tooltip">
                                <i class="tio-info-outined"></i>
                            </span>
                        </label>
                        <div class="dropdown suggestion_dropdown">
                            <input type="text" class="form-control" name="generic_name"
                                autocomplete="off">
                            @if (count(\App\Models\GenericName::select(['generic_name'])->get()) > 0)
                                <div class="dropdown-menu">
                                    @foreach (\App\Models\GenericName::select(['generic_name'])->get() as $generic_name)
                                        <div class="dropdown-item">{{ $generic_name->generic_name }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if (Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food' || Config::get('module.current_module_type') == 'voucher')
                    {{-- <div class="col-sm-6 col-lg-3" id="halal">
                        <div class="form-check mb-sm-2 pb-sm-1">
                            <input class="form-check-input" name="is_halal" type="checkbox"
                                value="1" id="flexCheckDefault1" checked>
                            <label class="form-check-label" for="flexCheckDefault1">
                                {{ translate('messages.Is_It_Halal') }}
                            </label>
                        </div>
                    </div> --}}
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" id="addon_input">
    <div class="card shadow--card-2 border-0">
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
                        class="input-label-secondary" title="{{ translate('messages.addon') }}"><img
                            src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                            alt="{{ translate('messages.store_required_warning') }}"></span></label>
                <select name="addon_ids[]" class="form-control js-select2-custom" multiple="multiple"
                    id="add_on">

                </select>
            </div>
        </div>
    </div>
</div>
{{-- <div class="col-md-6" id="time_input">
    <div class="card shadow--card-2 border-0">
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
</div> --}}
<div class="col-md-12">
    <div class="card shadow--card-2 border-0">
        <div class="card-header">
            <h5 class="card-title">
                <span class="card-header-icon"><i class="tio-label-outlined"></i></span>
                <span>{{ translate('Price Information') }}</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-2">
                <div
                    class="col-md-4 col-12">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{ translate('messages.price') }} <span
                                class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span></label>
                        <input type="number" min="0" max="999999999999.99" step="0.01"
                            value="1" name="price" class="form-control"
                            placeholder="{{ translate('messages.Ex:') }} 100" required>
                    </div>
                </div>
                {{-- <div class="col-sm-{{ in_array(Config::get('module.current_module_type'), ['food', 'voucher']) ? '4' : '3' }} col-6"
                    id="stock_input">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="total_stock">{{ translate('messages.total_stock') }}</label>
                        <input type="number" placeholder="{{ translate('messages.Ex:_10') }}"
                            class="form-control" name="current_stock" min="0" id="quantity">
                    </div>
                </div>
                <div class="col-sm-{{ in_array(Config::get('module.current_module_type'), ['food', 'voucher']) ? '4' : '3' }} col-6">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{ translate('messages.discount_type') }}
                            <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span><span class="input-label-secondary text--title" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores') }}">
                                <i class="tio-info-outined"></i>
                            </span>
                        </label>
                        <select name="discount_type" id="discount_type"
                            class="form-control js-select2-custom">
                            <option value="percent">{{ translate('messages.percent') }} (%)</option>
                            <option value="amount">{{ translate('messages.amount') }}
                                ({{ \App\CentralLogics\Helpers::currency_symbol() }})
                            </option>
                        </select>
                    </div>
                </div>
                <div
                    class="col-sm-{{ in_array(Config::get('module.current_module_type'), ['food', 'voucher']) ? '4' : '3' }} col-6">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{ translate('messages.discount') }}
                            <span id=symble> (%) </span>
                            <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span></label>
                        <input type="number" min="0" max="9999999999999999999999" value="0"
                            name="discount" class="form-control"
                            placeholder="{{ translate('messages.Ex:') }} 100">
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@if ($productWiseTax)
    <div class="col-lg-12">
        <div class="card shadow--card-2 border-0">
            <div class="card-header flex-wrap">
                <h5 class="card-title">
                    <span class="card-header-icon mr-2">
                        <i class="tio-canvas-text"></i>
                    </span>
                    <span>{{ translate('messages.Tax_Information') }}</span>
                </h5>
            </div>
            <div class="card-body">
                <span class="mb-2 d-block title-clr fw-normal">{{ translate('Select Tax Rate') }}</span>
                <select name="tax_ids[]" required id="tax__rate" class="form-control js-select2-custom"
                    multiple="multiple" placeholder="Type & Select Tax Rate">
                    @foreach ($taxVats as $taxVat)
                        <option value="{{ $taxVat->id }}"> {{ $taxVat->name }}
                            ({{ $taxVat->tax_rate }}%)
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
    </div>
@endif
{{-- <div class="col-lg-12" id="food_variation_section">
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
                    <img src="{{ asset('/public/assets/admin/img/variation.png') }}" alt="">
                    <div>{{ translate('No variation added') }}</div>
                </div>
            </div>
            <div id="add_new_option">
            </div>
        </div>
    </div>
</div> --}}
<div class="col-md-12" id="attribute_section">
    <div class="card shadow--card-2 border-0">
        <div class="card-header">
            <h5 class="card-title">
                <span class="card-header-icon"><i class="tio-canvas-text"></i></span>
                <span>{{ translate('attribute') }}</span>
            </h5>
        </div>
        <div class="card-body pb-0">
            <div class="row g-2">
                <div class="col-12">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlSelect1">{{ translate('messages.attribute') }}<span
                                class="input-label-secondary"></span></label>
                        <select name="attribute_id[]" id="choice_attributes"
                            class="form-control js-select2-custom" multiple="multiple">
                            @foreach (\App\Models\Attribute::orderBy('name')->get() as $attribute)
                                <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}
                                </option>
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
<div class="col-md-12">
    <div class="card shadow--card-2 border-0">
        <div class="card-header">
            <h5 class="card-title">
                <span class="card-header-icon"><i class="tio-label"></i></span>
                <span>{{ translate('tags') }}</span>
            </h5>
        </div>
        <div class="card-body pb-0">
            <div class="row g-2">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" class="form-control" name="tags"
                            placeholder="{{ translate('messages.search_tags') }}" data-role="tagsinput">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
