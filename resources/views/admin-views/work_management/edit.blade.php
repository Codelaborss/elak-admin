@extends('layouts.admin.app')

@section('title',"Edit How It Works Guide")

@section('content')

<style>
    .search-container {
        padding: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .search-box {
        width: 100%;
        padding: 10px 12px;
        border: none;
        border-radius: 6px;
        background: rgba(255,255,255,0.1);
        color: white;
        font-size: 14px;
        outline: none;
    }

    .menu-item {
        display: block;
        padding: 12px 20px;
        color: white;
        text-decoration: none;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s ease;
        font-size: 14px;
        cursor: pointer;
    }

    .menu-item:hover, .menu-item.active {
        background: rgba(255,255,255,0.1);
        padding-left: 25px;
    }

    .section-header {
        padding: 15px 20px 8px;
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .icon {
        margin-right: 10px;
        width: 16px;
        display: inline-block;
    }

    .main-content {
        flex: 1;
        padding: 20px;
        background: white;
        margin: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-y: auto;
    }

    .content-header {
        color: #333;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #2c5f5f;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group select, .form-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group select:focus, .form-group input:focus {
        outline: none;
        border-color: #2c5f5f;
    }

    .section-builder {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 2px solid #e0e0e0;
    }

    .section-number {
        font-size: 24px;
        font-weight: 700;
        color: #2c5f5f;
        margin-bottom: 15px;
        display: inline-block;
        background: white;
        padding: 5px 15px;
        border-radius: 6px;
    }

    .section-title-input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .section-title-input:focus {
        outline: none;
        border-color: #2c5f5f;
    }

    .step-container {
        margin-top: 20px;
        margin-bottom: 15px;
    }

    .step-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        background: white;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .step-number {
        background: #2c5f5f;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: bold;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .step-input {
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 10px;
        font-size: 14px;
    }

    .step-input:focus {
        outline: none;
        border-color: #2c5f5f;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn-primary {
        background: #2c5f5f;
        color: white;
    }

    .btn-primary:hover {
        background: #1a4040;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        font-size: 13px;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .remove-section-btn {
        background: #dc3545;
        color: white;
        padding: 8px 16px;
        margin-bottom: 15px;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-add-step {
        width: 100%;
        margin-top: 10px;
        background: #17a2b8;
        color: white;
        padding: 10px;
    }

    .btn-add-step:hover {
        background: #138496;
    }

    .actions-bar {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 20px 0;
        border-top: 2px solid #eee;
        margin-top: 30px;
    }

    .hidden {
        display: none;
    }

    .preview-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .preview-section {
        background: white;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        border-left: 4px solid #2c5f5f;
    }

    .preview-section h4 {
        color: #2c5f5f;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .preview-section ol {
        margin-left: 20px;
    }

    .preview-section li {
        margin-bottom: 5px;
        line-height: 1.5;
    }

    .error {
        border-color: #dc3545 !important;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }

    .btn--container {
        display: flex;
        gap: 10px;
    }

    .btn--reset {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
    }

    .btn--reset:hover {
        background: #5a6268;
    }

    .btn--primary {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
    }

    .btn--primary:hover {
        background: #0056b3;
    }

    #sections-container {
        margin-top: 20px;
    }
</style>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
            </span>
            <span>{{ isset($ManagementType) ? 'Edit How It Works Guide' : 'Create How It Works Guide' }}</span>
        </h1>
    </div>

    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
    @php($language = $language->value ?? null)
    @php($defaultLang = str_replace('_', '-', app()->getLocale()))

    <!-- End Page Header -->
    <div class="row g-3">
        <div class="col-12">
            <form action="{{route('admin.workmanagement.update',[$ManagementType['id']])}}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($ManagementType))
                    @method('post')
                @endif

                @if ($language)
                <div class="main-content">
                    <div class="content-header">
                        <h1>{{ isset($ManagementType) ? 'Edit How It Works Guide' : 'Create How It Works Guide' }}</h1>
                        <p>{{ isset($ManagementType) ? 'Update step-by-step instructions for your voucher types' : 'Create step-by-step instructions for your voucher types' }}</p>
                    </div>

                    <div class="form-group">
                        <label for="voucher_type">Select Voucher Type *</label>
                        <select id="voucher_type" name="voucher_type" required>
                            <option value="">-- Select Voucher Type --</option>
                            @foreach ($vouchers as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($ManagementType) && $ManagementType->voucher_type == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="guide_title">Guide Title *</label>
                        <input type="text" id="guide_title" name="guide_title"
                               value="{{ isset($ManagementType) ? $ManagementType->guid_title : '' }}"
                               required placeholder="Enter guide title">
                        <div class="error-message" id="guide_title_error"></div>
                    </div>

                    <!-- Sections Container -->
                    <div id="sections-container">
                        <!-- Sections will be dynamically added here -->
                    </div>

                    <!-- Add Section Button -->
                    <button type="button" class="btn btn-primary mt-4" id="add-section-btn">
                        + Add More Section
                    </button>

                    <div class="btn--container justify-content-end mt-5">
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">
                            {{ isset($ManagementType) ? translate('messages.update') : translate('messages.submit') }}
                        </button>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection

@push('script_2')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
<script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
<script src="{{asset('public/assets/admin')}}/js/view-pages/product-index.js"></script>
<script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>
<script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
$(document).ready(function() {
    let sectionIndex = 0;

    // Existing sections data from backend (for edit mode)
    let existingSections = @json($sections ?? []);

    // Parse if it's a string (double encoded JSON)
    if (typeof existingSections === 'string') {
        try {
            existingSections = JSON.parse(existingSections);
        } catch (e) {
            console.error('Error parsing sections:', e);
            existingSections = [];
        }
    }

    console.log('Loaded sections:', existingSections); // Debug

    // Initialize: Load existing sections or add one empty section
    if (existingSections && Array.isArray(existingSections) && existingSections.length > 0) {
        existingSections.forEach(function(section, index) {
            addSection(section.title || '', section.steps || [''], index + 1);
        });
    } else {
        addSection('', [''], 1);
    }

    // Add Section Function
    function addSection(title = '', steps = [''], displayNumber = null) {
        // If displayNumber not provided, calculate it
        if (displayNumber === null) {
            displayNumber = $('.section-builder').length + 1;
        }

        // Escape HTML to prevent XSS and handle special characters
        let escapedTitle = $('<div>').text(title).html();

        let sectionHtml = `
            <div class="section-builder" data-section-index="${sectionIndex}">
                <!-- Section Number Display -->
                <span class="section-number">${displayNumber}</span>

                <!-- Section Title Input -->
                <input type="text"
                       class="section-title-input"
                       placeholder="Enter Section Title..."
                       name="sections[${sectionIndex}][title]"
                       value="${escapedTitle}">

                <button class="btn btn-danger remove-section-btn" type="button">
                    Remove Section
                </button>

                <!-- Steps Container -->
                <div class="step-container" data-section-index="${sectionIndex}">
                    <!-- Steps will be added here -->
                </div>

                <button type="button" class="btn btn-add-step" data-section-index="${sectionIndex}">
                    + Add Step
                </button>
            </div>
        `;

        $('#sections-container').append(sectionHtml);

        // Add steps for this section
        if (Array.isArray(steps) && steps.length > 0) {
            steps.forEach(function(stepText) {
                addStep(sectionIndex, stepText || '');
            });
        } else {
            addStep(sectionIndex, '');
        }

        sectionIndex++;
        updateSectionNumbers();
    }

    // Add Step Function
    function addStep(secIndex, stepText = '') {
        let stepContainer = $(`.step-container[data-section-index="${secIndex}"]`);
        let stepCount = stepContainer.find('.step-item').length;

        // Escape HTML to prevent XSS and handle special characters
        let escapedStepText = $('<div>').text(stepText).html();

        let stepHtml = `
            <div class="step-item">
                <span class="step-number">${stepCount + 1}</span>
                <input type="text"
                       class="step-input"
                       placeholder="Enter step description..."
                       name="sections[${secIndex}][steps][${stepCount}]"
                       value="${escapedStepText}">
                <button class="btn btn-danger remove-step-btn" type="button">
                    ✕
                </button>
            </div>
        `;

        stepContainer.append(stepHtml);
    }

    // Update section numbers display
    function updateSectionNumbers() {
        $('.section-builder').each(function(index) {
            $(this).find('.section-number').text(index + 1);
        });
    }

    // Update step numbers after removal
    function updateStepNumbers(secIndex) {
        let stepContainer = $(`.step-container[data-section-index="${secIndex}"]`);
        stepContainer.find('.step-item').each(function(index) {
            $(this).find('.step-number').text(index + 1);
            $(this).find('.step-input').attr('name', `sections[${secIndex}][steps][${index}]`);
        });
    }

    // Event: Add Section
    $('#add-section-btn').on('click', function() {
        let nextNumber = $('.section-builder').length + 1;
        addSection('', [''], nextNumber);
    });

    // Event: Add Step
    $(document).on('click', '.btn-add-step', function() {
        let secIndex = $(this).data('section-index');
        addStep(secIndex, '');
    });

    // Event: Remove Section
    $(document).on('click', '.remove-section-btn', function() {
        if ($('.section-builder').length > 1) {
            $(this).closest('.section-builder').remove();
            updateSectionNumbers();
        } else {
            alert('At least one section is required!');
        }
    });

    // Event: Remove Step
    $(document).on('click', '.remove-step-btn', function() {
        let stepItem = $(this).closest('.step-item');
        let section = stepItem.closest('.section-builder');
        let secIndex = section.data('section-index');

        if (section.find('.step-item').length > 1) {
            stepItem.remove();
            updateStepNumbers(secIndex);
        } else {
            alert('At least one step is required per section!');
        }
    });

    // Form Reset Handler
    $('form').on('reset', function() {
        setTimeout(function() {
            $('#sections-container').empty();
            sectionIndex = 0;

            if (existingSections && Array.isArray(existingSections) && existingSections.length > 0) {
                existingSections.forEach(function(section, index) {
                    addSection(section.title || '', section.steps || [''], index + 1);
                });
            } else {
                addSection('', [''], 1);
            }
        }, 10);
    });

    // Voucher card selection (if needed)
    $(document).on('click', '.voucher-card_2, .js-select2-custom', function() {
        $('.voucher-card_2').removeClass('selected');
        $(this).addClass('selected');
    });
});
</script>

@endpush
