@extends('layouts.admin.app')
@section('title',"Color Themes")
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

        .is-valid ~ .valid-feedback {
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
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span>
                   Color Theme List
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
                        <form action="{{route('admin.client-side.color_theme')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                for="color_name"> Color Name
                                            </label>
                                            <input type="text" name="color_name" value="{{ request('color_name') }}" id="color_name" class="form-control"  >
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                for="color_code"> Color Code
                                            </label>
                                            <input type="text" name="color_code" value="{{ request('color_code') }}" id="color_code" class="form-control"  >
                                        </div>
                                    </div>
                                    </div>
                                   <div class="col-6 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="gradient_option"> Gradient </label>
                                            <div class="mt-2">
                                                <label class="mr-3">
                                                    <input type="radio" name="gradient_option" value="1"  {{ request('gradient_option') == '1' ? 'checked' : '' }}> True
                                                </label>
                                                <label>
                                                    <input type="radio" name="gradient_option" value="0" checked {{ request('gradient_option') == '0' ? 'checked' : '' }}> False
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-6 col-md-4">
                                        <div class="lang_form" id="default-form">
                                              <div class="form-group">
                                                  <label class="input-label" for="color_type"> Type </label>
                                                  <select name="color_type" id="color_type" class="form-control">
                                                      <option value="">-- Select Type --</option>
                                                      <option value="primary" {{ request('color_type') == 'primary' ? 'selected' : '' }}>primary</option>
                                                      <option value="secondary" {{ request('color_type') == 'secondary' ? 'selected' : '' }}>secondary</option>
                                                  </select>
                                              </div>
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
                                Banner List<span class="badge badge-soft-dark ml-2" id="itemCount"></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search" name="search" class="form-control"
                                            placeholder="Ex: Banner" aria-label="Search" >
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
                                <th class="border-0">Color Name</th>
                                <th class="border-0">Color Code</th>
                                <th class="border-0">Gradient</th>
                                <th class="border-0">Color Type</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Action</th>
                            </tr>

                            </thead>
                            <tbody id="set-rows">
                         @foreach($Banners as $key => $Banner)
                            <tr>
                                {{-- Serial No --}}
                                <td class="text-center">
                                    <span class="mr-3">
                                        {{  $key +1 }}
                                    </span>
                                </td>
                                {{-- Client Email --}}
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $Banner->color_name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $Banner->color_code }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        @if ($Banner->color_gradient == "1")
                                        <span class="badge badge-soft-primary mr-1 my-1">True</span>
                                        @else
                                        <span class="badge badge-soft-primary mr-1 my-1">False</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $Banner->color_type }}
                                    </span>
                                </td>

                                {{-- Status Toggle (Active/Inactive) --}}
                                <td class="text-center">
                                    <label class="toggle-switch toggle-switch-sm" for="status-{{ $Banner->id }}">
                                        <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                            {{ $Banner->status == '1' ? 'checked' : '' }}
                                            data-id="status-{{ $Banner->id }}"
                                            data-type="status"
                                            id="status-{{ $Banner->id }}">
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <form action="{{ route('admin.client-side.status_color_theme', [$Banner->id]) }}"
                                        method="post" id="status-{{ $Banner->id }}_form">
                                        @csrf
                                    </form>
                                </td>
                                {{-- Action Buttons --}}
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{ route('admin.client-side.edit_color_theme', [$Banner->id]) }}"
                                        title="Edit">
                                        <i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                        href="javascript:"
                                        data-id="client-{{ $Banner->id }}"
                                        data-message="Want to delete this client ?"
                                        title="Delete">
                                        <i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{ route('admin.client-side.delete_color_theme', [$Banner->id]) }}"
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
                    @if(count($Banners) !== 0)
                    <hr>
                    @endif
                    <div class="page-area">
                        {!! $Banners->links() !!}
                    </div>
                    @if(count($Banners) === 0)
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

 <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
