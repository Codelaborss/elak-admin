<div id="btn-group" class="flex items-center gap-1 bg-muted p-1 rounded-lg shadow-inner">
    <button onclick="bundle('simple')" class="border rounded p-4 text-center btns selected" data-testid="button-form-product">
    <i class="fas fa-shopping-bag mr-2"></i> Simple
    </button>
    <button onclick="bundle('bundle')" class="border rounded p-4 text-center btns" data-testid="button-form-bundle">
    <i class="fas fa-box mr-2"></i> Bundle
    </button>
    <button onclick="bundle('Flat discount')" class="border rounded p-4 text-center btns" data-testid="button-form-bundle">
    <i class="fas fa-tags mr-2"></i> Flat discount
    </button>
    <button onclick="bundle('Gift')" class="border rounded p-4 text-center btns" data-testid="button-form-bundle">
    <i class="fas fa-gift mr-2"></i> Gift
    </button>
</div>
<!-- Step 1: Select Voucher Type -->
<div class="section-card rounded p-4 mb-4">
    <h2 class="fw-semibold h5 mb-4">
        <i class="fas fa-bullseye me-2"></i> Step 1: Select Voucher Type
    </h2>
    <div class="row g-3">
        @php $i = 1; @endphp
        @foreach (\App\Models\VoucherType::orderBy('name')->get() as $voucherType)
            <div class="col-md-3">
                <div class="voucher-card border rounded py-4 text-center h-70 "
                    onclick="section_one('{{ $i }}' , '{{ $voucherType->id }}', '{{ $voucherType->name }}')"
                    data-value="{{ $voucherType->name }}">
                    <div class="display-4 mb-2">
                        <img src="{{ asset($voucherType->logo) }}" alt="{{ $voucherType->name }}" style="width: 40px;" />
                    </div>

                    <h6 class="fw-semibold">{{ $voucherType->name }}</h6>
                    <small class="text-muted">{{ $voucherType->desc }}</small>
                </div>
            </div>
            @php $i++; @endphp
        @endforeach
    </div>
</div>
<!-- Step 2: Select Management Type -->
<div class="section-card rounded p-4 mb-4" id="management_selection">
    <h2 class="fw-semibold h5 mb-4">
        <i class="fas fa-cog me-2"></i> Step 2: Select Management Type
    </h2>
    <div class="row g-3" id="append_all_data"></div>
</div>
