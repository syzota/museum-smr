<div class="modal-overlay" id="modal-koleksi">
  <div class="modal">
    <div class="modal-header">
      <div>
        <div class="modal-label" id="modal-koleksi-label">Tambah Data</div>
        <div class="modal-title" id="modal-koleksi-title">Koleksi Baru</div>
      </div>
      <button class="modal-close" onclick="closeModal('modal-koleksi')">✕</button>
    </div>
    <div class="modal-body">
      <form id="form-koleksi" onsubmit="submitKoleksi(event)">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">No. Koleksi <span class="req">*</span></label>
            <input type="text" class="form-control" id="k-nomor" placeholder="cth: KOL-1248">
            <span class="form-error" id="e-k-nomor">Format: KOL-XXXX (4 digit)</span>
          </div>
          <div class="form-group">
            <label class="form-label">Kategori <span class="req">*</span></label>
            <select class="form-control" id="k-kategori">
              <option value="">-- Pilih Kategori --</option>
              <option value="Etnografika">Etnografika</option>
              <option value="Keramnologi">Keramnologi</option>
              <option value="Mangkok">Mangkok</option>
              <option value="Guci">Guci</option>
              <option value="Alat Musik">Alat Musik</option>
              <option value="Pakaian Adat">Pakaian Adat</option>
              <option value="Mandau">Mandau</option>
              <option value="Kerajinan Tangan">Kerajinan Tangan</option>
              <option value="Bluko">Bluko</option>
              <option value="Obat Tradisional">Obat Tradisional</option>
              <option value="Sarung">Sarung</option>
            </select>
            <span class="form-error" id="e-k-kategori">Pilih kategori koleksi</span>
          </div>
        </div>

        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Nama Koleksi <span class="req">*</span></label>
            <input type="text" class="form-control" id="k-nama" placeholder="Nama koleksi lengkap">
            <span class="form-error" id="e-k-nama">Nama koleksi wajib diisi (min. 3 karakter)</span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Era / Periode <span class="req">*</span></label>
            <input type="text" class="form-control" id="k-era" placeholder="cth: Abad ke-18 / 1990">
            <span class="form-error" id="e-k-era">Era / periode wajib diisi</span>
          </div>
          <div class="form-group">
            <label class="form-label">Kondisi <span class="req">*</span></label>
            <select class="form-control" id="k-kondisi">
              <option value="">-- Pilih Kondisi --</option>
              <option value="Sangat Baik">Sangat Baik</option>
              <option value="Baik">Baik</option>
              <option value="Cukup">Cukup</option>
              <option value="Rusak Ringan">Rusak Ringan</option>
              <option value="Rusak Berat">Rusak Berat</option>
            </select>
            <span class="form-error" id="e-k-kondisi">Pilih kondisi koleksi</span>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Asal Daerah</label>
            <input type="text" class="form-control" id="k-asal" placeholder="cth: Kutai Barat">
          </div>
          <div class="form-group">
            <label class="form-label">Lokasi Penyimpanan</label>
            <input type="text" class="form-control" id="k-lokasi" placeholder="cth: Ruang III · Vitrin 7">
          </div>
        </div>

        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Deskripsi Koleksi</label>
            <textarea class="form-control" id="k-deskripsi" placeholder="Deskripsi singkat mengenai koleksi ini..." rows="3"></textarea>
          </div>
        </div>

        <div class="form-row single">
          <div class="form-group">
            <label class="form-label">Foto Koleksi</label>
            
            <div id="container-preview" style="margin-bottom: 10px; display: none;">
                <img id="v-foto-preview" src="" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #eee;">
                <p style="font-size: 10px; color: #888; margin: 5px 0 0 0;">Foto saat ini</p>
            </div>

            <input type="file" id="k-foto" accept="image/*" class="form-control">
            <small class="form-hint">Format: JPG, PNG, atau WebP. Maks 2MB.</small>
            <span id="e-k-foto" class="form-error">Silakan pilih file foto</span>
          </div>
        </div>

        <input type="hidden" id="k-id">
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline" onclick="closeModal('modal-koleksi')">Batal</button>
      <button type="submit" form="form-koleksi" class="btn btn-primary" id="btn-submit-koleksi">Simpan Koleksi</button>
    </div>
  </div>
</div>