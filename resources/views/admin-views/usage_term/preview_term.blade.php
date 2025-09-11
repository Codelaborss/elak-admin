@extends('layouts.admin.app')

@section('title', 'Usage Term List')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet">
    <style>
        /* Dropdown options - selected option ka background highlight */
        .select2-results__option[aria-selected="true"] {
            background-color: #005555 !important;
            /* Bootstrap primary */
            color: #fff !important;
        }

        /* Hover effect on options */
        .select2-results__option--highlighted[aria-selected] {
            background-color: #005555 !important;
            color: #fff !important;
        }

        /* Selected tags (neeche input me show hone wale items) */
        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            background-color: #005555;
            /* blue tag */
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
            padding: 15px 20px;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            padding-left: 25px;
            border-right: 3px solid #fff;
        }

        .menu-icon {
            margin-right: 10px;
            font-size: 16px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background: white;
            margin: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }


        .section.active {
            display: block;
        }

        .page-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2c5f5f;
        }

        .page-header h1 {
            color: #2c5f5f;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
            font-size: 16px;
        }

        /* Form Styles */
        .form-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #2c5f5f;
        }

        .section-title {
            color: #2c5f5f;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title .icon {
            margin-right: 10px;
            font-size: 24px;
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

        .form-row-triple {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
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
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #2c5f5f;
            box-shadow: 0 0 0 3px rgba(44, 95, 95, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        /* Checkbox Groups */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-item:hover {
            border-color: #2c5f5f;
            background: #f0f8f8;
        }

        .checkbox-item.selected {
            border-color: #2c5f5f;
            background: #e8f4f4;
        }

        .checkbox-item input {
            width: auto;
            margin-right: 8px;
            transform: scale(1.2);
            accent-color: #2c5f5f;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            font-weight: normal;
        }

        /* Time Range Inputs */
        .time-range {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 15px;
            align-items: center;
        }

        .time-separator {
            text-align: center;
            font-weight: 600;
            color: #666;
        }

        /* Special Input Styles */
        .number-input-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .number-input-group input {
            flex: 1;
        }

        .number-input-group .unit {
            color: #666;
            font-weight: 600;
            min-width: 60px;
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
            margin: 10px 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 30px;
            transition: 0.4s;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            border-radius: 50%;
            transition: 0.4s;
        }

        input:checked+.toggle-slider {
            background-color: #2c5f5f;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(30px);
        }

        /* Action Bar */
        .action-bar {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 25px 0;
            border-top: 3px solid #e9ecef;
            margin-top: 40px;
        }

        /* Conditions List */
        .conditions-grid {
            display: grid;
            gap: 20px;
            margin-top: 30px;
        }

        .condition-card {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .condition-card:hover {
            border-color: #2c5f5f;
            box-shadow: 0 4px 20px rgba(44, 95, 95, 0.1);
        }

        .condition-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .condition-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c5f5f;
            margin-bottom: 5px;
        }

        .condition-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .condition-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            font-size: 13px;
        }

        .condition-detail-item {
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .condition-detail-item:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        .detail-value {
            color: #2c5f5f;
            font-weight: 600;
        }

        .condition-actions {
            margin-top: 15px;
            text-align: right;
        }

        /* Preview Styles */
        .preview-container {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 12px;
            padding: 25px;
            margin-top: 25px;
        }

        .preview-title {
            color: #2c5f5f;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .preview-terms {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .preview-section {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .preview-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .preview-section h4 {
            color: #2c5f5f;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .preview-section ul {
            margin-left: 20px;
        }

        .preview-section li {
            margin-bottom: 5px;
            color: #555;
        }

        @media (max-width: 768px) {

            .form-row,
            .form-row-triple {
                grid-template-columns: 1fr;
            }

            .checkbox-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    <div class="content container-fluid">

        @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
        <!-- End Page Header -->
        <form action="{{ route('admin.UsageTerm.getAssignments_update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="assign" class="section">
                <div class="page-header">
                    <h1>👁️ Preview Customer Terms</h1>
                    <p>See exactly how the terms will appear to your customers</p>
                </div>

                <div class="form-group">
                    <label for="voucherTypeSelect">Select Voucher Type to Preview</label>
                    <select id="voucherTypeSelect" name="voucher_id">
                        <option value="">-- Select Voucher Type --</option>
                        @foreach ($VoucherType as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Yahan data load hoga -->
                <div id="voucherAssignmentsContainer"></div>

            </div>




        </form>
        <!-- End Table -->
    </div>

@endsection

@push('script_2')
    <!-- Select2 (agar bootstrap ke baad bhi chalega) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <!-- Aapke custom scripts (last me) -->
    <script src="{{ asset('public/assets/admin/js/view-pages/segments-index.js') }}"></script>
    <script src="{{ asset('public/assets/admin/js/view-pages/client-side-index.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#voucherTypeSelect").on("change", function() {
                let voucherId = $(this).val();

                if (voucherId) {
                    $.ajax({
                        url: "/admin/UsageTerm/preview-terms-show/" + voucherId,
                        type: "GET",
                        dataType: "json",
                 success: function(response) {
                    let html = '<div class="conditions-grid" id="assignmentGrid">';

                    if (response.conditions && response.conditions.length > 0) {
                        response.conditions.forEach(condition => {
                            let days = "";
                            if (condition.timeandday_config_days) {
                                let parsedDays = Array.isArray(condition.timeandday_config_days)
                                    ? condition.timeandday_config_days
                                    : JSON.parse(condition.timeandday_config_days);
                                days = parsedDays.map(day => day.charAt(0).toUpperCase() + day.slice(1)).join(", ");
                            }

                            html += `
                                <div class="preview-container card shadow-sm p-4 mb-4">
                                    <div class="preview-title h4 mb-3">📋 Usage Terms & Conditions</div>
                                    <div class="preview-section bg-white p-3">
                                    <h4 class="preview-title mb-3"> ${condition.baseinfor_condition_title ?? "Untitled"}</h4>
                                    <p>${condition.baseinfor_description ?? ""}</p>
                                    <ul>
                                        <li><strong>Available on:</strong> ${days || "N/A"}</li>
                                        <li><strong>Time:</strong> ${condition.timeandday_config_time_range_from ?? ""} - ${condition.timeandday_config_time_range_to ?? ""}</li>
                                        <li><strong>Valid from:</strong> ${condition.timeandday_config_valid_from_date ?? "N/A"} to ${condition.timeandday_config_valid_until_date ?? "N/A"}</li>
                                        <li><strong>Holiday restrictions:</strong> ${condition.holiday_occasions_holiday_restrictions ?? "None"}</li>
                                        <li><strong>Blackout dates:</strong> ${condition.holiday_occasions_customer_blackout_dates ?? "None"}</li>
                                        <li><strong>Special occasions:</strong> ${condition.holiday_occasions_special_occasions ?? "None"}</li>
                                        <li><strong>Limit per user:</strong> ${condition.usage_limits_limit_per_user ?? "N/A"}</li>
                                        <li><strong>Period:</strong> ${condition.usage_limits_period ?? "N/A"}</li>
                                        <li><strong>Min purchase amount:</strong> ${condition.usage_limits_min_purch_account ?? "N/A"}</li>
                                        <li><strong>Max discount:</strong> ${condition.usage_limits_max_discount_amount ?? "N/A"}</li>
                                        <li><strong>Advance booking required:</strong> ${condition.usage_limits_advance_booking_required ? "Yes" : "No"}</li>
                                        <li><strong>Group size required:</strong> ${condition.usage_limits_group_size_required ?? "N/A"}</li>
                                        <li><strong>Venue types:</strong> ${condition.location_availability_venue_types ?? "N/A"}</li>
                                        <li><strong>Specific branch:</strong> ${condition.location_availability_specific_branch ?? "N/A"}</li>
                                        <li><strong>City:</strong> ${condition.location_availability_city ?? "N/A"}</li>
                                        <li><strong>Delivery radius:</strong> ${condition.location_availability_delivery_radius ?? "N/A"}</li>
                                        <li><strong>Customer type:</strong> ${condition.customer_membership_customer_type ?? "N/A"}</li>
                                        <li><strong>Age restriction:</strong> ${condition.customer_membership_age_restriction ?? "N/A"}</li>
                                        <li><strong>Membership radius:</strong> ${condition.customer_membership_min_membership_radius ?? "N/A"}</li>
                                        <li><strong>Restriction type:</strong> ${condition.restriction_polices_restriction_type ?? "N/A"}</li>
                                        <li><strong>Cancellation policy:</strong> ${condition.restriction_polices_cancellation_policy ?? "N/A"}</li>
                                        <li><strong>Excluded product:</strong> ${condition.restriction_polices_excluded_product ?? "N/A"}</li>
                                        <li><strong>Surcharge account:</strong> ${condition.restriction_polices_surchange_account ?? "N/A"}</li>
                                        <li><strong>Surcharge apple:</strong> ${condition.restriction_polices_surchange_apple ?? "N/A"}</li>
                                    </ul>
                                    <small class="text-muted">Created at: ${condition.created_at} | Updated at: ${condition.updated_at}</small>
                                </div>
                                </div>
                            `;
                        });
                    } else {
                        html += `
                            <div class="card shadow-sm p-4 text-center text-muted">
                                <h5>⚠️ No Terms & Conditions Found</h5>
                                <p>This voucher has no usage terms yet.</p>
                            </div>
                        `;
                    }

                    html += '</div>';
                    $("#voucherAssignmentsContainer").html(html);
                },

                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $("#voucherAssignmentsContainer").html(
                                "<p style='color:red;'>Error loading data</p>");
                        }
                    });
                } else {
                    $("#voucherAssignmentsContainer").html("");
                }
            });
        });
    </script>

    <script>
        $(function() {
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
