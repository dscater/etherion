<script>
const breadbrums = [
    {
        title: "Inicio",
        disabled: false,
        url: route("inicio"),
        name_url: "inicio",
    },
    {
        title: "Reporte Ingresos por Comisión",
        disabled: false,
        url: "",
        name_url: "",
    },
];
</script>

<script setup>
import BreadBrums from "@/Components/BreadBrums.vue";
import { useApp } from "@/composables/useApp";
import { computed, onMounted, ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useProductoTamanos } from "@/composables/producto_tamanos/useProductoTamanos";
import { useCategorias } from "@/composables/categorias/useCategorias";

const { setLoading } = useApp();
const { getCategorias } = useCategorias();
const { getProductoTamanos } = useProductoTamanos();

onMounted(() => {
    setTimeout(() => {
        setLoading(false);
    }, 300);
});

const existe_validacion_fechas = ref(false);

const rules_fechas = ref([
    (value) => {
        if (value) {
            existe_validacion_fechas.value = false;
            return true;
        }
        existe_validacion_fechas.value = true;
        return "Debes seleccionar una fecha";
    },
]);

const listFiltro = ref([
    {
        value: "todos",
        label: "TODOS",
    },
    {
        value: "categoria",
        label: "Categoría, Tamaño y Estado",
    },
    {
        value: "fechas",
        label: "Rango de Fechas",
    },
]);

const form = ref({
    filtro: "todos",
    categoria_id: "todos",
    producto_tamano_id: "todos",
    estado: "todos",
    fecha_ini: "",
    fecha_fin: "",
    tipo: "pdf",
});

const generando = ref(false);
const txtBtn = computed(() => {
    if (generando.value) {
        return "Generando Reporte...";
    }
    return "Generar Reporte";
});

const listCategorias = ref([]);
const listProductoTamanos = ref([]);
const listEstados = ref([
    {
        id: "todos",
        nombre: "TODOS",
    },
    {
        id: "PENDIENTE",
        nombre: "PENDIENTE",
    },
    {
        id: "ENTREGA PENDIENTE",
        nombre: "ENTREGA PENDIENTE",
    },
    {
        id: "ENTREGADO",
        nombre: "ENTREGADO",
    },
    {
        id: "DEVOLUCIÓN",
        nombre: "DEVOLUCIÓN",
    },
]);
const listTipos = ref([
    {
        value: "pdf",
        label: "PDF",
    },
    {
        value: "excel",
        label: "EXCEL",
    },
]);

const cargaListas = async () => {
    listCategorias.value = await getCategorias();
    listCategorias.value.unshift({
        id: "todos",
        nombre: "TODOS",
    });
    listProductoTamanos.value = await getProductoTamanos();
    listProductoTamanos.value.unshift({
        id: "todos",
        nombre: "TODOS",
    });
};

const formulario = ref(null);

const generarReporte = async () => {
    const { valid } = await formulario.value.validate();
    if (valid) {
        generando.value = true;
        const url = route("reportes.r_ingresos_comision", form.value);
        window.open(url, "_blank");
        setTimeout(() => {
            generando.value = false;
        }, 500);
    }
};

onMounted(() => {
    cargaListas();
});
</script>
<template>
    <Head title="Reporte Ingresos por Comisión"></Head>
    <v-container>
        <BreadBrums :breadbrums="breadbrums"></BreadBrums>
        <v-row>
            <v-col cols="12" sm="12" md="12" xl="8" class="mx-auto">
                <v-card>
                    <v-card-item>
                        <v-container>
                            <v-form
                                @submit.prevent="generarReporte"
                                ref="formulario"
                            >
                                <v-row>
                                    <v-col cols="12">
                                        <v-select
                                            variant="outlined"
                                            density="compact"
                                            required
                                            :items="listFiltro"
                                            item-value="value"
                                            item-title="label"
                                            label="Tipo*"
                                            v-model="form.filtro"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        v-if="form.filtro == 'categoria'"
                                    >
                                        <v-select
                                            variant="outlined"
                                            density="compact"
                                            required
                                            :items="listCategorias"
                                            item-value="id"
                                            item-title="nombre"
                                            label="Categoría*"
                                            v-model="form.categoria_id"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        v-if="form.filtro == 'categoria'"
                                    >
                                        <v-select
                                            variant="outlined"
                                            density="compact"
                                            required
                                            :items="listProductoTamanos"
                                            item-value="id"
                                            item-title="nombre"
                                            label="Tamaño*"
                                            v-model="form.producto_tamano_id"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        v-if="form.filtro == 'categoria'"
                                    >
                                        <v-select
                                            variant="outlined"
                                            density="compact"
                                            required
                                            :items="listEstados"
                                            item-value="id"
                                            item-title="nombre"
                                            label="Estado*"
                                            v-model="form.estado"
                                        ></v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        v-if="form.filtro == 'fechas'"
                                    >
                                        <v-row>
                                            <v-col cols="6">
                                                <v-text-field
                                                    :hide-details="
                                                        !existe_validacion_fechas
                                                    "
                                                    type="date"
                                                    variant="outlined"
                                                    label="Fecha Inicio"
                                                    required
                                                    density="compact"
                                                    v-model="form.fecha_ini"
                                                    :rules="rules_fechas"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-text-field
                                                    :hide-details="
                                                        !existe_validacion_fechas
                                                    "
                                                    type="date"
                                                    variant="outlined"
                                                    label="Fecha Inicio"
                                                    required
                                                    density="compact"
                                                    v-model="form.fecha_fin"
                                                    :rules="rules_fechas"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-select
                                            variant="outlined"
                                            density="compact"
                                            required
                                            :items="listTipos"
                                            item-value="value"
                                            item-title="label"
                                            label="Tipo Reporte*"
                                            v-model="form.tipo"
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-btn
                                            color="blue-darken-2"
                                            block
                                            @click="generarReporte"
                                            :disabled="generando"
                                            v-text="txtBtn"
                                        ></v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-container>
                    </v-card-item>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
