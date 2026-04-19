<!-- ─── MODAL KEGIATAN ─── -->

<div class="modal-overlay" id="modal-kegiatan">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-label" id="modal-kegiatan-label">Tambah Data</div>
        <div class="modal-title" id="modal-kegiatan-title">Kegiatan Baru</div>
      </div>
      <button class="modal-close" onclick="closeModal('modal-kegiatan')">✕</button>
    </div>
    <div class="modal-body">
      <form id="form-kegiatan" onsubmit="return false;" novalidate>
        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Nama Kegiatan <span class="req">*</span></label>
            <input type="text" class="form-control" id="kg-nama" placeholder="Judul kegiatan / event" required minlength="5" maxlength="150">
            <span class="form-error" id="e-kg-nama">Nama kegiatan wajib diisi (5–150 karakter)</span>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Mulai <span class="req">*</span></label>
            <input type="date" class="form-control" id="kg-tanggal" required>
            <span class="form-error" id="e-kg-tanggal">Tanggal kegiatan wajib diisi</span>
          </div>
          <div class="form-group">
            <label class="form-label">Jam Mulai <span class="req">*</span></label>
            <input type="time" class="form-control" id="kg-jam" required>
            <span class="form-error" id="e-kg-jam">Jam kegiatan wajib diisi</span>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Kategori <span class="req">*</span></label>
            <select class="form-control" id="kg-kategori" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="Pameran">Pameran</option>
              <option value="Workshop">Workshop</option>
              <option value="Diskusi">Diskusi & Seminar</option>
              <option value="Edukasi">Edukasi Sekolah</option>
              <option value="Korporat">Korporat</option>
              <option value="Lainnya">Lainnya</option>
            </select>
            <span class="form-error" id="e-kg-kategori">Pilih kategori kegiatan</span>
          </div>
          <div class="form-group">
            <label class="form-label">Tempat <span class="req">*</span></label>
            <select class="form-control" id="kg-tempat" required>
              <option value="">-- Pilih Tempat --</option>
              <option value="Aula Utama">Aula Utama</option>
              <option value="Ruang Seminar">Ruang Seminar</option>
              <option value="Ruang Edukasi">Ruang Edukasi</option>
              <option value="Teras Heritage">Teras Heritage</option>
              <option value="Ruang Pameran Temporer">Ruang Pameran Temporer</option>
              <option value="Seluruh Ruang Museum">Seluruh Ruang Museum</option>
            </select>
            <span class="form-error" id="e-kg-tempat">Pilih tempat kegiatan</span>
          </div>
        </div>
        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Deskripsi Kegiatan</label>
            <textarea class="form-control" id="kg-deskripsi" placeholder="Detail kegiatan, tujuan, dan informasi lainnya..." rows="3"></textarea>
          </div>
        </div>
        <input type="hidden" id="kg-id">
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-kegiatan')">Batal</button>
      <button class="btn btn-primary" onclick="submitKegiatan()" id="btn-submit-kegiatan">Simpan Kegiatan</button>
    </div>
  </div>
</div>