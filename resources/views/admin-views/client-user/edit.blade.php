@extends('layouts.admin.app')

@section('title',"Client Edit")

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
                   Edit Client
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.client-side.update',[$client['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                        @php($language = $language->value ?? null)
                        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <div class="row">
                                <div class="col-6 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="name"> Client Name
                                            </label>
                                            <input type="text" name="name" id="name" class="form-control"  placeholder="Enter Client Name" value="{{ $client->name }}">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="email">Email
                                            </label>
                                            <input type="text" name="email" value="{{ $client->email }}" id="email"class="form-control"  placeholder="Enter Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="password">Password </label>
                                            <input type="text" name="password" id="password" class="form-control"  placeholder="Enter Password" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="logo_image">Logo </label>
                                            <input type="file" name="logo_image" id="logo_image" class="form-control">

                                            {{-- Agar client ka logo already hai to niche show kare --}}
                                            @if(!empty($client->logo))
                                                <div class="mt-2">
                                                    <img src="{{ asset($client->logo) }}"
                                                        alt="Client Logo"
                                                        class="img-thumbnail"
                                                        style="max-width: 120px; height:auto;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="cover_image">Cover </label>
                                            <input type="file" name="cover_image" id="cover_image" class="form-control" >
                                                {{-- Agar client ka logo already hai to niche show kare --}}
                                            @if(!empty($client->cover))
                                                <div class="mt-2">
                                                    <img src="{{ asset($client->cover) }}"
                                                        alt="Client Logo"
                                                        class="img-thumbnail"
                                                        style="max-width: 120px; height:auto;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="type">Segment Types</label>

                                            <select
                                                name="type[]"
                                                id="type"
                                                class="form-control select2"
                                                multiple="multiple"
                                                data-placeholder="-- Select Types --"
                                            >
                                                @foreach ($Segment as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if(in_array($item->id, old('type', $selectedTypes))) selected @endif>
                                                         {{ $item->name }} /  {{ $item->type }}
                                                    </option>
                                                @endforeach
                                            </select>
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
