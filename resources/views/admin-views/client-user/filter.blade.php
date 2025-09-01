@extends('layouts.admin.app')
@section('title',"Filter List")
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
                   Client Filter
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
                        <form action="{{route('admin.client-side.filter')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                            <label class="form-label" for="select_client"> Select Client </label>
                                            <select
                                                name="select_client"
                                                id="select_client"
                                                class="form-control Clients-select"
                                                data-placeholder="-- Select Client --">
                                                <option></option>
                                                @foreach ($Clients as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                                <div class="valid-feedback">
                                                Great choice! Client selected successfully.
                                            </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="">
                                            <label class="form-label" for="segment_type">
                                                Segment Types
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select
                                                name="segment_type"
                                                id="segment_type"
                                                class="form-control segment-select"
                                                data-placeholder="-- Select Segment --">
                                                <option></option>
                                            </select>
                                            <div class="valid-feedback">
                                                Great choice! Segment selected successfully.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="ref_id"> Ref Id
                                                </label>
                                                <input type="number" name="ref_id"  value="{{ request('ref_id') }}" id="ref_id" class="form-control"  placeholder="Ref Id">
                                            </div>
                                        </div>
                                    </div>
                                  <div class="col-6 col-md-4">
                                <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="status"> Status </label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">-- Select Status --</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-6 col-md-4">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="from_date"> From
                                                </label>
                                                <input type="date" name="from_date" value="{{ request('from_date') }}" id="from_date" class="form-control"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="lang_form" id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="to_date"> To
                                                </label>
                                                <input type="date" name="to_date" value="{{ request('to_date') }}"  id="to_date" class="form-control"  >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="btn--container justify-content-end mt-5">
                                <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                <button type="submit" class="btn btn--primary">{{translate('messages.filter')}}</button>
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
                                User List<span class="badge badge-soft-dark ml-2" id="itemCount"></span>
                            </h5>
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
                                <th class="border-0">Username</th>
                                   <th class="border-0">Client Name</th>
                                   <th class="border-0">Segment</th>
                                <th class="border-0">status</th>
                                <th class="border-0">Ref Id</th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                         @foreach($Users as $key => $User)
                            <tr>
                                {{-- Serial No --}}
                                <td class="text-center">
                                    <span class="mr-3">
                                        {{ $Users->firstItem() + $key }}
                                    </span>
                                </td>

                                {{-- Client Name --}}
                                <td class="text-center">
                                 --
                                </td>

                                {{-- Client Email --}}
                                <td class="text-center">
                                  --
                                </td>
                              {{-- Client Types --}}
                                <td class="text-center">
                                   --
                                </td>

                                <td class="text-center">
                                    {{ $User->client_name ?? '' }}
                                </td>
                            {{-- Segment Names --}}
                                <td class="text-center">
                                    @if(!empty($User->type_names))
                                    {{-- @dd($User->type_names) --}}
                                        @foreach($User->type_names as $segment)
                                            <span class="badge badge-soft-primary mr-1 my-1">{{ $segment }}</span><br>
                                        @endforeach
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>

                                {{-- Client Created At --}}
                                <td class="text-center">
                                    @if($User->status == 1)
                                        <span class="badge badge-soft-success">Active</span>
                                    @else
                                        <span class="badge badge-soft-danger">Inactive</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                  {{ $User->ref_by ?? '' }}
                                </td>

                            </tr>
                        @endforeach

                            </tbody>
                        </table>
                    </div>
                    @if(count($Users) !== 0)
                    <hr>
                    @endif
                    <div class="page-area">
                        {!! $Users->links() !!}
                    </div>
                    @if(count($Users) === 0)
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
