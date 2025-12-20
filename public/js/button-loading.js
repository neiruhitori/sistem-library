/**
 * Button Loading Handler
 * Mencegah duplikat submit dengan menambahkan loading state pada button
 * Author: System Library SMPN 02 Klakah
 */

(function() {
    'use strict';

    // Konfigurasi
    const config = {
        // Selector untuk button yang akan di-handle
        submitButtonSelector: 'button[type="submit"], .btn-submit',
        deleteButtonSelector: '.btn-delete, button[type="submit"][class*="btn-danger"]',
        formSelector: 'form',
        
        // Text loading
        loadingText: '<i class="fas fa-spinner fa-spin mr-1"></i> Loading...',
        loadingTextShort: '<i class="fas fa-spinner fa-spin"></i>',
        
        // Timeout untuk auto-enable button jika ada error (dalam ms)
        autoEnableTimeout: 10000, // 10 detik
    };

    // State management
    const buttonStates = new WeakMap();

    /**
     * Simpan state awal button
     */
    function saveButtonState(button) {
        if (!buttonStates.has(button)) {
            buttonStates.set(button, {
                originalHTML: button.innerHTML,
                originalDisabled: button.disabled,
                originalClasses: button.className,
            });
        }
    }

    /**
     * Set button ke loading state
     */
    function setButtonLoading(button, showText = true) {
        saveButtonState(button);
        
        // Disable button
        button.disabled = true;
        button.classList.add('btn-loading');
        
        // Simpan text asli jika belum
        if (!button.dataset.originalText) {
            button.dataset.originalText = button.innerHTML;
        }
        
        // Tampilkan loading
        const hasIcon = button.querySelector('i');
        const hasText = button.textContent.trim().length > 0;
        
        if (hasText && showText) {
            button.innerHTML = config.loadingText;
        } else {
            button.innerHTML = config.loadingTextShort;
        }
        
        // Set timeout untuk auto-enable jika ada error
        const timeoutId = setTimeout(() => {
            resetButton(button);
            console.warn('Button auto-enabled after timeout:', button);
        }, config.autoEnableTimeout);
        
        button.dataset.timeoutId = timeoutId;
    }

    /**
     * Reset button ke state awal
     */
    function resetButton(button) {
        const state = buttonStates.get(button);
        
        if (state) {
            button.innerHTML = state.originalHTML;
            button.disabled = state.originalDisabled;
            button.className = state.originalClasses;
        } else if (button.dataset.originalText) {
            button.innerHTML = button.dataset.originalText;
            button.disabled = false;
        }
        
        button.classList.remove('btn-loading');
        
        // Clear timeout
        if (button.dataset.timeoutId) {
            clearTimeout(parseInt(button.dataset.timeoutId));
            delete button.dataset.timeoutId;
        }
        
        delete button.dataset.originalText;
    }

    /**
     * Reset semua button dalam form
     */
    function resetFormButtons(form) {
        const buttons = form.querySelectorAll('button[type="submit"], .btn-submit');
        buttons.forEach(button => resetButton(button));
    }

    /**
     * Handle form submit
     */
    function handleFormSubmit(event) {
        const form = event.target;
        const submitButton =
            event.submitter ||
            form.querySelector('button[type="submit"]:focus') ||
            form.querySelector('button[type="submit"]');

        // Jika button sudah loading, prevent submit (double click prevention)
        if (submitButton && submitButton.classList.contains("btn-loading")) {
            console.warn("Form submit prevented - button already loading");
            event.preventDefault();
            return false;
        }

        // JANGAN prevent jika button disabled tapi tidak loading
        // Ini bisa terjadi karena validasi HTML5

        // Set semua submit button ke loading
        const submitButtons = form.querySelectorAll(
            'button[type="submit"], .btn-submit'
        );
        submitButtons.forEach((button) => {
            setButtonLoading(button);
        });

        // Untuk form dengan method GET (search form), reset button setelah delay
        if (form.method.toLowerCase() === "get") {
            setTimeout(() => {
                resetFormButtons(form);
            }, 1000);
        }

        // Log untuk debugging
        console.log(
            "Form submitting:",
            form.action || form.getAttribute("action")
        );
    }

    /**
     * Handle button click langsung (non-form)
     */
    function handleButtonClick(event) {
        const button = event.currentTarget;
        
        // Skip jika button sudah loading
        if (button.disabled || button.classList.contains('btn-loading')) {
            event.preventDefault();
            return false;
        }
        
        // Skip untuk button yang ada di dalam form (akan di-handle oleh form submit)
        if (button.closest('form')) {
            return;
        }
        
        // Set loading untuk button dengan data-href atau onclick
        if (button.dataset.href || button.getAttribute('onclick')) {
            setButtonLoading(button);
        }
    }

    /**
     * Handle link yang styled sebagai button
     */
    function handleLinkClick(event) {
        const link = event.currentTarget;
        
        // Skip jika sudah loading
        if (link.classList.contains('btn-loading')) {
            event.preventDefault();
            return false;
        }
        
        // Skip untuk link dengan target _blank atau link ke file
        if (link.target === '_blank' || link.href.match(/\.(pdf|png|jpg|jpeg|gif|zip|xls|xlsx|doc|docx)$/i)) {
            return;
        }
        
        // Set loading
        const tempButton = document.createElement('span');
        tempButton.className = link.className;
        tempButton.innerHTML = link.innerHTML;
        saveButtonState(link);
        setButtonLoading(link, false);
    }

    /**
     * Handle AJAX form submission (untuk form dengan class .ajax-form)
     */
    function handleAjaxForm(form) {
        // Reset button setelah response (success atau error)
        const observer = new MutationObserver(() => {
            // Jika ada alert/notification muncul, reset button
            if (document.querySelector('.alert, .swal2-container')) {
                resetFormButtons(form);
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Handle DataTables button
     */
    function handleDataTablesButtons() {
        // Untuk tombol delete dalam DataTables
        document.addEventListener('click', function(event) {
            const deleteBtn = event.target.closest('.btn-delete, .delete-btn, button[onclick*="delete"]');
            
            if (deleteBtn && !deleteBtn.classList.contains('btn-loading')) {
                // Set loading setelah konfirmasi
                const originalOnClick = deleteBtn.onclick;
                
                if (originalOnClick) {
                    deleteBtn.onclick = function(e) {
                        const result = originalOnClick.call(this, e);
                        
                        // Jika ada konfirmasi dan di-confirm, set loading
                        if (result !== false) {
                            setTimeout(() => {
                                setButtonLoading(deleteBtn, false);
                            }, 100);
                        }
                        
                        return result;
                    };
                }
            }
        });
    }

    /**
     * Setup observer untuk dynamic content
     */
    function setupDynamicContentObserver() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) { // Element node
                        // Init forms baru
                        if (node.matches && node.matches('form')) {
                            initForm(node);
                        }
                        
                        // Init forms dalam node baru
                        const forms = node.querySelectorAll ? node.querySelectorAll('form') : [];
                        forms.forEach(form => initForm(form));
                    }
                });
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Initialize form
     */
    function initForm(form) {
        // Skip jika sudah di-init
        if (form.dataset.loadingInit) {
            return;
        }
        
        form.dataset.loadingInit = 'true';
        
        // Handle form submit
        form.addEventListener('submit', handleFormSubmit);
        
        // Handle AJAX form
        if (form.classList.contains('ajax-form')) {
            handleAjaxForm(form);
        }
    }

    /**
     * Initialize semua event listeners
     */
    function init() {
        // Init semua form yang ada
        document.querySelectorAll('form').forEach(form => {
            initForm(form);
        });
        
        // Handle button click
        document.addEventListener('click', function(event) {
            const button = event.target.closest('button[type="submit"], .btn-submit');
            if (button) {
                handleButtonClick(event);
            }
        });
        
        // Handle link yang styled sebagai button
        document.addEventListener('click', function(event) {
            const link = event.target.closest('a.btn');
            if (link && link.href && !link.href.startsWith('#')) {
                handleLinkClick(event);
            }
        });
        
        // Setup DataTables integration
        handleDataTablesButtons();
        
        // Setup observer untuk dynamic content
        setupDynamicContentObserver();
        
        // Listen untuk page visibility change (untuk reset jika user switch tab)
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                // Reset semua loading button yang mungkin stuck
                document.querySelectorAll('.btn-loading').forEach(button => {
                    const elapsed = Date.now() - (parseInt(button.dataset.loadingStart) || 0);
                    if (elapsed > 5000) { // Jika lebih dari 5 detik
                        resetButton(button);
                    }
                });
            }
        });
        
        // Handle browser back button
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Reset semua button jika page di-restore dari cache
                document.querySelectorAll('.btn-loading').forEach(button => {
                    resetButton(button);
                });
            }
        });
        
        console.log('✓ Button Loading Handler initialized');
    }

    // Initialize saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose API untuk manual control jika diperlukan
    window.ButtonLoading = {
        setLoading: setButtonLoading,
        reset: resetButton,
        resetForm: resetFormButtons
    };

})();
