<script>
const breadbrums = [
    {
        title: "Inicio",
        disabled: false,
        url: route("inicio"),
        name_url: "inicio",
    },
    {
        title: "Orden de Venta",
        disabled: false,
        url: route("orden_ventas.index"),
        name_url: "orden_ventas.index",
    },
    {
        title: "Detalle de Orden",
        disabled: false,
        url: "",
        name_url: "",
    },
];
</script>
<script setup>
import BreadBrums from "@/Components/BreadBrums.vue";
import { useApp } from "@/composables/useApp";
import { Head, router, usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { useMenu } from "@/composables/useMenu";
import Comprobante from "./Comprobante.vue";
import { useOrdenVentas } from "@/composables/orden_ventas/useOrdenVentas";
const { props: props_page } = usePage();

const { deleteOrdenVenta } = useOrdenVentas();
const props = defineProps({
    orden_venta: {
        type: Object,
        default: null,
    },
});
const { mobile, identificaDispositivo, cambiarUrl } = useMenu();
const { setLoading } = useApp();

const accion_dialog = ref(0);
const open_dialog = ref(false);
const url_comprobante = ref("");
const tipo_comprobante = ref("");

const cargaMapaGoogle = async (lat, lng, drag = false, dir = "") => {
    lat = parseFloat(lat);
    lng = parseFloat(lng);
    // Inicializa el mapa
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const map = new Map(document.getElementById("google_map"), {
        zoom: 18,
        center: { lat: lat, lng: lng },
        mapId: mapa_id,
    });
    const infoWindow = new InfoWindow();
    // Crea un marcador en el centro del mapa
    const marker_map = new AdvancedMarkerElement({
        map,
        position: { lat: lat, lng: lng },
        gmpDraggable: drag,
        // title:""
    });

    // evento click sobre el marcador
    infoWindow.close();
    infoWindow.setContent("Ubicación Entrega");
    marker_map.addListener("click", () => {
        infoWindow.open(marker_map.map, marker_map);
    });
};

const verComprobante = (url, tipo) => {
    accion_dialog.value = 0;
    open_dialog.value = true;
    url_comprobante.value = url;
    tipo_comprobante.value = tipo;
};

const actualizaEstado = () => {
    Swal.fire({
        title: "Quieres cambiar el estado de la Orden de Venta a:",
        html: `<strong>ENTRENGA PENDIENTE</strong>`,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Si, continuar",
        cancelButtonText: "No, cancelar",
        denyButtonText: `No, cancelar`,
    }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            axios
                .patch(
                    route(
                        "orden_ventas.actualiza_estado",
                        props.orden_venta.id
                    ),
                    {
                        estado: "ENTREGA PENDIENTE",
                    }
                )
                .then((response) => {
                    props.orden_venta.estado = response.data.orden_venta.estado;
                    Swal.fire({
                        icon: "success",
                        title: "Correcto",
                        text: `${response.data.message}`,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: `Aceptar`,
                    });
                })
                .catch((error) => {
                    enviando.value = false;
                    if (error.response) {
                        if (
                            error.response.status === 420 ||
                            error.response.status === 419 ||
                            error.response.status === 401
                        ) {
                            window.location = "/";
                        }
                        if (error.response.status === 500) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: error.response.data.message,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: `Aceptar`,
                            });
                        }
                    }
                });
        }
    });
};

const eliminarOrdenVenta = () => {
    Swal.fire({
        title: "¿Quierés eliminar este registro?",
        html: `<strong>${props.orden_venta.codigo}</strong>`,
        showCancelButton: true,
        confirmButtonColor: "#B61431",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        denyButtonText: `No, cancelar`,
    }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let respuesta = await deleteOrdenVenta(props.orden_venta.id);
            if (respuesta && respuesta.sw) {
                cambiarUrl(route("orden_ventas.index"));
            }
        }
    });
};

