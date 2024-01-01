<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

let tampung_faktur_detail = ref({ faktur_id: "" });
let tampung_barang_faktur = ref([]);

const props = defineProps({
    faktur_id: {
        type: String,
        default: "",
    },
});

onMounted(async () => {
    detailFaktur();
    listBarangFaktur();
});

const detailFaktur = async () => {
    let respon = await axios.get(`/api/faktur-detail/${props.faktur_id}`);
    tampung_faktur_detail.value = respon.data.faktur_detail;
};

const listBarangFaktur = async () => {
    let respon = await axios.get(`/api/list-barang-faktur/${props.faktur_id}`);
    tampung_barang_faktur.value = respon.data.list_barang_faktur;
};

const subTotalFakturBarang = () => {
    let total = 0;
    tampung_barang_faktur.value.map((data) => {
        total = total + data.harga_satuan * data.kuantitas;
    });
    return total;
};

const totalBayarFakturBarang = () => {
    return subTotalFakturBarang() - tampung_faktur_detail.value.diskon;
};
</script>

<template>
    <div class="container">
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoice</h2>
                </div>
                <div></div>
            </div>
            <div>
                <div class="card__header--title">
                    <h1 class="mr-2">#{{ tampung_faktur_detail.nomor }}</h1>
                    <p>July 17, 2020 at 3:28 am</p>
                </div>

                <div>
                    <ul class="card__header-list">
                        <li>
                            <!-- Select Btn Option -->
                            <button class="selectBtnFlat">
                                <i class="fas fa-print"></i>
                                Print
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                        <li>
                            <!-- Select Btn Option -->
                            <button class="selectBtnFlat">
                                <i class="fas fa-reply"></i>
                                Edit
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                        <li>
                            <!-- Select Btn Option -->
                            <button class="selectBtnFlat">
                                <i class="fas fa-pencil-alt"></i>
                                Delete
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table invoice">
                <div class="logo">
                    <!-- <img src="assets/img/logo.png" alt="" style="width: 200px" /> -->
                </div>
                <div class="invoice__header--title">
                    <p></p>
                    <p class="invoice__header--title-1">Invoice</p>
                    <p></p>
                </div>

                <div class="invoice__header--item">
                    <div>
                        <h2>Invoice To:</h2>
                        <p>Customer 1</p>
                    </div>
                    <div>
                        <div class="invoice__header--item1">
                            <p>Invoice#</p>
                            <span>#{{ tampung_faktur_detail.nomor }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Date</p>
                            <span>{{ tampung_faktur_detail.tanggal }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Due Date</p>
                            <span>{{ tampung_faktur_detail.batas_waktu }}</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Reference</p>
                            <span>{{ tampung_faktur_detail.referensi }}</span>
                        </div>
                    </div>
                </div>

                <div class="table py1">
                    <div class="table--heading3">
                        <p>#</p>
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                    </div>

                    <!-- item 1 -->
                    <div
                        class="table--items3"
                        v-for="(faktur_barang, i) in tampung_barang_faktur"
                        :key="faktur_barang.id"
                        v-if="tampung_barang_faktur.length > 0"
                    >
                        <p>{{ i + 1 }}</p>
                        <p>{{ faktur_barang.relasi_produk.deskripsi }}</p>
                        <p>{{ faktur_barang.relasi_produk.harga_satuan }}</p>
                        <p>{{ faktur_barang.kuantitas }}</p>
                        <p>
                            {{
                                faktur_barang.relasi_produk.harga_satuan *
                                faktur_barang.kuantitas
                            }}
                        </p>
                    </div>
                    <div class="table--items" v-else>
                        <p>Faktur tidak ditemukan</p>
                    </div>
                </div>

                <div class="invoice__subtotal">
                    <div>
                        <h2>Thank you for your business</h2>
                    </div>
                    <div>
                        <div class="invoice__subtotal--item1">
                            <p>Sub Total</p>
                            <span>{{ subTotalFakturBarang() }}</span>
                        </div>
                        <div class="invoice__subtotal--item2">
                            <p>Discount</p>
                            <span>{{ tampung_faktur_detail.diskon }}</span>
                        </div>
                    </div>
                </div>

                <div class="invoice__total">
                    <div>
                        <h2>Terms and Conditions</h2>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and
                            typesetting industry.
                        </p>
                    </div>
                    <div>
                        <div class="grand__total">
                            <div class="grand__total--items">
                                <p>Grand Total</p>
                                <span>{{ totalBayarFakturBarang() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card__footer">
                <div></div>
                <div>
                    <a class="btn btn-secondary"> Save </a>
                </div>
            </div>
        </div>
    </div>
    <br /><br /><br />
</template>
