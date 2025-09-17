@extends('layouts.admin.app')

@section('title',"Bonus & Limits Settings")

@section('content')

      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
<style>
    .select2-container .select2-selection--single{
        height: 45px!important;
    }
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
    <style>
    .menu-item {
        padding: 15px 25px;
        cursor: pointer;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .menu-item:hover {
        background: rgba(255,255,255,0.15);
        padding-left: 30px;
    }

    .menu-item.active {
        background: rgba(255,255,255,0.2);
        border-right: 4px solid #fff;
    }

    .menu-icon {
        margin-right: 12px;
        font-size: 16px;
        width: 20px;
        text-align: center;
    }

    .main-content {
        flex: 1;
        padding: 30px;
        background: white;
        margin: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        overflow-y: auto;
    }

    .section.active {
        display: block;
    }

    .page-header {
        margin-bottom: 35px;
        padding-bottom: 20px;
        border-bottom: 3px solid #667eea;
    }

    .page-header h1 {
        color: #333;
        font-size: 32px;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .page-header p {
        color: #666;
        font-size: 16px;
    }

    .form-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border-left: 4px solid #667eea;
    }

    .section-title {
        color: #667eea;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn:hover {
        background: #5a6fd8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
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

    .btn-secondary:hover {
        background: #545b62;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .btn--reset {
        background: #f8f9fa;
        color: #6c757d;
        border: 2px solid #e9ecef;
    }

    .btn--reset:hover {
        background: #e9ecef;
        color: #495057;
    }

    .btn--primary {
        background: #667eea;
        color: white;
    }

    .merchant-list {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-top: 15px;
        display: block;
    }

    .merchant-item {
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .merchant-item:hover {
        background: #f8f9fa;
    }

    .merchant-item.selected {
        background: #e8f4fd;
        border-left: 4px solid #667eea;
    }

    .merchant-name {
        font-weight: 600;
        color: #333;
    }

    .merchant-info {
        font-size: 13px;
        color: #666;
        margin-top: 5px;
    }

    .bonus-tiers {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
        border: 1px solid #e9ecef;
        display: block;
    }

    .tier-item {
        display: grid;
        grid-template-columns: 1fr 1fr 120px 80px;
        gap: 15px;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .tier-header {
        grid-column: 1 / -1;
        font-weight: 600;
        color: #667eea;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .tier-input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
    }

    .radio-group {
        display: flex;
        gap: 20px;
    }

    .radio-group label {
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .btn--container {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .loading-spinner {
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .error-message {
        color: #dc3545;
        padding: 15px;
        text-align: center;
        background: #f8d7da;
        border-radius: 8px;
        margin: 10px 0;
    }

    .success-message {
        color: #155724;
        padding: 15px;
        text-align: center;
        background: #d4edda;
        border-radius: 8px;
        margin: 10px 0;
    }
    </style>

    <div class="content container-fluid">
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))

        <div class="row g-3">
            <div class="col-12">
                <form action="{{route('admin.Giftcard.update_bonus',$BonuLimitSetting->id)}}" method="post" enctype="multipart/form-data" id="occasionForm">
                    @csrf
                    @if ($language)
                        <div class="main-content">
                            <!-- MERCHANT BONUS & LIMITS -->
                            <div id="merchant-bonus" class="section">
                                <div class="page-header">
                                    <h1>Bonus & Limits Settings</h1>
                                    <p>Configure multi-level bonus tiers and amount limits per merchant</p>
                                </div>

                                <input type="hidden" name="hidden_store_id" value="{{ $BonuLimitSetting->hidden_store_id ?? '' }}" id="hidden_store_id" />

                                <!-- Type Selection -->
                                <div class="form-section">
                                    <div class="section-title">Select Type</div>
                                    <div class="form-group">
                                        <div class="radio-group">
                                            <label>
                                                <input type="radio" id="type_flate" {{ isset($BonuLimitSetting) && $BonuLimitSetting->type == "flate" ? "checked" : "" }} name="type_select" value="flate">
                                                Flat Discount
                                            </label>
                                            <label>
                                                <input type="radio" id="type_bonus" {{ isset($BonuLimitSetting) && $BonuLimitSetting->type == "bonus" ? "checked" : "" }} name="type_select" value="bonus">
                                                Bonus Discount
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Voucher Type Selection -->
                                <div class="form-section">
                                    <div class="section-title">Select Voucher Type</div>
                                    <div class="form-group">
                                        <label for="voucher_type">Voucher Type</label>
                                        <select id="voucher_type" name="voucher_type" required>
                                            <option value="">-- Select Voucher Type --</option>
                                            @foreach(\App\Models\VoucherType::get() as $VoucherType)
                                                <option value="{{ $VoucherType->id }}"
                                                    {{ (isset($BonuLimitSetting) && $BonuLimitSetting->voucher_type == $VoucherType->id) ? 'selected' : '' }}>
                                                    {{ $VoucherType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Category & Merchant Selection -->
                                <div class="form-section">
                                    <div class="section-title">Select Category & Merchant</div>
                                    <div class="form-group">
                                        <label for="categoryFilter">Business Category</label>
                                        <select id="categoryFilter" name="category" onchange="loadMerchantsByCategory()" required>
                                            <option value="">-- Select Category --</option>
                                            @foreach(\App\Models\Category::get() as $Category)
                                                <option value="{{ $Category->id }}"
                                                    {{ (isset($BonuLimitSetting) && $BonuLimitSetting->category == $Category->id) ? 'selected' : '' }}>
                                                    {{ $Category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="merchant-list" id="merchantsList">
                                        @if(isset($giftCards) && count($giftCards) > 0)
                                            @foreach($giftCards as $merchant)
                                                <div class="merchant-item {{ isset($BonuLimitSetting) && $merchant->id == $BonuLimitSetting->hidden_store_id ? 'selected' : '' }}"
                                                    onclick="selectMerchantItem(this, {{ $merchant->id }})">
                                                    <div class="merchant-name">{{ $merchant->name }}</div>
                                                    <div class="merchant-info">
                                                        Current: {{ $merchant->bonus_tiers ?? 0 }} bonus tiers |
                                                        Limits: ${{ $merchant->limit_from ?? 0 }} - ${{ $merchant->limit_to ?? 0 }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="loading-spinner">Select a category to view stores</div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Multi-Level Bonus Configuration -->
                                <div class="form-section">
                                    <div class="section-title">Multi-Level Bonus Configuration</div>

                                    <div class="bonus-tiers" id="bonusTiers">
                                        <div class="tier-header">Bonus Tiers Configuration</div>
                                        <div class="tier-item">
                                            <div><strong>Min Amount</strong></div>
                                            <div><strong>Max Amount</strong></div>
                                            <div><strong>Bonus %</strong></div>
                                            <div><strong>Action</strong></div>
                                        </div>
                                        <div id="tiersList">
                                            @php($tiers = json_decode($BonuLimitSetting->multi_level_bonus_configuration ?? '{}', true))
                                            @if(!empty($tiers) && isset($tiers['min']) && is_array($tiers['min']))
                                                @for($i = 0; $i < count($tiers['min']); $i++)
                                                    <div class="tier-item" id="tier-{{ $i }}">
                                                        <input type="number" class="tier-input" name="min[]" placeholder="Min $"
                                                               value="{{ $tiers['min'][$i] ?? '' }}" min="0" required>
                                                        <input type="number" class="tier-input" name="max[]" placeholder="Max $"
                                                               value="{{ $tiers['max'][$i] ?? '' }}" min="0" required>
                                                        <input type="number" class="tier-input" name="bonus[]" placeholder="Bonus %"
                                                               value="{{ $tiers['bonus'][$i] ?? '' }}" min="0" max="100" required>
                                                        <button type="button" class="btn btn-danger" onclick="removeTier({{ $i }})" style="padding: 8px; font-size: 12px;">Remove</button>
                                                    </div>
                                                @endfor
                                            @else
                                                <div class="tier-item" id="tier-0">
                                                    <input type="number" class="tier-input" name="min[]" placeholder="Min $" min="0" required>
                                                    <input type="number" class="tier-input" name="max[]" placeholder="Max $" min="0" required>
                                                    <input type="number" class="tier-input" name="bonus[]" placeholder="Bonus %" min="0" max="100" required>
                                                    <button type="button" class="btn btn-danger" onclick="removeTier(0)" style="padding: 8px; font-size: 12px;">Remove</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary" onclick="addBonusTier()">Add New Tier</button>
                                </div>

                                <!-- Amount Limits -->
                                <div class="form-section">
                                    <div class="section-title">Amount Limits</div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="merchantMinAmount">Minimum Gift Card Amount</label>
                                            <input type="number" value="{{ $BonuLimitSetting->min_gift_ard ?? '' }}"
                                                   name="min_gift_ard" id="merchantMinAmount" placeholder="25" min="1" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="merchantMaxAmount">Maximum Gift Card Amount</label>
                                            <input type="number" value="{{ $BonuLimitSetting->max_gift_ard ?? '' }}"
                                                   name="max_gift_ard" id="merchantMaxAmount" placeholder="1000" min="1" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="btn--container">
                                    <button type="button" class="btn btn--reset" id="resetBtn">{{translate('messages.reset')}}</button>
                                    <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script_2')
<!-- Select2 (agar bootstrap ke baad bhi chalega) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>

    <script>
        // Global variables
        let tierCounter = {{ isset($tiers) && isset($tiers['min']) ? count($tiers['min']) : 1 }};
        let selectedMerchantId = {{ $BonuLimitSetting->hidden_store_id ?? 'null' }};

        // Initialize page
        $(document).ready(function() {
            console.log('Page initialized');

            // Load merchants if category is already selected
            if ($('#categoryFilter').val()) {
                loadMerchantsByCategory();
            }

            // Add event listeners
            $('#resetBtn').on('click', resetForm);
            $('#occasionForm').on('submit', validateForm);

            // Initialize Select2 if needed
            if (typeof $.fn.select2 !== 'undefined') {
                $('#categoryFilter, #voucher_type').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                });
            }
        });

        // Load merchants by category
        function loadMerchantsByCategory() {
            const category = $('#categoryFilter').val();
            const merchantsList = $('#merchantsList');

            console.log('Loading merchants for category:', category);

            if (!category) {
                merchantsList.html('<div class="loading-spinner">Select a category to view stores</div>');
                return;
            }

            merchantsList.html('<div class="loading-spinner">Loading stores...</div>');

            $.ajax({
                url: '/admin/Giftcard/add-get-merchants',
                method: 'GET',
                data: { category: category },
                dataType: 'json',
                success: function(response) {
                    console.log('Merchants loaded:', response);
                    merchantsList.empty();

                    if (!response.data || response.data.length === 0) {
                        merchantsList.html('<div class="error-message">No stores found for this category</div>');
                        return;
                    }

                    response.data.forEach(merchant => {
                        const isSelected = selectedMerchantId && selectedMerchantId == merchant.id;
                        const item = $(`
                            <div class="merchant-item ${isSelected ? 'selected' : ''}" onclick="selectMerchantItem(this, ${merchant.id})">
                                <div class="merchant-name">${merchant.name}</div>
                                <div class="merchant-info">
                                    Current: ${merchant.bonus_tiers || 0} bonus tiers |
                                    Limits: $${merchant.limit_from || 0} - $${merchant.limit_to || 0}
                                </div>
                            </div>
                        `);
                        merchantsList.append(item);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching merchants:', error);
                    merchantsList.html('<div class="error-message">Error loading stores. Please try again.</div>');
                }
            });
        }

        // Select merchant item
        function selectMerchantItem(element, merchantId) {
            console.log('Selecting merchant:', merchantId);

            // Update UI
            $('.merchant-item').removeClass('selected');
            $(element).addClass('selected');

            // Update hidden input
            $('#hidden_store_id').val(merchantId);
            selectedMerchantId = merchantId;

            console.log('Hidden input updated to:', $('#hidden_store_id').val());
        }

        // Add bonus tier
        function addBonusTier() {
            console.log('Adding new tier, current counter:', tierCounter);

            const tiersList = $('#tiersList');
            const newTier = $(`
                <div class="tier-item" id="tier-${tierCounter}">
                    <input type="number" class="tier-input" name="min[]" placeholder="Min $" min="0" required>
                    <input type="number" class="tier-input" name="max[]" placeholder="Max $" min="0" required>
                    <input type="number" class="tier-input" name="bonus[]" placeholder="Bonus %" min="0" max="100" required>
                    <button type="button" class="btn btn-danger" onclick="removeTier(${tierCounter})" style="padding: 8px; font-size: 12px;">Remove</button>
                </div>
            `);

            tiersList.append(newTier);
            tierCounter++;
        }

        // Remove tier
        function removeTier(tierId) {
            console.log('Removing tier:', tierId);

            const tierElement = $(`#tier-${tierId}`);
            if (tierElement.length) {
                // Check if it's the last tier
                if ($('.tier-item').length <= 2) { // 2 because header is also counted
                    alert('At least one tier is required!');
                    return;
                }
                tierElement.remove();
            }
        }

        // Reset form
        function resetForm() {
            if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
                $('#occasionForm')[0].reset();
                $('.merchant-item').removeClass('selected');
                $('#hidden_store_id').val('');
                selectedMerchantId = null;

                // Reset tiers to default
                $('#tiersList').html(`
                    <div class="tier-item" id="tier-0">
                        <input type="number" class="tier-input" name="min[]" placeholder="Min $" min="0" required>
                        <input type="number" class="tier-input" name="max[]" placeholder="Max $" min="0" required>
                        <input type="number" class="tier-input" name="bonus[]" placeholder="Bonus %" min="0" max="100" required>
                        <button type="button" class="btn btn-danger" onclick="removeTier(0)" style="padding: 8px; font-size: 12px;">Remove</button>
                    </div>
                `);
                tierCounter = 1;
            }
        }

        // Validate form before submit
        function validateForm(e) {
            const hiddenStoreId = $('#hidden_store_id').val();
            const voucherType = $('#voucher_type').val();
            const category = $('#categoryFilter').val();
            const typeSelect = $('input[name="type_select"]:checked').val();

            if (!hiddenStoreId) {
                e.preventDefault();
                alert('Please select a store/merchant!');
                return false;
            }

            if (!voucherType) {
                e.preventDefault();
                alert('Please select a voucher type!');
                return false;
            }

            if (!category) {
                e.preventDefault();
                alert('Please select a category!');
                return false;
            }

            if (!typeSelect) {
                e.preventDefault();
                alert('Please select discount type!');
                return false;
            }

            // Validate tier inputs
            let isValid = true;
            $('.tier-item input[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).focus();
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill all tier fields!');
                return false;
            }

            console.log('Form validation passed, submitting...');
            return true;
        }

        // Legacy function to maintain compatibility
        function update_ids(id) {
            selectedMerchantId = id;
            $('#hidden_store_id').val(id);
            console.log("Hidden input updated via legacy function:", id);
        }

        // Show success/error messages
        function showMessage(message, type = 'success') {
            const alertClass = type === 'success' ? 'success-message' : 'error-message';
            const alertHtml = `<div class="${alertClass}">${message}</div>`;

            $('.page-header').after(alertHtml);

            setTimeout(() => {
                $(`.${alertClass}`).fadeOut();
            }, 5000);
        }

           // Handle AJAX errors globally
        $(document).ajaxError(function(event, xhr, settings, thrownError) {
            console.error('AJAX Error:', {
                url: settings.url,
                status: xhr.status,
                error: thrownError
            });
        });

    </script>
@endpush
