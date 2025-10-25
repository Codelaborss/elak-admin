@extends('layouts.admin.app')

@section('title',"Message Template List")

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
                   Add  Message Template
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
                        <form action="{{route('admin.MessageTemplate.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)
                                <div class="row">
                                    <div class="col-6 ">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="title">  Title
                                                </label>
                                                <input type="text" name="title" id="title" class="form-control"  placeholder="Enter Title">
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    </div>
                                    <div class="col-6 ">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label" for="icon">icon </label>
                                                <input type="file" name="icon" id="icon" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 ">
                                        <div class="form-group mb-0">
                                              <label class="input-label"
                                                  for="exampleFormControlInput1">des</label>
                                              <textarea type="text" name="des" placeholder="des" class="form-control min-h-90px ckeditor"></textarea>
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

            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                Message Template<span class="badge badge-soft-dark ml-2" id="itemCount"></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search" name="search" class="form-control"
                                            placeholder="Ex: Message Template" aria-label="Search" >
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
                                <th class="border-0">Title</th>
                                <th class="border-0">Logo</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Action</th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                         @foreach($MessageTemplate as $key => $item)
                            <tr>
                                {{-- Serial No --}}
                                <td class="text-center">
                                    <span class="mr-3">
                                        {{ $MessageTemplate->firstItem() + $key }}
                                    </span>
                                </td>


                                {{-- Client Name --}}
                                <td class="text-center">
                                    <span title="{{ $item->title }}" class="font-size-sm text-body mr-3">
                                        {{ Str::limit($item->title, 20, '...') }}
                                    </span>
                                </td>

                                {{-- Client Created At --}}
                                <td class="text-center">
                                    <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                        <img src="{{ asset($item->icon) }}"
                                            class="img-fluid rounded open-image-modal"
                                            alt="Client Logo"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </td>
                                    {{-- Status Toggle (Active/Inactive) --}}
                                <td class="text-center">
                                    <label class="toggle-switch toggle-switch-sm" for="status-{{ $item->id }}">
                                        <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                            {{ $item->status == 'active' ? 'checked' : '' }}
                                            data-id="status-{{ $item->id }}"
                                            data-type="status"
                                            id="status-{{ $item->id }}">
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <form action="{{ route('admin.MessageTemplate.status', [$item->id]) }}"
                                        method="post" id="status-{{ $item->id }}_form">
                                        @csrf
                                    </form>
                                </td>
                                {{-- Action Buttons --}}
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{ route('admin.MessageTemplate.edit', [$item->id]) }}"
                                        title="Edit">
                                        <i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                        href="javascript:"
                                        data-id="client-{{ $item->id }}"
                                        data-message="Want to delete this client ?"
                                        title="Delete">
                                        <i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{ route('admin.MessageTemplate.delete', [$item->id]) }}"
                                            method="post" id="client-{{ $item->id }}">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                            </tbody>
                        </table>
                    </div>
                    @if(count($MessageTemplate) !== 0)
                    <hr>
                    @endif
                    <div class="page-area">
                        {!! $MessageTemplate->links() !!}
                    </div>
                    @if(count($MessageTemplate) === 0)
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
    <script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>

 <script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
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
