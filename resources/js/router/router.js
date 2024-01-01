import { createRouter, createWebHistory } from "vue-router";

import fakturIndex from "../components/faktur/faktur.vue";
import fakturTambah from "../components/faktur/tambah.vue";
import fakturDetail from "../components/faktur/detail.vue";
import tidakDitemukan from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        component: fakturIndex,
    },
    {
        path: "/faktur/baru",
        component: fakturTambah,
    },
    {
        path: "/faktur/detail/:faktur_id",
        component: fakturDetail,
        props: true,
    },
    {
        // "/:pathMatch(.*)*" -> Maksudnya belum diketahui
        path: "/:pathMatch(.*)*",
        component: tidakDitemukan,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
