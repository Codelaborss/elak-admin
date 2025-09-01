@extends('layouts.admin.app')

@section('title',"App List")

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span>
                   Add  Mobile App
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
                        <form action="{{route('admin.app.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="name"> Mobile App Name
                                                    </label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" placeholder="Enter Segment Name"
                                                    >
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            </div>
                                        </div>
                                         <div class="col-12 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="type">Select Types</label>
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="" disabled selected>-- Select Types --</option>
                                                            <option value="mobile_app">Mobile App</option>
                                                            <option value="website">Website</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-12 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="color_theme">Select Color</label>
                                                    <select name="color_theme" id="color_theme" class="form-control">
                                                        <option value="" disabled selected>-- Select Color --</option>
                                                        @foreach ($ColorTheme as $item )
                                                           <option value="{{ $item->id }}">{{ $item->color_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-12 ">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="descrption">
                                                        Description
                                                    </label>
                                                    <textarea name="descrption" id="descrption"
                                                        class="form-control" rows="3" placeholder="Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-12 col-md-4">
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label" for="banner">Select Banner</label>
                                                    <select name="banner" id="banner" class="form-control">
                                                        <option value="" disabled selected>-- Select Banner --</option>
                                                             @foreach ($Banner as $item )
                                                           <option value="{{ $item->id }}">{{ $item->type }}</option>
                                                        @endforeach
                                                    </select>
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
                                                                classs="img-thumbnail"
                                                                style="max-width: 120px; height:auto;">
                                                        </div>
                                                    @endif
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
                                Mobile App List<span class="badge badge-soft-dark ml-2" id="itemCount">{{$Apps->total()}}</span>
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
                                <th class="border-0">App Name</th>
                                <th class="border-0">type</th>
                                <th class="border-0">Description</th>
                                <th class="border-0">App Logo</th>
                                <th class="border-0">Color</th>
                                <th class="border-0">Banner</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Action</th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                            @foreach($Apps as $key => $App)
                            <tr>
                                <td class="text-center">
                                    <span class="mr-3">
                                        {{ $Apps->firstItem() + $key }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span title="{{ $App->app_name }}" class="font-size-sm text-body mr-3">
                                        {{ Str::limit($App->app_name, 20, '...') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $App->app_type }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $App->app_dec }}
                                    </span>
                                </td>
                                 <td class="text-center">
                                    <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                        <img src="{{ asset($App->app_logo) }}"
                                            class="img-fluid rounded open-image-modal"
                                            alt="Client Logo"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </td>
                                   <td class="text-center">
                                    <span class="bg-gradient-light text-dark">
                                        {{ $App->color_name }}
                                    </span>
                                </td>
                                   <td class="text-center">
                                    <div class="d-inline-block" style="width:50px; height:50px; cursor:pointer;">
                                        <img src="{{ asset($App->banner_image) }}"
                                            class="img-fluid rounded open-image-modal"
                                            alt="Client Logo"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </td>
                                {{-- Status Toggle (Active/Inactive) --}}
                                <td class="text-center">
                                    <label class="toggle-switch toggle-switch-sm" for="status-{{ $App->id }}">
                                        <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                            {{ $App->status == 'active' ? 'checked' : '' }}
                                            data-id="status-{{ $App->id }}"
                                            data-type="status"
                                            id="status-{{ $App->id }}">
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <form action="{{ route('admin.app.status', [$App->id]) }}"
                                        method="post" id="status-{{ $App->id }}_form">
                                        @csrf
                                    </form>
                                </td>

                                {{-- Action Buttons --}}
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="{{ route('admin.app.edit', [$App->id]) }}"
                                        title="Edit">
                                        <i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                        href="javascript:"
                                        data-id="client-{{ $App->id }}"
                                        data-message="Want to delete this client ?"
                                        title="Delete">
                                        <i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{ route('admin.app.delete', [$App->id]) }}"
                                            method="post" id="client-{{ $App->id }}">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($Apps) !== 0)
                    <hr>
                    @endif
                    <div class="page-area">
                        {!! $Apps->links() !!}
                    </div>
                    @if(count($Apps) === 0)
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
