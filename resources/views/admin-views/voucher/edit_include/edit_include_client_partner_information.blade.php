<!-- Client Information -->
<div class="section-card rounded p-4 mb-4" id="basic_info_main">
    <h3 class="h5 fw-semibold mb-4">Client Information</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="input-label" for="default_name">
                    {{ translate('Client App Name') }}
                </label>
                <input type="text" name="name" value="{{ $product->name }}" id="default_name"
                       class="form-control" placeholder="{{ translate('Client App Name') }}">
            </div>
        </div>
        <div class="col-md-6">
            @php(
                $selectedClients = is_array($product->client_id)
                    ? $product->client_id
                    : json_decode($product->client_id, true)


            )
            @php(           $selectedSegments = is_array($product->segment_ids)
                    ? $product->segment_ids
                    : json_decode($product->segment_ids, true))

            <div class="form-group">
                <label class="input-label" for="select_client">
                    {{ translate('Client Name') }}
                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                        data-original-title="{{ translate('Client Name') }}"></span>
                </label>

                <select name="select_client[]" id="select_client" required
                        class="form-control js-select2-custom Clients_select_new"
                        data-placeholder="{{ translate('Select Client') }}" multiple>
                    @foreach (\App\Models\Client::all() as $item)
                        <option value="{{ $item->id }}"
                            @if(in_array($item->id, $selectedClients ?? [])) selected @endif>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="input-label" for="segment_type">
            {{ translate('Segment') }}
            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                  data-original-title="{{ translate('Segment') }}"></span>
        </label>
        <select name="segment_type[]" id="segment_type" required
                class="form-control js-select2-custom"
                data-placeholder="{{ translate('Select Segment') }}" multiple>
        </select>
    </div>
</div>

<!-- Partner Information -->
<div class="section-card rounded p-4 mb-4" id="store_category_main">
    <h3 class="h5 fw-semibold mb-4">{{ translate('Partner Information') }}</h3>

    <div class="col-md-12">
        <div class="row g-2 align-items-end">
            <div class="col-sm-6 col-lg-4">
                <div class="form-group mb-0">
                    <label class="input-label" for="store_id">
                        {{ translate('messages.store') }}
                        <span class="form-label-secondary text-danger" data-toggle="tooltip"
                              data-placement="right" data-original-title="{{ translate('messages.Required.') }}"> *
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
                    <label class="input-label" for="categories">
                        {{ translate('messages.category') }}
                        <span class="form-label-secondary text-danger" data-toggle="tooltip"
                              data-placement="right" data-original-title="{{ translate('messages.Required.')}}"> *
                        </span>
                    </label>
                    <select name="categories[]" id="categories"
                            onchange="multiples_category()"
                            data-placeholder="{{ translate('messages.select_category') }}"
                            class="js-data-example-ajax form-control js-select2-category" multiple>
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="form-group mb-0">
                    <label class="input-label" for="sub_categories_game">
                        {{ translate('messages.sub_category') }}
                    </label>
                    <select name="sub_categories_game[]"
                            onchange="multples_sub_category()"
                            class="form-control js-select2-sub_category"
                            data-placeholder="{{ translate('messages.select_sub_category') }}"
                            id="sub_categories_game" multiple>
                    </select>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group mb-0">
                    <label class="input-label" for="sub_branch_id">
                        {{ translate('Branches') }}
                        <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                              data-original-title="{{ translate('Branches') }}"></span>
                    </label>
                    <select name="sub_branch_id[]" id="sub-branch" required
                            class="form-control js-select2-custom"
                            data-placeholder="{{ translate('Select Branches') }}" multiple>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    console.log("Document ready - Script loaded!");

    // -------------------- Load Segments Function --------------------
    function loadClientSegments(clientIds, preselectedSegments = []) {
        if (!clientIds || clientIds.length === 0) {
            console.log("No client IDs provided");
            return;
        }

        console.log("Loading segments for client IDs:", clientIds);
        console.log("Preselected Segments:", preselectedSegments);

        let ids = Array.isArray(clientIds) ? clientIds.join(',') : clientIds;
        let url = "{{ route('admin.client-side.getSegments', ':id') }}".replace(':id', ids);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                console.log("Segments Response:", res);

                $('#segment_type').empty();
                $('#segment_type').append('<option value="">Select Segment</option>');

                if (Array.isArray(res) && res.length > 0) {
                    $.each(res, function(index, item) {
                        // Check if this segment should be selected
                        let isSelected = preselectedSegments.includes(item.id.toString()) ||
                                       preselectedSegments.includes(item.id);

                        let selectedAttr = isSelected ? 'selected' : '';

                        $('#segment_type').append(
                            '<option value="' + item.id + '" ' + selectedAttr + '>' +
                            item.name + ' / ' + item.type +
                            '</option>'
                        );
                    });
                } else {
                    $('#segment_type').append('<option value="">No segments found</option>');
                }

                // Refresh Select2
                $('#segment_type').trigger('change');
            },
            error: function(xhr, status, error) {
                console.error("Error loading segments:", error);
                console.error("XHR:", xhr);
            }
        });
    }

    // -------------------- Client Change Event --------------------
    $('.Clients_select_new').on('change', function() {
        let selectedClients = $(this).val();
        console.log("Selected Clients (on change):", selectedClients);
        loadClientSegments(selectedClients);
    });

    // -------------------- Load Preselected Segments on Page Load --------------------
    @if(!empty($selectedClients))
        let preselectedClients = {!! json_encode($selectedClients) !!};
        let preselectedSegments = {!! json_encode($selectedSegments ?? []) !!};

        console.log("Preselected Clients:", preselectedClients);
        console.log("Preselected Segments:", preselectedSegments);

        // Small delay to ensure Select2 is initialized
        setTimeout(function() {
            loadClientSegments(preselectedClients, preselectedSegments);
        }, 500);
    @endif
});

