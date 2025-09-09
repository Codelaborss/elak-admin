@extends('layouts.admin.app')

@section('title',"Create How It Works Guide")

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
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c5f5f;
        margin-bottom: 15px;
        padding: 10px;
        background: white;
        border-radius: 6px;
        border-left: 4px solid #2c5f5f;
    }

    .step-container {
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
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .step-input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 10px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #2c5f5f;
        color: white;
    }

    .btn-primary:hover {
        background: #1a4040;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
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
</style>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
            </span>
            <span>Create How It Works Guide</span>
        </h1>
    </div>
    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
    @php($language = $language->value ?? null)
    @php($defaultLang = str_replace('_', '-', app()->getLocale()))

    <!-- End Page Header -->
    <div class="row g-3">
        <div class="col-12">
            <form id="guide-form" action="{{route('admin.workmanagement.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($language)
                <div class="main-content">
                    <div class="content-header">
                        <h1>Create How It Works Guide</h1>
                        <p>Create step-by-step instructions for your voucher types</p>
                    </div>
                    <div class="form-group">
                        <label for="voucher_type">Select Voucher Type *</label>
                        <select id="" name="voucher_type" required>
                            <option value="">-- Select Voucher Type --</option>
                            @foreach ($vouchers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="guide_title">Guide Title *</label>
                        <input type="text" id="guide_title" name="guide_title" required placeholder="Guide title will auto-generate based on voucher type">
                        <div class="error-message" id="guide_title_error"></div>
                    </div>

                    <!-- Purchase Process Section -->
                    <div class="section-builder">
                        <div class="section-title">Purchase Process</div>
                        <div id="purchase-steps" class="step-container" data-section="purchase_process">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <input type="text" class="step-input" name="purchase_process[]" placeholder="Enter step description..." value="Browse and select your desired voucher">
                                <button type="button" class="btn btn-danger" onclick="removeStep(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-step" onclick="addStep('purchase-steps', 'purchase_process[]')">+ Add Step</button>
                    </div>

                    <!-- Payment & Confirmation Section -->
                    <div class="section-builder">
                        <div class="section-title">Payment & Confirmation</div>
                        <div id="payment-steps" class="step-container" data-section="payment_confirmation">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <input type="text" class="step-input" name="payment_confirmation[]" placeholder="Enter step description..." value="Complete payment using your preferred method">
                                <button type="button" class="btn btn-danger" onclick="removeStep(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-step" onclick="addStep('payment-steps', 'payment_confirmation[]')">+ Add Step</button>
                    </div>

                    <!-- Voucher Delivery Section -->
                    <div class="section-builder">
                        <div class="section-title">Voucher Delivery</div>
                        <div id="delivery-steps" class="step-container" data-section="voucher_delivery">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <input type="text" class="step-input" name="voucher_delivery[]" placeholder="Enter step description..." value="Check your email inbox for voucher delivery">
                                <button type="button" class="btn btn-danger" onclick="removeStep(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-step" onclick="addStep('delivery-steps', 'voucher_delivery[]')">+ Add Step</button>
                    </div>

                    <!-- Redemption Process Section -->
                    <div class="section-builder">
                        <div class="section-title">Redemption Process</div>
                        <div id="redemption-steps" class="step-container" data-section="redemption_process">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <input type="text" class="step-input" name="redemption_process[]" placeholder="Enter step description..." value="Present voucher at participating location">
                                <button type="button" class="btn btn-danger" onclick="removeStep(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-step" onclick="addStep('redemption-steps', 'redemption_process[]')">+ Add Step</button>
                    </div>

                    <!-- Account Management Section -->
                    <div class="section-builder">
                        <div class="section-title">Account Management</div>
                        <div id="account-steps" class="step-container" data-section="account_management">
                            <div class="step-item">
                                <span class="step-number">1</span>
                                <input type="text" class="step-input" name="account_management[]" placeholder="Enter step description..." value="View all vouchers in your app account">
                                <button type="button" class="btn btn-danger" onclick="removeStep(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-add-step" onclick="addStep('account-steps', 'account_management[]')">+ Add Step</button>
                    </div>

                    <div class="actions-bar">
                        {{-- <button type="button" class="btn btn-secondary" onclick="previewGuide()">Preview Guide</button> --}}
                        {{-- <button type="button" class="btn btn-primary" onclick="saveAsDraft()">Save as Draft</button> --}}
                        {{-- <button type="button" class="btn btn-success" onclick="publishGuide()">Publish Guide</button> --}}
                    </div>
                      <div class="btn--container justify-content-end mt-5">
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                    </div>

                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- PREVIEW MODAL -->
    <div id="preview-modal" class="hidden" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: relative; width: 80%; height: 80%; margin: 5% auto; background: white; border-radius: 8px; overflow-y: auto;">
            <div style="padding: 20px; border-bottom: 2px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h2>Preview: How It Works Guide</h2>
                <button type="button" class="btn btn-secondary" onclick="closePreview()">Close</button>
            </div>
            <div id="preview-content" style="padding: 20px;">
                <!-- Preview content will be generated here -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('script_2')
<script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>
<script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 if needed
    $('#voucher_type').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Select Voucher Type',
        allowClear: true
    });
});

