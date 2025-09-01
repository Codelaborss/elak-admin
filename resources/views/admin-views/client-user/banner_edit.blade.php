@extends('layouts.admin.app')

@section('title',"Banner Edit")

@push('css_or_js')

@endpush

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
<style>
    /* Dropdown options - selected option ka background highlight */
    .select2-results__option[aria-selected="true"] {
        background-color: #005555 !important; /* Bootstrap primary */
        color: #fff !important;
    }

    /* Hover effect on options */
    .select2-results__option--highlighted[aria-selected] {
        background-color: #005555 !important;
        color: #fff !important;
    }

    /* Selected tags (neeche input me show hone wale items) */
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        background-color: #005555;   /* blue tag */
        border: none;
        color: #fff;
        padding: 4px 10px;
        margin: 3px 4px 0 0;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }

    /* Tag ke andar remove (x) button */
    .select2-container--bootstrap4 .select2-selection__choice__remove {
        margin-right: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Input field height thoda sa neat */
    .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: 46px;
        border: 1px solid #ced4da;
        border-radius: .5rem;
        padding: 4px;
    }

    /* Dropdown ka max height with scroll */
    .select2-results__options {
        max-height: 220px !important;
        overflow-y: auto !important;
    }

    /* Dropdown search bar */
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 6px 10px;
        width: 100% !important;
        outline: none;
    }
</style>

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/edit.png')}}" class="w--26" alt="">
                </span>
                <span>
                   Edit Banner
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.client-side.update_banner',[$Banner['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                        @php($language = $language->value ?? null)
                        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
                        @if($language)

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
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('messages.update')}}</button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>
@endsection

@push('script_2')
<script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
    $(function () {
        $('#type').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: $('#type').data('placeholder'),
            allowClear: true,
            closeOnSelect: false
        });
    });
</script>

@endpush
