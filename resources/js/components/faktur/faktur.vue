<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

let tampung_faktur = ref([]);
let cariDataIni = ref([]);

onMounted(async () => {
    tampilDataFaktur();
});

const tampilDataFaktur = async () => {
    let respon = await axios.get("/api/tampil-data-faktur");
    tampung_faktur.value = respon.data.faktur;
};

const cariDataFaktur = async () => {
    let respon = await axios.get(
        "/api/cari-data-faktur?cari=" + cariDataIni.value
    );
    tampung_faktur.value = respon.data.faktur;
};

const fakturBaru = async () => {
    let form = await axios.get("/api/baru-data-faktur");
    router.push("/faktur/baru");
};

const tampilDetailFaktur = (id) => {
    router.push("/faktur/detail/" + id);
};
</script>

<template>
    <div class="container">
        <!--==================== INVOICE LIST ====================-->
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoices</h2>
                </div>
                <div>
                    <a class="btn btn-secondary" @click="fakturBaru">
                        New Invoice
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                    <span class="table--filter--collapseBtn">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p
                                    class="table--filter--link table--filter--link--active"
                                >
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link">Paid</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search"></i>
                        <input
                            class="table--search--input"
                            type="text"
                            placeholder="Search invoice"
                            v-model="cariDataIni"
                            @keyup="cariDataFaktur()"
                        />
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Number</p>
                    <p>Customer</p>
                    <p>Due Date</p>
                    <p>Total</p>
                </div>

                <!-- item 1 -->
                <div
                    class="table--items"
                    v-for="item in tampung_faktur"
                    :key="item.id"
                    v-if="tampung_faktur.length > 0"
                >
                    <a href="#" @click="tampilDetailFaktur(item.id)"
                        >#{{ item.id }}
                    </a>
                    <p>{{ item.tanggal }}</p>
                    <p>{{ item.nomor }}</p>
                    <p v-if="item.relasi_pelanggan">
                        {{ item.relasi_pelanggan.nama_depan }} &nbsp;
                        {{ item.relasi_pelanggan.nama_belakang }}
                    </p>
                    <p v-else></p>
                    <p>{{ item.batas_waktu }}</p>
                    <p>{{ item.total }}</p>
                </div>
                <div class="table--items" v-else>
                    <p>Faktur tidak ditemukan</p>
                </div>
            </div>
        </div>
    </div>
</template>
