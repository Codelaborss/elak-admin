@extends('layouts.admin.app')

@section('title',"Client List")

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
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span>
                   Add Client
                </span>
            </h1>
        </div>
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.client-side.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="name"> Client Name
                                                    </label>
                                                    <input type="text" name="name" id="name" class="form-control"  placeholder="Enter Client Name">
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="email">Email
                                                    </label>
                                                    <input type="text" name="email" id="email"class="form-control"  placeholder="Enter Email">
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
                                                    <input type="file" name="logo_image" id="logo_image" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="cover_image">Cover </label>
                                                    <input type="file" name="cover_image" id="cover_image" class="form-control" >
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
                                                                @if(collect(old('type', []))->contains($item->id)) selected @endif>
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
                                <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
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
                                Client List<span class="badge badge-soft-dark ml-2" id="itemCount"></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search" name="search" class="form-control"
                                            placeholder="Ex: Client Name" aria-label="Search" >
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            @if(request()->get('search'))
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="{{url()->full()}}">{{translate('messages.reset')}}</button>
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
                                <th class="border-0">{{translate('sl')}}</th>
                                <th class="border-0">Name</th>
                                <th class="border-0">Email</th>
                                <th class="border-0">types</th>
                                <th class="border-0">Logo</th>
                                <th class="border-0">Cover</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Action</th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                         @foreach($clients as $key => $client)
                            <tr>
                                {{-- Serial No --}}
                                <td class="text-center">
                                    <span class="mr-3">
                                        {{ $clients->firstItem() + $key }}
                                    </span>
                                </td>

                                {{-- Client Name --}}
                                <td class="text-center">
                                    <span title="{{ $client->name }}" class="font-size-sm text-body mr-3">
                                        {{ Str::limit($client->name, 20, '...') }}
                                    </span>
                                </td>

                                {{-- Client Email --}}
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $client->email }}
                                    </span>
                                </td>
                              {{-- Client Types --}}
                                <td class="text-center">
                                    @if(!empty($client->type_names))
                                        @foreach($client->type_names as $tName)
                                            <span class="badge badge-info d-block mb-1">{{ $tName }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                {{-- Client Created At --}}
                                <td class="text-center">
                                    <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                        <img src="{{ asset($client->logo) }}"
                                            class="img-fluid rounded open-image-modal"
                                            alt="Client Logo"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                        <img src="{{ asset($client->cover) }}"
                                            class="img-fluid rounded open-image-modal"
                                            alt="Client Logo"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </td>

                                {{-- Status Toggle (Active/Inactive) --}}
                                <td class="text-center">
                                    <label class="toggle-switch toggle-switch-sm" for="status-{{ $client->id }}">
                                        <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                            {{ $client->status == 'active' ? 'checked' : '' }}
                                            data-id="status-{{ $client->id }}"
                                            data-type="status"
                                            id="status-{{ $client->id }}">
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <form action="{{ route('admin.client-side.status', [$client->id]) }}"
                                        method="post" id="status-{{ $client->id }}_form">
                                        @csrf
                                    </form>
                                </td>
                                {{-- Action Buttons --}}
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{ route('admin.client-side.edit', [$client->id]) }}"
                                        title="Edit">
                                        <i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                        href="javascript:"
                                        data-id="client-{{ $client->id }}"
                                        data-message="Want to delete this client ?"
                                        title="Delete">
                                        <i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{ route('admin.client-side.delete', [$client->id]) }}"
                                            method="post" id="client-{{ $client->id }}">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                            </tbody>
                        </table>
                    </div>
                    @if(count($clients) !== 0)
                    <hr>
                    @endif
                    <div class="page-area">
                        {!! $clients->links() !!}
                    </div>
                    @if(count($clients) === 0)
                    <div class="empty--data">
                        <img src="{{asset('/public/assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                        <h5>
                            {{translate('no_data_found')}}
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
