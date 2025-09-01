@extends('layouts.admin.app')

@section('title'," Edit Segment")

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/edit.png')}}" class="w--26" alt="">
                </span>
                <span>
                    Edit Mobile App
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.app.update',[$App['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                        @php($language = $language->value ?? null)
                        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
                        @if($language)

                          <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="name"> Mobile App Name
                                            </label>
                                            <input type="text" name="name" id="name"
                                                class="form-control" value="{{ $App->app_name }}" placeholder="Enter Segment Name"
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
                                                    <option value="mobile_app" {{ $App->app_type == "mobile_app" ? "Selected":"" }}>Mobile App</option>
                                                    <option value="website" {{ $App->app_type == "website" ? "Selected":"" }}>Website</option>
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
                                                        <option value="{{ $item->id }}" {{ $item->id == $App->color_theme ? "Selected":"" }} >{{ $item->color_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12  ">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="descrption">
                                                Description
                                            </label>
                                            <textarea name="descrption" id="descrption"
                                                class="form-control" rows="3" placeholder="Description">{{$App->app_dec}}</textarea>
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
                                                        <option value="{{ $item->id }}" {{ $item->id == $App->banner ? "Selected":"" }} >{{ $item->type }}</option>
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
                                            @if(!empty($App->app_logo))
                                                <div class="mt-2">
                                                    <img src="{{ asset($App->app_logo) }}"
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

@endpush
