@extends('layouts.admin.app')

@section('title',"Usage Term Edit")
@push('css_or_js')
@endpush

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
<style>
    /* Select2 Styling */
    .select2-results__option[aria-selected="true"] {
        background-color: #005555 !important;
        color: #fff !important;
    }

    .select2-results__option--highlighted[aria-selected] {
        background-color: #005555 !important;
        color: #fff !important;
    }

    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        background-color: #005555;
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

    .select2-container--bootstrap4 .select2-selection__choice__remove {
        margin-right: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: 46px;
        border: 1px solid #ced4da;
        border-radius: .5rem;
        padding: 4px;
    }

    .select2-results__options {
        max-height: 220px !important;
        overflow-y: auto !important;
    }

    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 6px 10px;
        width: 100% !important;
        outline: none;
    }

    /* General Form Styling */
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
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
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
        width: 150px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255,0,0,0.8);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        font-size: 14px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }

    .remove-btn:hover {
        background: rgba(255,0,0,1);
    }

    .dynamic-file-input {
        display: none;
    }

    .existing-image {
        border: 2px solid #28a745;
    }

    .new-image {
        border: 2px solid #007bff;
    }
</style>

<div class="content container-fluid">
    <form id="occasionForm" action="{{route('admin.Giftcard.update',[$ManagementType['id']])}}" method="post" enctype="multipart/form-data">
        @csrf
        @php($language = \App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($defaultLang = str_replace('_', '-', app()->getLocale()))
        @if ($language)
        <div class="main-content">
            <div id="create-occasion" class="section active">
                <div class="page-header">
                    <h1>Edit   Occasion</h1>
                    <p>Edit occasion type with gallery for gift card customization</p>
                </div>

                <div class="form-section">
                    <div class="section-title">Basic Information</div>
                    <div class="form-group">
                        <label for="occasionName">Occasion Name</label>
                        <input type="text" id="occasionName" value="{{ $ManagementType->occasion_name}}" name="occasion_name" placeholder="e.g., Birthday, Anniversary, Wedding" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="occasionCategory">Business Category</label>
                            <select id="occasionCategory" class="form-control" name="business_category" required>
                                <option value="">Select Category</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->id}}" {{ $ManagementType->business_category == $item->id ? "selected":"" }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occasionPriority">Display Priority</label>
                            <select id="occasionPriority" name="display_priority" required>
                                <option value="">Select Priority</option>
                                <option value="1" {{ $ManagementType->display_priority == "1" ? "selected":"" }}>1 - Highest Priority</option>
                                <option value="2" {{ $ManagementType->display_priority == "2" ? "selected":"" }}>2 - High Priority</option>
                                <option value="3" {{ $ManagementType->display_priority == "3" ? "selected":"" }}>3 - Medium Priority</option>
                                <option value="4" {{ $ManagementType->display_priority == "4" ? "selected":"" }}>4 - Low Priority</option>
                                <option value="5" {{ $ManagementType->display_priority == "5" ? "selected":"" }}>5 - Lowest Priority</option>
                            </select>
                        </div>
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
                        <!-- Existing images from database -->
                        @if(isset($gallery) && is_array($gallery) && count($gallery) > 0)
                            @foreach($gallery as $index => $img)
                                <div class="preview-card existing-image" data-existing-img="{{ $img }}">
                                    <img src="{{ asset($img) }}" alt="Existing Image">
                                    <button type="button" class="remove-btn" onclick="removeExistingImage('{{ $img }}', this)">&times;</button>
                                    <input type="hidden" name="existing_images[]" value="{{ $img }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Container for dynamic file inputs -->
                    <div id="dynamicInputsContainer"></div>

                    <!-- Hidden input to track removed existing images -->
                    <input type="hidden" id="removedImages" name="removed_images" value="">
                </div>

                <div class="btn--container justify-content-end mt-5">
                    <button type="button" class="btn btn--reset" id="resetBtn">{{translate('messages.reset')}}</button>
                    <button type="submit" class="btn btn--primary">{{translate('messages.update')}}</button>
                </div>
            </div>
        </div>
        @endif
    </form>
</div>
@endsection

@push('script_2')
<script src="{{asset('public/assets/admin')}}/js/view-pages/segments-index.js"></script>
<script src="{{asset('public/assets/admin')}}/js/view-pages/client-side-index.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
    let selectedFiles = [];
    let fileCounter = 0;
    let removedExistingImages = [];

    // Handle new file selection
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
                previewCard.className = "preview-card new-image";
                previewCard.setAttribute('data-file-id', fileId);

                previewCard.innerHTML = `
                    <img src="${e.target.result}" alt="New Image">
                    <button type="button" class="remove-btn" onclick="removeNewFile('${fileId}')">&times;</button>
                `;

                document.getElementById("galleryPreview").appendChild(previewCard);
            };

            reader.readAsDataURL(file);

            // Create actual hidden file input for this file
            createFileInput(file, fileId);
        });

        // Clear the main input
        event.target.value = "";
    });

    // Create hidden file input for new files
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

    // Remove new file
    function removeNewFile(fileId) {
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

    // Remove existing image
    function removeExistingImage(imagePath, buttonElement) {
        // Add to removed images array
        removedExistingImages.push(imagePath);

        // Update hidden input with removed images
        document.getElementById('removedImages').value = JSON.stringify(removedExistingImages);

        // Remove the preview card
        const previewCard = buttonElement.closest('.preview-card');
        if (previewCard) {
            previewCard.remove();
        }
    }

    // Reset button functionality
    document.getElementById('resetBtn').addEventListener('click', function(e) {
        e.preventDefault();

        if(confirm('Are you sure you want to reset all changes?')) {
            // Clear all new file data
            selectedFiles = [];
            fileCounter = 0;
            removedExistingImages = [];

            // Clear dynamic inputs
            document.getElementById('dynamicInputsContainer').innerHTML = '';

            // Clear main input
            document.getElementById("galleryFiles").value = '';

            // Clear removed images input
            document.getElementById('removedImages').value = '';

            // Remove all new image previews
            const newImageCards = document.querySelectorAll('.preview-card.new-image');
            newImageCards.forEach(card => card.remove());

            // Restore removed existing images (reload page)
            location.reload();
        }
    });

    // Form validation before submit
    document.getElementById('occasionForm').addEventListener('submit', function(e) {
        const occasionName = document.getElementById('occasionName').value.trim();
        const businessCategory = document.getElementById('occasionCategory').value;
        const displayPriority = document.getElementById('occasionPriority').value;

        // Count remaining images (existing + new)
        const existingImages = document.querySelectorAll('.preview-card.existing-image').length;
        const newImages = selectedFiles.length;
        const totalImages = existingImages + newImages;

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

        if (totalImages === 0) {
            alert('Please keep at least one image in gallery');
            e.preventDefault();
            return false;
        }

        console.log('Submitting form with', newImages, 'new files and', existingImages, 'existing images');
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
