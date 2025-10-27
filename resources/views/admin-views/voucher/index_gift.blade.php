@extends('layouts.admin.app')

@section('title', translate('messages.add_new_item'))
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

<style>
#selectedItemsSection .badge {
    font-size: 0.9rem;
    padding: 0.4rem 0.8rem;
}

#selectedItemsSection {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Custom toggle style */
.form-switch .form-check-input {
  width: 2.5em;
  height: 1.3em;
  background-color: #ccc;
  border-radius: 1em;
  position: relative;
  appearance: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.form-switch .form-check-input::before {
  content: "";
  position: absolute;
  top: 2px;
  left: 3px;
  width: 1em;
  height: 1em;
  background: #fff;
  border-radius: 50%;
  transition: transform 0.3s ease;
}

.form-switch .form-check-input:checked {
  background-color: #0d6efd;
}

.form-switch .form-check-input:checked::before {
  transform: translateX(1.2em);
}

.template-card {
  cursor: pointer;
  transition: all 0.25s ease-in-out;
  background-color: #fff;
}

.template-card:hover {
  border-color: #0d6efd;
  background-color: #f8f9fa;
}

.template-card.selected {
  border: 2px solid #0d6efd;
  background-color: #e7f1ff;
  box-shadow: 0 0 5px rgba(13,110,253,0.3);
}


</style>
<style>
/* Normal button look */
.type-option {
    border: 2px solid #007bff;
    color: #007bff;
    background-color: white;
    transition: all 0.2s ease-in-out;
}

/* When active (radio checked) */
.type-option.active {
    background-color: #007bff !important;
    color: white !important;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

/* Optional: little hover feedback */
.type-option:hover {
    background-color: #e6f0ff;
}
</style>

@section('content')
  <link rel="stylesheet" href="{{asset('public/assets/admin/css/voucher.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/voucher.css')}}">
     <!-- Page Header -->
     <div class="container-fluid px-4 py-3">
          @include("admin-views.voucher.include_heading")
        <div class="bg-white shadow rounded-lg p-4">
            <input type="hidden" name="hidden_value" id="hidden_value" value="1"/>
            <input type="hidden" name="hidden_bundel" id="hidden_bundel" value="simple"/>
            <input type="hidden" name="hidden_name" id="hidden_name" value="Delivery/Pickup"/>

            {{-- Step 1: Select Voucher Type and Step 2: Select Management Type  --}}
             @include("admin-views.voucher.include_client_voucher_management")

            <form action="javascript:" method="post" id="item_form" enctype="multipart/form-data">
                @csrf
                @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
                @php($language = $language->value ?? null)
                @php($defaultLang = str_replace('_', '-', app()->getLocale()))
                {{-- Client Information and Partner Information --}}
                 @include("admin-views.voucher.include_client_partner_information")

                   <!-- Occasions-->
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4">Occasions</h3>
                    {{-- tags --}}
                    <div class="col-12 mt-3">
                          <p class="text-muted mb-3">Select occasions for this gift card</p>
                         <div class="form-group mb-0">
                                <label class="input-label"
                                    for="select_category_all">{{ translate('Occasions') }}</label>
                                    <select name="select_category_all" id="select_category_all" class="form-control js-select2-custom" multiple>
                                    @foreach (\App\Models\GiftOccasions::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                </div>
                   <!-- Recipient Info Form Fields-->
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                      <h3 class="h5 fw-semibold mb-4">Recipient Info Form Fields</h3>
                    <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="text-muted mb-4">Select which fields will appear on the recipient info form</p>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40%">Field Name</th>
                                        <th width="30%" class="text-center">Show Field</th>
                                        <th width="30%" class="text-center">Mark as Required</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Sender Name</strong>
                                            <small class="d-block text-muted">Who is sending the gift card</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_sender_name" name="form_fields[]" value="sender_name" data-target="req_sender_name">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_sender_name" name="required_fields[]" value="sender_name" disabled>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Sender Email</strong>
                                            <small class="d-block text-muted">Sender's email address</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_sender_email" name="form_fields[]" value="sender_email" data-target="req_sender_email">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_sender_email" name="required_fields[]" value="sender_email" disabled>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Recipient Name</strong>
                                            <small class="d-block text-muted">Who will receive the gift card</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_recipient_name" name="form_fields[]" value="recipient_name" checked data-target="req_recipient_name">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_recipient_name" name="required_fields[]" value="recipient_name" checked>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Recipient Email</strong>
                                            <small class="d-block text-muted">Where to send the gift card</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_recipient_email" name="form_fields[]" value="recipient_email" checked data-target="req_recipient_email">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_recipient_email" name="required_fields[]" value="recipient_email" checked>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Recipient Phone</strong>
                                            <small class="d-block text-muted">Phone number for WhatsApp delivery</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_recipient_phone" name="form_fields[]" value="recipient_phone" data-target="req_recipient_phone">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_recipient_phone" name="required_fields[]" value="recipient_phone" disabled>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Personal Message</strong>
                                            <small class="d-block text-muted">Custom message from sender</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_message" name="form_fields[]" value="message" data-target="req_message">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_message" name="required_fields[]" value="message" disabled>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Scheduled Delivery Date</strong>
                                            <small class="d-block text-muted">When to send the gift card</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_delivery_date" name="form_fields[]" value="delivery_date" data-target="req_delivery_date">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_delivery_date" name="required_fields[]" value="delivery_date" disabled>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>Recipient Address</strong>
                                            <small class="d-block text-muted">Physical address (for physical cards)</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input field-toggle" type="checkbox" id="field_recipient_address" name="form_fields[]" value="recipient_address" data-target="req_recipient_address">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="req_recipient_address" name="required_fields[]" value="recipient_address" disabled>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class=" mt-3 mb-0 p-2 " style="background:#005555;color:white">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Enable "Show Field" first, then you can mark it as required. Recipient Name and Email are enabled by default.
                        </div>
                    </div>
                </div>


                </div>
                   <!-- Message Template Style-->
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4">Message Template Style</h3>
                     <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <p class="text-muted mb-3">Select one message template style for this gift card</p>
                            <div class="row g-3">
                                @foreach (\App\Models\MessageTemplate::all() as $item)
                                    @php(
                                    $id = 'template_' . $item->id
                                    )
                                    <div class="col-md-6">
                                    <input type="radio" class="btn-check template-radio" name="message_template_style" id="{{ $id }}" value="{{ $item->id }}">
                                    <label class="template-card border rounded p-3 w-100 d-block" for="{{ $id }}">
                                        <img src="{{ asset($item->icon) }}" alt="" style="width: 25px; height: 25px;">
                                        <strong class="ms-2">{{ $item->title }}</strong>
                                        <small class="d-block text-muted mt-1">{{ $item->sub_title }}</small>
                                    </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                   <!-- Delivery Options-->
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4">Delivery Options</h3>
                    {{-- tags --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <p class="text-muted mb-3">Select how gift cards will be delivered to recipients</p>

                          <div class="row">
                            @foreach (\App\Models\DeliveryOption::all() as $item)
                                @php(
                                    $id = 'delivery_' . $item->id
                                    )
                                <div class="col-md-6 mb-3">
                                    <div class="card border-primary h-100">
                                        <div class="card-body">
                                            <div class="form-check form-switch">
                                                <input
                                                    class="form-check-input delivery-option"
                                                    type="checkbox"
                                                    id="{{ $id }}"
                                                    name="delivery_options[]"
                                                    value="{{ $item->slug ?? $item->id }}"
                                                    {{ $loop->first ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label" for="{{ $id }}">
                                                    <h6 class="mb-1">
                                                        <i class="fas fa-envelope text-primary me-2"></i>{{ $item->title }}
                                                    </h6>
                                                    <small class="text-muted">{{ $item->sub_title }}</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                           <div class=" mt-3 mb-0 p-2 " style="background:#005555;color:white">
                                <i class="fas fa-info-circle"></i>
                                <strong>Note:</strong> At least one delivery option must be selected. Email is enabled by default.
                            </div>
                        </div>
                    </div>
                </div>
                   <!-- How It Works-->
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4">How It Works</h3>
                    {{-- tags --}}
                      <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <p class="text-muted mb-4">Explain redemption process</p>
                                <div class="mb-3">
                                    <label for="redemption_process" class="form-label">Redemption Process</label>
                                    <textarea class="form-control" id="redemption_process" name="redemption_process" rows="6"
                                            placeholder="Step by step instructions on how to redeem this voucher...">{{ old('redemption_process') }}</textarea>
                                </div>

                            </div>
                        </div>

                </div>
                {{-- Amount Configuration --}}
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4"> Amount Configuration</h3>
                     <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Amount Type <span class="text-danger">*</span></label>
                               <div class="row g-2" id="amountTypeGroup">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="type" id="type_fixed" value="fixed" {{ old('type', 'fixed') == 'fixed' ? 'checked' : '' }}>
                                        <label class="btn border type-option " for="type_fixed">
                                            <i class="fas fa-list"></i> Fixed Amounts
                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="type" id="type_range" value="range" {{ old('type') == 'range' ? 'checked' : '' }}>
                                        <label class="btn border type-option " for="type_range">
                                            <i class="fas fa-arrows-alt-h"></i> Range
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch form-switch-lg">
                                    <input class="form-check-input" type="checkbox" id="custom_enabled" name="custom_enabled" value="1" {{ old('custom_enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="custom_enabled">
                                        <strong>Enable Custom Amount</strong>
                                        <small class="d-block text-muted">Allow customers to enter their own amount</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Fixed Amounts Section -->
                            <div id="fixedAmountsSection" style="display: none;">
                                <label class="form-label">Fixed Amount Options <span class="text-danger">*</span></label>
                                <div id="fixedAmountsContainer">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="fixed_amounts[]" step="0.01" min="0" placeholder="25.00">
                                        <button type="button" class="btn btn-danger remove-amount" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary border" id="addAmountBtn">
                                    <i class="fas fa-plus"></i> Add Another Amount
                                </button>
                            </div>

                            <!-- Range Amounts Section -->
                            <div id="rangeAmountsSection" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="min_amount" class="form-label">Minimum Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control @error('min_amount') is-invalid @enderror"
                                                id="min_amount" name="min_amount" step="0.01" min="0" value="{{ old('min_amount') }}" placeholder="10.00">
                                        </div>
                                        @error('min_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="max_amount" class="form-label">Maximum Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control @error('max_amount') is-invalid @enderror"
                                                id="max_amount" name="max_amount" step="0.01" min="0" value="{{ old('max_amount') }}" placeholder="1000.00">
                                        </div>
                                        @error('max_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Bonus Configuration --}}
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4"> Bonus Configuration</h3>
                    {{-- tags --}}
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div>
                </div>
                {{-- Terms & Conditions --}}
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4"> Terms & Conditions</h3>
                    {{-- tags --}}
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div>
                </div>
                {{-- Review & Summary --}}
                <div class="section-card rounded p-4 mb-4" id="bundel_food_voucher_fields_1_3_1_4">
                    <h3 class="h5 fw-semibold mb-4"> Review & Summary</h3>
                    {{-- tags --}}
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <h3 class="h5 fw-semibold "> {{ translate('tags') }}</h3>
                            <input type="text" class="form-control" name="tags" placeholder="{{translate('messages.search_tags')}}" data-role="tagsinput">
                        </div>
                    </div>
                </div>

            </form>
        </div>
      </div>

      @include("admin-views.voucher.include_model")

@endsection


@push('script_2')
{{-- dashboard code --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/product-index.js"></script>

    {{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const typeOptions = document.querySelectorAll('.type-option input[type="radio"]');

    function updateActiveState() {
        document.querySelectorAll('.type-option').forEach(div => div.classList.remove('active'));
        const selected = document.querySelector('.type-option input[type="radio"]:checked');
        if (selected) selected.closest('.type-option').classList.add('active');
    }

    typeOptions.forEach(input => {
        input.addEventListener('change', updateActiveState);
    });

    // Initialize on page load (for old() / preselected)
    updateActiveState();
});
</script> --}}


<script>
document.addEventListener('DOMContentLoaded', function() {
    const options = document.querySelectorAll('.type-option');
    const radios = document.querySelectorAll('input[name="type"]');

    function updateActive() {
        options.forEach(opt => opt.classList.remove('active'));
        const checked = document.querySelector('input[name="type"]:checked');
        if (checked) {
            const label = document.querySelector(`label[for="${checked.id}"]`);
            if (label) label.classList.add('active');
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', updateActive);
    });

    // Initialize on load (for old() / pre-selected value)
    updateActive();
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelectorAll('input[name="type"]');
    const fixedSection = document.getElementById('fixedAmountsSection');
    const rangeSection = document.getElementById('rangeAmountsSection');
    const addAmountBtn = document.getElementById('addAmountBtn');
    const fixedContainer = document.getElementById('fixedAmountsContainer');

    // 🔹 Toggle between Fixed and Range sections
    function toggleSections() {
        const selectedType = document.querySelector('input[name="type"]:checked')?.value;
        fixedSection.style.display = selectedType === 'fixed' ? 'block' : 'none';
        rangeSection.style.display = selectedType === 'range' ? 'block' : 'none';
    }

    typeSelect.forEach(radio => {
        radio.addEventListener('change', toggleSections);
    });
    toggleSections(); // Initial setup

    // 🔹 Add new fixed amount input
    addAmountBtn.addEventListener('click', function() {
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <span class="input-group-text">$</span>
            <input type="number" class="form-control" name="fixed_amounts[]" step="0.01" min="0" placeholder="25.00">
            <button type="button" class="btn btn-danger remove-amount">
                <i class="fas fa-times"></i>
            </button>
        `;
        fixedContainer.appendChild(newField);

        // Remove field
        newField.querySelector('.remove-amount').addEventListener('click', function() {
            newField.remove();
        });
    });

    // 🔹 Make first fixed input's remove button visible only after adding more
    const observer = new MutationObserver(() => {
        const allRemoveBtns = fixedContainer.querySelectorAll('.remove-amount');
        allRemoveBtns.forEach((btn, i) => {
            btn.style.display = (i === 0 && allRemoveBtns.length === 1) ? 'none' : 'inline-block';
        });
    });
    observer.observe(fixedContainer, { childList: true, subtree: false });
});
</script>




<script>
   // Form field toggle functionality
    document.querySelectorAll('.field-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const targetId = this.getAttribute('data-target');
            const requiredToggle = document.getElementById(targetId);

            if (this.checked) {
                // Enable the "Mark as Required" toggle when field is shown
                requiredToggle.disabled = false;
            } else {
                // Disable and uncheck the "Mark as Required" toggle when field is hidden
                requiredToggle.disabled = true;
                requiredToggle.checked = false;
            }
        });
    });


</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const radios = document.querySelectorAll('.template-radio');

  radios.forEach(radio => {
    radio.addEventListener('change', function () {
      document.querySelectorAll('.template-card').forEach(card => {
        card.classList.remove('selected');
      });
      const label = document.querySelector('label[for="' + this.id + '"]');
      label.classList.add('selected');
    });
  });
});




</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const options = document.querySelectorAll('.delivery-option');

    options.forEach(opt => {
        opt.addEventListener('change', function() {
            const checkedOptions = document.querySelectorAll('.delivery-option:checked');

            // agar user last checked ko uncheck kar raha hai → prevent it
            if (checkedOptions.length === 0) {
                this.checked = true;
                alert('At least one delivery option must remain selected.');
            }
        });
    });
});
</script>




  <script>

$(document).ready(function() {
    // Initialize Select2 for all dropdowns
    $('#select_pro, #select_pro1, #select_pro2').select2({
        width: '100%',
        placeholder: 'Select a Product'
    });

    // Store selected products
    let selectedProductsArray = [];
    let productCounter = 0;

    // BOGO specific storage - Arrays for multiple products
    let bogoProductsA = [];
    let bogoProductsB = [];
    let bogoCounterA = 0;
    let bogoCounterB = 0;

    // On page load, check bundle type
    let bundleType = $('#bundle_offer_type').val();
    updateFieldsVisibility(bundleType);

    // When "Add Product to Bundle" button is clicked
    $('#addProductBtn').on('click', function() {
        const bundleOfferType = $('#bundle_offer_type').val();
        const availableProducts = $('#availableProducts');
        const availableProductsGetXBuyY = $('#availableProducts_get_x_buy_y');

        // Check if bundle offer type is selected
        if (!bundleOfferType || bundleOfferType === "") {
            alert("Please select a bundle offer type first!");
            return;
        }

        if (bundleOfferType === "bogo_free") {
            // Hide normal products section first
            if (availableProducts.is(':visible')) {
                availableProducts.slideUp();
            }
            // Then show/hide BOGO section
            availableProductsGetXBuyY.slideToggle();
        } else {
            // Hide BOGO section first
            if (availableProductsGetXBuyY.is(':visible')) {
                availableProductsGetXBuyY.slideUp();
            }
            // Then show/hide normal products section
            availableProducts.slideToggle();
        }
    });

    // ==================== REGULAR BUNDLE LOGIC ====================
    $('#select_pro').on('change', function() {
        let selected = $(this).find('option:selected');
        let productId = selected.val();
        let productName = selected.data('name');
        let basePrice = parseFloat(selected.data('price')) || 0;
        let variations = selected.data('variations') || [];
        let addons = selected.data('addons') || [];

        if (!productId) return;

        let bundleOfferType = $('#bundle_offer_type').val();

        // Handle different bundle types
        if (bundleOfferType === 'simple') {
            $('#productDetails .card').remove();
            selectedProductsArray = [];
            productCounter = 0;
            $('#priceCalculator').hide();
            $('#price').val('0.00');
            $('#price_hidden').val('0.00');
        } else if (bundleOfferType === 'bundle' || bundleOfferType === 'mix_match') {
            if (selectedProductsArray.includes(productId)) {
                alert(`"${productName}" is already added to the bundle!`);
                $('#select_pro').val('').trigger('change');
                return;
            }
        }

        selectedProductsArray.push(productId);
        let html = createProductCard(productId, productName, basePrice, variations, addons, productCounter);
        $('#productDetails').append(html);
        productCounter++;
        $('#select_pro').val('').trigger('change');
        $('#selectedProducts p').hide();
        updateBundleTotal();
    });

    // ==================== BOGO PRODUCT A LOGIC (MULTIPLE) ====================
    $('#select_pro1').on('change', function() {
        let selected = $(this).find('option:selected');
        let productId = selected.val();
        let productName = selected.data('name');
        let basePrice = parseFloat(selected.data('price')) || 0;
        let variations = selected.data('variations') || [];
        let addons = selected.data('addons') || [];

        if (!productId) return;

        // Check if product is already in Section A
        if (bogoProductsA.includes(productId)) {
            alert(`"${productName}" is already added to Product A section!`);
            $('#select_pro1').val('').trigger('change');
            return;
        }

        // Add to Product A array
        bogoProductsA.push(productId);

        // Create product card for Product A with unique counter
        let html = createBogoProductCard(productId, productName, basePrice, variations, addons, 'A', bogoCounterA);
        $('#productDetails_section_a').append(html);

        bogoCounterA++;
        $('#select_pro1').val('').trigger('change');
        updateBogoTotal();
    });

    // ==================== BOGO PRODUCT B LOGIC (MULTIPLE) ====================
    $('#select_pro2').on('change', function() {
        let selected = $(this).find('option:selected');
        let productId = selected.val();
        let productName = selected.data('name');
        let basePrice = parseFloat(selected.data('price')) || 0;
        let variations = selected.data('variations') || [];
        let addons = selected.data('addons') || [];

        if (!productId) return;

        // Check if product is already in Section B
        if (bogoProductsB.includes(productId)) {
            alert(`"${productName}" is already added to Product B section!`);
            $('#select_pro2').val('').trigger('change');
            return;
        }

        // Add to Product B array
        bogoProductsB.push(productId);

        // Create product card for Product B with unique counter
        let html = createBogoProductCard(productId, productName, basePrice, variations, addons, 'B', bogoCounterB);
        $('#productDetails_section_b').append(html);

        bogoCounterB++;
        $('#select_pro2').val('').trigger('change');
        updateBogoTotal();
    });

    // ==================== CREATE PRODUCT CARD (REGULAR) ====================
    function createProductCard(productId, productName, basePrice, variations, addons, counter) {
        let html = `
        <div class="card p-3 shadow-sm mb-3 col-12 col-md-6" data-product-temp-id="${counter}" data-product-id="${productId}">


            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border rounded p-2">

                <!-- Product Name -->
                <div class="">
                <h5 class="mb-0">${productName}</h5>
                <!-- Variations -->
                ${variations && variations.length > 0 ? `
                    <div class="variations">
                        <strong>Variations:</strong>
                        ${variations.map(v => `
                            <label class="ms-2 small">
                                <input
                                    type="checkbox"
                                    name="variation_${counter}"
                                    class="variation-checkbox"
                                    value="${v.type || ''}"
                                    data-price="${v.price || 0}"
                                    data-type="${v.type || 'Option'}"
                                >
                                ${v.type || 'Option'} - $${v.price || 0}
                                ${v.stock ? ` (Stock: ${v.stock})` : ''}
                            </label>
                        `).join('')}
                    </div>
                ` : ''}
               </div>
                <!-- Product Total -->
                <div class="p-2 text-nowrap">
                    <span class="product-total text-success fw-bold" style="font-size: 1.2em;">
                        $${basePrice.toFixed(2)}
                    </span>
                </div>

                <!-- Delete Button -->
                <button
                    type="button"
                    class="btn btn-danger btn-sm remove-product-btn"
                    data-temp-id="${counter}"
                    data-product-id="${productId}"
                >
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            <input type="hidden" class="product-id" value="${productId}">
            <input type="hidden" class="product-name" value="${productName}">
            <input type="hidden" class="product-base-price" value="${basePrice}">
        `;

        return html;
    }

    // ==================== CREATE BOGO PRODUCT CARD (MULTIPLE) ====================
    function createBogoProductCard(productId, productName, basePrice, variations, addons, section, counter) {
        const variationsHtml = (variations && variations.length)
            ? `<div class="mt-2">
                    <strong>Variations:</strong>
                    ${variations.map((v, index) => `~
                        <label class="d-block small mt-1">
                            <input
                                type="checkbox"
                                name="bogo_variation_${section}_${counter}_${index}"
                                class="bogo-variation-checkbox"
                                value="${v.type || ''}"
                                data-price="${v.price || 0}"
                                data-type="${v.type || 'Option'}"
                            >
                            ${v.type || 'Option'} - $${(v.price || 0).toFixed(2)}
                            ${v.stock ? ` (Stock: ${v.stock})` : ''}
                        </label>
                    `).join('')}
            </div>`
            : '';

        const html = `
        <div class="card p-3 shadow-sm mb-3 col-12" data-bogo-section="${section}" data-bogo-counter="${counter}" data-product-id="${productId}">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border rounded p-2">

                <!-- Product Name + Info -->
                <div class="me-3 flex-grow-1">
                    <h5 class="mb-1">Product ${section}: ${productName}</h5>
                    ${variationsHtml}
                </div>

                <!-- Product Total -->
                <div class="p-2 text-nowrap">
                    <span class="product-total text-success fw-bold" style="font-size: 1.2em;">
                        $${basePrice.toFixed(2)}
                    </span>
                </div>

                <!-- Delete Button -->
                <button type="button" class="btn btn-danger btn-sm remove-bogo-product-btn"
                    data-section="${section}" data-counter="${counter}" data-product-id="${productId}">
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            <input type="hidden" class="bogo-product-id" value="${productId}">
            <input type="hidden" class="bogo-product-name" value="${productName}">
            <input type="hidden" class="bogo-product-base-price" value="${basePrice}">
        </div>
        `;

        return html;
    }


    // ==================== REMOVE BOGO PRODUCT ====================
    $(document).on('click', '.remove-bogo-product-btn', function() {
        let section = $(this).data('section');
        let counter = $(this).data('counter');
        let productId = $(this).data('product-id');

        // Remove from respective array
        if (section === 'A') {
            bogoProductsA = bogoProductsA.filter(id => id !== productId);
        } else if (section === 'B') {
            bogoProductsB = bogoProductsB.filter(id => id !== productId);
        }

        // Remove card with animation
        $(`[data-bogo-section="${section}"][data-bogo-counter="${counter}"]`).fadeOut(300, function() {
            $(this).remove();
            updateBogoTotal();
        });
    });

    // ==================== UPDATE BOGO TOTAL (MULTIPLE PRODUCTS) ====================
    function updateBogoTotal() {
        let totalProductsA = 0;
        let totalProductsB = 0;
        let breakdownHTML = '<h5>BOGO Bundle Breakdown:</h5><ul class="list-group">';

        let allProductPrices = [];

        // Calculate all Product A totals
        $('#productDetails_section_a .card').each(function() {
            let basePrice = parseFloat($(this).find('.bogo-product-base-price').val()) || 0;
            let productName = $(this).find('.bogo-product-name').val();
            let quantity = parseInt($(this).find('.bogo-product-quantity').val()) || 1;
            let productTotal = basePrice;

            // Add variation price
            let selectedVariation = $(this).find('.bogo-variation-checkbox:checked');
            let variationText = '';
            if (selectedVariation.length) {
                let varPrice = parseFloat(selectedVariation.data('price')) || 0;
                let varType = selectedVariation.data('type');
                productTotal += varPrice;
                variationText = `<div class="small text-muted ml-3">└ ${varType} (+$${varPrice.toFixed(2)})</div>`;
            }

            // Add addon prices
            let addonsText = '';
            $(this).find('.bogo-addon-checkbox:checked').each(function() {
                let addonPrice = parseFloat($(this).data('price')) || 0;
                let addonName = $(this).data('name');
                productTotal += addonPrice;
                addonsText += `<div class="small text-muted ml-3">└ ${addonName} (+$${addonPrice.toFixed(2)})</div>`;
            });

            // Multiply by quantity
            productTotal = productTotal * quantity;
            totalProductsA += productTotal;

            // Store individual price for BOGO calculation
            allProductPrices.push(productTotal);

            // Update display
            $(this).find('.bogo-product-total').text('$' + productTotal.toFixed(2));

            breakdownHTML += `
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong>Product A: ${productName}</strong> (x${quantity})
                            <div class="small text-muted">Base: $${basePrice.toFixed(2)}</div>
                            ${variationText}
                            ${addonsText}
                        </div>
                        <strong class="text-success ml-3">$${productTotal.toFixed(2)}</strong>
                    </div>
                </li>`;
        });

        // Calculate all Product B totals
        $('#productDetails_section_b .card').each(function() {
            let basePrice = parseFloat($(this).find('.bogo-product-base-price').val()) || 0;
            let productName = $(this).find('.bogo-product-name').val();
            let quantity = parseInt($(this).find('.bogo-product-quantity').val()) || 1;
            let productTotal = basePrice;

            // Add variation price
            let selectedVariation = $(this).find('.bogo-variation-checkbox:checked');
            let variationText = '';
            if (selectedVariation.length) {
                let varPrice = parseFloat(selectedVariation.data('price')) || 0;
                let varType = selectedVariation.data('type');
                productTotal += varPrice;
                variationText = `<div class="small text-muted ml-3">└ ${varType} (+$${varPrice.toFixed(2)})</div>`;
            }

            // Add addon prices
            let addonsText = '';
            $(this).find('.bogo-addon-checkbox:checked').each(function() {
                let addonPrice = parseFloat($(this).data('price')) || 0;
                let addonName = $(this).data('name');
                productTotal += addonPrice;
                addonsText += `<div class="small text-muted ml-3">└ ${addonName} (+$${addonPrice.toFixed(2)})</div>`;
            });

            // Multiply by quantity
            productTotal = productTotal * quantity;
            totalProductsB += productTotal;

            // Store individual price for BOGO calculation
            allProductPrices.push(productTotal);

            // Update display
            $(this).find('.bogo-product-total').text('$' + productTotal.toFixed(2));

            breakdownHTML += `
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong>Product B: ${productName}</strong> (x${quantity})
                            <div class="small text-muted">Base: $${basePrice.toFixed(2)}</div>
                            ${variationText}
                            ${addonsText}
                        </div>
                        <strong class="text-success ml-3">$${productTotal.toFixed(2)}</strong>
                    </div>
                </li>`;
        });

        // Calculate BOGO discount
        let subtotal = totalProductsA + totalProductsB;
        let finalTotal = subtotal;
        let discount = 0;

        // BOGO Logic: Buy X Get Y Free (pay for higher priced items)
        if (allProductPrices.length >= 2) {
            // Sort prices descending
            allProductPrices.sort((a, b) => b - a);

            // Calculate discount (every 2nd item is free, starting from cheapest)
            for (let i = 1; i < allProductPrices.length; i += 2) {
                discount += allProductPrices[i];
            }

            finalTotal = subtotal - discount;
        }

        breakdownHTML += `
            <li class="list-group-item">
                <strong>Subtotal: </strong><span class="text-primary">$${subtotal.toFixed(2)}</span>
            </li>`;

        // if (discount > 0) {
        //     breakdownHTML += `
        //         <li class="list-group-item text-success">
        //             <strong>BOGO Discount (Buy 1 Get 1 Free): </strong>
        //             <span>-$${discount.toFixed(2)}</span>
        //         </li>`;
        // }

        // breakdownHTML += `
        //     <li class="list-group-item bg-success text-white">
        //         <strong>Final Bundle Total: </strong>
        //         <strong style="font-size: 1.3em;">$${finalTotal.toFixed(2)}</strong>
        //     </li>
        // </ul>`;

        // Show price calculator if at least one product is selected
        let hasProducts = $('#productDetails_section_a .card').length > 0 || $('#productDetails_section_b .card').length > 0;

        if (hasProducts) {
            $('#priceCalculator').show();
            $('#priceBreakdown').html(breakdownHTML);
            $('#price').val(finalTotal.toFixed(2));
            $('#price_hidden').val(finalTotal.toFixed(2));
        } else {
            $('#priceCalculator').hide();
            $('#price').val('0.00');
            $('#price_hidden').val('0.00');
        }
    }

    // ==================== BOGO EVENT LISTENERS ====================
    $(document).on('change', '.bogo-variation-checkbox, .bogo-addon-checkbox, .bogo-product-quantity', function() {
        updateBogoTotal();
    });

    // ==================== REGULAR BUNDLE EVENT LISTENERS ====================
    $(document).on('change', '.variation-checkbox, .addon-checkbox, .product-quantity', function() {
        let productCard = $(this).closest('.card');
        let basePrice = parseFloat(productCard.find('.product-base-price').val()) || 0;
        let quantity = parseInt(productCard.find('.product-quantity').val()) || 1;
        let total = basePrice;

        let selectedVariation = productCard.find('.variation-checkbox:checked');
        if (selectedVariation.length) {
            total += parseFloat(selectedVariation.data('price')) || 0;
        }

        productCard.find('.addon-checkbox:checked').each(function() {
            total += parseFloat($(this).data('price')) || 0;
        });

        total = total * quantity;
        productCard.find('.product-total').fadeOut(200, function() {
            $(this).text('$' + total.toFixed(2)).fadeIn(200);
        });

        updateBundleTotal();
    });

    $(document).on('click', '.remove-product-btn', function() {
        let tempId = $(this).data('temp-id');
        let productId = $(this).data('product-id');

        selectedProductsArray = selectedProductsArray.filter(id => id !== productId);

        $(`[data-product-temp-id="${tempId}"]`).fadeOut(300, function() {
            $(this).remove();
            updateBundleTotal();

            if ($('#productDetails .card').length === 0) {
                $('#selectedProducts p').show();
            }
        });
    });

    // ==================== UPDATE BUNDLE TOTAL (REGULAR) ====================
    function updateBundleTotal() {
        let bundleTotal = 0;
        let productCount = 0;
        let breakdownHTML = '<h5>Bundle Price Breakdown:</h5><ul class="list-group">';

        $('#productDetails .card').each(function() {
            let productName = $(this).find('.product-name').val();
            let basePrice = parseFloat($(this).find('.product-base-price').val()) || 0;
            let productTotal = parseFloat($(this).find('.product-total').text().replace('$', '')) || 0;
            let quantity = parseInt($(this).find('.product-quantity').val()) || 1;

            bundleTotal += productTotal;
            productCount++;

            let selectedVariation = $(this).find('.variation-checkbox:checked');
            let variationText = '';
            if (selectedVariation.length) {
                let varType = selectedVariation.data('type');
                let variationPrice = parseFloat(selectedVariation.data('price')) || 0;
                variationText = `<div class="small text-muted ml-3">└ ${varType} (+$${variationPrice.toFixed(2)})</div>`;
            }

            let addonsText = '';
            $(this).find('.addon-checkbox:checked').each(function() {
                let addonName = $(this).data('name');
                let addonPrice = parseFloat($(this).data('price')) || 0;
                addonsText += `<div class="small text-muted ml-3">└ ${addonName} (+$${addonPrice.toFixed(2)})</div>`;
            });

            let perItemPrice = productTotal / quantity;

            breakdownHTML += `
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong>${productName}</strong> (x${quantity})
                            <div class="small text-muted">Base: $${basePrice.toFixed(2)}</div>
                            ${variationText}
                            ${addonsText}
                            ${quantity > 1 ? `<div class="small text-info mt-1">Per item: $${perItemPrice.toFixed(2)}</div>` : ''}
                        </div>
                        <strong class="text-success ml-3">$${productTotal.toFixed(2)}</strong>
                    </div>
                </li>`;
        });

        let discount = parseFloat($('#discount').val()) || 0;
        let discountType = $('#discount_type').val();
        let discountAmount = 0;

        if (discountType === 'percent') {
            discountAmount = (bundleTotal * discount) / 100;
        } else {
            discountAmount = discount;
        }

        let finalTotal = Math.max(bundleTotal - discountAmount, 0);

        breakdownHTML += `
            <li class="list-group-item">
                <strong>Subtotal: </strong><span class="text-primary">$${bundleTotal.toFixed(2)}</span>
            </li>`;

        if (discountAmount > 0) {
            breakdownHTML += `
                <li class="list-group-item text-danger">
                    <strong>Discount (${discountType === 'percent' ? discount + '%' : '$' + discount}): </strong>
                    -$${discountAmount.toFixed(2)}
                </li>`;
        }

        breakdownHTML += `
            <li class="list-group-item bg-success text-white">
                <strong>Final Bundle Total: </strong>
                <strong style="font-size: 1.3em;">$${finalTotal.toFixed(2)}</strong>
            </li>
        </ul>`;

        if (productCount > 0) {
            $('#priceCalculator').show();
            $('#priceBreakdown').html(breakdownHTML);
            $('#selectedProducts p').hide();
        } else {
            $('#priceCalculator').hide();
            $('#selectedProducts p').show();
        }

        let bundleType = $('#bundle_offer_type').val();
        if (bundleType === 'bogo_free' || bundleType === 'mix_match') {
            $('#price').val(finalTotal.toFixed(2));
            $('#price_hidden').val(finalTotal.toFixed(2));
        } else {
            $('#price').val(finalTotal.toFixed(2));
            $('#price_hidden').val(bundleTotal.toFixed(2));
        }
    }

    $('#discount, #discount_type').on('change input', function() {
        let discount = parseFloat($('#discount').val()) || 0;
        let discountType = $('#discount_type').val();
        let bundleTotal = parseFloat($('#price_hidden').val()) || 0;

        if (discountType === 'percent' && discount > 100) {
            alert('Discount percentage cannot exceed 100%');
            $('#discount').val(0);
            return;
        }

        if (discountType !== 'percent' && discount > bundleTotal) {
            alert(`Discount amount ($${discount}) cannot exceed bundle total ($${bundleTotal})`);
            $('#discount').val(0);
            return;
        }

        updateBundleTotal();
    });

    function updateFieldsVisibility(bundleType) {
        if (bundleType === 'mix_match') {
            $('#price_input_hide').addClass('d-none');
            $('#discount_input_hide').removeClass('d-none');
            $('#required_qty').removeClass('d-none');
            $('#discount_value_input_hide').removeClass('d-none');
        } else if (bundleType === 'bogo_free') {
            $('#price_input_hide').addClass('d-none');
            $('#discount_input_hide').addClass('d-none');
             $('#required_qty').addClass('d-none');
            $('#discount_value_input_hide').addClass('d-none');
        } else if (bundleType === 'simple' || bundleType === 'bundle') {
            $('#price_input_hide').removeClass('d-none');
               $('#required_qty').addClass('d-none');
            $('#discount_input_hide').removeClass('d-none');
            $('#discount_value_input_hide').removeClass('d-none');
        } else {
            $('#price_input_hide').removeClass('d-none');
               $('#required_qty').addClass('d-none');
            $('#discount_input_hide').removeClass('d-none');
            $('#discount_value_input_hide').removeClass('d-none');
        }
    }

    $('#bundle_offer_type').on('change', function() {
        let bundleType = $(this).val();
        updateFieldsVisibility(bundleType);

        $('#availableProducts').hide();
        $('#availableProducts_get_x_buy_y').hide();

        // Clear regular products
        $('#productDetails .card').fadeOut(300, function() {
            $(this).remove();
            $('#selectedProducts p').show();
        });
        selectedProductsArray = [];
        productCounter = 0;

        // Clear BOGO products
        $('#productDetails_section_a').empty();
        $('#productDetails_section_b').empty();
        bogoProductsA = [];
        bogoProductsB = [];
        bogoCounterA = 0;
        bogoCounterB = 0;

        $('#priceCalculator').hide();
        $('#price').val('0.00');
        $('#price_hidden').val('0.00');
        $('#discount').val('0');
    });

    $('#price_type, input[name="price_type"]').on('change', function() {
        let priceType = $(this).val() || $('input[name="price_type"]:checked').val();

        if (priceType === 'fixed') {
            $('#productDetails .card').fadeOut(300, function() {
                $(this).remove();
                $('#selectedProducts p').show();
            });
            selectedProductsArray = [];
            productCounter = 0;

            $('#productDetails_section_a').empty();
            $('#productDetails_section_b').empty();
            bogoProductsA = [];
            bogoProductsB = [];
            bogoCounterA = 0;
            bogoCounterB = 0;

            $('#priceCalculator').hide();
            $('#price').val('0.00');
            $('#price_hidden').val('0.00');

            alert('Fixed price selected. All product selections have been reset.');
        }
    });
});

</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const managementSelection = document.querySelectorAll('#management_selection');
            const voucherCards = document.querySelectorAll('.voucher-card');
            const voucherCards2 = document.querySelectorAll('.voucher-card_2');
             const allimages = document.getElementById('allimages');
            // Move these functions OUTSIDE of DOMContentLoaded to make them globally accessible
            function section_one(loopIndex, primaryId,name) {

                  if (loopIndex === "1" || name === "Delivery/Pickup") {
                    window.location.href = "{{ url('admin/Voucher/add-new') }}";
                } else if (loopIndex === "2" || name === "Flat discount") {
                    window.location.href = "{{ url('admin/Voucher/add-new') }}";
                }


                getDataFromServer(primaryId);
                  get_product();
                // Set hidden input value
                document.getElementById('hidden_value').value = loopIndex;
                document.getElementById('hidden_name').value = name;

                const managementSelection = document.querySelectorAll('#management_selection');

                     // Get all elements
                const basic_info_main = document.getElementById('basic_info_main');
                const store_category_main = document.getElementById('store_category_main');
                const how_it_work_main = document.getElementById('how_it_work_main');
                const term_condition_main = document.getElementById('term_condition_main');
                const review_submit_main = document.getElementById('review_submit_main');
                const allimages = document.getElementById('allimages');

                const bundle_rule = document.getElementById('bundle_rule');
                const Bundle_products_configuration = document.getElementById('Bundle_products_configuration');

                const Product_voucher_fields_1_3 = document.getElementById('Product_voucher_fields_1_3');
                const product_voucher_price_info_1_3 = document.getElementById('product_voucher_price_info_1_3');

                const food_voucher_fields_1_4 = document.getElementById('food_voucher_fields_1_4');
                const food_voucher_price_info_1_4 = document.getElementById('food_voucher_price_info_1_4');

                const bundel_food_voucher_fields_1_3_1_4 = document.getElementById('bundel_food_voucher_fields_1_3_1_4');
                const bundel_food_voucher_price_info_1_3_1_4 = document.getElementById('bundel_food_voucher_price_info_1_3_1_4');

                managementSelection.forEach(el => {
                    if (loopIndex === "1" || name === "Delivery/Pickup") {
                        submit_voucher_type(loopIndex, primaryId,name);
                        el.classList.remove('d-none');

                              showElements([basic_info_main, store_category_main, how_it_work_main, term_condition_main, review_submit_main,Product_voucher_fields_1_3,product_voucher_price_info_1_3,allimages]);
                            hideElements([bundel_food_voucher_fields_1_3_1_4, bundel_food_voucher_price_info_1_3_1_4, food_voucher_fields_1_4, food_voucher_price_info_1_4]);
                        // Hide discount-specific sections
                        const elementsToHide = [
                            document.getElementById('basic_info'),
                            document.getElementById('store_category'),
                            document.getElementById('price_info'),
                            document.getElementById('voucher_behavior'),
                            document.getElementById('usage_terms'),
                            document.getElementById('attributes'),
                            document.getElementById('tags'),
                            document.getElementById('allimages')
                        ];

                        elementsToHide.forEach(element => {
                            if (element) element.classList.add('d-none');
                        });

                    } else if (loopIndex === "2" || name === "In-Store") {

                        submit_voucher_type(loopIndex, primaryId,name);
                        el.classList.remove('d-none');

                        // Show discount-specific sections
                        const elementsToShow = [
                            document.getElementById('basic_info'),
                            document.getElementById('store_category'),
                            document.getElementById('price_info'),
                            document.getElementById('voucher_behavior'),
                            document.getElementById('usage_terms'),
                            document.getElementById('attributes'),
                            document.getElementById('tags'),

                        ];

                        elementsToShow.forEach(element => {
                            if (element) element.classList.remove('d-none');
                        });
                    }
                });
            }

            // DOMContentLoaded event listener for initialization
            document.addEventListener("DOMContentLoaded", function () {
                const managementSelection = document.querySelectorAll('#management_selection');
                const voucherCards = document.querySelectorAll('.voucher-card');
                const voucherCards2 = document.querySelectorAll('.voucher-card_2');

                // Highlight selected voucher-card
                voucherCards.forEach(card => {
                    card.addEventListener('click', function () {
                        voucherCards.forEach(c => c.classList.remove('selected'));
                        this.classList.add('selected');
                    });
                });

                // Event delegation for dynamically created voucher-card_2 elements
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.voucher-card_2')) {
                        document.querySelectorAll('.voucher-card_2').forEach(card => {
                            card.classList.remove('selected');
                        });
                        e.target.closest('.voucher-card_2').classList.add('selected');
                    }
                });
            });
                 // Highlight selected voucher-card
            voucherCards.forEach(card => {
                card.addEventListener('click', function () {
                    voucherCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            // Make functions globally accessible
            window.section_one = section_one;
            window.section_second = section_second;
        });
    </script>

    <script>
        getDataFromServer(4)

        function getDataFromServer(storeId) {
            $.ajax({
                url: "{{ route('admin.Voucher.get_document') }}",
                type: "GET",
                data: { store_id: storeId },
                dataType: "json",
                success: function(response) {
                console.log(response);

                // 🟢 WorkManagement (list items)
                // let workHtml = "";
                // $.each(response.work_management, function(index, item) {
                //     workHtml += "<li>" + item.guid_title + "</li>";
                // });
                // $("#workList").html(workHtml);

                // 🟢 WorkManagement (show all details)
            let workHtml = "";

                $.each(response.work_management, function(index, item) {
                    workHtml += `
                        <div class="work-item  mb-4 rounded-lg ">
                            <h3 class="font-bold text-lg mb-2">${item.guid_title}</h3>

                            <div class="mb-3">
                                <strong>Purchase Process:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.purchase_process.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Payment Confirm:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.payment_confirm.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Voucher Deliver:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.voucher_deliver.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Redemption Process:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.redemption_process.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>

                            <div class="mb-3">
                                <strong>Account Management:</strong>
                                <ul class="list-disc list-inside text-gray-700">
                                    ${item.account_management.map(step => `<li>${step}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                    `;
                });
                $("#workList").html(workHtml);

                // 🟢 UsageTermManagement (checkboxes)
                let usageHtml = "";
                $.each(response.usage_term_management, function(index, term) {
                    usageHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-5 d-flex align-items-center">
                        <input class="form-check-input mr-2" type="checkbox" id="term${term.id}">
                        <label class="form-check-label mb-0" for="term${term.id}">
                            ${term.baseinfor_condition_title}
                        </label>
                        </div>
                    </div>
                    `;
                });
                $("#usageTerms").html(usageHtml);

                },
                error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("Something went wrong!");
                }
            });
        }

        function bundle(type) {
            // 1. Set the hidden input value
            document.getElementById('hidden_bundel').value = type;

            // 2. IDs of elements to hide
            const ids = [
                'management_selection',
                'basic_info_main',
                'store_category_main',
                'how_it_work_main',
                'term_condition_main',
                'review_submit_main',
                'Product_voucher_fields_1_3',
                'product_voucher_price_info_1_3',
                'food_voucher_fields_1_4',
                'food_voucher_price_info_1_4',
                'bundel_food_voucher_fields_1_3_1_4',
                'bundel_food_voucher_price_info_1_3_1_4',
                'Bundle_products_configuration',
                'allimages'
            ];

            // Add d-none to each element if it's visible
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el && !el.classList.contains('d-none')) {
                el.classList.add('d-none');
                }
            });

            // 3. Remove "selected" from ALL voucher-card_2 sections
            document.querySelectorAll('.voucher-card').forEach(card => {
                card.classList.remove('selected');
            });
        }
        // -------------------- Client Change => Load Segments --------------------
        $(document).ready(function () {
            $('.Clients_select_new').on('change', function () {
                let clientId = $(this).val();
                if (!clientId) return;
                // alert(clientId);
                let url = "{{ route('admin.client-side.getSegments', ':id') }}".replace(':id', clientId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (res) {
                        // Clear and refill segment dropdown
                        $('#segment_type').empty().append('<option value="">Select Product</option>');
                        // Agar res ek array hai to loop karo
                        if (Array.isArray(res) && res.length > 0) {
                            $.each(res, function (index, item) {
                                $('#segment_type').append(
                                    '<option value="' + item.id + '">' + item.name + ' / ' + item.type + '</option>'
                                );
                            });
                        } else {
                            $('#segment_type').append('<option value="">No segments found</option>');
                        }

                        // Refresh Select2
                        $('#segment_type').trigger('change');
                    },
                    error: function () {
                        // alert("Error loading segments!");
                    }
                });

            });
        });

        function submit_voucher_type(loopIndex,id,name) {
            var loopIndex = loopIndex;
            var primary_vouchertype_id = id;

            $.ajax({
                url: "{{ route('admin.Voucher.voucherType.store') }}", // <-- اپنے route کے حساب سے بدلیں
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // Laravel CSRF protection کیلئے ضروری
                    voucher_type_id: primary_vouchertype_id,
                    loopIndex: loopIndex
                },
                success: function(response) {
                    console.log("Success:", response);
                    // empty previous content
                    $("#append_all_data").empty();
                    // starting index (4 se start karna hai)
                    let index = 5;
                    // loop through modules
                    response.all_ids.forEach(function(module) {
                        let card = `
                            <div class="col-md-3">
                                <div class="voucher-card_2 border rounded py-4 text-center h-70" onclick="section_second(${index}, ${module.id}, '${module.module_name}')">
                                        <div class="display-4 mb-2">
                                        <img src="${module.thumbnail}" alt="${module.module_name}" style="width:40px; height:auto;" />
                                    </div>

                                    <h6 class="fw-semibold">${module.module_name}</h6>
                                    <small class="text-muted">${module.description ?? ''}</small>
                                </div>
                            </div>

                        `;
                        $("#append_all_data").append(card);

                        index++; // next card ke liye +1
                    });
                },

                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("Something went wrong!");
                }
            });
        }

        $(document).on('click', '.voucher-card_2', function () {
            $('.voucher-card_2').removeClass('selected');
            $(this).addClass('selected');
        });

        function get_product() {
            var category_id = $("#category_id").val();
            var store_id = $("#store_id").val();
            // var _product_name = _product_name;

            if (store_id == "") {
                alert("Please select store");
            } else {
                $.ajax({
                    url: "{{ route('admin.Voucher.get_product') }}",
                    type: "GET",
                    data: {
                        store_id: store_id,
                        category_id: category_id , // optional agar zaroori ho
                        // product_name: _product_name  // optional agar zaroori ho
                    },
                    success: function(response) {
                        console.log(response);
                        $('.all_product_list')
                            .empty()
                            .append('<option value="">{{ translate("Select Product") }}</option>');

                        $.each(response, function(key, product) {
                            $('.all_product_list')
                                .append('<option value="'+ product.id +'">'
                                + product.name + '</option>');
                        });
                    },
                    error: function() {
                        toastr.error("{{ translate('messages.failed_to_load_branches') }}");
                    }
                });
            }
        }

    </script>

    <script>
        "use strict";
        $(document).on('change', '#discount_type', function () {
         let data =  document.getElementById("discount_type");
         if(data.value === 'amount'){
             $('#symble').text("({{ \App\CentralLogics\Helpers::currency_symbol() }})");
            }
            else{
             $('#symble').text("(%)");
         }
         });
        $(document).ready(function() {
            $("#add_new_option_button").click(function(e) {
                $('#empty-variation').hide();
                count++;
                let add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">{{ translate('Required') }}</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button"
                                        title="{{ translate('Delete') }}">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">{{ translate('name') }}</label>
                                    <input required name=options[` + count +
                    `][name] class="form-control new_option_name" type="text" data-count="`+
                    count +`">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">{{ translate('messages.selcetion_type') }} </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="checkbox" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Multiple Selection') }}
                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="checkbox" value="single"
                    name="options[` + count + `][type]" id="type` + count +
                    `"
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Single Selection') }}
                    </span>
                </label>
            </div>
        </div>
        </div>
        <div class="col-xl-4 col-lg-6">
        <div class="row g-2">
            <div class="col-6">
                <label for="">{{ translate('Min') }}</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">{{ translate('Max') }}</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Option_name') }}</label>
                                                <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Additional_price') }}</label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                        <button type="button" class="btn btn--primary btn-outline-primary add_new_row_button" data-count="`+
                    count +`">{{ translate('Add_New_Option') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $("#add_new_option").append(add_option_view);
            });

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        function add_new_row_button(data) {
            count = data;
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            let add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Option_name') }}</label>
                        <input class="form-control" required type="text" name="options[` + count + `][values][` +
                countRow + `][label]" id="">
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Additional_price') }}</label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                count +
                `][values][` + countRow + `][optionPrice]" id="">
                    </div>
                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm deleteRow"
                                title="{{ translate('Delete') }}">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
            $('#option_price_view_' + data).append(add_new_row_view);

        }
        $('#store_id').on('change', function () {
            let route = '{{url('/')}}/admin/store/get-addons?data[]=0&store_id='+$(this).val();
            let id = 'add_on';
            getRestaurantData(route, id);
        });
        function modulChange(id) {
            $.get({
                url: "{{url('/')}}/admin/business-settings/module/show/"+id,
                dataType: 'json',
                success: function(data) {
                    module_data = data.data;
                    console.log(module_data)
                    stock = module_data.stock;
                    module_type = data.type;
                    if (stock) {
                        $('#stock_input').show();
                    } else {
                        $('#stock_input').hide();
                    }
                    if (module_data.add_on) {
                        $('#addon_input').show();
                    } else {
                        $('#addon_input').hide();
                    }

                    if (module_data.item_available_time) {
                        $('#time_input').show();
                    } else {
                        $('#time_input').hide();
                    }

                    if (module_data.veg_non_veg) {
                        $('#veg_input').show();
                    } else {
                        $('#veg_input').hide();
                    }
                    if (module_data.unit) {
                        $('#unit_input').show();
                    } else {
                        $('#unit_input').hide();
                    }
                    if (module_data.common_condition) {
                        $('#condition_input').show();
                    } else {
                        $('#condition_input').hide();
                    }
                    if (module_data.brand) {
                        $('#brand_input').show();
                    } else {
                        $('#brand_input').hide();
                    }
                    combination_update();
                    if (module_type == 'food') {
                        $('#food_variation_section').show();
                        $('#attribute_section').hide();
                    } else {
                        $('#food_variation_section').hide();
                        $('#attribute_section').show();
                    }
                    if (module_data.organic) {
                        $('#organic').show();
                    } else {
                        $('#organic').hide();
                    }
                    if (module_data.basic) {
                        $('#basic').show();
                    } else {
                        $('#basic').hide();
                    }
                    if (module_data.nutrition) {
                        $('#nutrition').show();
                    } else {
                        $('#nutrition').hide();
                    }
                    if (module_data.allergy) {
                        $('#allergy').show();
                    } else {
                        $('#allergy').hide();
                    }
                },
            });
            module_id = id;
        }

        modulChange({{Config::get('module.current_module_id')}});

        $('#condition_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/common-condition/get-all',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#brand_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/brand/get-all',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#store_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/store/get-stores',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:{{Config::get('module.current_module_id')}},
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#category_id').select2({
            ajax: {
                url: '{{ url('/') }}/admin/item/get-categories?parent_id=0',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:{{Config::get('module.current_module_id')}},
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#sub-categories').select2({
            ajax: {
                url: '{{ url('/') }}/admin/item/get-categories',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id:{{Config::get('module.current_module_id')}},
                        parent_id: parent_category_id,
                        sub_category: true
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#choice_attributes').on('change', function() {
            if (module_id == 0) {
                toastr.error('{{ translate('messages.select_a_module') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
                $(this).val("");
                return false;
            }
            $('#customer_choice_options').html(null);
            $('#variant_combination').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                if ($(this).val().length > 50) {
                    toastr.error(
                        '{{ translate('validation.max.string', ['attribute' => translate('messages.variation'), 'max' => '50']) }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    return false;
                }
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name;

            $('#customer_choice_options').append(
                `<div class="__choos-item"><div><input type="hidden" name="choice_no[]" value="${i}"><input type="text" class="form-control d-none" name="choice[]" value="${n}" placeholder="{{ translate('messages.choice_title') }}" readonly> <label class="form-label">${n}</label> </div><div><input type="text" class="form-control combination_update" name="choice_options_${i}[]" placeholder="{{ translate('messages.enter_choice_values') }}" data-role="tagsinput"></div></div>`
            );
            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('admin.Voucher.variant-combination') }}",
                data: $('#item_form').serialize() + '&stock=' + stock,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    console.log(data);
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length < 1) {
                        $('input[name="current_stock"]').attr("readonly", false);
                    }
                }
            });
        }

        $('#item_form').on('submit', function(e) {
            $('#submitButton').attr('disabled', true);
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.Voucher.store') }}',
                data: $('#item_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success("{{ translate('messages.product_added_successfully') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                "{{ route('admin.Voucher.list') }}";
                        }, 1000);
                    }
                }
            });
        });

        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'item_images[]',
                maxCount: 5,
                rowHeight: '176px !important',
                groupClassName: 'spartan_item_wrapper min-w-176px max-w-176px',
                maxFileSize: '',
                placeholderImage: {
                    image: "{{ asset('public/assets/admin/img/upload-img.png') }}",
                    width: '176px'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                        "{{ translate('messages.please_only_input_png_or_jpg_type_file') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                },
                onSizeErr: function(index, file) {
                    toastr.error("{{ translate('messages.file_size_too_big') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('#reset_btn').click(function() {
            $('#module_id').val(null).trigger('change');
            $('#store_id').val(null).trigger('change');
            $('#category_id').val(null).trigger('change');
            $('#sub-categories').val(null).trigger('change');
            $('#unit').val(null).trigger('change');
            $('#veg').val(0).trigger('change');
            $('#add_on').val(null).trigger('change');
            $('#discount_type').val(null).trigger('change');
            $('#choice_attributes').val(null).trigger('change');
            $('#customer_choice_options').empty().trigger('change');
            $('#variant_combination').empty().trigger('change');
            $('#viewer').attr('src', "{{ asset('public/assets/admin/img/upload.png') }}");
            $('#customFileEg1').val(null).trigger('change');
            $("#coba").empty().spartanMultiImagePicker({
                fieldName: 'item_images[]',
                maxCount: 6,
                rowHeight: '176px !important',
                groupClassName: 'spartan_item_wrapper min-w-176px max-w-176px',
                maxFileSize: '',
                placeholderImage: {
                    image: "{{ asset('public/assets/admin/img/upload-img.png') }}",
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error(
                        "{{ translate('messages.please_only_input_png_or_jpg_type_file') }}", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                },
                onSizeErr: function(index, file) {
                    toastr.error("{{ translate('messages.file_size_too_big') }}", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        })
          //   findBranch
        function findBranch(storeId) {
            if (!storeId) {
                $('#sub-branch').empty().append('<option value="">{{ translate('messages.select_branch') }}</option>');
                return;
            }

            $.ajax({
                url: "{{ route('admin.Voucher.get_branches') }}",
                type: "GET",
                data: { store_id: storeId },
                success: function(response) {
                    $('#sub-branch').empty().append('<option value="">{{ translate('messages.select_branch') }}</option>');
                    $.each(response, function(key, branch) {
                        $('#sub-branch').append('<option value="'+ branch.id +'"> ' + branch.name + '  ('+ branch.type +')</option>');
                    });
                },
                error: function() {
                    toastr.error("{{ translate('messages.failed_to_load_branches') }}");
                }
            });
        }
    </script>

@endpush
