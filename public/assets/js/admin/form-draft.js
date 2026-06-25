document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.draft-enabled');
    if (!form) return;

    // Use a unique key based on the URL path so different forms have different drafts
    const storageKey = 'vaago_draft_' + window.location.pathname.replace(/[^a-zA-Z0-9]/g, '_');
    
    // 1. RESTORE DRAFT
    const savedDraft = localStorage.getItem(storageKey);
    let isRestoring = false;

    if (savedDraft) {
        isRestoring = true;
        try {
            const data = JSON.parse(savedDraft);
            
            // SPECIAL HANDLING: Reconstruct Itineraries for Tour Creation
            let maxItineraryIndex = -1;
            for (const key in data) {
                const match = key.match(/^itineraries\[(\d+)\]/);
                if (match) {
                    const idx = parseInt(match[1]);
                    if (idx > maxItineraryIndex) maxItineraryIndex = idx;
                }
            }

            if (maxItineraryIndex >= 0) {
                const addBtn = document.getElementById('btn-add-itinerary');
                if (addBtn) {
                    // Count how many already exist
                    let currentCount = document.querySelectorAll('.itinerary-block').length;
                    while (currentCount <= maxItineraryIndex) {
                        addBtn.click();
                        currentCount++;
                    }
                }
            }
            
            // Standard inputs & Selects
            for (const key in data) {
                // Handle multiple inputs with the same name (like arrays e.g., faqs[])
                // Use a safe selector to avoid errors with brackets in names
                const safeKey = key.replace(/"/g, '\\"');
                const inputs = form.querySelectorAll(`[name="${safeKey}"]`);
                if (!inputs.length) continue;

                if (inputs[0].type === 'checkbox' || inputs[0].type === 'radio') {
                    inputs.forEach(input => {
                        input.checked = Array.isArray(data[key]) 
                            ? data[key].includes(input.value) 
                            : data[key] == input.value;
                    });
                } else if (inputs[0].tagName === 'SELECT') {
                    const select = $(inputs[0]);
                    select.val(data[key]);
                    // Only trigger change.select2 if Select2 is attached
                    if (select.hasClass('select2-hidden-accessible')) {
                        select.trigger('change.select2'); 
                    } else {
                        select.trigger('change');
                    }
                } else {
                    inputs[0].value = data[key];
                    // If it's a textarea, let's also try to update CKEditor if it's already active
                    const id = inputs[0].id || inputs[0].name;
                    if (window.editorInstances && window.editorInstances[id]) {
                        window.editorInstances[id].setData(data[key]);
                    } else if (inputs[0].editorInstance) {
                        inputs[0].editorInstance.setData(data[key]);
                    }
                }
            }

            // Since editors might initialize after this script, set a quick interval to patch them
            let checks = 0;
            const editorPatchInterval = setInterval(() => {
                checks++;
                for (const key in data) {
                    const safeKey = key.replace(/"/g, '\\"');
                    const inputs = form.querySelectorAll(`[name="${safeKey}"]`);
                    if (inputs.length && inputs[0].tagName === 'TEXTAREA') {
                        const id = inputs[0].id || inputs[0].name;
                        let editor = null;
                        if (window.editorInstances && window.editorInstances[id]) {
                            editor = window.editorInstances[id];
                        } else if (inputs[0].editorInstance) {
                            editor = inputs[0].editorInstance;
                        }

                        if (editor) {
                            // Only set if current data is empty, to avoid overwriting user's fresh typing
                            if (editor.getData() === '') {
                                editor.setData(data[key]);
                            }
                        }
                    }
                }
                if (checks > 15) clearInterval(editorPatchInterval); // Stop checking after 1.5 second
            }, 100);

        } catch (e) {
            console.error("Draft restore error", e);
        }
        
        setTimeout(() => { isRestoring = false; }, 500);
    }

    // 2. SAVE DRAFT
    const saveDraft = function() {
        if (isRestoring) return;

        const formData = new FormData(form);
        const data = {};

        for (const [key, value] of formData.entries()) {
            // Ignore files
            if (value instanceof File) continue;
            
            // Ignore CSRF token and method fields
            if (key === '_token' || key === '_method') continue;

            if (data[key]) {
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value);
            } else {
                data[key] = value;
            }
        }

        // Specifically read CKEditors, because they might not sync to textarea until submit
        if (window.editorInstances) {
            for (const [id, editor] of Object.entries(window.editorInstances)) {
                // Find textarea with this id or name
                const safeId = id.replace(/"/g, '\\"');
                const textarea = form.querySelector(`#${safeId}`) || form.querySelector(`[name="${safeId}"]`);
                if (textarea) {
                    data[textarea.name] = editor.getData();
                }
            }
        }
        
        // Also read dynamic editors that might not be in window.editorInstances
        const dynamicEditors = form.querySelectorAll('.dynamic-ckeditor');
        dynamicEditors.forEach(textarea => {
            if (textarea.editorInstance) {
                data[textarea.name] = textarea.editorInstance.getData();
            }
        });

        localStorage.setItem(storageKey, JSON.stringify(data));
    };

    // Debounce function
    let timeout;
    const debouncedSave = function() {
        clearTimeout(timeout);
        timeout = setTimeout(saveDraft, 1000);
    };

    // Listen to form changes
    form.addEventListener('input', debouncedSave);
    form.addEventListener('change', debouncedSave);

    // Hook into Select2 change events using jQuery (for select inputs)
    if (typeof $ !== 'undefined') {
        $(form).on('change', 'select', debouncedSave);
    }
    
    // Hook into CKEditor change events using jQuery (from app.blade.php triggers)
    if (typeof $ !== 'undefined') {
        $(form).on('change', 'textarea', debouncedSave);
    }

    // 3. CLEAR DRAFT ON SUBMIT
    form.addEventListener('submit', function() {
        localStorage.removeItem(storageKey);
    });
});
