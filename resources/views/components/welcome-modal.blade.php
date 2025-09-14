<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-hospital fa-2x me-3"></i>
                    <div>
                        <h4 class="modal-title mb-0" id="welcomeModalLabel">Selamat Datang di</h4>
                        <h3 class="mb-0 fw-bold">Rumah Sakit Sehat Sentosa</h3>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>Tentang Sistem
                            </h5>
                            <p class="text-muted">
                                Sistem Manajemen Rumah Sakit terintegrasi dengan AI Assistant untuk memberikan 
                                pelayanan terbaik bagi pasien, dokter, dan staf medis.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-star me-2"></i>Fitur Unggulan
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Manajemen Pasien
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Jadwal Dokter
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Booking Appointment
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            AI Chat Assistant
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Dashboard Analytics
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Notifikasi Real-time
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-phone me-2"></i>Kontak Darurat
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <i class="fas fa-phone text-danger me-2"></i>
                                        <strong>Emergency:</strong> (021) 9999-8888
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <strong>Informasi:</strong> (021) 1234-5678
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="mb-4">
                                <i class="fas fa-user-md fa-4x text-primary mb-3"></i>
                                <h6 class="text-muted">Sistem Terintegrasi</h6>
                            </div>

                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-robot me-2"></i>AI Assistant
                                    </h6>
                                    <p class="card-text small text-muted">
                                        Dapatkan bantuan 24/7 dari AI Assistant kami untuk 
                                        pertanyaan tentang layanan rumah sakit.
                                    </p>
                                    <button class="btn btn-sm btn-outline-primary" onclick="openChatWidget()">
                                        <i class="fas fa-comments me-1"></i>Coba Chat
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Data Anda aman dan terlindungi
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Jam Operasional: 08:00 - 20:00 (Senin-Jumat)
                        </small>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-right me-2"></i>Mulai Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Info Modal -->
<div class="modal fade" id="systemInfoModal" tabindex="-1" aria-labelledby="systemInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="systemInfoModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-hospital fa-2x text-primary mb-2"></i>
                            <h6>Rumah Sakit Sehat Sentosa</h6>
                            <small class="text-muted">Sistem Manajemen Terintegrasi</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-code fa-2x text-success mb-2"></i>
                            <h6>Laravel 12.x</h6>
                            <small class="text-muted">Framework PHP Modern</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-robot fa-2x text-warning mb-2"></i>
                            <h6>AI Powered</h6>
                            <small class="text-muted">Google Gemini Integration</small>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Fitur Utama:</h6>
                        <ul class="list-unstyled small">
                            <li><i class="fas fa-check text-success me-2"></i>Manajemen Pasien</li>
                            <li><i class="fas fa-check text-success me-2"></i>Jadwal Dokter</li>
                            <li><i class="fas fa-check text-success me-2"></i>Booking Appointment</li>
                            <li><i class="fas fa-check text-success me-2"></i>Dashboard Analytics</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Teknologi:</h6>
                        <ul class="list-unstyled small">
                            <li><i class="fas fa-check text-success me-2"></i>Laravel 12.x</li>
                            <li><i class="fas fa-check text-success me-2"></i>Bootstrap 5.3</li>
                            <li><i class="fas fa-check text-success me-2"></i>Google Gemini AI</li>
                            <li><i class="fas fa-check text-success me-2"></i>JWT Authentication</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="openChatWidget()">
                    <i class="fas fa-comments me-2"></i>Coba AI Assistant
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-show welcome modal on first visit
document.addEventListener('DOMContentLoaded', function() {
    // Check if user has seen the welcome modal before
    if (!localStorage.getItem('welcomeModalShown')) {
        const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
        welcomeModal.show();
        
        // Mark as shown
        localStorage.setItem('welcomeModalShown', 'true');
    }
    
    // Add system info button to footer
    addSystemInfoButton();
});

// Function to open chat widget
function openChatWidget() {
    const chatToggle = document.getElementById('chatToggle');
    if (chatToggle) {
        chatToggle.click();
    }
}

// Function to add system info button
function addSystemInfoButton() {
    // Add system info button to the page
    const systemInfoBtn = document.createElement('button');
    systemInfoBtn.className = 'btn btn-outline-info btn-sm position-fixed';
    systemInfoBtn.style.cssText = 'bottom: 20px; left: 20px; z-index: 1000;';
    systemInfoBtn.innerHTML = '<i class="fas fa-info-circle me-1"></i>Info Sistem';
    systemInfoBtn.setAttribute('data-bs-toggle', 'modal');
    systemInfoBtn.setAttribute('data-bs-target', '#systemInfoModal');
    
    document.body.appendChild(systemInfoBtn);
}

// Function to show welcome modal manually
function showWelcomeModal() {
    const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
    welcomeModal.show();
}

// Function to reset welcome modal (for testing)
function resetWelcomeModal() {
    localStorage.removeItem('welcomeModalShown');
    showWelcomeModal();
}
</script>
