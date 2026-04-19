<!-- ─── MODAL BERITA ─── -->

<div class="modal-overlay" id="modal-berita">
  <div class="modal" style="max-width:640px;">
    <div class="modal-header">
      <div>
        <div class="modal-label" id="modal-berita-label">Tambah Data</div>
        <div class="modal-title" id="modal-berita-title">Berita Baru</div>
      </div>
      <button class="modal-close" onclick="closeModal('modal-berita')">✕</button>
    </div>

    <div class="modal-body">
      <form id="form-berita" onsubmit="return false;" novalidate>
        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Judul Berita <span class="req">*</span></label>
            <input
              type="text"
              class="form-control"
              id="b-judul"
              placeholder="Judul berita / artikel"
              required
              minlength="10"
              maxlength="200"
            >
            <span class="form-error" id="e-b-judul">Judul wajib diisi (10–200 karakter)</span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Kategori <span class="req">*</span></label>
            <select class="form-control" id="b-kategori" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="Koleksi Baru">Koleksi Baru</option>
              <option value="Kerjasama">Kerjasama</option>
              <option value="Fasilitas">Fasilitas</option>
              <option value="Pengumuman">Pengumuman</option>
              <option value="Penelitian">Penelitian</option>
              <option value="Lainnya">Lainnya</option>
            </select>
            <span class="form-error" id="e-b-kategori">Pilih kategori berita</span>
          </div>

          <div class="form-group">
            <label class="form-label">Tanggal Tayang <span class="req">*</span></label>
            <input type="date" class="form-control" id="b-tanggal" required>
            <span class="form-error" id="e-b-tanggal">Tanggal tayang wajib diisi</span>
          </div>
        </div>

        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Ringkasan / Snippet <span class="req">*</span></label>
            <textarea
              class="form-control"
              id="b-snippet"
              placeholder="Ringkasan singkat yang tampil di halaman berita..."
              required
              minlength="20"
              maxlength="300"
              rows="3"
            ></textarea>
            <span class="form-hint">Maks. 300 karakter</span>
            <span class="form-error" id="e-b-snippet">Ringkasan wajib diisi (20–300 karakter)</span>
          </div>
        </div>

        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Isi Berita</label>
            <textarea class="form-control" id="b-isi" placeholder="Isi lengkap berita..." rows="5"></textarea>
          </div>
        </div>

        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Thumbnail Berita</label>

            <div id="container-preview-berita" style="margin-bottom:10px;display:none;">
              <img
                id="b-foto-preview"
                src=""
                alt="Preview thumbnail"
                style="width:140px;height:90px;object-fit:cover;border-radius:8px;border:2px solid #eee;"
              >
              <p style="font-size:10px;color:#888;margin:5px 0 0 0;">Thumbnail saat ini</p>
            </div>

            <input type="file" id="b-foto" accept="image/*" class="form-control">   
            <small class="form-hint">Format: JPG, PNG, atau WebP. Maks 2MB.</small>
            <span id="e-b-foto" class="form-error">File thumbnail tidak valid</span>
          </div>
        </div>

        <input type="hidden" id="b-id">
      </form>
    </div>

    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-berita')">Batal</button>
      <button class="btn btn-primary" onclick="submitBerita()" id="btn-submit-berita">Simpan Berita</button>
    </div>
  </div>
</div>