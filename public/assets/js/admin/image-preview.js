document.addEventListener("DOMContentLoaded", function() {
    
    const uploadWrappers = document.querySelectorAll('.image-upload-wrapper');

    uploadWrappers.forEach(wrapper => {
        const input = wrapper.querySelector('.image-upload-input');
        const preview = wrapper.querySelector('.image-preview');
        const removeBtn = wrapper.querySelector('.image-remove-btn');
        const removeInput = wrapper.querySelector('.remove-input');

        // Check initial state (if image already exists from DB)
        if (preview && preview.getAttribute('src')) {
            wrapper.classList.add('has-image');
        }

        // Handle File Selection
        if (input) {
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.setAttribute('src', e.target.result);
                        wrapper.classList.add('has-image');
                        if(removeInput) removeInput.value = '0'; // Reset remove flag
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Handle Remove Click
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                input.value = ''; // Clear file input
                preview.removeAttribute('src'); // Clear preview image
                wrapper.classList.remove('has-image');
                if(removeInput) removeInput.value = '1'; // Set flag to delete on server
            });
        }
    });

});
