import { createRouter, createWebHistory } from "vue-router";

import fakturIndex from "../components/faktur/faktur.vue";

import tidakDitemukan from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        component: fakturIndex,
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
