@extends('layouts.sidebar')

@section('content')
<div class="container">
    <div class="row mb-3">
        <!-- Card Tagihan -->
        <div class="col-md-8">
            <div class="card p-3 shadow-sm h-100 d-flex justify-content-center">
                <h1 class="font-weight-bold m-0">Tagihan: Rp <span id="total_tagihan">0</span></h1>
            </div>
        </div>

        <!-- Card Informasi Nota -->
        <div class="col-md-4">
            <div class="card p-3 shadow-sm h-100">
                <label>Tanggal:</label>
                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>

                <label>Customer:</label>
                <input type="hidden" name="customer_id" id="customer_id">
                <input type="text" id="nama_customer" class="form-control" list="customerList" placeholder="Cari customer...">
                <datalist id="customerList">
                    @foreach($customerList as $customer)
                        <option data-id="{{ $customer->id }}" value="{{ $customer->nama_customer }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>

    <!-- Form Input Produk -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label>Nama Produk</label>
            <input type="hidden" name="produk_id" id="produk_id">
            <input type="text" id="nama_produk" class="form-control" list="produkList" placeholder="Cari produk...">
            <datalist id="produkList">
                @foreach($produkList as $produk)
                    <option data-id="{{ $produk->id }}" value="{{ $produk->nama_produk }}"></option>
                @endforeach
            </datalist>
        </div>

        <div class="col-md-3">
            <label>Harga Per Satuan</label>
            <input type="text" class="form-control" id="harga_satuan" readonly>
        </div>

        <div class="col-md-2">
            <label>Jumlah</label>
            <input type="number" class="form-control" id="jumlah" value="1" min="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div class="col-md-2">
            <label>Jenis Satuan</label>
            <select class="form-control" id="jenis_satuan">
                <!-- Opsi akan diisi dengan JavaScript -->
            </select>
        </div>

        <div class="col-md-2">
            <label>Harga Akhir</label>
            <input type="text" class="form-control" id="harga_akhir" readonly>
        </div>
    </div>

    <button class="btn btn-primary" id="simpan_item">Simpan Item</button>

    <!-- Tabel Barang Dibeli -->
    <div class="card mt-3 p-3">
        <h5>Barang Dibeli</h5>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Jenis Satuan</th>
                    <th>Harga Jual</th>
                    <th class="text-center">Opsi</th>
                </tr>
            </thead>
            <tbody id="tabel_barang">
                <!-- Data akan diisi dengan JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Card Subtotal, Diskon, dan Total Akhir -->
    <div class="d-flex justify-content-end">
        <div class="card mt-3 p-3 ms-auto" style="max-width: 400px;">
            <h5>Ringkasan Pembayaran</h5>
            
            <!-- Subtotal -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="me-2 mb-0">Subtotal:</label>
                <h4 class="mb-0">Rp <span id="subtotal">0</span></h4>
            </div>

            <!-- Diskon -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="me-2 mb-0">Diskon:</label>
                <input type="number" class="form-control w-100" id="diskon" placeholder="Masukkan diskon" value="" min="0" oninput="validity.valid||(value='');">
            </div>

            <!-- Total Akhir -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <label class="me-2 mb-0">Total Akhir:</label>
                <h4 class="mb-0">Rp <span id="total_akhir">0</span></h4>
            </div>

            <!-- Tombol Simpan & Batal -->
            <button class="btn btn-success btn-sm">Simpan</button>
        </div>
    </div>
</div>