onMounted(() => {
    console.log(props_page.auth.user.permisos);
    identificaDispositivo();
    cargaMapaGoogle(props.orden_venta.lat, props.orden_venta.lng);
    setTimeout(() => {
        setLoading(false);
    }, 300);
});
</script>
<template>
    <Head title="Detalle de Orden"></Head>
    <v-container>
        <BreadBrums :breadbrums="breadbrums"></BreadBrums>
        <v-row class="mt-0">
            <v-col cols="12" class="d-flex justify-end">
                <template v-if="mobile">
                    <v-btn
                        icon="mdi-arrow-left"
                        class="mr-2"
                        @click="cambiarUrl(route('orden_ventas.index'))"
                    ></v-btn>
                </template>
                <template v-if="!mobile">
                    <v-btn
                        prepend-icon="mdi-arrow-left"
                        class="mr-2"
                        @click="cambiarUrl(route('orden_ventas.index'))"
                    >
                        Volver</v-btn
                    >
                </template>
            </v-col>
        </v-row>
        <v-row class="mt-0">
            <v-col cols="12">
                <v-card flat>
                    <v-card-title>
                        <v-row class="bg-primary d-flex align-center pa-3">
                            <v-col cols="12" sm="6" md="4">
                                Orden de venta
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-row class="pt-3">
                            <v-col cols="12" md="6">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        class="text-right font-weight-bold"
                                        >Código:</v-col
                                    >
                                    <v-col cols="8">{{
                                        orden_venta.codigo
                                    }}</v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        class="text-right font-weight-bold"
                                        >Cliente:</v-col
                                    >
                                    <v-col cols="8">{{
                                        orden_venta.user.full_name
                                    }}</v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        class="text-right font-weight-bold"
                                        >Forma de Pago:</v-col
                                    >
                                    <v-col cols="8"
                                        >{{
                                            orden_venta.configuracion_pago.banco
                                        }}
                                        <span class="text-caption"
                                            >({{
                                                orden_venta.configuracion_pago
                                                    .nro_cuenta
                                            }})</span
                                        ></v-col
                                    >
                                </v-row>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        class="text-right font-weight-bold"
                                        >Celular:</v-col
                                    >
                                    <v-col cols="8">{{
                                        orden_venta.celular
                                    }}</v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        md="2"
                                        class="text-right font-weight-bold"
                                        >Ubicación:</v-col
                                    >
                                    <v-col cols="8" md="10">
                                        <div id="google_map"></div>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        md="2"
                                        class="text-right font-weight-bold"
                                        >Comprobante de pago:</v-col
                                    >
                                    <v-col cols="8" md="10">
                                        <v-btn
                                            color="primary"
                                            size="small"
                                            class="pa-1 ma-1"
                                            @click="
                                                verComprobante(
                                                    orden_venta.url_comprobante,
                                                    orden_venta.tipo
                                                )
                                            "
                                            icon="mdi-open-in-new"
                                        ></v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        md="2"
                                        class="text-right font-weight-bold"
                                        >Productos:</v-col
                                    >
                                    <v-col cols="8" md="10">
                                        <v-table>
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th class="text-right">
                                                        Subtotal
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        item, index
                                                    ) in orden_venta.orden_detalles"
                                                >
                                                    <td>{{ index + 1 }}</td>
                                                    <td>
                                                        {{
                                                            item.producto
                                                                .descripcion
                                                        }}
                                                    </td>
                                                    <td>{{ item.cantidad }}</td>
                                                    <td>
                                                        {{
                                                            item.producto
                                                                .precio_total
                                                        }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ item.precio_total }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        colspan="4"
                                                        class="text-right font-weight-bold"
                                                    >
                                                        TOTAL
                                                    </td>
                                                    <td class="text-right">
                                                        {{ orden_venta.total }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </v-table>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-row>
                                    <v-col
                                        cols="4"
                                        md="2"
                                        class="text-right font-weight-bold"
                                        >Estado:</v-col
                                    >
                                    <v-col cols="8" md="10">
                                        <v-chip
                                            :color="
                                                [
                                                    props.orden_venta.estado == 'ENTREGA PENDIENTE'
                                                        ? 'primary'
                                                        : props.orden_venta.estado ==
                                                          'ENTREGADO'
                                                        ? 'success'
                                                        : props.orden_venta.estado ==
                                                          'DEVOLUCIÓN'
                                                        ? 'error'
                                                        : '',
                                                ][0]
                                            "
                                            >{{
                                                props.orden_venta.estado
                                            }}</v-chip
                                        >
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col
                                cols="12"
                                v-if="
                                    props_page.auth.user.permisos.includes(
                                        'orden_ventas.update_estado'
                                    ) ||
                                    props_page.auth.user.permisos.includes(
                                        'orden_ventas.destroy'
                                    )
                                "
                            >
                                <v-row>
                                    <v-col
                                        cols="4"
                                        md="2"
                                        class="text-right font-weight-bold"
                                        >Acciones:</v-col
                                    >
                                    <v-col cols="8" md="10">
                                        <v-btn
                                            v-if="
                                                props.orden_venta.estado ==
                                                    'PENDIENTE' &&
                                                props_page.auth.user.permisos.includes(
                                                    'orden_ventas.update_estado'
                                                )
                                            "
                                            color="primary"
                                            prepend-icon="mdi-pencil"
                                            block
                                            class="mb-2"
                                            @click="actualizaEstado"
                                        >
                                            Entrega Pendiente
                                        </v-btn>
                                        <v-btn
                                            v-if="
                                                props_page.auth.user.permisos.includes(
                                                    'orden_ventas.destroy'
                                                )
                                            "
                                            color="error"
                                            prepend-icon="mdi-trash-can"
                                            block
                                            @click="eliminarOrdenVenta"
                                        >
                                            Eliminar Orden
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <Comprobante
            :open_dialog="open_dialog"
            :accion_dialog="accion_dialog"
            :tipo="tipo_comprobante"
            :url_comprobante="url_comprobante"
            @cerrar-dialog="open_dialog = false"
        ></Comprobante>
    </v-container>
</template>

<style scoped>
#google_map {
    width: 100%;
    height: 300px;
}
</style>
