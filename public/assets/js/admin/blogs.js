document.addEventListener("DOMContentLoaded", function() {

    // Slug Generator
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    if (titleInput && slugInput) {
        titleInput.addEventListener('keyup', function() {
            let title = this.value;
            let slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            slugInput.value = slug;
        });
    }
    
    // File Input and Preview Logic
    const uploadContainer = document.getElementById('multiple-upload-container');
    const fileInput = document.getElementById('blogs-image-input');
    const previewGrid = document.getElementById('blogs-preview-grid');
    
    let selectedFiles = [];

    if (uploadContainer && fileInput) {
        // Trigger click on input when container is clicked
        uploadContainer.addEventListener('click', function(e) {
            // Prevent double-trigger if clicking input directly
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', function() {
            const files = Array.from(this.files);
            
            // Append newly selected files
            files.forEach(file => {
                // Ensure it is an image
                if (file.type.startsWith('image/')) {
                    selectedFiles.push(file);
                }
            });

            updateFilesInputAndPreviews();
        });
    }

    function updateFilesInputAndPreviews() {
        // Clear preview grid
        previewGrid.innerHTML = '';

        // Rebuild preview cards
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            const card = document.createElement('div');
            card.className = 'image-preview-card';
            card.setAttribute('data-index', index);

            const img = document.createElement('img');
            card.appendChild(img);

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'delete-btn';
            deleteBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            card.appendChild(deleteBtn);

            deleteBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                selectedFiles.splice(index, 1);
                updateFilesInputAndPreviews();
            });

            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            previewGrid.appendChild(card);
        });

        // Sync files with standard FileList using DataTransfer
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }

    // Ajax Image Deletion for Existing Uploads (Edit Page)
    const existingImages = document.querySelectorAll('.existing-image-card');
    
    existingImages.forEach(card => {
        const deleteBtn = card.querySelector('.delete-existing-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const imageId = this.getAttribute('data-image-id');
                const deleteUrl = this.getAttribute('data-delete-url');

                showConfirmModal('Delete Image', 'Are you sure you want to delete this image? This action cannot be undone.', function() {
                    // Send delete request
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || getCsrfFromForm(),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            card.remove();
                            if (typeof showToast === 'function') {
                                showToast('success', 'Deleted', data.message);
                            } else {
                                alert(data.message);
                            }
                        } else {
                            if (typeof showToast === 'function') {
                                showToast('error', 'Error', data.message);
                            } else {
                                alert(data.message);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting image:', error);
                        alert('Something went wrong while deleting the image.');
                    });
                });
            });
        }
    });

    function getCsrfFromForm() {
        return document.querySelector('input[name="_token"]')?.value || '';
    }

});
