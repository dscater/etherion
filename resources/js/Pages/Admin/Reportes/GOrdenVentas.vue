<script>
const breadbrums = [
    {
        title: "Inicio",
        disabled: false,
        url: route("inicio"),
        name_url: "inicio",
    },
    {
        title: "Reporte Gráfico Orden de Ventas",
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
import Highcharts from "highcharts";
import exporting from "highcharts/modules/exporting";
exporting(Highcharts);
Highcharts.setOptions({
    lang: {
        downloadPNG: "Descargar PNG",
        downloadJPEG: "Descargar JPEG",
        downloadPDF: "Descargar PDF",
        downloadSVG: "Descargar SVG",
        printChart: "Imprimir gráfico",
        contextButtonTitle: "Menú de exportación",
        viewFullscreen: "Pantalla completa",
        exitFullscreen: "Salir de pantalla completa",
    },
});

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
        label: "Categoría y Estado",
    },
    {
        value: "fechas",
        label: "Rango de Fechas",
    },
]);

const form = ref({
    filtro: "todos",
    categoria_id: "todos",
    estado: "todos",
    fecha_ini: "",
    fecha_fin: "",
});

const generando = ref(false);
const txtBtn = computed(() => {
    if (generando.value) {
        return "Generando Reporte...";
    }
    return "Generar Reporte";
});

const listCategorias = ref([]);
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

const cargaListas = async () => {
    listCategorias.value = await getCategorias();
    listCategorias.value.unshift({
        id: "todos",
        nombre: "TODOS",
    });
};

const formulario = ref(null);
const total_categorias = ref(0);
const generarReporte = async () => {
    const { valid } = await formulario.value.validate();
    if (valid) {
        generando.value = true;

        axios
            .get(route("reportes.r_g_orden_ventas"), { params: form.value })
            .then((response) => {
                total_categorias.value = response.data.categories.length;
                console.log(total_categorias.value);
                // Create the chart
                Highcharts.chart("container", {
                    chart: {
                        type: "column",
                    },
                    title: {
                        align: "center",
                        text: "ORDENES DE VENTA",
                    },
                    subtitle: {
                        align: "center",
                        useHTML: true,
                        text: `Total Monto: ${response.data.suma_total_monto}<br>Cantidad total:${response.data.suma_total_cantidad}`,
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true,
                        },
                    },
                    xAxis: {
                        categories: response.data.categories,
                        crosshair: true,
                        accessibility: {
                            description: "Producto",
                        },
                        labels: {
                            style: {
                                textOverflow: "ellipsis",
                                // whiteSpace: "nowrap",
                                fontSize: "10px",
                            },
                            rotation: -90,
                            align: "right",
                        },
                    },
                    yAxis: {
                        title: {
                            text: "Total",
                        },
                    },
                    legend: {
                        enabled: true,
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: "{point.y:.2f}",
                            },
                        },
                    },
                    series: response.data.series,
                });
                generando.value = false;
            });
    }
};

onMounted(() => {
    cargaListas();
});
</script>
<template>
    <Head title="Reporte Gráfico Orden de Ventas"></Head>
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
            <v-col cols="12" class="overflow-auto">
                <div
                    class="contenedor_grafico"
                    :style="[
                        total_categorias.length <= 4
                            ? 'min-width:600px'
                            : total_categorias.length <= 20
                            ? 'min-width:900px'
                            : 'min-width:1200px',
                        ,
                    ]"
                >
                    <div id="container"></div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<style>
/* .contenedor_grafico {
    min-width: 900px;
} */
#container {
    height: 700px;
}
</style>
