    <div class=" h-100">
        <div class=" d-flex flex-wrap align-items-center">
            <div class="w-100 d-flex flex-wrap __gap-15px">
                <div class="flex-grow-1 mx-auto">
                    <label class="text-dark d-block mb-4 mb-xl-5">
                        {{ translate('messages.item_image') }}
                        <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                    </label>
                    <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba"></div>
                </div>
                <div class="flex-grow-1 mx-auto">
                    <label class="text-dark d-block mb-4 mb-xl-5">
                        {{ translate('messages.item_thumbnail') }}
                        @if(Config::get('module.current_module_type') == 'food')
                        <small class="">( {{ translate('messages.ratio') }} 1:1 )</small>
                        @else
                        <small class="text-danger">* ( {{ translate('messages.ratio') }} 1:1 )</small>
                        @endif
                    </label>
                    <label class="d-inline-block m-0 position-relative">
                        <img class="img--176 border" id="viewer" src="{{ asset('public/assets/admin/img/upload-img.png') }}" alt="thumbnail" />
                        <div class="icon-file-group">
                            <div class="icon-file"><input type="file" name="image" id="customFileEg1" class="custom-file-input d-none" accept=".webp, .jpg, .png, .webp, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <i class="tio-edit"></i>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
