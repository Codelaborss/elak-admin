@extends('layouts.admin.app')

@section('title',"Holiday & Occasion  List")

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet">

<style>
    .preview-panel {
        position: sticky;
        top: 20px;
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .preview-header {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }

    .preview-section {
        margin-bottom: 20px;
    }

    .preview-label {
        font-weight: 600;
        color: #007bff;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .preview-value {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        padding-left: 10px;
    }

    .preview-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #007bff;
        color: white;
        border-radius: 12px;
        font-size: 12px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .condition-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    .condition-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        cursor: pointer;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
    }

    .condition-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 16px;
        color: #333;
    }

    .active-badge {
        background: #007bff;
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .condition-body {
        padding-top: 15px;
    }

    .day-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .day-btn {
        padding: 8px 16px;
        border: 2px solid #ddd;
        background: white;
        color: #666;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }

    .day-btn.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }

    .holiday-checkbox {
        margin-bottom: 10px;
    }

    .holiday-checkbox input[type="checkbox"] {
        margin-right: 8px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .holiday-checkbox label {
        cursor: pointer;
        font-size: 14px;
        color: #333;
    }

    .usage-row {
        display: flex;
        gap: 15px;
        align-items: end;
        margin-bottom: 15px;
    }

    .usage-row .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    .times-label {
        padding: 8px 12px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #666;
        font-size: 14px;
    }
</style>


    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/condition.png')}}" class="w--26" alt="">
                </span>
                <span>
                   Add  Holiday & Occasion
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
    <form action="{{route('admin.HolidayandOccasion.store')}}" method="post" id="conditionsForm">
        @csrf
        <div class="row">
            <!-- LEFT SIDE - FORM -->
            <div class="col-lg-7">

                <!-- TIME CONDITIONS -->
                <div class="condition-card">
                    <div class="condition-header" data-bs-toggle="collapse" data-bs-target="#timeConditions">
                        <div class="condition-title">
                            <i class="tio-time" style="font-size: 20px;"></i>
                            <span>Time Conditions</span>
                            <span class="active-badge" id="timeActiveCount">0 Active</span>
                        </div>
                        <i class="tio-chevron-down"></i>
                    </div>
                    <div class="collapse show condition-body" id="timeConditions">

                        <!-- Validity Period -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="validityPeriod" name="validity_period">
                                <label class="custom-control-label" for="validityPeriod">Validity Period</label>
                            </div>
                        </div>

                        <div class="row validity-dates" style="display:none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="startDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="endDate">
                                </div>
                            </div>
                        </div>

                        <!-- Specific Days -->
                        <div class="form-group mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="specificDays" name="specific_days">
                                <label class="custom-control-label" for="specificDays">Specific Days of Week</label>
                            </div>
                        </div>

                        <div class="day-time-table" id="dayTimeTable" style="display:none;">
                            <table class="table table-bordered">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="width: 15%;">DAY</th>
                                        <th style="width: 35%;">START TIME</th>
                                        <th style="width: 35%;">END TIME</th>
                                        <th style="width: 15%;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-day="Monday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Monday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="monday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="monday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                    <tr data-day="Tuesday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Tuesday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="tuesday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="tuesday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                    <tr data-day="Wednesday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Wednesday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="wednesday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="wednesday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                    <tr data-day="Thursday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Thursday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="thursday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="thursday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                    <tr data-day="Friday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Friday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="friday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="friday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                    <tr data-day="Saturday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Saturday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="saturday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="saturday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                    <tr data-day="Sunday">
                                        <td style="vertical-align: middle; color: #666; font-weight: 500;">Sunday</td>
                                        <td>
                                            <input type="time" class="form-control start-time" name="sunday_start" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <input type="time" class="form-control end-time" name="sunday_end" placeholder="--:-- --">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-sm reset-day" style="width: 100%;">Reset</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Holidays & Occasions -->
                        <div class="form-group mt-4">
                            <label style="font-weight: 600;">🎄 Holidays & Occasions</label>
                            <p style="font-size: 13px; color: #666;">Holiday Restrictions</p>

                            <div class="holiday-checkbox">
                                <input type="checkbox" id="excludeNational" name="exclude_national" value="1">
                                <label for="excludeNational">Exclude National Holidays</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="excludeReligious" name="exclude_religious" value="1">
                                <label for="excludeReligious">Exclude Religious Holidays</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="excludeRamadan" name="exclude_ramadan" value="1">
                                <label for="excludeRamadan">Exclude Ramadan</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="excludeChristmas" name="exclude_christmas" value="1">
                                <label for="excludeChristmas">Exclude Christmas Period</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="excludeNewYear" name="exclude_newyear" value="1">
                                <label for="excludeNewYear">Exclude New Year</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="excludeEid" name="exclude_eid" value="1">
                                <label for="excludeEid">Exclude Eid Holidays</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GENERAL RESTRICTIONS -->
                <div class="condition-card">
                    <div class="condition-header" data-bs-toggle="collapse" data-bs-target="#generalRestrictions">
                        <div class="condition-title">
                            <i class="tio-shield-outlined" style="font-size: 20px;"></i>
                            <span>General Restrictions</span>
                            <span class="active-badge" id="restrictionActiveCount">0 Active</span>
                        </div>
                        <i class="tio-chevron-down"></i>
                    </div>
                    <div class="collapse show condition-body" id="generalRestrictions">

                        <!-- Age Restriction -->
                        <div class="form-group">
                            <label>Age Restriction</label>
                            <select class="form-control" name="age_restriction" id="ageRestriction">
                                <option value="">No Age Restriction</option>
                                <option value="18+">18+ Only</option>
                                <option value="21+">21+ Only</option>
                                <option value="under_18">Under 18 Only</option>
                            </select>
                        </div>

                        <!-- Group Size -->
                        <div class="form-group">
                            <label>Group Size Requirement</label>
                            <select class="form-control" name="group_size" id="groupSize">
                                <option value="">No requirement</option>
                                <option value="min_2">Minimum 2 people</option>
                                <option value="min_4">Minimum 4 people</option>
                                <option value="min_6">Minimum 6 people</option>
                                <option value="max_4">Maximum 4 people</option>
                            </select>
                        </div>

                        <!-- Usage Limit per User -->
                        <div class="form-group">
                            <label>Usage Limit per User</label>
                            <div class="usage-row">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="user_limit" id="userLimit" placeholder="Number of times" min="1">
                                </div>
                                <span class="times-label">times</span>
                                <div class="form-group">
                                    <select class="form-control" name="user_period" id="userPeriod">
                                        <option value="">Select period</option>
                                        <option value="per_day">Per Day</option>
                                        <option value="per_week">Per Week</option>
                                        <option value="per_month">Per Month</option>
                                        <option value="total">Total</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Usage Limit per Store -->
                        <div class="form-group">
                            <label>Usage Limit per Store</label>
                            <div class="usage-row">
                                <div class="form-group">
                                    <input type="number" class="form-control" name="store_limit" id="storeLimit" placeholder="Number of times" min="1">
                                </div>
                                <span class="times-label">times</span>
                                <div class="form-group">
                                    <select class="form-control" name="store_period" id="storePeriod">
                                        <option value="">Select period</option>
                                        <option value="per_day">Per Day</option>
                                        <option value="per_week">Per Week</option>
                                        <option value="per_month">Per Month</option>
                                        <option value="total">Total</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Offer Validity -->
                        <div class="form-group">
                            <label>Offer Validity After Purchase</label>
                            <select class="form-control" name="validity_after" id="validityAfter">
                                <option value="">No time limit</option>
                                <option value="1_month">1 Month</option>
                                <option value="3_months">3 Months</option>
                                <option value="6_months">6 Months</option>
                                <option value="1_year">1 Year</option>
                            </select>
                        </div>

                        <!-- General Restrictions Checkboxes -->
                        <div class="form-group">
                            <label style="font-weight: 600;">General Restrictions</label>

                            <div class="holiday-checkbox">
                                <input type="checkbox" id="noOtherOffers" name="no_other_offers" value="1">
                                <label for="noOtherOffers">Cannot be combined with other offers</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="noDiscountCodes" name="no_discount_codes" value="1">
                                <label for="noDiscountCodes">Cannot be combined with other discount codes</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="noCashback" name="no_cashback" value="1">
                                <label for="noCashback">Does not apply to cashback</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="noLoyalty" name="no_loyalty" value="1">
                                <label for="noLoyalty">Does not apply to loyalty points</label>
                            </div>
                            <div class="holiday-checkbox">
                                <input type="checkbox" id="requiresAccount" name="requires_account" value="1">
                                <label for="requiresAccount">Requires registered account</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE - PREVIEW -->
            <div class="col-lg-5">
                <div class="preview-panel">
                    <div class="preview-header">Active Conditions Preview</div>

                    <!-- Available On -->
                    <div class="preview-section" id="previewDays" style="display:none;">
                        <div class="preview-label">Available on:</div>
                        <div class="preview-value" id="previewDaysText">-</div>
                    </div>

                    <!-- Validity Period -->
                    <div class="preview-section" id="previewValidityPeriod" style="display:none;">
                        <div class="preview-label">Validity period:</div>
                        <div class="preview-value" id="previewValidityPeriodText">-</div>
                    </div>

                    <!-- Holiday Restrictions -->
                    <div class="preview-section" id="previewHolidays" style="display:none;">
                        <div class="preview-label">Holiday restrictions:</div>
                        <div class="preview-value" id="previewHolidaysText">-</div>
                    </div>

                    <!-- Age Restriction -->
                    <div class="preview-section" id="previewAge" style="display:none;">
                        <div class="preview-label">Age restriction:</div>
                        <div class="preview-value" id="previewAgeText">-</div>
                    </div>

                    <!-- Group Size -->
                    <div class="preview-section" id="previewGroup" style="display:none;">
                        <div class="preview-label">Group size required:</div>
                        <div class="preview-value" id="previewGroupText">-</div>
                    </div>

                    <!-- Validity -->
                    <div class="preview-section" id="previewValidity" style="display:none;">
                        <div class="preview-label">Validity after purchase:</div>
                        <div class="preview-value" id="previewValidityText">-</div>
                    </div>

                    <!-- Limit per User -->
                    <div class="preview-section" id="previewUserLimit" style="display:none;">
                        <div class="preview-label">Limit per user:</div>
                        <div class="preview-value" id="previewUserLimitText">-</div>
                    </div>

                    <!-- Limit per Store -->
                    <div class="preview-section" id="previewStoreLimit" style="display:none;">
                        <div class="preview-label">Limit per store:</div>
                        <div class="preview-value" id="previewStoreLimitText">-</div>
                    </div>

                    <!-- General Restrictions -->
                    <div class="preview-section" id="previewRestrictions" style="display:none;">
                        <div class="preview-label">General restrictions:</div>
                        <div class="preview-value" id="previewRestrictionsText">-</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


                    <div class="btn--container justify-content-end mt-5">
                        <button type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
                    </div>

            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>

 <script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

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
<script>
$(document).ready(function() {
    let selectedDays = [];

    // Format time to 12-hour format
    function formatTime(time24) {
        if (!time24) return '';
        let [hours, minutes] = time24.split(':');
        hours = parseInt(hours);
        let period = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        return `${hours}:${minutes} ${period}`;
    }

    // Update Preview Function
    function updatePreview() {
        let timeActive = 0;
        let restrictionActive = 0;

        // Days Preview with Times
        let daysWithTimes = [];
        let processedDays = []; // Track processed days to avoid duplicates

        $('tr[data-day]').each(function() {
            let day = $(this).data('day');
            let startTime = $(this).find('.start-time').val();
            let endTime = $(this).find('.end-time').val();

            // Only add if not already processed and has time values
            if (!processedDays.includes(day) && (startTime || endTime)) {
                let timeDisplay = '';
                if (startTime && endTime) {
                    timeDisplay = ` (${formatTime(startTime)} - ${formatTime(endTime)})`;
                } else if (startTime) {
                    timeDisplay = ` (from ${formatTime(startTime)})`;
                } else if (endTime) {
                    timeDisplay = ` (until ${formatTime(endTime)})`;
                }
                daysWithTimes.push(`<div style="margin-bottom: 5px;">${day}${timeDisplay}</div>`);
                processedDays.push(day);
            }
        });

        if (daysWithTimes.length > 0) {
            $('#previewDays').show();
            $('#previewDaysText').html(daysWithTimes.join(''));
            timeActive++;
        } else {
            $('#previewDays').hide();
        }

        // Update selected days array
        selectedDays = processedDays;

        // Holidays Preview
        let holidays = [];
        if ($('#excludeNewYear').is(':checked')) holidays.push('New Year');
        if ($('#excludeRamadan').is(':checked')) holidays.push('Ramadan');
        if ($('#excludeReligious').is(':checked')) holidays.push('Religious Holidays');
        if ($('#excludeNational').is(':checked')) holidays.push('National Holidays');
        if ($('#excludeChristmas').is(':checked')) holidays.push('Christmas Period');
        if ($('#excludeEid').is(':checked')) holidays.push('Eid Holidays');

        if (holidays.length > 0) {
            $('#previewHolidays').show();
            $('#previewHolidaysText').html(holidays.map(h => `<div style="margin-bottom: 5px;">${h}</div>`).join(''));
            timeActive++;
        } else {
            $('#previewHolidays').hide();
        }

        // Age Restriction Preview
        let ageRestriction = $('#ageRestriction').val();
        if (ageRestriction) {
            $('#previewAge').show();
            $('#previewAgeText').text($('#ageRestriction option:selected').text());
            restrictionActive++;
        } else {
            $('#previewAge').hide();
        }

        // Group Size
        let groupSize = $('#groupSize').val();
        if (groupSize) {
            $('#previewGroup').show();
            $('#previewGroupText').text($('#groupSize option:selected').text());
            restrictionActive++;
        } else {
            $('#previewGroup').hide();
        }

        // Validity
        let validity = $('#validityAfter').val();
        if (validity) {
            $('#previewValidity').show();
            $('#previewValidityText').text($('#validityAfter option:selected').text());
            restrictionActive++;
        } else {
            $('#previewValidity').hide();
        }

        // User Limit
        let userLimit = $('#userLimit').val();
        let userPeriod = $('#userPeriod').val();
        if (userLimit && userPeriod) {
            $('#previewUserLimit').show();
            $('#previewUserLimitText').text(userLimit + ' ' + $('#userPeriod option:selected').text());
            restrictionActive++;
        } else {
            $('#previewUserLimit').hide();
        }

        // Store Limit
        let storeLimit = $('#storeLimit').val();
        let storePeriod = $('#storePeriod').val();
        if (storeLimit && storePeriod) {
            $('#previewStoreLimit').show();
            $('#previewStoreLimitText').text(storeLimit + ' ' + $('#storePeriod option:selected').text());
            restrictionActive++;
        } else {
            $('#previewStoreLimit').hide();
        }

        // General Restrictions
        let restrictions = [];
        if ($('#noLoyalty').is(':checked')) restrictions.push('Does not apply to loyalty points');
        if ($('#requiresAccount').is(':checked')) restrictions.push('Requires registered account');
        if ($('#noCashback').is(':checked')) restrictions.push('Does not apply to cashback');
        if ($('#noOtherOffers').is(':checked')) restrictions.push('Cannot be combined with other offers');
        if ($('#noDiscountCodes').is(':checked')) restrictions.push('Cannot be combined with other discount codes');

        if (restrictions.length > 0) {
            $('#previewRestrictions').show();
            $('#previewRestrictionsText').html(restrictions.join(', '));
            restrictionActive++;
        } else {
            $('#previewRestrictions').hide();
        }

        // Update Active Counts
        $('#timeActiveCount').text(timeActive + ' Active');
        $('#restrictionActiveCount').text(restrictionActive + ' Active');
    }

    // Validity Period Toggle
    $('#validityPeriod').change(function() {
        $('.validity-dates').toggle(this.checked);
        updatePreview();
    });

    // Validity Period Dates Change
    $('#startDate, #endDate').change(function() {
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();

        if (startDate || endDate) {
            $('#previewValidityPeriod').show();
            let dateText = '';
            if (startDate && endDate) {
                dateText = `From ${formatDate(startDate)} to ${formatDate(endDate)}`;
            } else if (startDate) {
                dateText = `From ${formatDate(startDate)}`;
            } else if (endDate) {
                dateText = `Until ${formatDate(endDate)}`;
            }
            $('#previewValidityPeriodText').text(dateText);
        } else {
            $('#previewValidityPeriod').hide();
        }
        updatePreview();
    });

    // Format date function
    function formatDate(dateStr) {
        if (!dateStr) return '';
        let date = new Date(dateStr);
        let options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Specific Days Toggle
    $('#specificDays').change(function() {
        $('#dayTimeTable').toggle(this.checked);
        if (!this.checked) {
            selectedDays = [];
            $('.start-time, .end-time').val('');
        }
        updatePreview();
    });

    // Reset Individual Day
    $('.reset-day').click(function() {
        let row = $(this).closest('tr');
        row.find('.start-time, .end-time').val('');
        updatePreview();
    });

    // Time Input Changes
    $('.start-time, .end-time').on('change input', function() {
        updatePreview();
    });

    // All Change Events
    $('input[type="checkbox"], select, input[type="number"]').change(updatePreview);
    $('input[type="date"]').change(updatePreview);

    // Initial Preview
    updatePreview();
});
</script>
@endpush
