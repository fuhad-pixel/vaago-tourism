document.addEventListener("DOMContentLoaded", function () {
    // Slug Generator
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    if (nameInput && slugInput) {
        nameInput.addEventListener('keyup', function () {
            let title = this.value;
            let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            slugInput.value = slug;
        });
    }

    // Itinerary Repeater
    const itineraryContainer = document.getElementById('itineraries-container');
    const addItineraryBtn = document.getElementById('btn-add-itinerary');

    if (itineraryContainer && addItineraryBtn) {
        let itineraryIndex = document.querySelectorAll('.itinerary-block').length;

        addItineraryBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const block = document.createElement('div');
            block.className = 'repeater-block itinerary-block';
            block.innerHTML = `
                <div class="repeater-header">
                    <i class="fa-solid fa-calendar-day"></i> Day <span class="day-number">${itineraryIndex + 1}</span>
                </div>
                <div class="btn-remove" title="Remove Itinerary"><i class="fa-solid fa-trash-can"></i></div>
                <div class="form-group">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="itineraries[${itineraryIndex}][title]" class="modern-input required-itinerary-title" placeholder="Enter title" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="itineraries[${itineraryIndex}][description]" class="modern-input dynamic-ckeditor" rows="5"></textarea>
                </div>
            `;

            itineraryContainer.appendChild(block);

            // Initialize CKEditor for the newly added textarea
            const newTextarea = block.querySelector('.dynamic-ckeditor');
            if (typeof ClassicEditor !== 'undefined') {
                ClassicEditor
                    .create(newTextarea, { minHeight: '300px' })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            newTextarea.value = editor.getData();
                            $(newTextarea).trigger('change');
                        });
                    })
                    .catch(error => { console.error('CKEditor Init Error:', error); });
            }

            itineraryIndex++;
            updateDayNumbers();
        });

        itineraryContainer.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove')) {
                const block = e.target.closest('.itinerary-block');
                showConfirmModal('Remove Itinerary', 'Remove this itinerary?', function () {
                    block.remove();
                    updateDayNumbers();
                });
            }
        });

        function updateDayNumbers() {
            const blocks = itineraryContainer.querySelectorAll('.itinerary-block');
            blocks.forEach((block, index) => {
                block.querySelector('.day-number').textContent = index + 1;
                block.querySelector('.required-itinerary-title').name = `itineraries[${index}][title]`;
                block.querySelector('.dynamic-ckeditor').name = `itineraries[${index}][description]`;
            });
            itineraryIndex = blocks.length;
        }
    }

    // Multi Image Preview & Accumulator
    const multiImageInput = document.querySelector('.multi-image-input');
    const previewContainer = document.getElementById('image-preview-container');

    if (multiImageInput && previewContainer) {
        let dt = new DataTransfer(); // Holds all files accumulatively

        multiImageInput.addEventListener('change', function (e) {
            const files = e.target.files;
            
            // Add new selected files to our DataTransfer object
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                // Check if file is already in the list to prevent duplicates
                let exists = false;
                for (let j = 0; j < dt.files.length; j++) {
                    if (dt.files[j].name === file.name && dt.files[j].size === file.size) {
                        exists = true;
                        break;
                    }
                }
                if (!exists) {
                    dt.items.add(file);
                }
            }
            
            // Assign the accumulated files back to the input element
            multiImageInput.files = dt.files;
            
            // Update preview
            updateImagePreview();
        });

        function updateImagePreview() {
            previewContainer.innerHTML = ''; // Clear previous previews
            const files = Array.from(dt.files);
            
            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                            <img src="${event.target.result}" alt="Preview">
                            <div class="remove-btn remove-preview-btn" data-index="${index}" title="Remove Image">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        `;
                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Add event listener to remove single images from the list
        previewContainer.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-preview-btn');
            if (removeBtn) {
                const indexToRemove = parseInt(removeBtn.dataset.index);
                
                // Reconstruct DataTransfer excluding the deleted item
                const newDt = new DataTransfer();
                for (let i = 0; i < dt.files.length; i++) {
                    if (i !== indexToRemove) {
                        newDt.items.add(dt.files[i]);
                    }
                }
                dt = newDt;
                multiImageInput.files = dt.files;
                updateImagePreview();
            }
        });
    }

    // Existing Images AJAX Remove
    const existingContainer = document.querySelector('.existing-images-container');
    if (existingContainer) {
        existingContainer.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.existing-remove-btn');
            if (removeBtn) {
                showConfirmModal('Delete Image', 'Are you sure you want to delete this image?', function () {
                    const item = removeBtn.closest('.existing-image');
                    const imageId = item.dataset.id;

                    fetch(`/admin/tours/image/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                item.remove();
                                if (typeof showToast === 'function') {
                                    showToast('success', 'Deleted', 'Image deleted successfully.');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting image:', error);
                            alert('Failed to delete image.');
                        });
                });
            }
        });
    }
});
