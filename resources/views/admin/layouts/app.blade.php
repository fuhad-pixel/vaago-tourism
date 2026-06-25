<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ $company_setting->company_name ?? 'Premium Travel' }}</title>
    @if(isset($company_setting) && $company_setting->favicon_path)
        <link rel="icon" href="{{ asset($company_setting->favicon_path) }}" type="image/x-icon">
    @endif
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/toast.css') }}?v={{ time() }}">
    <!-- jQuery DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/datatable.css') }}?v={{ time() }}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    @yield('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px !important;
        }
    </style>
</head>
<body>

    <div id="toast-container"></div>

    <div class="admin-layout">
        <div class="admin-sidebar-wrapper">
            @include('admin.partials.sidebar')
        </div>

        <div class="admin-main">
            @include('admin.partials.header')
            
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Custom Confirm Modal -->
    <div class="custom-confirm-overlay" id="customConfirmOverlay">
        <div class="custom-confirm-modal">
            <div class="confirm-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="confirm-title" id="customConfirmTitle">Confirm Action</h3>
            <p class="confirm-message" id="customConfirmMessage">Are you sure you want to proceed?</p>
            <div class="confirm-actions">
                <button type="button" class="btn-confirm-cancel" id="customConfirmCancelBtn">Cancel</button>
                <button type="button" class="btn-confirm-proceed" id="customConfirmProceedBtn">Yes, Delete</button>
            </div>
        </div>
    </div>

    <!-- jQuery (Required for Validation) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- Additional Methods for Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/admin/dashboard.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/admin/toast.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('assets/js/admin/form-validation.js') }}?v={{ time() }}"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                showToast('success', 'Success', "{{ session('success') }}");
            @endif
            @if(session('error'))
                showToast('error', 'Error', "{{ session('error') }}");
            @endif
            @if($errors->any())
                showToast('error', 'Validation Error', "Please check the form for errors.");
            @endif

            // Global CKEditor initialization
            window.editorInstances = window.editorInstances || {};
            document.querySelectorAll('.ckeditor-init').forEach(textarea => {
                ClassicEditor
                    .create(textarea, {
                        minHeight: '300px'
                    })
                    .then(editor => {
                        const id = textarea.id || textarea.name;
                        if (id) {
                            window.editorInstances[id] = editor;
                        }
                        editor.model.document.on('change:data', () => {
                            textarea.value = editor.getData();
                            $(textarea).trigger('change');
                        });
                    })
                    .catch(error => {
                        console.error('CKEditor Init Error:', error);
                    });
            });

            // Global Select2 initialization
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2-init').select2({
                    width: '100%'
                });
            }
        });
    </script>

    <!-- Custom JS -->
    @yield('scripts')
</body>
</html>
