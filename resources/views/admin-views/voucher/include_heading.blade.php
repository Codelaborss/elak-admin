<div class="page-header d-flex flex-wrap __gap-15px justify-content-between align-items-center">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{ asset('public/assets/admin/img/items.png') }}" class="w--22" alt="">
            </span>
            <span>
                {{ translate('messages.add_new_item') }}
            </span>
        </h1>
        <div class=" d-flex flex-sm-nowrap flex-wrap  align-items-end">
            <div class="text--primary-2 d-flex flex-wrap align-items-center mr-2">
                <a href="{{ route('admin.Voucher.product_gallery') }}" class="btn btn-outline-primary btn--primary d-flex align-items-center bg-not-hover-primary-ash rounded-8 gap-2">
                    <img src="{{ asset('public/assets/admin/img/product-gallery.png') }}" class="w--22" alt="">
                    <span>{{translate('Add Info From Gallery')}}</span>
                </a>
            </div>

            @if(Config::get('module.current_module_type') == 'food')
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center mb-3 foodModalShow"  type="button" >
                <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
            @else
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center mb-3 attributeModalShow" type="button" >
                <strong class="mr-2">{{translate('See_how_it_works!')}}</strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
            @endif
        </div>
    </div>
