<script>
const breadbrums = [
    {
        title: "Inicio",
        disabled: false,
        url: route("inicio"),
        name_url: "inicio",
    },
    {
        title: "Orden de venta",
        disabled: false,
        url: "",
        name_url: "",
    },
];
</script>
<script setup>
import BreadBrums from "@/Components/BreadBrums.vue";
import { useApp } from "@/composables/useApp";
import { Head, router } from "@inertiajs/vue3";
import { useOrdenVentas } from "@/composables/orden_ventas/useOrdenVentas";
import { ref, onMounted } from "vue";
import { useMenu } from "@/composables/useMenu";
const { mobile, identificaDispositivo } = useMenu();
const { setLoading } = useApp();
onMounted(() => {
    identificaDispositivo();
    setTimeout(() => {
        setLoading(false);
    }, 300);
});

const {
    getOrdenVentasApi,
    setOrdenVenta,
    limpiarOrdenVenta,
    deleteOrdenVenta,
} = useOrdenVentas();
const responseOrdenVentas = ref([]);
const listOrdenVentas = ref([]);
const itemsPerPage = ref(5);
const headers = ref([
    {
        title: "Código Orden",
        align: "start",
        sortable: false,
    },
    {
        title: "Producto",
        align: "start",
        sortable: false,
    },
    {
        title: "Cantidad",
        align: "start",
        sortable: false,
    },
    {
        title: "Total Venta",
        align: "start",
        sortable: false,
    },
    {
        title: "Estado",
        align: "start",
        sortable: false,
    },
    {
        title: "Fecha de Registro",
        align: "start",
        sortable: false,
    },
]);

const search = ref("");
const options = ref({
    page: 1,
    itemsPerPage: itemsPerPage,
    sortBy: "",
    sortOrder: "desc",
    search: "",
});

const loading = ref(true);
const totalItems = ref(0);
let setTimeOutLoadData = null;
const loadItems = async ({ page, itemsPerPage, sortBy }) => {
    loading.value = true;
    options.value.page = page;
    if (sortBy.length > 0) {
        options.value.sortBy = sortBy[0].key;
        options.value.sortOrder = sortBy[0].order;
    }
    options.value.search = search.value;

    clearInterval(setTimeOutLoadData);
    setTimeOutLoadData = setTimeout(async () => {
        responseOrdenVentas.value = await getOrdenVentasApi(options.value);
        listOrdenVentas.value = responseOrdenVentas.value.data;
        totalItems.value = parseInt(responseOrdenVentas.value.total);
        loading.value = false;
    }, 300);
};

const verOrdenVenta = (item) => {
    console.log(item);
    router.get(route("orden_ventas.show", item.id));
};
</script>
<template>
    <Head title="Orden de venta"></Head>
    <v-container>
        <BreadBrums :breadbrums="breadbrums"></BreadBrums>
        <v-row class="mt-0">
            <v-col cols="12">
                <v-card flat>
                    <v-card-title>
                        <v-row class="bg-primary d-flex align-center pa-3">
                            <v-col cols="12" sm="6" md="4">
                                Orden de venta
                            </v-col>
                            <v-col cols="12" sm="6" md="4" offset-md="4">
                                <v-text-field
                                    v-model="search"
                                    label="Buscar"
                                    append-inner-icon="mdi-magnify"
                                    variant="underlined"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table-server
                            v-model:items-per-page="itemsPerPage"
                            :headers="!mobile ? headers : []"
                            :class="[mobile ? 'mobile' : '']"
                            :items-length="totalItems"
                            :items="listOrdenVentas"
                            :loading="loading"
                            :search="search"
                            @update:options="loadItems"
                            height="auto"
                            no-data-text="No se encontrarón registros"
                            loading-text="Cargando..."
                            page-text="{0} - {1} de {2}"
                            items-per-page-text="Registros por página"
                            :items-per-page-options="[
                                { value: 10, title: '10' },
                                { value: 25, title: '25' },
                                { value: 50, title: '50' },
                                { value: 100, title: '100' },
                                {
                                    value: -1,
                                    title: 'Todos',
                                },
                            ]"
                        >
                            <template v-slot:item="{ item }">
                                <tr v-if="!mobile">
                                    <td>{{ item.codigo }}</td>
                                    <td>{{ item.descripcion }}</td>
                                    <td>{{ item.cantidad }}</td>
                                    <td>
                                        {{ item.precio_sc }}
                                    </td>
                                    <td>
                                        <v-chip
                                            :color="
                                                [
                                                    item.estado == 'ENTREGA PENDIENTE'
                                                        ? 'primary'
                                                        : item.estado ==
                                                          'ENTREGADO'
                                                        ? 'success'
                                                        : item.estado ==
                                                          'DEVOLUCIÓN'
                                                        ? 'error'
                                                        : '',
                                                ][0]
                                            "
                                            class="text-caption"
                                            >{{ item.estado }}</v-chip
                                        >
                                    </td>
                                    <td>{{ item.fecha_registro_t }}</td>
                                </tr>
                                <tr v-else>
                                    <td>
                                        <ul class="flex-content">
                                            <li
                                                class="flex-item"
                                                data-label="Código Orden"
                                            >
                                                {{ item.codigo }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Producto:"
                                            >
                                                {{ item.nombre }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Cantidad:"
                                            >
                                                {{ item.cantidad }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Total:"
                                            >
                                                {{ item.precio_sc }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Estado:"
                                            >
                                                <v-chip
                                                    :color="
                                                        [
                                                            item.estado ==
                                                            'PENDIENTE'
                                                                ? 'primary'
                                                                : item.estado ==
                                                                  'ENTREGADO'
                                                                ? 'success'
                                                                : item.estado ==
                                                                  'DEVOLUCIÓN'
                                                                ? 'error'
                                                                : '',
                                                        ][0]
                                                    "
                                                    class="text-caption"
                                                    >{{ item.estado }}</v-chip
                                                >
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Fecha de Registro:"
                                            >
                                                {{ item.fecha_registro_t }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table-server>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
