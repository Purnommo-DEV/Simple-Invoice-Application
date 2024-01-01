<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();

let tampung_listForm = ref([]);
let tampung_semuaPelanggan = ref([]);
let tampung_pelanggan_id = ref([]);
let barang = ref([]);
let tampung_daftarIsiKeranjang = ref([]);
let tampung_daftarProduk = ref([]);

const tampilModal = ref(false);
const sembunyikanModal = ref(true);

// console.log(barang);

onMounted(async () => {
    // Masukkan ke dlm sini fungsi yang akan menampilkan data
    listKolomForm();
    tampilSemuaPelanggan();
    tampilSemuaProduk();
});

// listKolomForm merupakan variable yang nantinya akan mengambil form yang akan diisi oleh penggun, form tersbut di ambil dari controller
const listKolomForm = async () => {
    let respon = await axios.get("/api/baru-data-faktur");
    tampung_listForm.value = respon.data;
};

const tampilSemuaPelanggan = async () => {
    let respon = await axios.get("/api/tampil-data-pelanggan");
    tampung_semuaPelanggan.value = respon.data.pelanggan;
};

const tambahKeKeranjang = (barang) => {
    const barangDlmKeranjang = {
        id: barang.id,
        kode_barang: barang.kode_barang,
        deskripsi: barang.deskripsi,
        harga_satuan: barang.harga_satuan,
        kuantitas: barang.kuantitas,
    };
    tampung_daftarIsiKeranjang.value.push(barangDlmKeranjang);
    tutupModal();
};

const hapusProduk = (i) => {
    tampung_daftarIsiKeranjang.value.splice(i, 1);
};

const tampilSemuaProduk = async () => {
    let respon = await axios.get("/api/tampil-data-produk");
    tampung_daftarProduk.value = respon.data.produk;
};

const bukaModal = () => {
    tampilModal.value = !tampilModal.value;
};

const tutupModal = () => {
    tampilModal.value = !sembunyikanModal.value;
};

const subTotal = () => {
    let total = 0;
    tampung_daftarIsiKeranjang.value.map((data) => {
        total = total + data.kuantitas * data.harga_satuan;
    });
    return total;
};

const Total = () => {
    return subTotal() - tampung_listForm.value.diskon;
};