// -------------------- Multiple Category Function --------------------
function multiples_category() {
    var category_ids_all = $('#categories').val();
    console.log("Selected category IDs:", category_ids_all);

    if (!category_ids_all || category_ids_all.length === 0) {
        console.log("No categories selected");
        $('#sub_categories_game').html('<option value="">Select category first</option>');
        return;
    }

    $.ajax({
        url: "{{ route('admin.Voucher.getSubcategories') }}",
        type: "GET",
        data: { category_ids_all: category_ids_all },
        traditional: true,
        dataType: "json",
        success: function(response) {
            console.log("Subcategories Response:", response);

            $('#sub_categories_game').empty();

            if (!Array.isArray(response) || response.length === 0) {
                $('#sub_categories_game').html('<option value="">No subcategories found</option>');
                return;
            }

            let options = '<option value="">Select Subcategory</option>';
            response.forEach(function(item) {
                options += '<option value="' + item.id + '">' + item.name + '</option>';
            });

            $('#sub_categories_game').html(options);
            $('#sub_categories_game').trigger('change');
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            console.error("XHR:", xhr);
        }
    });
}

// -------------------- Multiple Category by Store ID --------------------
function multiples_category_by_store_id() {
    var store_id = $('#store_id').val();
    console.log("Selected Store ID:", store_id);

    if (!store_id) {
        console.log("No store selected");
        return;
    }

    $.ajax({
        url: "{{ route('admin.Voucher.getCategoty') }}",
        type: "GET",
        data: { store_id: store_id },
        dataType: "json",
        success: function(response) {
            console.log("Category Response:", response);

            $('#categories').empty();

            if (!Array.isArray(response) || response.length === 0) {
                $('#categories').html('<option value="">No categories found</option>');
                return;
            }

            let options = '<option value="">Select Category</option>';
            response.forEach(function(item) {
                options += '<option value="' + item.id + '">' + item.name + '</option>';
            });

            $('#categories').html(options);
            $('#categories').trigger('change');
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
            console.error("XHR:", xhr);
        }
    });
}
</script>
