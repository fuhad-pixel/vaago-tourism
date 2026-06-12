document.addEventListener("DOMContentLoaded", function() {
    
    // Check if jQuery validation is loaded
    if (typeof $.fn.validate !== 'undefined') {
        
        // Initialize validation on all forms with class .validate-form
        $(".validate-form").each(function() {
            $(this).validate({
                errorElement: "span",
                errorClass: "error-message text-danger",
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                errorPlacement: function(error, element) {
                    error.css('font-size', '0.8rem');
                    error.css('margin-top', '4px');
                    error.css('display', 'block');
                    error.css('color', '#EF4444');
                    if (element.parent('.image-upload-wrapper').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    // This only runs if validation PASSES
                    
                    // Find the submit button
                    const submitBtn = $(form).find('button[type="submit"]');
                    
                    if (submitBtn.length) {
                        // Disable the button to prevent multiple submissions
                        submitBtn.prop('disabled', true);
                        
                        // Change text to processing state with a spinner
                        const originalHtml = submitBtn.html();
                        submitBtn.data('original-html', originalHtml);
                        submitBtn.html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...');
                        submitBtn.css('opacity', '0.8');
                        submitBtn.css('cursor', 'not-allowed');
                    }
                    
                    // Submit the form normally
                    form.submit();
                }
            });
        });
        
    }

});