<script>
   document.addEventListener("DOMContentLoaded", function () {
    const produkInput = document.getElementById("nama_produk");
    const hargaSatuanInput = document.getElementById("harga_satuan");
    const jumlahInput = document.getElementById("jumlah");
    const jenisSatuanSelect = document.getElementById("jenis_satuan");
    const hargaAkhirInput = document.getElementById("harga_akhir");
    const produkIdInput = document.getElementById("produk_id");
    const simpanItemBtn = document.getElementById("simpan_item");
    const tabelBarang = document.getElementById("tabel_barang");
    const totalTagihan = document.getElementById("total_tagihan");

    const subtotalElement = document.getElementById("subtotal");
    const diskonInput = document.getElementById("diskon");
    const totalAkhirElement = document.getElementById("total_akhir");

    let produkData = {
        @foreach($produkList as $produk)
            "{{ $produk->nama_produk }}": {
                id: "{{ $produk->id }}",
                hargaSatuan: "{{ $produk->harga_jual_per_satuan }}",
                hargaIsi: "{{ $produk->harga_jual_per_isi }}",
                isiPerSatuan: "{{ $produk->isi_per_satuan }}",
                satuanUtama: "{{ $produk->satuan }}",
                satuanKecil: "{{ $produk->jenis_isi }}"
            },
        @endforeach
    };

    produkInput.addEventListener("input", function () {
        const selectedProduk = produkData[this.value];
        if (selectedProduk) {
            produkIdInput.value = selectedProduk.id;
            hargaSatuanInput.value = selectedProduk.hargaSatuan;
            jumlahInput.value = 1;
            updateSatuanOptions(selectedProduk);
            updateHargaAkhir();
        }
    });

    jenisSatuanSelect.addEventListener("change", updateHargaAkhir);
    jumlahInput.addEventListener("input", updateHargaAkhir);

    function updateSatuanOptions(produk) {
        jenisSatuanSelect.innerHTML = "";
        let optionUtama = document.createElement("option");
        optionUtama.value = produk.satuanUtama;
        optionUtama.textContent = produk.satuanUtama;
        jenisSatuanSelect.appendChild(optionUtama);

        if (produk.satuanKecil) {
            let optionKecil = document.createElement("option");
            optionKecil.value = produk.satuanKecil;
            optionKecil.textContent = produk.satuanKecil;
            jenisSatuanSelect.appendChild(optionKecil);
        }
    }

    function updateHargaAkhir() {
        const selectedProduk = produkData[produkInput.value];
        if (!selectedProduk) return;

        let hargaAkhir = 0;
        let jumlah = jumlahInput.value || 1;

        if (jenisSatuanSelect.value === selectedProduk.satuanUtama) {
            hargaAkhir = selectedProduk.hargaSatuan * jumlah;
        } else if (jenisSatuanSelect.value === selectedProduk.satuanKecil && selectedProduk.isiPerSatuan > 0) {
            hargaAkhir = selectedProduk.hargaIsi * jumlah;
        }

        hargaAkhirInput.value = hargaAkhir.toFixed(2);
    }

    simpanItemBtn.addEventListener("click", function () {
        const namaProduk = produkInput.value;
        const hargaSatuan = hargaSatuanInput.value;
        const jumlah = jumlahInput.value;
        const jenisSatuan = jenisSatuanSelect.value;
        const hargaJual = hargaAkhirInput.value;

        if (!namaProduk || !hargaSatuan || !jumlah || !hargaJual) return;

        // Buat baris baru
        let row = tabelBarang.insertRow();
        row.setAttribute("data-harga", hargaJual); // Simpan harga sebagai atribut data-harga

        row.innerHTML = `
            <td>${namaProduk}</td>
            <td>Rp ${parseFloat(hargaSatuan).toLocaleString()}</td>
            <td>${jumlah}</td>
            <td>${jenisSatuan}</td>
            <td>Rp ${parseFloat(hargaJual).toLocaleString()}</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm" onclick="hapusItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        // Hitung ulang total tagihan dan subtotal
        updateTotalTagihan();
    });

    function updateTotalTagihan() {
        let total = 0;
        let rows = document.querySelectorAll("#tabel_barang tr");

        rows.forEach(row => {
            let harga = parseFloat(row.getAttribute("data-harga") || 0);
            total += harga;
        });

        subtotalElement.textContent = total.toLocaleString();
        totalTagihan.textContent = total.toLocaleString();

        // Perbarui total akhir dengan diskon
        updateTotalAkhir();
    }

    function updateTotalAkhir() {
        let subtotal = parseFloat(subtotalElement.textContent.replace(/,/g, "")) || 0;
        let diskon = parseFloat(diskonInput.value) || 0;
        let totalAkhir = subtotal - diskon;

        if (totalAkhir < 0) totalAkhir = 0; // Pastikan total akhir tidak negatif

        totalAkhirElement.textContent = totalAkhir.toLocaleString();
        totalTagihan.textContent = totalAkhir.toLocaleString(); // Perbarui total tagihan juga
    }

    diskonInput.addEventListener("input", updateTotalAkhir);

    function hapusItem(button) {
        let row = button.closest("tr");
        row.remove();

        updateTotalTagihan();
    }

    document.addEventListener("click", function (event) {
        if (event.target.closest(".btn-danger")) {
            hapusItem(event.target.closest(".btn-danger"));
        }
    });
});
</script>
@endsection
