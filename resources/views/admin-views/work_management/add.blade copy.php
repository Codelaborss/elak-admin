@extends('layouts.admin.app')

@section('title',"VoucherType List")

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
    <style>


        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #2c5f5f, #1a4040);
            color: white;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .menu-section {
            padding: 20px 0;
        }

        .section-header {
            padding: 15px 20px 8px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
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

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            padding-left: 25px;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            padding-left: 25px;
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

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Simple button styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            margin-top: 10px;
        }

        .btn-primary {
            background: #2c5f5f;
            color: white;
        }

        .btn-primary:hover {
            background: #1a4040;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        /* Simple form styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2c5f5f;
        }

        /* Term type cards */
        .term-type-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .term-type-card {
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .term-type-card:hover {
            border-color: #2c5f5f;
            background-color: #f8f9fa;
        }

        .term-type-card.selected {
            border-color: #2c5f5f;
            background-color: #e8f4f4;
        }

        .term-type-card h3 {
            color: #2c5f5f;
            margin-bottom: 10px;
        }

        .term-type-card p {
            color: #666;
            font-size: 14px;
        }

        /* Hidden sections initially */
        .form-step {
            display: none;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .form-step.show {
            display: block;
        }

        .step-title {
            color: #2c5f5f;
            margin-bottom: 20px;
            font-size: 18px;
        }

        /* Conditional rules specific styles */
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            width: auto;
        }

        /* Table styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c5f5f;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .type-informational {
            background: #d1ecf1;
            color: #0c5460;
        }

        .type-conditional {
            background: #fff3cd;
            color: #856404;
        }
    </style>

    <style>
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

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span> Add  New Usage Term
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
                        <form action="{{route('admin.workmanagement.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)

                            <div>
                                <!-- CREATE SECTION -->
                                <div id="create-section" class="content-section active">
                                    <div class="content-header">
                                        <p>Create informational notes or conditional rules for your vouchers</p>
                                    </div>
                                    <input type="hidden" name="term_type" id="term_type"   />
                                    <!-- Step 1: Select Term Type -->
                                    <div class="step-title">Step 1: Select Term Type</div>
                                    <div class="term-type-selection">
                                        <div class="term-type-card" onclick="selectTermType('informational')">
                                            <h3>📝 Informational Notes</h3>
                                            <p>Display messages to customers</p>
                                            <small style="color: #888;">Example: "Valid for dine-in only"</small>
                                        </div>
                                        <div class="term-type-card" onclick="selectTermType('conditional')">
                                            <h3>⚙️ Conditional Rules</h3>
                                            <p>Control when vouchers are available</p>
                                            <small style="color: #888;">Example: "Weekdays only"</small>
                                        </div>
                                    </div>

                                    <!-- Step 2: Basic Info (Hidden initially) -->
                                    <div id="basic-info-step" class="form-step">
                                        <div class="step-title">Step 2: Basic Information</div>

                                        <div class="form-group">
                                            <label for="term-title">Term Title</label>
                                            <input type="text" id="term-title" name="term_title"   placeholder="Enter a title for this term">
                                        </div>

                                        <div class="form-group">
                                            <label for="term-description">Description</label>
                                            <textarea id="term-description" name="desc" placeholder="Describe what this term does"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="voucher-types">Applicable Voucher Types</label>
                                            <select id="voucher-types" name="voucher_type[]" multiple style="height: 100px;">
                                                @foreach (\App\Models\VoucherType::get() as $item)

                                                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <small>Hold Ctrl/Cmd to select multiple</small>
                                        </div>
                                    </div>

                                    <!-- Step 3: Informational Content (Hidden initially) -->
                                    <div id="informational-step" class="form-step">
                                        <div class="step-title">Step 3: Informational Content</div>

                                        <div class="form-group">
                                            <label for="customer-message">Customer Message</label>
                                            <textarea id="customer-message" name="mesage" placeholder="Enter the message customers will see" style="min-height: 100px;"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="display-when">When to Display</label>
                                            <select id="display-when" name="when_to_display">
                                                <option value="always">Always Show</option>
                                                <option value="purchase">During Purchase Only</option>
                                                <option value="redemption">During Redemption Only</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Step 3: Conditional Rules (Hidden initially) -->
                                    <div id="conditional-step" class="form-step">
                                        <div class="step-title">Step 3: Conditional Rules</div>

                                        <div class="form-group">
                                            <label>Available Days (leave unchecked for all days)</label>
                                            <div class="checkbox-group">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-monday" name="days[]" value="monday">
                                                    <label for="day-monday">Monday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-tuesday" name="days[]" value="tuesday">
                                                    <label for="day-tuesday">Tuesday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-wednesday" name="days[]" value="wednesday">
                                                    <label for="day-wednesday">Wednesday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-thursday" name="days[]" value="thursday">
                                                    <label for="day-thursday">Thursday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-friday" name="days[]" value="friday">
                                                    <label for="day-friday">Friday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-saturday" name="days[]" value="saturday">
                                                    <label for="day-saturday">Saturday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-sunday" name="days[]" value="sunday">
                                                    <label for="day-sunday">Sunday</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="min-purchase">Minimum Purchase Amount (optional)</label>
                                            <input type="number" id="min-purchase" name="min_purchase_amount" placeholder="0.00" step="0.01" min="0">
                                        </div>

                                        <div class="form-group">
                                            <label for="restriction-action">What happens when condition is not met?</label>
                                            <select id="restriction-action" name="condition_is_not_met">
                                                <option value="hide">Hide voucher completely</option>
                                                <option value="warning">Show warning message</option>
                                                <option value="block">Block redemption</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="restriction-message">Message when condition not met</label>
                                            <textarea id="restriction-message" name="condition_not_met" placeholder="Enter message to show to customer"></textarea>
                                        </div>
                                    </div>

                                    <!-- Action Buttons (Hidden initially) -->
                                    {{-- <div id="action-buttons" class="form-step">
                                        <button class="btn btn-primary" onclick="previewTerm()">Preview Term</button>
                                        <button class="btn btn-success" onclick="saveTerm()">Save Term</button>
                                    </div> --}}

                                      <div class="btn--container justify-content-end mt-5">
                                            <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                            <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                                        </div>

                                </div>

                            </div>
                             @endif
                        </form>
                    </div>

            <!-- End Table -->
        </div>


    </div>



@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>

 <script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>


<script>
// Global variables
let selectedTermType = '';
let usageTermsData = [
    {
        id: 1,
        title: 'Weekdays Only',
        type: 'conditional',
        description: 'Voucher only available Monday-Friday',
        voucherTypes: ['in-store'],
        status: 'active',
        conditions: {
            days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            action: 'hide',
            message: 'This voucher is only available on weekdays'
        }
    },
    {
        id: 2,
        title: 'Dine-in Only Notice',
        type: 'informational',
        description: 'Notice about dine-in restriction',
        voucherTypes: ['in-store'],
        status: 'active',
        content: {
            message: 'Valid for dine-in only, not for takeaway',
            displayWhen: 'always'
        }
    }
];

// Basic navigation
function showSection(sectionName) {
    console.log('Switching to section:', sectionName);

    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });

    // Remove active class from menu items
    document.querySelectorAll('.menu-item').forEach(item => {
        item.classList.remove('active');
    });

    // Show selected section
    document.getElementById(sectionName + '-section').classList.add('active');

    // Add active class to clicked menu item
    event.target.classList.add('active');

    // Load data if it's the list section
    if (sectionName === 'list') {
        loadTermsList();
    }
}

// Term type selection
function selectTermType(type) {
    console.log('Selected term type:', type);
    selectedTermType = type;

    // Update card selection
    document.querySelectorAll('.term-type-card').forEach(card => {
        card.classList.remove('selected');
    });
    event.target.classList.add('selected');

    // Show basic info step
    document.getElementById('basic-info-step').classList.add('show');

    // Show appropriate content step
    if (type === 'informational') {
        document.getElementById('informational-step').classList.add('show');
        document.getElementById('conditional-step').classList.remove('show');
        document.getElementById('term_type').value = 'informational';
    } else {
        document.getElementById('conditional-step').classList.add('show');
        document.getElementById('informational-step').classList.remove('show');
        document.getElementById('term_type').value = 'conditional';
    }

    // Show action buttons
    document.getElementById('action-buttons').classList.add('show');
}

// Preview function
function previewTerm() {
    const title = document.getElementById('term-title').value;
    const description = document.getElementById('term-description').value;

    if (!title) {
        alert('Please enter a term title');
        return;
    }

    if (!selectedTermType) {
        alert('Please select a term type first');
        return;
    }

    let previewMessage = `Preview of "${title}":\n\n`;
    previewMessage += `Type: ${selectedTermType}\n`;
    previewMessage += `Description: ${description}\n\n`;

    if (selectedTermType === 'informational') {
        const customerMessage = document.getElementById('customer-message').value;
        const displayWhen = document.getElementById('display-when').value;
        previewMessage += `Customer will see: "${customerMessage}"\n`;
        previewMessage += `Display: ${displayWhen}`;
    } else {
        // Get selected days
        const selectedDays = [];
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
            selectedDays.push(cb.value);
        });

        const minPurchase = document.getElementById('min-purchase').value;
        const restrictionMessage = document.getElementById('restriction-message').value;

        if (selectedDays.length > 0) {
            previewMessage += `Available days: ${selectedDays.join(', ')}\n`;
        }
        if (minPurchase) {
            previewMessage += `Minimum purchase: $${minPurchase}\n`;
        }
        if (restrictionMessage) {
            previewMessage += `Restriction message: "${restrictionMessage}"`;
        }
    }

    alert(previewMessage);
}

// Save function
function saveTerm() {
    const title = document.getElementById('term-title').value;
    const description = document.getElementById('term-description').value;

    if (!title) {
        alert('Please enter a term title');
        return;
    }

    if (!selectedTermType) {
        alert('Please select a term type first');
        return;
    }

    // Create new term object
    const newTerm = {
        id: usageTermsData.length + 1,
        title: title,
        type: selectedTermType,
        description: description,
        voucherTypes: Array.from(document.getElementById('voucher-types').selectedOptions).map(opt => opt.value),
        status: 'active'
    };

    // Add type-specific data
    if (selectedTermType === 'informational') {
        newTerm.content = {
            message: document.getElementById('customer-message').value,
            displayWhen: document.getElementById('display-when').value
        };
    } else {
        const selectedDays = [];
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
            selectedDays.push(cb.value);
        });

        newTerm.conditions = {
            days: selectedDays,
            minPurchase: parseFloat(document.getElementById('min-purchase').value) || 0,
            action: document.getElementById('restriction-action').value,
            message: document.getElementById('restriction-message').value
        };
    }

    // Add to data array
    usageTermsData.push(newTerm);

    alert('Usage term saved successfully!');

    // Reset form
    resetForm();
}

// Reset form
function resetForm() {
    // Clear all inputs
    document.querySelectorAll('input, textarea, select').forEach(input => {
        if (input.type === 'checkbox') {
            input.checked = false;
        } else {
            input.value = '';
        }
    });

    // Hide all form steps
    document.querySelectorAll('.form-step').forEach(step => {
        step.classList.remove('show');
    });

    // Remove selection from cards
    document.querySelectorAll('.term-type-card').forEach(card => {
        card.classList.remove('selected');
    });

    selectedTermType = '';
}

// Load terms list
function loadTermsList() {
    console.log('Loading terms list...');
    const tbody = document.getElementById('terms-list');
    tbody.innerHTML = '';

    usageTermsData.forEach(term => {
        const row = document.createElement('tr');

        const voucherTypeNames = term.voucherTypes.map(type => {
            const names = {
                'in-store': 'In-Store',
                'online': 'Online',
                'service': 'Service',
                'gift': 'Gift'
            };
            return names[type] || type;
        });

        row.innerHTML = `
            <td>${term.title}</td>
            <td><span class="status-badge type-${term.type}">${term.type}</span></td>
            <td>${voucherTypeNames.join(', ')}</td>
            <td><span class="status-badge status-${term.status}">${term.status}</span></td>
            <td>
                <button class="btn btn-primary" onclick="editTerm(${term.id})">Edit</button>
            </td>
        `;

        tbody.appendChild(row);
    });
}

// Edit term (placeholder)
function editTerm(id) {
    alert(`Editing term with ID: ${id}`);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing...');
    loadTermsList();
});
</script>


<script>
    $(function () {
        $('#type').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: $('#type').data('placeholder'),
            allowClear: true,
            closeOnSelect: false
        });
    });
</script>

@endpush
