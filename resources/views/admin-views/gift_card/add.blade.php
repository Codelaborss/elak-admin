@extends('layouts.admin.app')

@section('title',"VoucherType List")

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

        .section {
            display: none;
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

        .preview-card {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            margin: 5px;
            padding: 5px;
            text-align: center;
            width: 150px;
            display: inline-block;
        }

        .preview-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 8px;
            background: rgba(255,0,0,0.8);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
        }

        .remove-btn:hover {
            background: rgba(255,0,0,1);
        }

        /* Hide the actual file inputs that will be created dynamically */
        .dynamic-file-input {
            display: none;
        }
    </style>

    <div class="content container-fluid">
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))

        <div class="row g-3">
            <div class="col-12">
                <form action="{{route('admin.Giftcard.store')}}" method="post" enctype="multipart/form-data" id="occasionForm">
                    @csrf
                    @if ($language)
                        <div class="main-content">
                            <!-- CREATE NEW OCCASION -->
                            <div id="create-occasion" class="section active">
                                <div class="page-header">
                                    <h1>Create New Occasion</h1>
                                    <p>Add a new occasion type with gallery for gift card customization</p>
                                </div>

                                <div class="form-section">
                                    <div class="section-title">Basic Information</div>

                                    <div class="form-group">
                                        <label for="occasionName">Occasion Name</label>
                                        <input type="text" id="occasionName" name="occasion_name" placeholder="e.g., Birthday, Anniversary, Wedding" required>
                                    </div>

                                    <div class="form-row">
                                        {{-- <div class="form-group">
                                            <label for="occasionCategory">Business Category</label>
                                            <select id="occasionCategory" class="form-control" name="business_category" required>
                                                <option value="">Select Category</option>
                                                @foreach ($category as $item)
                                                <option value="{{ $item->id}}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>
                                        </div> --}}
                                        <div class="select-item">
                                             <label for="occasionPriority">Display Priority</label>
                                            <select name="display_priority" class="form-control  set-filter"
                                                     data-filter="occasionPriority">
                                                 <option value="">Select Priority</option>
                                                <option value="1">1 - Highest Priority</option>
                                                <option value="2">2 - High Priority</option>
                                                <option value="3">3 - Medium Priority</option>
                                                <option value="4">4 - Low Priority</option>
                                                <option value="5">5 - Lowest Priority</option>
                                            </select>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="occasionPriority">Display Priority</label>
                                            <select id="occasionPriority" name="display_priority" required>
                                                <option value="">Select Priority</option>
                                                <option value="1">1 - Highest Priority</option>
                                                <option value="2">2 - High Priority</option>
                                                <option value="3">3 - Medium Priority</option>
                                                <option value="4">4 - Low Priority</option>
                                                <option value="5">5 - Lowest Priority</option>
                                            </select>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-title">Occasion Gallery</div>

                                    <div class="file-upload" onclick="document.getElementById('galleryFiles').click()">
                                        <input type="file" id="galleryFiles" style="display: none;" accept=".jpg,.jpeg,.png" multiple>
                                        <div style="font-size: 48px; margin-bottom: 15px;">🖼️</div>
                                        <div>Click to upload gallery images or drag and drop</div>
                                        <div style="font-size: 13px; color: #999; margin-top: 10px;">
                                            Supported: JPG, PNG (Multiple files allowed)
                                        </div>
                                    </div>

                                    <!-- Preview Area -->
                                    <div class="gallery-preview" id="galleryPreview">
                                        <div class="col-12 text-muted text-center" id="previewContainer">
                                            <!-- Previews will appear here -->
                                        </div>
                                    </div>

                                    <!-- Container for dynamic file inputs -->
                                    <div id="dynamicInputsContainer"></div>
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
    {{-- <script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script> --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{asset('public/assets/admin')}}/js/view-pages/product-index.js"></script>

    <script>
    $(document).on('click', '.js-select2-custom', function () {
            $('.js-select2-custom').removeClass('selected');
            $(this).addClass('selected');
        });

</script>
    <script>
        let selectedFiles = [];
        let fileCounter = 0;

        document.getElementById("galleryFiles").addEventListener("change", function (event) {
            const files = Array.from(event.target.files);

            files.forEach(file => {
                if (!file.type.startsWith("image/")) return;

                const fileId = 'file_' + fileCounter++;
                selectedFiles.push({
                    id: fileId,
                    file: file
                });

                // Create preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    const previewCard = document.createElement("div");
                    previewCard.className = "preview-card";
                    previewCard.setAttribute('data-file-id', fileId);

                    previewCard.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-btn">&times;</button>
                    `;

                    previewCard.querySelector(".remove-btn").addEventListener("click", function () {
                        removeFile(fileId);
                    });

                    document.getElementById("previewContainer").appendChild(previewCard);
                };

                reader.readAsDataURL(file);

                // Create actual hidden file input for this file
                createFileInput(file, fileId);
            });

            // Clear the main input
            event.target.value = "";
        });

        function createFileInput(file, fileId) {
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'occasion_gallery[]';
            input.className = 'dynamic-file-input';
            input.setAttribute('data-file-id', fileId);

            // Create a new FileList with just this file
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;

            document.getElementById('dynamicInputsContainer').appendChild(input);
        }

        function removeFile(fileId) {
            // Remove from selectedFiles array
            selectedFiles = selectedFiles.filter(item => item.id !== fileId);

            // Remove preview card
            const previewCard = document.querySelector(`[data-file-id="${fileId}"]`);
            if (previewCard) {
                previewCard.remove();
            }

            // Remove the corresponding hidden input
            const hiddenInput = document.querySelector(`input.dynamic-file-input[data-file-id="${fileId}"]`);
            if (hiddenInput) {
                hiddenInput.remove();
            }
        }

        // Reset button functionality
        document.getElementById('resetBtn').addEventListener('click', function(e) {
            e.preventDefault();

            // Clear all data
            selectedFiles = [];
            fileCounter = 0;

            // Clear previews
            document.getElementById("previewContainer").innerHTML = '';

            // Clear dynamic inputs
            document.getElementById('dynamicInputsContainer').innerHTML = '';

            // Clear main input
            document.getElementById("galleryFiles").value = '';

            // Reset form
            document.getElementById('occasionForm').reset();
        });

        // Form validation before submit
        document.getElementById('occasionForm').addEventListener('submit', function(e) {
            const occasionName = document.getElementById('occasionName').value.trim();
            const businessCategory = document.getElementById('occasionCategory').value;
            const displayPriority = document.getElementById('occasionPriority').value;

            if (!occasionName) {
                alert('Please enter occasion name');
                e.preventDefault();
                return false;
            }

            if (!businessCategory) {
                alert('Please select business category');
                e.preventDefault();
                return false;
            }

            if (!displayPriority) {
                alert('Please select display priority');
                e.preventDefault();
                return false;
            }

            if (selectedFiles.length === 0) {
                alert('Please select at least one image for gallery');
                e.preventDefault();
                return false;
            }

            console.log('Submitting form with', selectedFiles.length, 'files');
            return true;
        });

        // Select2 initialization
        $(function () {
            $('#occasionCategory, #occasionPriority').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
        });
    </script>

@endpush
