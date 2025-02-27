<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <div class="d-flex align-items-center">
                    <i id="toast-icon" class="bi me-2"></i>&nbsp;&nbsp;
                    <span id="toast-message"></span>
                </div>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
class Toast {
    static show(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast, {
            delay: 3000
        });
        
        // Remove previous background classes
        toast.className = 'toast align-items-center border-0';
        
        // Set icon and background based on type
        const icon = document.getElementById('toast-icon');
        
        switch(type) {
            case 'success':
                icon.className = 'bi bi-check-circle-fill';
                toast.classList.add('text-bg-success');
                break;
            case 'error':
                icon.className = 'bi bi-x-circle-fill';
                toast.classList.add('text-bg-danger');
                break;
            case 'warning':
                icon.className = 'bi bi-exclamation-triangle-fill';
                toast.classList.add('text-bg-warning');
                break;
            case 'info':
                icon.className = 'bi bi-info-circle-fill';
                toast.classList.add('text-bg-info');
                break;
        }
        
        // Set message
        document.getElementById('toast-message').textContent = message;
        
        // Show toast
        toastBootstrap.show();
    }
}

window.Toast = Toast;
</script> 