@extends('layouts.admin.app')

@section('title',"segments List")

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span>
                   Add Segments
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
                        <form action="{{route('admin.segments.store')}}" method="post">
                            @csrf
                            @if ($language)
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="name"> Segment Name
                                                    </label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" placeholder="Enter Segment Name"
                                                    >
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            </div>
                                        </div>
                                         <div class="col-12 col-md-6">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="type">Select Types</label>
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="" disabled selected>-- Select Types --</option>
                                                            <option value="free">Free</option>
                                                            <option value="paid">Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                          <div class="col-12 col-md-6">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="validation_date"> Validation Days
                                                    </label>
                                                    <input type="text" name="validation_date" id="validation_date"
                                                        class="form-control"  placeholder="Enter The Number"
                                                    >
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
                                Client List<span class="badge badge-soft-dark ml-2" id="itemCount">{{$Segments->total()}}</span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="{{ request()?->search ?? null }}" type="search" name="search" class="form-control"
                                            placeholder="Ex: segment Name" aria-label="Search" >
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
                                <th class="border-0">Segment Name</th>
                                <th class="border-0">type</th>
                                <th class="border-0">Validation Date</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Action</th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                            @foreach($Segments as $key => $Segment)
                            <tr>
                                <td class="text-center">
                                    <span class="mr-3">
                                        {{ $Segments->firstItem() + $key }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span title="{{ $Segment->name }}" class="font-size-sm text-body mr-3">
                                        {{ Str::limit($Segment->name, 20, '...') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $Segment->type }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $Segment->validation_date }}
                                    </span>
                                </td>
                                {{-- Status Toggle (Active/Inactive) --}}
                                <td class="text-center">
                                    <label class="toggle-switch toggle-switch-sm" for="status-{{ $Segment->id }}">
                                        <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                            {{ $Segment->status == 'active' ? 'checked' : '' }}
                                            data-id="status-{{ $Segment->id }}"
                                            data-type="status"
                                            id="status-{{ $Segment->id }}">
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <form action="{{ route('admin.segments.status', [$Segment->id]) }}"
                                        method="post" id="status-{{ $Segment->id }}_form">
                                        @csrf
                                    </form>
                                </td>

                                {{-- Action Buttons --}}
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{ route('admin.segments.edit', [$Segment->id]) }}"
                                        title="Edit">
                                        <i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                        href="javascript:"
                                        data-id="client-{{ $Segment->id }}"
                                        data-message="Want to delete this client ?"
                                        title="Delete">
                                        <i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{ route('admin.segments.delete', [$Segment->id]) }}"
                                            method="post" id="client-{{ $Segment->id }}">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($Segments) !== 0)
                    <hr>
                    @endif
                    <div class="page-area">
                        {!! $Segments->links() !!}
                    </div>
                    @if(count($Segments) === 0)
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
@endpush
