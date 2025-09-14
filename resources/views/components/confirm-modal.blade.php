<!-- Global Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmModalLabel">
          <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="confirmModalMessage" class="mb-0">Apakah Anda yakin ingin menghapus data ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmModalOkBtn">Hapus</button>
      </div>
    </div>
  </div>
</div>
<script>
window.confirmModal = function(message, onConfirm) {
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    document.getElementById('confirmModalMessage').textContent = message || 'Apakah Anda yakin?';
    const okBtn = document.getElementById('confirmModalOkBtn');
    okBtn.onclick = null;
    okBtn.onclick = function() {
        modal.hide();
        if (typeof onConfirm === 'function') onConfirm();
    };
    modal.show();
};
</script>