const onSave = () => {
    if (tampung_daftarIsiKeranjang.value.length >= 1) {
        let subtotal = 0;
        subtotal = subTotal();

        let total = 0;
        total = Total();

        const formData = new FormData();
        formData.append(
            "faktur_barang",
            JSON.stringify(tampung_daftarIsiKeranjang.value)
        );
        formData.append("pelanggan_id", tampung_pelanggan_id.value);
        formData.append("tanggal", tampung_listForm.value.tanggal);
        formData.append("batas_waktu", tampung_listForm.value.batas_waktu);
        formData.append("nomor", tampung_listForm.value.nomor);
        formData.append("referensi", tampung_listForm.value.referensi);
        formData.append("diskon", tampung_listForm.value.diskon);
        formData.append("subtotal", subtotal);
        formData.append("total", total);
        formData.append(
            "syarat_dan_ketentuan",
            tampung_listForm.value.syarat_dan_ketentuan
        );

        axios.post("/api/tambah-data-faktur", formData);
        tampung_daftarIsiKeranjang.value = [];
        router.push("/");
    }
};
</script>
<template>
    <div class="container">
        <!--==================== NEW INVOICE ====================-->
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">New Invoice</h2>
                </div>
                <div></div>
            </div>

            <div class="card__content">
                <div class="card__content--header">
                    <div>
                        <p class="my-1">Pelanggan</p>
                        <select
                            name=""
                            id=""
                            class="input"
                            v-model="tampung_pelanggan_id"
                        >
                            <option disabled>Pilih Pelanggan</option>
                            <option
                                v-for="pelanggan in tampung_semuaPelanggan"
                                :value="pelanggan.id"
                                :key="pelanggan.id"
                            >
                                {{ pelanggan.nama_depan }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <p class="my-1">Tanggal</p>
                        <input
                            id="date"
                            placeholder="dd-mm-yyyy"
                            type="date"
                            class="input"
                            v-model="tampung_listForm.tanggal"
                        />
                        <!---->
                        <p class="my-1">Batas Waktu</p>
                        <input
                            id="due_date"
                            type="date"
                            class="input"
                            v-model="tampung_listForm.batas_waktu"
                        />
                    </div>
                    <div>
                        <p class="my-1">Nomor</p>
                        <input
                            type="text"
                            class="input"
                            v-model="tampung_listForm.nomor"
                        />
                        <p class="my-1">Referensi (Opsional)</p>
                        <input
                            type="text"
                            class="input"
                            v-model="tampung_listForm.referensi"
                        />
                    </div>
                </div>
                <br /><br />
                <div class="table">
                    <div class="table--heading2">
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                        <p></p>
                    </div>

                    <!-- item 1 -->
                    <div
                        class="table--items2"
                        v-for="(barangPilihan, i) in tampung_daftarIsiKeranjang"
                        :key="barangPilihan.id"
                    >
                        <p>
                            {{ barangPilihan.kode_barang }}
                            {{ barangPilihan.deskripsi }}
                        </p>
                        <p>
                            <input
                                type="text"
                                class="input"
                                v-model="barangPilihan.harga_satuan"
                            />
                        </p>
                        <p>
                            <input
                                type="text"
                                class="input"
                                v-model="barangPilihan.kuantitas"
                            />
                        </p>
                        <p v-if="barangPilihan.kuantitas">
                            {{
                                barangPilihan.kuantitas *
                                barangPilihan.harga_satuan
                            }}
                        </p>
                        <p v-else></p>
                        <p
                            style="color: red; font-size: 24px; cursor: pointer"
                            @click="hapusProduk(i)"
                        >
                            &times;
                        </p>
                    </div>
                    <div style="padding: 10px 30px !important">
                        <button
                            class="btn btn-sm btn__open--modal"
                            @click="bukaModal()"
                        >
                            Add New Line
                        </button>
                    </div>
                </div>

                <div class="table__footer">
                    <div class="document-footer">
                        <p>Terms and Conditions</p>
                        <textarea
                            cols="50"
                            rows="7"
                            class="textarea"
                            v-model="tampung_listForm.syarat_dan_ketentuan"
                        ></textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Sub Total</p>
                            <span>{{ subTotal() }}</span>
                        </div>
                        <div class="table__footer--discount">
                            <p>Discount</p>
                            <input
                                type="number"
                                class="input"
                                v-model="tampung_listForm.diskon"
                            />
                        </div>
                        <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>{{ Total() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card__header" style="margin-top: 40px">
                <div></div>
                <div>
                    <a class="btn btn-secondary" @click="onSave()"> Save </a>
                </div>
            </div>
        </div>
    </div>

    <!--==================== add modal items ====================-->
    <div class="modal main__modal" :class="{ show: tampilModal }">
        <div class="modal__content">
            <span class="modal__close btn__close--modal" @click="tutupModal()"
                >×</span
            >
            <h3 class="modal__title">Add Item</h3>
            <hr />
            <br />
            <div class="modal__items">
                <ul style="list-style: none">
                    <li
                        v-for="(produk, i) in tampung_daftarProduk"
                        :key="produk.id"
                    >
                        <p>{{ i + 1 }}</p>
                        <a>{{ produk.kode_barang }} - {{ produk.deskripsi }}</a>
                        <button
                            @click="tambahKeKeranjang(produk)"
                            style="border: 1px solid"
                        >
                            +
                        </button>
                    </li>
                </ul>
            </div>
            <br />
            <hr />
            <div class="model__footer">
                <button
                    class="btn btn-light mr-2 btn__close--modal"
                    @click="tutupModal()"
                >
                    Cancel
                </button>
                <button class="btn btn-light btn__close--modal">Save</button>
            </div>
        </div>
    </div>

    <br /><br /><br />
</template>
