 {{-- How It Works --}}
<div class="section-card rounded p-4 mb-4 section3 two_four_complete" id="how_it_work_main">
    <h3 class="h5 fw-semibold mb-4"> {{ translate('How It Works') }}</h3>
    <p class="text-muted">Instructions for using your voucher</p>
    <div class="card ">
        <div class="card-body" id="workList">

        </div>
    </div>
</div>
{{--  Terms & Conditions --}}
<div class="section-card rounded p-4 mb-4  section3  " id="term_condition_main">
    <h3 class="h5 fw-semibold mb-2"> {{ translate('Terms & Conditions') }}</h3>
    <p class="text-muted">Set your business terms</p>
    <div class="card border shadow-sm mt-3">
        <div class="card-body">
            {{-- <h5 class="text-center font-weight-bold mb-4">Usage Terms</h5> --}}
            <div id="usageTerms" class="row">
            </div>
        </div>
    </div>
</div>

{{--  Review & Submit --}}
<div class="section-card rounded p-4 mb-4 section3 " id="review_submit_main">
    <h3 class="h5 fw-semibold mb-2"> {{ translate('Review & Submit') }}</h3>
    <p class="text-muted">Review your voucher before submitting</p>

    <div class="card border shadow-sm mt-3">
        <div class="card-body">
        <!-- MAIN REVIEW CONTENT (always visible) -->
        <div class="row">
            <div class="col-md-6 mb-4">
            <h5 class="font-weight-bold mb-3"> Client Information</h5>
            <p><strong>Client:</strong> Salvador Michael</p>
            <p><strong>App:</strong> Maxine Solis</p>
            <p><strong>Segment:</strong> Standard</p>
            </div>
            <div class="col-md-6 mb-4">
            <h5 class="font-weight-bold mb-3"> Partner Details</h5>
            <p><strong>Partner Name:</strong> Casey Hahn</p>
            <p><strong>Category:</strong> Desserts</p>
            <p><strong>Sub Category:</strong> Not set</p>
            <p><strong>Branches:</strong> Rem obcaecati sit s</p>
            </div>
            <div class="col-md-6 mb-4">
            <h5 class="font-weight-bold mb-3"> Voucher Info</h5>
            <p><strong>Title:</strong> Accusamus cum rerum</p>
            <p><strong>Thumbnail:</strong> https://www.kifatepy.me</p>
            <p><strong>Image:</strong> https://www.sunyqylufyxisy.org.uk</p>
            <p><strong>Food Add-ons:</strong> fdgdgfdg, dfjgbdf</p>
            <p><strong>Tags:</strong> jdhjfd, dfgbjfdg</p>
            </div>
            <div class="col-md-6 mb-4">
            <h5 class="font-weight-bold mb-3"> Pricing</h5>
            <p><strong>Price:</strong> $435</p>
            <p><strong>Discount:</strong> 30 $</p>
            <p><strong>Valid Until:</strong> 1999-09-13</p>
            <p><strong>Usage Limit:</strong> 20 per user</p>
            <p><strong>Max Purchase:</strong> 50</p>
            <p><strong>Stock:</strong> 795</p>
            <p><strong>Order Range:</strong> 31 - 100</p>
            <p><strong>Time Schedule:</strong> Sed eius distinctio</p>
            </div>
            <div class="col-md-6 mb-4">
            <h5 class="font-weight-bold mb-3"> How It Works</h5>
            <p><strong>Valid in Store Only:</strong> No</p>
            </div>
            <div class="col-md-6 mb-4">
            <h5 class="font-weight-bold mb-3"> Terms</h5>
            <p><strong>Non-refundable:</strong> No</p>
            <p><strong>Excludes Holidays:</strong> No</p>
            <p><strong>In-store Only:</strong> No</p>
            </div>
        </div>

        <div class="border-top pt-3 mt-3">
            <span class="badge badge-success"> Halal Certified</span>
        </div>

        <!-- Variations -->
        <div class="border-top pt-4 mt-4">
            <h5 class="font-weight-bold mb-3"> Variations (1)</h5>
            <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card border shadow-sm p-3">
                <p class="font-weight-medium mb-1">Cillum aut et minus</p>
                <p class="text-muted small mb-0">$31 • Stock: 31</p>
                </div>
            </div>
            </div>
        </div>

        <!-- TOGGLE BUTTON -->
        {{-- <div class="text-center mt-4">
            <button id="togglePreview" type="button" class="btn btn-secondary">
            Show Preview 👁️
            </button>
        </div> --}}

        <!-- PREVIEW BLOCK (hide/show only this) -->
        <div id="voucherPreview" class="card border-dashed mt-4 p-4" style="display: none;">
            <h5 class="font-weight-bold mb-3">Voucher Preview</h5>
            <div class="card bg-primary text-white p-4">
            <h3 class="mb-2">Accusamus cum rerum</h3>
            <p class="mb-3">Autem tenetur laboru</p>
            <div class="bg-white text-dark rounded p-3">
                <p class="h4 mb-0">$435</p>
                <small>Save 30$</small>
            </div>
            <div class="mt-3">
                <span class="badge badge-light">jdhjfd</span>
                <span class="badge badge-light">dfgbjfdg</span>
            </div>
            </div>
        </div>

        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="col-md-12">
    <div class="btn--container justify-content-end">
        <button type="reset" id="reset_btn"
            class="btn btn--reset">{{ translate('messages.reset') }}</button>
        <button type="submit" id="submitButton"  class="btn btn--primary">{{ translate('messages.submit') }}</button>
    </div>
</div>
