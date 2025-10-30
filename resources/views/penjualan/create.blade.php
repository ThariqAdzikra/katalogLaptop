@extends('layouts.app')

@section('title', 'Kasir Penjualan - Laptop Store')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/manajemen/kasir.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<div class="container py-4">
  <div class="form-container"> 

    <div class="page-header mb-4">
        <h1 class="page-title">
          <i class="bi bi-cash-register me-2"></i>Kasir Penjualan
        </h1>
        <p class="page-subtitle">Catat transaksi dengan cepat dan mudah</p>
    </div>

    <form action="{{ route('penjualan.store') }}" method="POST" id="form-kasir">
      @csrf
      <div class="row g-4 align-items-stretch">
        
        {{-- KARTU 1: INPUT (KIRI) --}}
        <div class="col-md-8">
          <div class="form-card h-100"> 
            <div class="form-section">
              <h3 class="section-title"><i class="bi bi-person"></i>Informasi Pelanggan</h3>

              <div class="row g-3"> 
                <div class="col-12">
                  <label class="form-label">Pelanggan</label>
                  <select name="pelanggan_input" id="pelanggan-select" class="form-select" required>
                    <option value="">-- Cari atau Ketik Nama Pelanggan --</option>
                    @foreach($pelanggan as $p)
                      <option value="{{ $p->id_pelanggan }}" 
                              data-nama="{{ $p->nama }}" 
                              data-hp="{{ $p->no_hp }}" 
                              data-email="{{ $p->email }}" 
                              data-alamat="{{ $p->alamat }}">
                        {{ $p->nama }}
                      </option>
                    @endforeach
                  </select>
                  <input type="hidden" name="id_pelanggan" id="id_pelanggan_hidden"> 
                  
                  <div id="kolom-pelanggan-baru" class="mt-3">
                    <h5><i class="bi bi-person-check-fill me-2"></i>Data Pelanggan</h5>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="nama_pelanggan_baru" class="form-label small mb-1">Nama Pelanggan</label>
                            <input type="text" id="nama_pelanggan_baru" name="nama_pelanggan_baru" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp_baru" class="form-label small mb-1">No. HP</label>
                            <input type="text" id="no_hp_baru" name="no_hp_baru" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label for="email_baru" class="form-label small mb-1">Email</label>
                            <input type="email" id="email_baru" name="email_baru" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label for="alamat_baru" class="form-label small mb-1">Alamat</label>
                            <textarea id="alamat_baru" name="alamat_baru" class="form-control form-control-sm" rows="1"></textarea> 
                        </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-12">
                  <label class="form-label">Tanggal Penjualan</label>
                  <input type="datetime-local" name="tanggal_penjualan" class="form-control" value="{{ now()->toDateTimeLocalString() }}" required>
                </div>
              </div>
            </div>

            <div class="form-section">
              <h3 class="section-title"><i class="bi bi-cart4"></i>Tambah Produk</h3>

              <div id="produk-wrapper">
                {{-- BARIS PRODUK PERTAMA --}}
                <div class="row g-3 mb-3 produk-row align-items-end" data-row-id="row-1">
                  <div class="col-md-5">
                    <div class="produk-label-wrapper">
                        <label class="form-label">Produk</label>
                        <small class="text-muted stok-info"></small> 
                    </div>
                    <select name="produk[]" class="form-select produk-select" required>
                      <option value="">-- Pilih Produk --</option>
                      @foreach($produk as $pr)
                        <option value="{{ $pr->id_produk }}" 
                                data-harga="{{ $pr->harga_jual }}" 
                                data-stok="{{ $pr->stok }}" 
                                data-nama="{{ $pr->nama_produk }}">
                          {{ $pr->nama_produk }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" placeholder="0" value="1" required>
                  </div>

                  <div class="col-md-3">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                      <span class="input-group-text">Rp</span>
                      <input type="text" class="form-control harga-display" placeholder="0" readonly>
                      <input type="hidden" name="harga_satuan[]" class="harga-input" value="0">
                    </div>
                  </div>
                  
                  <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-row">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>
              </div>

              <button type="button" id="add-row" class="btn btn-secondary-custom w-100">
                <i class="bi bi-plus-circle me-1"></i>Tambah Produk
              </button>
            </div>
          </div>
        </div>

        {{-- KARTU 2: RINGKASAN (KANAN) --}}
        <div class="col-md-4">
          <div class="summary-sticky-wrapper h-100">
            <div class="form-card h-100"> 
              <div class="form-section">
                <h3 class="section-title"><i class="bi bi-receipt"></i>Ringkasan Transaksi</h3>
                
                <div id="ringkasan-container" class="mb-3" style="max-height: 400px; overflow-y: auto; border: 1px solid #e9ecef; border-radius: 0.375rem; padding: 0.75rem;">
                  {{-- Kotak ringkasan akan muncul di sini via JS --}}
                  <div id="ringkasan-items"></div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Metode Pembayaran</label>
                  <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="qris">QRIS</option>
                  </select>
                </div>

                <div id="qris-preview" class="text-center mb-3 d-none">
                  <p class="fw-semibold">Scan QRIS untuk pembayaran:</p>
                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Demo-QRIS"
                       alt="QRIS Code" class="img-thumbnail" style="width: 150px;">
                  <p class="small text-muted mt-2">* QRIS dummy untuk demo</p>
                </div>

                <hr class="my-3">

                <div class="total-section">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal:</span>
                    <span id="subtotal-display" class="fw-bold">Rp 0</span>
                  </div>
                  <div class="d-flex justify-content-between align-items-center" style="border-top: 2px solid #8b7355; padding-top: 0.75rem;">
                    <h5 class="fw-bold mb-0">Total:</h5>
                    <h3 id="total-display" class="fw-bolder mb-0" style="color: #8b7355;">Rp 0</h3>
                  </div>
                  <input type="hidden" name="total_harga" id="total_harga" value="0">
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 mt-4">
                  <i class="bi bi-check-circle me-2"></i>Selesaikan Transaksi
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  let rowCounter = 1;

  // FUNGSI HELPER
  function formatRupiah(angka) { 
    return 'Rp ' + (Number(angka) || 0).toLocaleString('id-ID'); 
  }
  
  function formatAngka(angka) { 
    return (Number(angka) || 0).toLocaleString('id-ID'); 
  }

  // FUNGSI UPDATE TOTAL & RINGKASAN
  function updateTotal() {
    let grandTotal = 0;
    const $ringkasanItems = $('#ringkasan-items');
    $ringkasanItems.empty();
    let adaProduk = false;

    // Loop setiap row produk
    $('#produk-wrapper .produk-row').each(function(index) {
      const $row = $(this);
      const $select = $row.find('.produk-select');
      const $jumlah = $row.find('.jumlah-input');
      // const $hargaInput = $row.find('.harga-input'); // Jangan baca dari sini untuk kalkulasi

      const selectedValue = $select.val();
      const jumlahValue = parseInt($jumlah.val()) || 0;
      
      if (selectedValue && selectedValue !== '') {
        // Ambil data dari option yang dipilih
        const $selectedOption = $select.find('option:selected');
        const namaProduk = $selectedOption.data('nama') || $selectedOption.text();
        
        // =================================================================
        // PERBAIKAN: Ambil harga langsung dari atribut 'data-harga' di <option>
        // Ini memastikan nama dan harga SELALU SINKRON, tidak peduli
        // nilai di hidden input sudah ter-update atau belum.
        const hargaSatuan = parseFloat($selectedOption.data('harga')) || 0;
        // =================================================================

        if (jumlahValue > 0 && hargaSatuan > 0) {
          adaProduk = true;
          const subtotal = hargaSatuan * jumlahValue;
          grandTotal += subtotal;

          // Tambah kotak untuk setiap produk yang dipilih
          // Ini akan membuat kotaknya "berlenggek" seperti yang Anda mau
          $ringkasanItems.append(`
            <div class="ringkasan-item" style="background: white; border: 1px solid #e9ecef; border-radius: 0.375rem; padding: 0.75rem 1rem; margin-bottom: 0.75rem;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem;">
                <div style="flex: 1;">
                  <div style="font-weight: 600; margin-bottom: 0.25rem; font-size: 0.95rem;">${namaProduk}</div>
                  <div style="color: #999; font-size: 0.85rem;">${jumlahValue}x @ ${formatRupiah(hargaSatuan)}</div>
                </div>
                <div style="font-weight: 600; white-space: nowrap; font-size: 0.95rem;">${formatRupiah(subtotal)}</div>
              </div>
            </div>
          `);
        }
      }
    });

    if (!adaProduk) {
      $ringkasanItems.html('<div style="text-align: center; color: #999; padding: 1.5rem 0.75rem; font-size: 0.9rem;">Belum ada produk</div>');
    }
    
    // Update total display
    $('#total-display').text(formatRupiah(grandTotal));
    $('#subtotal-display').text(formatRupiah(grandTotal));
    $('#total_harga').val(grandTotal);
  }

  // FUNGSI INISIALISASI SELECT2
  function initProdukSelect($element) {
    // Cek apakah sudah ada Select2
    if ($element.hasClass('select2-hidden-accessible')) {
      $element.select2('destroy');
    }
    
    // Init Select2
    $element.select2({
      theme: 'bootstrap-5',
      width: '100%',
      placeholder: '-- Pilih Produk --',
      allowClear: false,
      language: {
        noResults: function() { return "Tidak ditemukan"; },
        searching: function() { return "Mencari..."; }
      }
    });

    // Event ketika produk dipilih
    $element.on('select2:select', function(e) {
      const $thisSelect = $(this);
      const $row = $thisSelect.closest('.produk-row');
      const data = e.params.data;
      
      // Ambil data dari option
      const $option = $thisSelect.find('option[value="' + data.id + '"]');
      const harga = parseFloat($option.data('harga')) || 0;
      const stok = parseInt($option.data('stok')) || 0;
      const nama = $option.data('nama') || $option.text();
      
      // Update hidden inputs
      const $hargaDisplay = $row.find('.harga-display');
      const $hargaInput = $row.find('.harga-input');
      const $stokInfo = $row.find('.stok-info');
      const $jumlahInput = $row.find('.jumlah-input');
      
      $hargaDisplay.val(formatAngka(harga));
      $hargaInput.val(harga); // Ini penting untuk dikirim ke server
      $stokInfo.text('Stok: ' + stok);
      $jumlahInput.attr('max', stok);
      $jumlahInput.val(1);
            
      // Panggil update total
      updateTotal();
    });

    // Event ketika dropdown di-clear
    $element.on('select2:clear', function(e) {
      const $row = $(this).closest('.produk-row');
      $row.find('.harga-display').val('0');
      $row.find('.harga-input').val('0');
      $row.find('.stok-info').text('');
      $row.find('.jumlah-input').attr('max', '');
      $row.find('.jumlah-input').val('1');
      updateTotal();
    });
  }

  $(document).ready(function() {
    
    // INISIALISASI SELECT2 PELANGGAN
    $('#pelanggan-select').select2({
      theme: 'bootstrap-5',
      width: '100%',
      tags: true, 
      placeholder: '-- Cari atau Ketik Nama Pelanggan --',
      allowClear: true,
      createTag: function (params) {
        var term = $.trim(params.term);
        if (term === '') { return null; }
        return { id: 'new_' + term, text: term, newTag: true }
      }
    });

    // INISIALISASI SELECT2 PRODUK PERTAMA
    initProdukSelect($('.produk-select').first());

    // EVENT PELANGGAN
    $('#pelanggan-select').on('select2:select', function (e) {
      var data = e.params.data;
      const $kolomBaru = $('#kolom-pelanggan-baru');
      const $hiddenInputId = $('#id_pelanggan_hidden');

      if (data.newTag) {
        $hiddenInputId.val('');
        $kolomBaru.slideDown();
        $('#nama_pelanggan_baru').val(data.text).prop('readonly', false).prop('required', true);
        $('#no_hp_baru').val('').prop('readonly', false).prop('required', true);
        $('#email_baru, #alamat_baru').val('').prop('readonly', false);
        setTimeout(() => $('#no_hp_baru').focus(), 100);
      } else {
        $hiddenInputId.val(data.id);
        const selectedOption = $(data.element);
        $('#nama_pelanggan_baru').val(selectedOption.data('nama') || '').prop('readonly', true);
        $('#no_hp_baru').val(selectedOption.data('hp') || '').prop('readonly', true);
        $('#email_baru').val(selectedOption.data('email') || '').prop('readonly', true);
        $('#alamat_baru').val(selectedOption.data('alamat') || '').prop('readonly', true);
        $kolomBaru.slideDown();
      }
    });
    
    $('#pelanggan-select').on('select2:unselect select2:clear', function (e) {
      $('#id_pelanggan_hidden').val('');
      $('#kolom-pelanggan-baru').slideUp();
      $('#nama_pelanggan_baru, #no_hp_baru, #email_baru, #alamat_baru').val('').prop('readonly', false);
    });

    // EVENT JUMLAH
    $(document).on('input', '.jumlah-input', function() {
      const max = parseInt($(this).attr('max')) || 999999;
      let jumlah = parseInt($(this).val()) || 0;
      
      if (jumlah > max) {
        $(this).val(max);
      }
      if (jumlah < 1) {
        $(this).val(1);
      }
      
      // Panggil updateTotal setelah input berubah
      setTimeout(updateTotal, 10);
    });

    // TAMBAH BARIS PRODUK
    $('#add-row').on('click', function() {
      rowCounter++;
      const newRowId = 'row-' + rowCounter;
      const $wrapper = $('#produk-wrapper');
      const produkOptions = $('.produk-select').first().html();
      
      const newRow = `
        <div class="row g-3 mb-3 produk-row align-items-end" data-row-id="${newRowId}">
          <div class="col-md-5">
            <div class="produk-label-wrapper">
                <label class="form-label">Produk</label>
                <small class="text-muted stok-info"></small> 
            </div>
            <select name="produk[]" class="form-select produk-select" required>
              ${produkOptions}
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah[]" class="form-control jumlah-input" min="1" placeholder="0" value="1" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Harga</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="text" class="form-control harga-display" placeholder="0" readonly>
              <input type="hidden" name="harga_satuan[]" class="harga-input" value="0">
            </div>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-row">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      `;
      
      $wrapper.append(newRow);
      
      // Inisialisasi Select2 untuk baris baru
      const $newSelect = $wrapper.find('[data-row-id="' + newRowId + '"] .produk-select');
      initProdukSelect($newSelect);
    });

    // HAPUS BARIS
    $(document).on('click', '.remove-row', function() {
      const $wrapper = $('#produk-wrapper');
      
      if ($wrapper.children('.produk-row').length > 1) {
        const $row = $(this).closest('.produk-row');
        
        if ($row.find('.produk-select').hasClass('select2-hidden-accessible')) {
          $row.find('.produk-select').select2('destroy');
        }
        
        $row.remove();
        updateTotal(); // Hitung ulang total setelah baris dihapus
      } else {
        alert('Minimal harus ada 1 baris produk');
      }
    });

    // METODE PEMBAYARAN
    $('#metode_pembayaran').on('change', function() {
      if ($(this).val() === 'qris') {
        $('#qris-preview').removeClass('d-none');
      } else {
        $('#qris-preview').addClass('d-none');
      }
    });

    // VALIDASI FORM
    $('#form-kasir').on('submit', function(e) {
      let adaProduk = false;
      $('.produk-select').each(function() {
        if ($(this).val()) {
          adaProduk = true;
          return false;
        }
      });
      
      if (!adaProduk) {
        e.preventDefault();
        alert('Pilih minimal 1 produk!');
        return false;
      }
      
      const pelangganVal = $('#pelanggan-select').val();
      if (!pelangganVal) {
        e.preventDefault();
        alert('Pilih atau masukkan nama pelanggan!');
        return false;
      }
      
      if (pelangganVal.startsWith('new_')) {
        const hp = $('#no_hp_baru').val().trim();
        if (!hp) {
          e.preventDefault();
          alert('No. HP pelanggan baru wajib diisi!');
          return false;
        }
      }
      
      if (!$('#metode_pembayaran').val()) {
        e.preventDefault();
        alert('Pilih metode pembayaran!');
        return false;
      }
      
      return true;
    });

    // Panggil sekali saat load untuk inisialisasi ringkasan (jika ada data lama)
    updateTotal();
  });
</script>
@endpush