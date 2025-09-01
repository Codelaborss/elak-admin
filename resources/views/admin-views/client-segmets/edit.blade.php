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
                    Edit Segment
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.segments.update',[$Segments['id']])}}" method="post">
                    @csrf
                    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                        @php($language = $language->value ?? null)
                        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
                        @if($language)
                            <div class="row">

                                <div class="col-12 col-md-6">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="name"> Segment Name
                                            </label>
                                            <input type="text" name="name" id="name" class="form-control"  placeholder="Enter Client Name" value="{{ $Segments->name }}">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="type">Select Type</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="" disabled selected>-- Select Type --</option>
                                                    <option value="free" {{ $Segments->type == "free" ? "Selected":"" }}>Free</option>
                                                    <option value="paid" {{ $Segments->type == "paid" ? "Selected":"" }}>Paid</option>
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
                                                    class="form-control"  value="{{ $Segments->validation_date }}"  placeholder="Enter The Number"
                                                >
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
