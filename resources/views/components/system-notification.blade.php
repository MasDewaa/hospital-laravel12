<!-- System Notification Modal -->
<div class="modal fade" id="systemNotificationModal" tabindex="-1" aria-labelledby="systemNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="systemNotificationModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Sistem Berhasil Dimuat
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <i class="fas fa-hospital fa-4x text-success mb-3"></i>
                    <h4>Rumah Sakit Sehat Sentosa</h4>
                    <p class="text-muted">Sistem Manajemen Terintegrasi dengan AI Assistant</p>
                </div>
                
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-server fa-2x text-primary mb-2"></i>
                            <h6>Server Status</h6>
                            <span class="badge bg-success">Online</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-database fa-2x text-info mb-2"></i>
                            <h6>Database</h6>
                            <span class="badge bg-success">Connected</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-robot fa-2x text-warning mb-2"></i>
                            <h6>AI Assistant</h6>
                            <span class="badge bg-success">Ready</span>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Sistem siap digunakan!</strong> Semua layanan telah berhasil dimuat dan siap melayani Anda.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-right me-2"></i>Mulai Menggunakan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="text-primary">Memuat Sistem...</h5>
                <p class="text-muted">Mohon tunggu sebentar, sistem sedang mempersiapkan layanan untuk Anda.</p>
            </div>
        </div>
    </div>
</div>

<script>
// System notification functions
function showSystemNotification() {
    const modal = new bootstrap.Modal(document.getElementById('systemNotificationModal'));
    modal.show();
}

function showLoadingModal() {
    const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
    modal.show();
    return modal;
}

function hideLoadingModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('loadingModal'));
    if (modal) {
        modal.hide();
    }
}

// Auto-show system notification on page load
document.addEventListener('DOMContentLoaded', function() {
    // Show loading modal briefly
    const loadingModal = showLoadingModal();
    
    // Hide loading modal and show notification after 2 seconds
    setTimeout(() => {
        hideLoadingModal();
        setTimeout(() => {
            showSystemNotification();
        }, 500);
    }, 2000);
});

// Add system status indicator
function addSystemStatusIndicator() {
    const statusIndicator = document.createElement('div');
    statusIndicator.className = 'position-fixed';
    statusIndicator.style.cssText = 'top: 20px; right: 20px; z-index: 1050;';
    statusIndicator.innerHTML = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Sistem Online</strong> - Semua layanan berjalan normal
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    document.body.appendChild(statusIndicator);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alert = statusIndicator.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}

// Initialize system status indicator
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(addSystemStatusIndicator, 3000);
});
</script>
