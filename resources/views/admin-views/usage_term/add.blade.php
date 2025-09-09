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
        /* .btn {
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
        } */

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
        .menu-item {
            padding: 15px 20px;
            cursor: pointer;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
            padding-left: 25px;
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
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
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .section {
            display: none;
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

        input:checked + .toggle-slider {
            background-color: #2c5f5f;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(30px);
        }

        /* Buttons */
        /* .btn {
            background: #2c5f5f;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #1a4040;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(44, 95, 95, 0.3);
        }

        .btn-success {
            background: #28a745;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #545b62;
        } */

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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            .form-row, .form-row-triple {
                grid-template-columns: 1fr;
            }

            .checkbox-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>


    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span> Create Deep Condition
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
                        <form action="{{route('admin.UsageTerm.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if ($language)

                                <!-- CREATE SECTION -->
                                <!-- CREATE DEEP CONDITION -->
                                <div id="create" class="section active">
                                    <!-- Basic Information -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">📝</span>Basic Information
                                        </div>

                                        <div class="form-group">
                                            <label for="conditionTitle">Condition Title</label>
                                            <input type="text" id="conditionTitle" name="baseinfor_condition_title" placeholder="e.g., Weekend Premium Hours">
                                        </div>

                                        <div class="form-group">
                                            <label for="conditionDescription">Detailed Description</label>
                                            <textarea id="conditionDescription" name="baseinfor_description" placeholder="Explain exactly when and how this condition applies, what it restricts, and what customers should know"></textarea>
                                        </div>
                                    </div>

                                    <!-- Time & Days Configuration -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">📅</span>Time & Days Configuration
                                        </div>

                                        <div class="form-group">
                                            <label>Available Days</label>
                                            <div class="checkbox-grid" id="daysCheckboxes">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-monday" name="timeandday_config_days[]" value="monday">
                                                    <label for="day-monday">Monday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-tuesday" name="timeandday_config_days[]" value="tuesday">
                                                    <label for="day-tuesday">Tuesday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-wednesday" name="timeandday_config_days[]" value="wednesday">
                                                    <label for="day-wednesday">Wednesday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-thursday" name="timeandday_config_days[]" value="thursday">
                                                    <label for="day-thursday">Thursday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-friday" name="timeandday_config_days[]" value="friday">
                                                    <label for="day-friday">Friday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-saturday" name="timeandday_config_days[]" value="saturday">
                                                    <label for="day-saturday">Saturday</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="day-sunday" name="timeandday_config_days[]" value="sunday">
                                                    <label for="day-sunday">Sunday</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Time Range</label>
                                            <div class="time-range">
                                                <input type="time" id="timeStart" name="timeandday_config_time_range_from" placeholder="Start time">
                                                <div class="time-separator">to</div>
                                                <input type="time" id="timeEnd" name="timeandday_config_time_range_to" placeholder="End time">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="dateStart">Valid From Date</label>
                                                <input type="date" name="timeandday_config_valid_from_date" id="dateStart">
                                            </div>
                                            <div class="form-group">
                                                <label for="dateEnd">Valid Until Date</label>
                                                <input type="date" name="timeandday_config_valid_until_date" id="dateEnd">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Holidays & Occasions -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">🎄</span>Holidays & Occasions
                                        </div>

                                        <div class="form-group">
                                            <label>Holiday Restrictions</label>
                                            <div class="checkbox-grid">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="exclude-national" name="holiday_occasions_holiday_restrictions[]" value="national-holidays">
                                                    <label for="exclude-national">Exclude National Holidays</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="exclude-religious" name="holiday_occasions_holiday_restrictions[]" value="religious-holidays">
                                                    <label for="exclude-religious">Exclude Religious Holidays</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="exclude-ramadan" name="holiday_occasions_holiday_restrictions[]" value="ramadan">
                                                    <label for="exclude-ramadan">Exclude Ramadan</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="exclude-christmas" name="holiday_occasions_holiday_restrictions[]" value="christmas">
                                                    <label for="exclude-christmas">Exclude Christmas Period</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="exclude-newyear" name="holiday_occasions_holiday_restrictions[]" value="newyear">
                                                    <label for="exclude-newyear">Exclude New Year</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="exclude-eid" name="holiday_occasions_holiday_restrictions[]" value="eid">
                                                    <label for="exclude-eid">Exclude Eid Holidays</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customHolidays">Custom Blackout Dates</label>
                                            <textarea id="customHolidays" name="holiday_occasions_customer_blackout_dates" placeholder="Enter specific dates to exclude (e.g., 2025-12-24, 2025-12-25, Company Anniversary dates, etc.)"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Special Occasions</label>
                                            <div class="checkbox-grid">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="valentines" name="holiday_occasions_special_occasions[]" value="valentines">
                                                    <label for="valentines">Valentine's Day</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="mothers-day" name="holiday_occasions_special_occasions[]" value="mothers-day">
                                                    <label for="mothers-day">Mother's Day</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="fathers-day" name="holiday_occasions_special_occasions[]" value="fathers-day">
                                                    <label for="fathers-day">Father's Day</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="graduation" name="holiday_occasions_special_occasions[]" value="graduation">
                                                    <label for="graduation">Graduation Season</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="back-to-school" name="holiday_occasions_special_occasions[]" value="back-to-school">
                                                    <label for="back-to-school">Back to School</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="black-friday" name="holiday_occasions_special_occasions[]" value="black-friday">
                                                    <label for="black-friday">Black Friday</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Usage & Limits -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">📊</span>Usage & Limits
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="usageLimit">Usage Limit per User</label>
                                                <div class="number-input-group">
                                                    <input type="number" id="usageLimit" name="usage_limits_limit_per_user" min="1" placeholder="1">
                                                    <span class="unit">times</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="usagePeriod">Usage Period</label>
                                                <select id="usagePeriod" name="usage_limits_period">
                                                    <option value="total">Total (lifetime)</option>
                                                    <option value="daily">Per Day</option>
                                                    <option value="weekly">Per Week</option>
                                                    <option value="monthly">Per Month</option>
                                                    <option value="yearly">Per Year</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="minPurchase">Minimum Purchase Amount</label>
                                                <div class="number-input-group">
                                                    <input type="number" id="minPurchase" name="usage_limits_min_purch_account" min="0" step="0.01" placeholder="0.00">
                                                    <span class="unit">USD</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="maxDiscount">Maximum Discount Amount</label>
                                                <div class="number-input-group">
                                                    <input type="number" id="maxDiscount" name="usage_limits_max_discount_amount" min="0" step="0.01" placeholder="No limit">
                                                    <span class="unit">USD</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="advanceBooking">Advance Booking Required</label>
                                                <div class="number-input-group">
                                                    <input type="number" id="advanceBooking" name="usage_limits_advance_booking_required" min="0" placeholder="0">
                                                    <span class="unit">hours</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="groupSize">Group Size Requirement</label>
                                                <select id="groupSize" name="usage_limits_group_size_required">
                                                    <option value="">No requirement</option>
                                                    <option value="2+">Minimum 2 people</option>
                                                    <option value="4+">Minimum 4 people</option>
                                                    <option value="6+">Minimum 6 people</option>
                                                    <option value="8+">Minimum 8 people</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Location & Availability -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">🏪</span>Location & Availability
                                        </div>

                                        <div class="form-group">
                                            <label>Venue Types</label>
                                            <div class="checkbox-grid">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="venue-instore" name="location_availability_venue_types[]" value="in-store">
                                                    <label for="venue-instore">In-Store Only</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="venue-online" name="location_availability_venue_types[]" value="online">
                                                    <label for="venue-online">Online Only</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="venue-delivery" name="location_availability_venue_types[]" value="delivery">
                                                    <label for="venue-delivery">Delivery Available</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="venue-pickup" name="location_availability_venue_types[]" value="pickup">
                                                    <label for="venue-pickup">Pickup Available</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="venue-dinein" name="location_availability_venue_types[]" value="dine-in">
                                                    <label for="venue-dinein">Dine-in Only</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="venue-takeaway" name="location_availability_venue_types[]" value="takeaway">
                                                    <label for="venue-takeaway">Takeaway Available</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="specificBranches">Specific Branches/Locations</label>
                                            <textarea id="specificBranches" name="location_availability_specific_branch" placeholder="List specific branch names, addresses, or location IDs where this condition applies"></textarea>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="cityRestriction">City/Region Restriction</label>
                                                <input type="text" id="cityRestriction" name="location_availability_city" placeholder="e.g., Downtown area only, Nablus region">
                                            </div>
                                            <div class="form-group">
                                                <label for="deliveryRadius">Delivery Radius (if applicable)</label>
                                                <div class="number-input-group">
                                                    <input type="number" id="deliveryRadius" name="location_availability_delivery_radius" min="0" placeholder="No limit">
                                                    <span class="unit">km</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Customer & Membership -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">👥</span>Customer & Membership
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="customerType">Customer Type Requirement</label>
                                                <select id="customerType" name="customer_membership_customer_type">
                                                    <option value="">All Customers</option>
                                                    <option value="new">New Customers Only</option>
                                                    <option value="returning">Returning Customers Only</option>
                                                    <option value="vip">VIP Customers Only</option>
                                                    <option value="member">Members Only</option>
                                                    <option value="premium">Premium Members Only</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="ageRestriction">Age Restriction</label>
                                                <select id="ageRestriction" name="customer_membership_age_restriction">
                                                    <option value="">No Age Restriction</option>
                                                    <option value="18+">18+ Only</option>
                                                    <option value="21+">21+ Only</option>
                                                    <option value="senior">Senior Citizens (65+)</option>
                                                    <option value="student">Students Only</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="membershipDuration">Minimum Membership Duration</label>
                                            <select id="membershipDuration" name="customer_membership_min_membership_radius">
                                                <option value="">No requirement</option>
                                                <option value="1month">1 Month</option>
                                                <option value="3months">3 Months</option>
                                                <option value="6months">6 Months</option>
                                                <option value="1year">1 Year</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Restrictions & Policies -->
                                    <div class="form-section">
                                        <div class="section-title">
                                            <span class="icon">🚫</span>Restrictions & Policies
                                        </div>

                                        <div class="form-group">
                                            <label>Restriction Types</label>
                                            <div class="checkbox-grid">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="non-refundable" name="restriction_polices_restriction_type[]" value="non-refundable">
                                                    <label for="non-refundable">Non-refundable</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="non-transferable" name="restriction_polices_restriction_type[]" value="non-transferable">
                                                    <label for="non-transferable">Non-transferable</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="no-cash-value"  name="restriction_polices_restriction_type[]"value="no-cash-value">
                                                    <label for="no-cash-value">No cash value</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="no-combination" name="restriction_polices_restriction_type[]" value="no-combination">
                                                    <label for="no-combination">Cannot combine with other offers</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="prior-reservation" name="restriction_polices_restriction_type[]" value="prior-reservation">
                                                    <label for="prior-reservation">Prior reservation required</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" id="id-required" name="restriction_polices_restriction_type[]" value="id-required">
                                                    <label for="id-required">ID verification required</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cancellationPolicy">Cancellation Policy</label>
                                            <select id="cancellationPolicy" name="restriction_polices_cancellation_policy">
                                                <option value="">No cancellation allowed</option>
                                                <option value="24hours">24 hours advance notice</option>
                                                <option value="48hours">48 hours advance notice</option>
                                                <option value="1week">1 week advance notice</option>
                                                <option value="flexible">Flexible cancellation</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="excludedItems">Excluded Products/Services</label>
                                            <textarea id="excludedItems" name="restriction_polices_excluded_product" placeholder="List specific products, services, or categories that this voucher cannot be used for"></textarea>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="surchargeAmount">Surcharge Amount</label>
                                                <div class="number-input-group">
                                                    <input type="number" id="surchargeAmount" name="restriction_polices_surchange_account" min="0" step="0.01" placeholder="0.00">
                                                    <span class="unit">USD</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="surchargeCondition">Surcharge Applies When</label>
                                                <input type="text" id="surchargeCondition" name="restriction_polices_surchange_apple" placeholder="e.g., During peak hours, Premium seating">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Bar -->
                                    {{-- <div class="action-bar">
                                        <button class="btn btn-success" onclick="createDeepCondition()">💾 Create Condition</button>
                                        <button class="btn btn-secondary" onclick="previewCondition()">👁️ Preview</button>
                                        <button class="btn" onclick="resetConditionForm()">🔄 Reset Form</button>
                                    </div> --}}
                                      <div class="btn--container justify-content-end mt-5">
                                            <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                                            <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                                        </div>

                                </div>
                                <!-- MANAGE CONDITIONS -->
                                {{-- <div id="manage" class="section">
                                    <div class="page-header">
                                        <h1>📋 Manage All Conditions</h1>
                                        <p>View, edit, and manage all your created deep conditions</p>
                                    </div>
                                    <div class="conditions-grid" id="conditionsGrid">
                                    </div>
                                </div> --}}
                                <!-- ASSIGN TO VOUCHERS -->
                                {{-- <div id="assign" class="section">
                                    <div class="page-header">
                                        <h1>🔗 Assign Conditions to Vouchers</h1>
                                        <p>Select which deep conditions apply to each voucher type</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="voucherTypeSelect">Select Voucher Type</label>
                                        <select id="voucherTypeSelect" onchange="loadVoucherAssignments()">
                                            <option value="">-- Select Voucher Type --</option>
                                            <option value="in-store">In-Store Voucher</option>
                                            <option value="online">Online Voucher</option>
                                            <option value="service">Service Voucher</option>
                                            <option value="gift">Gift Voucher</option>
                                        </select>
                                    </div>

                                    <div id="assignmentContainer" style="display: none;">
                                        <div class="conditions-grid" id="assignmentGrid">
                                            <!-- Assignment options will be loaded here -->
                                        </div>

                                        <div class="action-bar">
                                            <button class="btn btn-success" onclick="saveVoucherAssignments()">💾 Save Assignments</button>
                                            <button class="btn btn-secondary" onclick="resetAssignments()">🔄 Reset</button>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- PREVIEW TERMS -->
                                {{-- <div id="preview" class="section">
                                    <div class="page-header">
                                        <h1>👁️ Preview Customer Terms</h1>
                                        <p>See exactly how the terms will appear to your customers</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="previewVoucherSelect">Select Voucher Type to Preview</label>
                                        <select id="previewVoucherSelect" onchange="generateCustomerPreview()">
                                            <option value="">-- Select Voucher Type --</option>
                                            <option value="in-store">In-Store Voucher</option>
                                            <option value="online">Online Voucher</option>
                                            <option value="service">Service Voucher</option>
                                            <option value="gift">Gift Voucher</option>
                                        </select>
                                    </div>

                                    <div id="customerPreview">
                                        <!-- Customer preview will be generated here -->
                                    </div>
                                </div> --}}
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
        // Deep data storage with comprehensive condition structure
        let deepConditions = [
            {
                id: 1,
                title: 'Weekend Premium Experience',
                description: 'Premium weekend dining with advance booking requirement and group minimum',
                config: {
                    days: ['saturday', 'sunday'],
                    timeStart: '18:00',
                    timeEnd: '23:00',
                    dateStart: '2025-01-01',
                    dateEnd: '2025-12-31',
                    holidays: {
                        excludeNational: true,
                        excludeRamadan: true,
                        occasions: ['valentines']
                    },
                    usage: {
                        limit: 2,
                        period: 'monthly',
                        minPurchase: 150.00,
                        advanceBooking: 24,
                        groupSize: '4+'
                    },
                    location: {
                        venues: ['dine-in'],
                        branches: 'Downtown location only',
                        cityRestriction: 'Nablus city center'
                    },
                    customer: {
                        type: 'member',
                        ageRestriction: '21+',
                        membershipDuration: '3months'
                    },
                    restrictions: {
                        policies: ['non-refundable', 'prior-reservation', 'id-required'],
                        cancellationPolicy: '48hours',
                        excludedItems: 'Alcohol, special occasion cakes',
                        surchargeAmount: 15.00,
                        surchargeCondition: 'Window seating or private room'
                    }
                },
                createdDate: '2025-01-15',
                status: 'active'
            },
            {
                id: 2,
                title: 'Lunch Hour Special',
                description: 'Weekday lunch hour promotion for quick dining',
                config: {
                    days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    timeStart: '11:30',
                    timeEnd: '14:00',
                    usage: {
                        limit: 1,
                        period: 'daily',
                        minPurchase: 25.00
                    },
                    location: {
                        venues: ['dine-in', 'takeaway']
                    },
                    restrictions: {
                        policies: ['no-combination']
                    }
                },
                createdDate: '2025-01-14',
                status: 'active'
            }
        ];

        let voucherAssignments = {
            'in-store': [1, 2],
            'online': [2],
            'service': [1],
            'gift': [1]
        };

        let nextConditionId = 3;

        // Navigation - Fixed function name
        function switchSection(sectionName, clickedElement) {
            console.log('Switching to section:', sectionName);

            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });

            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(sectionName).classList.add('active');

            if (clickedElement) {
                clickedElement.classList.add('active');
            }

            if (sectionName === 'manage') {
                loadConditionsGrid();
            }
        }

        // Enhanced checkbox interaction
        document.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                const checkboxItem = e.target.closest('.checkbox-item');
                if (checkboxItem) {
                    if (e.target.checked) {
                        checkboxItem.classList.add('selected');
                    } else {
                        checkboxItem.classList.remove('selected');
                    }
                }
            }
        });

        // Create deep condition
        function createDeepCondition() {
            console.log('Creating deep condition...');

            const title = document.getElementById('conditionTitle').value.trim();
            const description = document.getElementById('conditionDescription').value.trim();

            if (!title || !description) {
                alert('Please enter both title and description');
                return;
            }

            // Collect all form data
            const config = {
                // Days and time
                days: Array.from(document.querySelectorAll('#daysCheckboxes input:checked')).map(cb => cb.value),
                timeStart: document.getElementById('timeStart').value,
                timeEnd: document.getElementById('timeEnd').value,
                dateStart: document.getElementById('dateStart').value,
                dateEnd: document.getElementById('dateEnd').value,

                // Holidays
                holidays: {
                    excludeNational: document.getElementById('exclude-national').checked,
                    excludeReligious: document.getElementById('exclude-religious').checked,
                    excludeRamadan: document.getElementById('exclude-ramadan').checked,
                    excludeChristmas: document.getElementById('exclude-christmas').checked,
                    excludeNewYear: document.getElementById('exclude-newyear').checked,
                    excludeEid: document.getElementById('exclude-eid').checked,
                    customHolidays: document.getElementById('customHolidays').value,
                    occasions: Array.from(document.querySelectorAll('[id^="valentines"], [id^="mothers-day"], [id^="fathers-day"], [id^="graduation"], [id^="back-to-school"], [id^="black-friday"]')).filter(cb => cb.checked).map(cb => cb.value)
                },

                // Usage and limits
                usage: {
                    limit: parseInt(document.getElementById('usageLimit').value) || null,
                    period: document.getElementById('usagePeriod').value,
                    minPurchase: parseFloat(document.getElementById('minPurchase').value) || 0,
                    maxDiscount: parseFloat(document.getElementById('maxDiscount').value) || null,
                    advanceBooking: parseInt(document.getElementById('advanceBooking').value) || 0,
                    groupSize: document.getElementById('groupSize').value
                },

                // Location
                location: {
                    venues: Array.from(document.querySelectorAll('[id^="venue-"]')).filter(cb => cb.checked).map(cb => cb.value),
                    branches: document.getElementById('specificBranches').value,
                    cityRestriction: document.getElementById('cityRestriction').value,
                    deliveryRadius: parseInt(document.getElementById('deliveryRadius').value) || null
                },

                // Customer
                customer: {
                    type: document.getElementById('customerType').value,
                    ageRestriction: document.getElementById('ageRestriction').value,
                    membershipDuration: document.getElementById('membershipDuration').value
                },

                // Restrictions
                restrictions: {
                    policies: Array.from(document.querySelectorAll('[id^="non-"], [id^="no-"], [id^="prior-"], [id^="id-"]')).filter(cb => cb.checked).map(cb => cb.value),
                    cancellationPolicy: document.getElementById('cancellationPolicy').value,
                    excludedItems: document.getElementById('excludedItems').value,
                    surchargeAmount: parseFloat(document.getElementById('surchargeAmount').value) || 0,
                    surchargeCondition: document.getElementById('surchargeCondition').value
                }
            };

            const newCondition = {
                id: nextConditionId++,
                title: title,
                description: description,
                config: config,
                createdDate: new Date().toISOString().split('T')[0],
                status: 'active'
            };

            deepConditions.push(newCondition);

            alert('🎉 Deep condition created successfully!\n\nYou can now assign it to voucher types.');

            resetConditionForm();
        }

        // Preview condition
        function previewCondition() {
            const title = document.getElementById('conditionTitle').value.trim();
            const description = document.getElementById('conditionDescription').value.trim();

            if (!title) {
                alert('Please enter a condition title first');
                return;
            }

            let preview = `📋 CONDITION PREVIEW\n`;
            preview += `═══════════════════\n\n`;
            preview += `🏷️ Title: ${title}\n`;
            preview += `📝 Description: ${description}\n\n`;

            // Days
            const selectedDays = Array.from(document.querySelectorAll('#daysCheckboxes input:checked')).map(cb => cb.value);
            if (selectedDays.length > 0) {
                preview += `📅 Available Days: ${selectedDays.join(', ')}\n`;
            }

            // Time
            const timeStart = document.getElementById('timeStart').value;
            const timeEnd = document.getElementById('timeEnd').value;
            if (timeStart && timeEnd) {
                preview += `⏰ Time: ${timeStart} - ${timeEnd}\n`;
            }

            // Usage limit
            const usageLimit = document.getElementById('usageLimit').value;
            if (usageLimit) {
                preview += `🎯 Usage Limit: ${usageLimit} times per ${document.getElementById('usagePeriod').value}\n`;
            }

            // Min purchase
            const minPurchase = document.getElementById('minPurchase').value;
            if (minPurchase) {
                preview += `💰 Minimum Purchase: ${minPurchase}\n`;
            }

            // Venues
            const selectedVenues = Array.from(document.querySelectorAll('[id^="venue-"]')).filter(cb => cb.checked).map(cb => cb.value);
            if (selectedVenues.length > 0) {
                preview += `🏪 Venues: ${selectedVenues.join(', ')}\n`;
            }

            // Customer type
            const customerType = document.getElementById('customerType').value;
            if (customerType) {
                preview += `👥 Customer Type: ${customerType}\n`;
            }

            preview += `\n✨ This is how your condition will work!`;

            alert(preview);
        }

        // Reset form
        function resetConditionForm() {
            document.querySelectorAll('input, textarea, select').forEach(input => {
                if (input.type === 'checkbox') {
                    input.checked = false;
                } else {
                    input.value = '';
                }
            });

            document.querySelectorAll('.checkbox-item.selected').forEach(item => {
                item.classList.remove('selected');
            });
        }

        // Load conditions grid
        function loadConditionsGrid() {
            const grid = document.getElementById('conditionsGrid');
            grid.innerHTML = '';

            deepConditions.forEach(condition => {
                const conditionCard = document.createElement('div');
                conditionCard.className = 'condition-card';

                // Build summary of key features
                let keyFeatures = [];
                if (condition.config.days && condition.config.days.length > 0) {
                    keyFeatures.push(`Days: ${condition.config.days.join(', ')}`);
                }
                if (condition.config.timeStart && condition.config.timeEnd) {
                    keyFeatures.push(`Time: ${condition.config.timeStart}-${condition.config.timeEnd}`);
                }
                if (condition.config.usage && condition.config.usage.limit) {
                    keyFeatures.push(`Limit: ${condition.config.usage.limit}/${condition.config.usage.period}`);
                }
                if (condition.config.usage && condition.config.usage.minPurchase) {
                    keyFeatures.push(`Min: ${condition.config.usage.minPurchase}`);
                }

                conditionCard.innerHTML = `
                    <div class="condition-header">
                        <div>
                            <div class="condition-title">${condition.title}</div>
                            <div class="condition-description">${condition.description}</div>
                        </div>
                    </div>

                    <div class="condition-details">
                        ${keyFeatures.map(feature => `
                            <div class="condition-detail-item">
                                <span class="detail-label">${feature.split(':')[0]}:</span>
                                <span class="detail-value">${feature.split(':')[1]}</span>
                            </div>
                        `).join('')}
                        <div class="condition-detail-item">
                            <span class="detail-label">Created:</span>
                            <span class="detail-value">${condition.createdDate}</span>
                        </div>
                        <div class="condition-detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value" style="color: #28a745;">●  ${condition.status}</span>
                        </div>
                    </div>

                    <div class="condition-actions">
                        <button class="btn" onclick="editCondition(${condition.id})">✏️ Edit</button>
                        <button class="btn btn-danger" onclick="deleteCondition(${condition.id})">🗑️ Delete</button>
                    </div>
                `;

                grid.appendChild(conditionCard);
            });
        }

        // Edit condition (placeholder)
        function editCondition(id) {
            alert(`Edit condition ${id} - Feature coming soon!`);
        }

        // Delete condition
        function deleteCondition(id) {
            if (confirm('Are you sure you want to delete this condition?')) {
                deepConditions = deepConditions.filter(c => c.id !== id);
                loadConditionsGrid();
                alert('Condition deleted successfully!');
            }
        }

        // Load voucher assignments
        function loadVoucherAssignments() {
            const voucherType = document.getElementById('voucherTypeSelect').value;
            if (!voucherType) {
                document.getElementById('assignmentContainer').style.display = 'none';
                return;
            }

            document.getElementById('assignmentContainer').style.display = 'block';
            const grid = document.getElementById('assignmentGrid');
            grid.innerHTML = '';

            const assignedIds = voucherAssignments[voucherType] || [];

            deepConditions.forEach(condition => {
                const isAssigned = assignedIds.includes(condition.id);

                const conditionCard = document.createElement('div');
                conditionCard.className = `condition-card ${isAssigned ? 'selected' : ''}`;
                conditionCard.style.cursor = 'pointer';
                conditionCard.onclick = () => toggleAssignment(condition.id, voucherType, conditionCard);

                conditionCard.innerHTML = `
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <input type="checkbox" ${isAssigned ? 'checked' : ''} style="margin-right: 15px; transform: scale(1.5);" onclick="event.stopPropagation();">
                        <div>
                            <div class="condition-title">${condition.title}</div>
                            <div class="condition-description">${condition.description}</div>
                        </div>
                    </div>
                `;

                grid.appendChild(conditionCard);
            });
        }

        // Toggle assignment
        function toggleAssignment(conditionId, voucherType, cardElement) {
            const checkbox = cardElement.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;

            if (checkbox.checked) {
                cardElement.classList.add('selected');
            } else {
                cardElement.classList.remove('selected');
            }
        }

        // Save voucher assignments
        function saveVoucherAssignments() {
            const voucherType = document.getElementById('voucherTypeSelect').value;
            const checkboxes = document.querySelectorAll('#assignmentGrid input[type="checkbox"]:checked');

            const selectedIds = [];
            checkboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    selectedIds.push(deepConditions[index].id);
                }
            });

            voucherAssignments[voucherType] = selectedIds;
            alert(`✅ Assignments saved for ${voucherType} voucher!\n${selectedIds.length} conditions assigned.`);
        }

        // Reset assignments
        function resetAssignments() {
            const voucherType = document.getElementById('voucherTypeSelect').value;
            if (voucherType && confirm('Reset all assignments for this voucher type?')) {
                voucherAssignments[voucherType] = [];
                loadVoucherAssignments();
            }
        }

        // Generate customer preview
        function generateCustomerPreview() {
            const voucherType = document.getElementById('previewVoucherSelect').value;
            const container = document.getElementById('customerPreview');

            if (!voucherType) {
                container.innerHTML = '';
                return;
            }

            const assignedIds = voucherAssignments[voucherType] || [];
            const assignedConditions = deepConditions.filter(c => assignedIds.includes(c.id));

            if (assignedConditions.length === 0) {
                container.innerHTML = `
                    <div class="preview-container">
                        <div class="preview-title">No conditions assigned</div>
                        <p style="text-align: center; color: #666;">Go to "Assign to Vouchers" to add conditions to this voucher type.</p>
                    </div>
                `;
                return;
            }

            let previewHtml = `
                <div class="preview-container">
                    <div class="preview-title">📋 Usage Terms & Conditions</div>
                    <div class="preview-terms">
                        <h3 style="color: #2c5f5f; margin-bottom: 20px; text-align: center;">
                            ${voucherType.charAt(0).toUpperCase() + voucherType.slice(1)} Voucher Terms
                        </h3>
            `;

            assignedConditions.forEach(condition => {
                previewHtml += `<div class="preview-section">`;
                previewHtml += `<h4>🎯 ${condition.title}</h4>`;
                previewHtml += `<ul>`;

                // Add relevant terms based on condition config
                if (condition.config.days && condition.config.days.length > 0) {
                    previewHtml += `<li>Available on: ${condition.config.days.join(', ')}</li>`;
                }

                if (condition.config.timeStart && condition.config.timeEnd) {
                    previewHtml += `<li>Time: ${condition.config.timeStart} - ${condition.config.timeEnd}</li>`;
                }

                if (condition.config.usage && condition.config.usage.limit) {
                    previewHtml += `<li>Usage limit: ${condition.config.usage.limit} times per ${condition.config.usage.period}</li>`;
                }

                if (condition.config.usage && condition.config.usage.minPurchase) {
                    previewHtml += `<li>Minimum purchase: ${condition.config.usage.minPurchase}</li>`;
                }

                if (condition.config.location && condition.config.location.venues) {
                    previewHtml += `<li>Available for: ${condition.config.location.venues.join(', ')}</li>`;
                }

                if (condition.config.customer && condition.config.customer.type) {
                    previewHtml += `<li>Customer requirement: ${condition.config.customer.type}</li>`;
                }

                if (condition.config.restrictions && condition.config.restrictions.policies) {
                    condition.config.restrictions.policies.forEach(policy => {
                        const policyText = policy.replace('-', ' ').replace('_', ' ');
                        previewHtml += `<li>${policyText}</li>`;
                    });
                }

                previewHtml += `</ul>`;
                previewHtml += `</div>`;
            });

            previewHtml += `
                    </div>
                </div>
            `;

            container.innerHTML = previewHtml;
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Deep Conditions Manager initialized');
            loadConditionsGrid();
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
