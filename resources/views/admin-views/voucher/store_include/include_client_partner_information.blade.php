 <!-- Client Information one-->
    <div class="section-card rounded p-4 mb-4  " id="basic_info_main">
        <h3 class="h5 fw-semibold mb-4"> Client Information</h3>
        <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label class="input-label" for="select_client">{{ translate('Client  Name') }}
                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Client  Name') }}"></span>
                    </label>
                    <select name="select_client[]" id="select_client" required class="form-control js-select2-custom Clients_select_new" data-placeholder="{{ translate('Select Client') }}" multiple>
                        @foreach (\App\Models\Client::all() as $item)
                        <option value="{{ $item->id }}" @if(collect(old('type', []))->contains($item->id)) selected @endif>
                                {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="input-label"
                        for="default_name">{{ translate('Client App Name') }}
                    </label>
                    <input type="text" name="name" id="default_name"  class="form-control" placeholder="{{ translate('Client App Name') }}" >
                </div>
            </div>

        </div>
        <div class="form-group">
            <label class="input-label" for="segment_type">{{ translate('Segment') }}
                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Segment') }}"></span>
            </label>
            <select name="segment_type[]" id="segment_type" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Segment') }}" multiple>
            </select>
        </div>
    </div>
    <!-- Partner Information one-->
    <div class="section-card rounded p-4 mb-4  " id="store_category_main">
        <h3 class="h5 fw-semibold mb-4"> {{ translate('Partner Information') }}</h3>
        {{-- Store & Category Info --}}
        <div class="col-md-12">
            <div class="row g-2 align-items-end">
                <div class="col-sm-6 col-lg-4">
                    <div class="form-group mb-0">
                        <label class="input-label" for="store_id">
                            {{ translate('messages.store') }}
                            <span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="{{ translate('messages.Required.') }}"> *
                            </span>
                        </label>
                        <select name="store_id" id="store_id"
                            data-placeholder="{{ translate('messages.select_store') }}"
                            class="js-data-example-ajax form-control"
                            onchange="findBranch(this.value)">
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="categories">{{ translate('messages.category') }}<span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="{{ translate('messages.Required.')}}"> *
                            </span></label>
                        <select name="categories[]" id="categories" onchange="multiples_category()" data-placeholder="{{ translate('messages.select_category') }}"
                            class="js-data-example-ajax form-control js-select2-category" multiple>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="form-group mb-0">
                        <label class="input-label"  for="sub_categories_game">{{ translate('messages.sub_category') }}</label>
                        <select name="sub_categories_game[]" onchange="multples_sub_category()" class=" form-control js-select2-sub_category" data-placeholder="{{ translate('messages.select_sub_category') }}"
                            id="sub_categories_game" multiple>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group mb-0">
                        <label class="input-label" for="sub_branch_id">{{ translate('Branches') }}<span class="form-label-secondary" data-toggle="tooltip"data-placement="right" data-original-title="{{ translate('Branches') }}"></span> </label>
                        <select name="sub_branch_id[]" id="sub-branch" required class="form-control js-select2-custom" data-placeholder="{{ translate('Select Branches') }}" multiple>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>


 <script>
    function multiples_category() {
        var category_ids_all = $('#categories').val();

        console.log("Selected category IDs:", category_ids_all);

        if (!category_ids_all || category_ids_all.length === 0) {
            alert("Please select at least one category!");
            return;
        }

        $.ajax({
            url: "{{ route('admin.Voucher.getSubcategories') }}",
            type: "GET",
            data: { category_ids_all: category_ids_all },
            traditional: false, // ✅ array bhejne ke liye sahi setting
            dataType: "json",
            success: function(response) {
                console.log("Subcategories Response:", response);

                if (!Array.isArray(response) || response.length === 0) {
                    $('#sub_categories_game').html('<option disabled>No subcategories found</option>');
                    return;
                }

                // Build option list dynamically
                let options = '';
                response.forEach(function(item) {
                    options += `<option value="${item.id}">
                                    ${item.name}
                                </option>`;
                });

                // Put options in the select box
                $('#sub_categories_game').html(options);

                // Agar Select2 use ho raha hai to refresh karna zaroori hai
                $('#sub_categories_game').trigger('change');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    function multiples_category_by_store_id() {
        var store_id = $('#store_id').val();

        console.log("Selected Store IDs:", store_id);

        if (!store_id || store_id.length === 0) {
            alert("Please select at least one Store!");
            return;
        }

        $.ajax({
            url: "{{ route('admin.Voucher.getCategoty') }}",
            type: "GET",
            data: { store_id: store_id },
            traditional: false, // ✅ array bhejne ke liye sahi setting
            dataType: "json",
            success: function(response) {
                console.log("Categoy Response:", response);

                if (!Array.isArray(response) || response.length === 0) {
                    $('#sub_categories_game').html('<option disabled>No Categoy found</option>');
                    return;
                }

                // Build option list dynamically
                let options = '';
                response.forEach(function(item) {
                    options += `<option value="${item.id}">
                                    ${item.name}
                                </option>`;
                });

                // Put options in the select box
                $('#sub_categories_game').html(options);

                // Agar Select2 use ho raha hai to refresh karna zaroori hai
                $('#sub_categories_game').trigger('change');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

</script>