// Update guide title based on voucher type
function updateGuideTitle() {
    const voucherType = document.getElementById('voucher_type').value;
    const titleInput = document.getElementById('guide_title');

    clearError('voucher_type');

    const titles = {
        'in-store': 'How In-Store Vouchers Work',
        'online': 'How Online Vouchers Work',
        'service': 'How Service Vouchers Work',
        'gift': 'How Gift Vouchers Work'
    };

    titleInput.value = titles[voucherType] || '';
    clearError('guide_title');
}

// Add new step to a section
function addStep(containerId, fieldName) {
    const container = document.getElementById(containerId);
    const stepCount = container.children.length + 1;

    const stepHtml = `
        <div class="step-item">
            <span class="step-number">${stepCount}</span>
            <input type="text" class="step-input" name="${fieldName}" placeholder="Enter step description...">
            <button type="button" class="btn btn-danger" onclick="removeStep(this)">✕</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', stepHtml);
}

// Remove step from section
function removeStep(button) {
    const stepItem = button.parentNode;
    const container = stepItem.parentNode;

    // Don't remove if it's the last step
    if (container.children.length <= 1) {
        alert('At least one step is required in each section.');
        return;
    }

    stepItem.remove();

    // Renumber remaining steps
    const steps = container.children;
    for (let i = 0; i < steps.length; i++) {
        steps[i].querySelector('.step-number').textContent = i + 1;
    }
}

// Validate form
function validateForm() {
    let isValid = true;

    // Clear previous errors
    clearAllErrors();

    // Validate voucher type
    const voucherType = document.getElementById('voucher_type').value;
    if (!voucherType) {
        showError('voucher_type', 'Please select a voucher type');
        isValid = false;
    }

    // Validate guide title
    const guideTitle = document.getElementById('guide_title').value.trim();
    if (!guideTitle) {
        showError('guide_title', 'Please enter a guide title');
        isValid = false;
    }

    // Validate that each section has at least one non-empty step
    const sections = ['purchase-steps', 'payment-steps', 'delivery-steps', 'redemption-steps', 'account-steps'];

    sections.forEach(sectionId => {
        const container = document.getElementById(sectionId);
        const steps = container.querySelectorAll('.step-input');
        let hasContent = false;

        steps.forEach(step => {
            if (step.value.trim()) {
                hasContent = true;
            }
        });

        if (!hasContent) {
            alert(`Please add at least one step in the ${container.parentElement.querySelector('.section-title').textContent} section`);
            isValid = false;
        }
    });

    return isValid;
}

// Show error message
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + '_error');

    field.classList.add('error');
    if (errorDiv) {
        errorDiv.textContent = message;
    }
}

// Clear error message
function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId + '_error');

    field.classList.remove('error');
    if (errorDiv) {
        errorDiv.textContent = '';
    }
}

// Clear all errors
function clearAllErrors() {
    const errorFields = document.querySelectorAll('.error');
    const errorMessages = document.querySelectorAll('.error-message');

    errorFields.forEach(field => field.classList.remove('error'));
    errorMessages.forEach(msg => msg.textContent = '');
}




// Prevent form submission on Enter key in input fields
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('guide-form');

    form.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
        }
    });

});
</script>
@endpush
