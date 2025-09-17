@extends('layouts.admin.app')

@section('title',"Bonus & Limits Settings")

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
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


    .btn:hover {
    background: #5a6fd8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-success {
    background: #28a745;
    }

    .btn-success:hover {
    background: #218838;
    }

    .btn-secondary {
    background: #6c757d;
    }

    .btn-secondary:hover {
    background: #545b62;
    }

    .file-upload {
    border: 2px dashed #ccc;
    border-radius: 8px;
    padding: 40px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    }

    .file-upload:hover {
    border-color: #667eea;
    background: #f8f9ff;
    }

    .gallery-preview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 10px;
    margin-top: 15px;
    padding: 15px;
    background: white;
    border-radius: 8px;
    min-height: 80px;
    border: 1px solid #e9ecef;
    }

    .gallery-item {
    aspect-ratio: 1;
    background: #f0f0f0;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 12px;
    position: relative;
    }

    .merchant-list {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-top: 15px;
    display: none;
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
    display: none;
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

    .cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 20px;
    margin-top: 25px;
    }

    .card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s ease;
    }

    .card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
    }

    .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    }

    .card-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    }

    .card-content {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
    }

    .card-actions {
    text-align: right;
    }

    .status-badge {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    }

    .status-active {
    background: #d4edda;
    color: #155724;
    }

    .status-inactive {
    background: #f8d7da;
    color: #721c24;
    }

    .btn-danger {
    background: #dc3545;
    }

    .btn-danger:hover {
    background: #c82333;
    }

    .edit-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    }

    .edit-modal.show {
    display: flex;
    }

    .modal-content {
    background: white;
    border-radius: 12px;
    padding: 30px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow-y: auto;
    }

    .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
    }

    .close-modal {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #999;
    }

    .action-bar {
    position: sticky;
    bottom: 0;
    background: white;
    padding: 25px 0;
    border-top: 3px solid #e9ecef;
    margin-top: 40px;
    }

    .radio-group {
    display: flex;
    gap: 20px; /* dono ke beech thoda space */
    }

    .radio-group label {
    display: flex;
    align-items: center;
    gap: 5px; /* text aur radio button ke beech spacing */
    cursor: pointer;
    }

    </style>
    <div class="content container-fluid">
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
        <div class="row g-3">
            <div class="col-12">
                <form action="{{route('admin.Giftcard.bonus_store')}}" method="post" enctype="multipart/form-data" id="occasionForm">
                    @csrf
                    @if ($language)
                        <div class="main-content">
                            <!-- MERCHANT BONUS & LIMITS -->
                            <div id="merchant-bonus" class="section">
                                <div class="page-header">
                                    <h1>Bonus & Limits Settings</h1>
                                    <p>Configure multi-level bonus tiers and amount limits per merchant</p>
                                </div>
                                <input type="hidden" name="hidden_store_id" id="hidden_store_id" />
                                    <div class="form-section">
                                    <div class="form-group">
                                        <label>Select Type</label>
                                        <div class="radio-group">
                                        <label>
                                            <input type="radio" id="type_flate" name="type_select" value="flate">
                                            Flate Discount
                                        </label>
                                        <label>
                                            <input type="radio" id="type_bonus" name="type_select" value="bonus">
                                            Bonus Discount
                                        </label>
                                        </div>
                                    </div>
                                    </div>


                                <div class="form-section">
                                    <div class="section-title">Select Voucher Type</div>
                                    <div class="form-group">
                                        <label for="voucher_type">Voucher Type</label>
                                        <select id="voucher_type" name="voucher_type" onchange="loadMerchantsByCategory()">
                                            <option value="">-- Select Voucher Type --</option>
                                          @foreach(\App\Models\VoucherType::get() as $VoucherType)
                                                <option value="{{ $VoucherType->id }}"
                                                @if( (old('voucher_type') && in_array($VoucherType->id, old('voucher_type')))
                                                    || (isset($selectedVoucherIds) && in_array($VoucherType->id, $selectedVoucherIds)) )
                                                    selected
                                                @endif
                                            >{{ $VoucherType->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-section">
                                    <div class="section-title">Select Category & Merchant</div>
                                    <div class="form-group">
                                        <label for="categoryFilter">Business Category</label>
                                        <select id="categoryFilter" name="category" onchange="loadMerchantsByCategory()">
                                            <option value="">-- Select Category --</option>
                                          @foreach(\App\Models\Category::get() as $Category)
                                                <option value="{{ $Category->id }}"
                                                @if( (old('category_id') && in_array($Category->id, old('category_id')))
                                                    || (isset($selectedVoucherIds) && in_array($Category->id, $selectedVoucherIds)) )
                                                    selected
                                                @endif
                                            >{{ $Category->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="merchant-list" id="merchantsList">
                                        <!-- Merchants will be loaded here -->
                                    </div>
                                </div>

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
                                            <!-- Tier items will be added here -->
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary" onclick="addBonusTier()">Add New Tier</button>
                                </div>

                                <div class="form-section">
                                    <div class="section-title">Amount Limits</div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="merchantMinAmount">Minimum Gift Card Amount</label>
                                            <input type="number" name="min_gift_ard" id="merchantMinAmount" placeholder="25" min="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="merchantMaxAmount">Maximum Gift Card Amount</label>
                                            <input type="number" name="max_gift_ard" id="merchantMaxAmount" placeholder="1000" min="1">
                                        </div>
                                    </div>
                                </div>

                                 <div class="btn--container justify-content-end mt-5">
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
    <script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>

      <script>
        // Data storage
        let occasionsData = [
            {
                id: 1,
                name: 'Birthday Celebration',
                category: 'Restaurants',
                priority: 1,
                galleryCount: 3,
                status: 'active',
                createdDate: '2025-01-15'
            },
            {
                id: 2,
                name: 'Anniversary Dinner',
                category: 'Hotels',
                priority: 2,
                galleryCount: 5,
                status: 'active',
                createdDate: '2025-01-14'
            },
            {
                id: 3,
                name: 'Movie Night',
                category: 'Cinemas',
                priority: 3,
                galleryCount: 2,
                status: 'inactive',
                createdDate: '2025-01-13'
            }
        ];
        let selectedMerchant = null;
        let tierCounter = 0;
        let editingOccasionId = null;

        let merchantsData = {
            'Hotels': [
                { id: 1, name: 'Grand Palace Hotel', bonusTiers: [], minAmount: 50, maxAmount: 1000 },
                { id: 2, name: 'Luxury Resort & Spa', bonusTiers: [], minAmount: 100, maxAmount: 2000 }
            ],
            'Restaurants': [
                { id: 3, name: 'The Gourmet Grill', bonusTiers: [], minAmount: 25, maxAmount: 300 },
                { id: 4, name: 'Italian Bistro', bonusTiers: [], minAmount: 30, maxAmount: 250 },
                { id: 5, name: 'Seafood Palace', bonusTiers: [], minAmount: 40, maxAmount: 400 }
            ],
            'Cinemas': [
                { id: 6, name: 'Cinema Central', bonusTiers: [], minAmount: 15, maxAmount: 150 },
                { id: 7, name: 'Luxury Cinema Complex', bonusTiers: [], minAmount: 20, maxAmount: 200 }
            ],
            'Spas & Wellness': [
                { id: 8, name: 'Serenity Spa', bonusTiers: [], minAmount: 60, maxAmount: 600 },
                { id: 9, name: 'Wellness Center', bonusTiers: [], minAmount: 50, maxAmount: 500 }
            ]
        };

        // Load merchants by category
    function loadMerchantsByCategory() {
        const category = $('#categoryFilter').val();
        const merchantsList = $('#merchantsList');

        console.log('Loading Store for category:', category);

        if (!category) {
            merchantsList.hide();
            return;
        }

        merchantsList.show().html('<div>Loading...</div>');

        $.ajax({
            url: '/admin/Giftcard/add-get-merchants',
            method: 'GET',
            data: { category: category },
            dataType: 'json',
            success: function(data) {

                merchantsList.empty();
                console.log(data.data)
                if (!data.data || data.data.length === 0) {

                    merchantsList.html('<div>No Store found</div>');
                    return;
                }
                data.data.forEach(merchant => {
                    const item = $(`
                        <div class="merchant-item" onclick="update_ids(${merchant.id})">
                            <div class="merchant-name">${merchant.name}</div>
                            <div class="merchant-info">
                                Current:  ${merchant.bonus_tiers} bonus tiers |
                                Limits: $${merchant.limit_from} -$${merchant.limit_to}
                            </div>
                        </div>
                    `);
                    item.on('click', () => selectMerchant(merchant));
                    merchantsList.append(item);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching merchants:', error);
                merchantsList.html('<div>Error loading Store</div>');
            }
        });
    }


        // Select merchant
        function selectMerchant(merchant) {
            selectedMerchant = merchant;
            console.log('Selected merchant:', merchant.name);

            // Update UI
            document.querySelectorAll('.merchant-item').forEach(item => {
                item.classList.remove('selected');
            });
            event.target.closest('.merchant-item').classList.add('selected');

            // Show bonus configuration
            document.getElementById('bonusTiers').style.display = 'block';

            // Load existing tiers
            loadExistingTiers();

            // Load merchant limits
            document.getElementById('merchantMinAmount').value = merchant.minAmount;
            document.getElementById('merchantMaxAmount').value = merchant.maxAmount;
        }

        // Load existing tiers
        function loadExistingTiers() {
            const tiersList = document.getElementById('tiersList');
            tiersList.innerHTML = '';

            if (selectedMerchant.bonusTiers && selectedMerchant.bonusTiers.length > 0) {
                selectedMerchant.bonusTiers.forEach((tier, index) => {
                    addTierRow(tier.minAmount, tier.maxAmount, tier.bonusPercent);
                });
            } else {
                // Add one default tier
                addTierRow('', '', '');
            }
        }

        // Add bonus tier
        function addBonusTier() {
            addTierRow('', '', '');
        }

        // Add tier row
        function addTierRow(minAmount = '', maxAmount = '', bonusPercent = '') {
            tierCounter++;
            const tiersList = document.getElementById('tiersList');

            const tierRow = document.createElement('div');
            tierRow.className = 'tier-item';
            tierRow.id = `tier-${tierCounter}`;

            tierRow.innerHTML = `
                <input type="number" class="tier-input" name="min[]" placeholder="Min $" value="${minAmount}" min="0">
                <input type="number" class="tier-input" name="max[]" placeholder="Max $" value="${maxAmount}" min="0">
                <input type="number" class="tier-input" name="bonus[]" placeholder="Bonus %" value="${bonusPercent}" min="0" max="100">
                <button class="btn btn-danger" onclick="removeTier(${tierCounter})" style="padding: 8px; font-size: 12px;">Remove</button>
            `;

            tiersList.appendChild(tierRow);
        }

        // Remove tier
        function removeTier(tierId) {
            const tierElement = document.getElementById(`tier-${tierId}`);
            if (tierElement) {
                tierElement.remove();
            }
        }


        function update_ids(id) {
            const tiersList = document.getElementById('hidden_store_id');
            if (tiersList) {
                tiersList.value = id; // hidden input ke andar value set hogi
                console.log("Hidden input updated:", tiersList.value);
            } else {
                console.error("hidden_store_id element not found!");
            }
        }


    </script>


@endpush
