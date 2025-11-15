@extends('layouts.admin.app')

@section('title',"Create How It Works Guide")

@section('content')

<style>
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

    .content-header h1 {
        margin: 0 0 10px 0;
        font-size: 24px;
    }

    .content-header p {
        margin: 0;
        color: #666;
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

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .form-group select:focus,
    .form-group input:focus {
        outline: none;
        border-color: #2c5f5f;
    }

    .section-builder {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 2px solid #e9ecef;
    }

    .section-header-input {
        width: 100%;
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        background: white;
    }

    .section-header-input:focus {
        outline: none;
        border-color: #2c5f5f;
    }

    .step-container {
        margin-bottom: 15px;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        background: white;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .step-number {
        background: #2c5f5f;
        color: white;
        min-width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .step-input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .step-input:focus {
        outline: none;
        border-color: #2c5f5f;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
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

    .btn--container {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }

    .btn--reset {
        background: #6c757d;
        color: white;
    }

    .btn--primary {
        background: #007bff;
        color: white;
    }

    .hidden {
        display: none;
    }

    .preview-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-modal-content {
        width: 90%;
        max-width: 800px;
        max-height: 80vh;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .preview-modal-header {
        padding: 20px;
        border-bottom: 2px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8f9fa;
    }

    .preview-modal-header h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .preview-modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
    }

    .preview-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        border-left: 4px solid #2c5f5f;
    }

    .preview-section h4 {
        color: #2c5f5f;
        margin: 0 0 10px 0;
        font-size: 16px;
    }

    .preview-section ol {
        margin: 0;
        padding-left: 20px;
    }

    .preview-section li {
        margin-bottom: 5px;
        line-height: 1.6;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 15px;
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

    <!-- Main Form -->
    <div class="row g-3">
        <div class="col-12">
            <form id="guide-form"
                  action="{{route('admin.workmanagement.store')}}"
                  method="post"
                  enctype="multipart/form-data"
                  x-data="guideForm()"
                  @submit="handleSubmit">
                @csrf

                @if ($language)
                <div class="main-content">
                    <div class="content-header">
                        <h1>Create How It Works Guide</h1>
                        <p>Create step-by-step instructions for your voucher types</p>
                    </div>

                    <!-- Voucher Type Selection -->
                    <div class="form-group">
                        <label for="voucher_type">Select Voucher Type *</label>
                        <select id="voucher_type"
                                name="voucher_type"
                                required
                                x-model="voucherType"
                                @change="updateGuideTitle">
                            <option value="">-- Select Voucher Type --</option>
                            @foreach ($vouchers as $item)
                                <option value="{{ $item->id }}" data-name="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="error-message" x-show="errors.voucherType" x-text="errors.voucherType"></div>
                    </div>

                    <!-- Guide Title -->
                    <div class="form-group">
                        <label for="guide_title">Guide Title *</label>
                        <input type="text"
                               id="guide_title"
                               name="guide_title"
                               required
                               placeholder="Guide title will auto-generate based on voucher type"
                               x-model="guideTitle">
                        <div class="error-message" x-show="errors.guideTitle" x-text="errors.guideTitle"></div>
                    </div>

                    <!-- Sections Builder -->
                    <div>
                        <!-- Existing Sections -->
                        <template x-for="(section, sIndex) in sections" :key="sIndex">
                            <div class="section-builder">
                                <!-- Section Title -->
                                <input type="text"
                                       class="section-header-input"
                                       placeholder="Enter Section Title..."
                                       x-model="section.title"
                                       :name="'sections[' + sIndex + '][title]'">

                                <button class="btn btn-danger mb-3"
                                        type="button"
                                        @click="removeSection(sIndex)"
                                        :disabled="sections.length === 1">
                                    <span x-show="sections.length === 1">⚠️ Last Section</span>
                                    <span x-show="sections.length > 1">🗑️ Remove Section</span>
                                </button>

                                <!-- Steps Container -->
                                <div class="step-container">
                                    <template x-for="(step, stIndex) in section.steps" :key="stIndex">
                                        <div class="step-item">
                                            <span class="step-number" x-text="stIndex + 1"></span>

                                            <input type="text"
                                                   class="step-input"
                                                   placeholder="Enter step description..."
                                                   x-model="section.steps[stIndex]"
                                                   :name="'sections[' + sIndex + '][steps][' + stIndex + ']'">

                                            <button class="btn btn-danger"
                                                    type="button"
                                                    @click="removeStep(sIndex, stIndex)"
                                                    :disabled="section.steps.length === 1">
                                                ✕
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <button type="button"
                                        class="btn btn-add-step"
                                        @click="addStep(sIndex)">
                                    ➕ Add Step
                                </button>
                            </div>
                        </template>

                        <!-- Add Section Button -->
                        <button type="button"
                                class="btn btn-primary"
                                style="width: 100%; margin-top: 20px;"
                                @click="addSection()">
                            ➕ Add New Section
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn--container">
                        <button type="button"
                                class="btn btn-secondary"
                                @click="showPreview = true">
                            👁️ Preview Guide
                        </button>
                        <button type="reset" class="btn btn--reset" @click="resetForm">
                            {{translate('messages.reset')}}
                        </button>
                        <button type="submit" class="btn btn--primary">
                            {{translate('messages.submit')}}
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
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('guideForm', () => ({
        voucherType: '',
        guideTitle: '',
        sections: [
            { title: '', steps: [''] }
        ],
        showPreview: false,
        errors: {
            voucherType: '',
            guideTitle: ''
        },

        // Initialize
        init() {
            console.log('Guide form initialized');
        },

        // Update guide title when voucher type changes
        updateGuideTitle() {
            if (this.voucherType) {
                const select = document.getElementById('voucher_type');
                const selectedOption = select.options[select.selectedIndex];
                const voucherName = selectedOption.getAttribute('data-name');
                this.guideTitle = `How to Use ${voucherName} Voucher`;
            } else {
                this.guideTitle = '';
            }
            this.errors.voucherType = '';
        },

        // Add new section
        addSection() {
            this.sections.push({ title: '', steps: [''] });
        },

        // Remove section
        removeSection(sIndex) {
            if (this.sections.length > 1) {
                this.sections.splice(sIndex, 1);
            } else {
                alert('At least one section is required.');
            }
        },

        // Add step to section
        addStep(sIndex) {
            if (!Array.isArray(this.sections[sIndex].steps)) {
                this.sections[sIndex].steps = [];
            }
            this.sections[sIndex].steps.push('');
        },

        // Remove step from section
        removeStep(sIndex, stIndex) {
            if (this.sections[sIndex].steps.length > 1) {
                this.sections[sIndex].steps.splice(stIndex, 1);
            } else {
                alert('At least one step is required in each section.');
            }
        },

        // Validate form
        validateForm() {
            this.errors = {
                voucherType: '',
                guideTitle: ''
            };

            let isValid = true;

            if (!this.voucherType) {
                this.errors.voucherType = 'Please select a voucher type';
                isValid = false;
            }

            if (!this.guideTitle.trim()) {
                this.errors.guideTitle = 'Please enter a guide title';
                isValid = false;
            }

            return isValid;
        },

        // Handle form submit
        handleSubmit(event) {
            if (!this.validateForm()) {
                event.preventDefault();
                alert('Please fix the errors before submitting');
                return false;
            }
        },

        // Reset form
        resetForm() {
            this.voucherType = '';
            this.guideTitle = '';
            this.sections = [{ title: '', steps: [''] }];
            this.errors = {
                voucherType: '',
                guideTitle: ''
            };
        }
    }));
});

// Prevent Enter key form submission
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('guide-form');

    if (form) {
        form.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && e.target.type !== 'submit' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
            }
        });
    }
});
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush
