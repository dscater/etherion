<script setup>
import { useApp } from "@/composables/useApp";
import { onMounted, ref, reactive, watch, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useCarritoStore } from "@/stores/carritoStore";
import { useConfiguracionPagos } from "@/composables/configuracion_pagos/useConfiguracionPagos";

import { useMenuPortalStore } from "@/stores/menuPortalStore";
const menu_portal_store = useMenuPortalStore();
menu_portal_store.setLoadingPage(true);
const carrito_store = useCarritoStore();

var url_assets = "";
const { props } = usePage();
const { getConfiguracionPagosPortal } = useConfiguracionPagos();
const user = props.auth.user;
const { setLoading } = useApp();

const quitar = (index) => {
    carrito_store.deleteProducto(index);
};

const actualizaCantidadMas = (index) => {
    let cantidad = carrito_store.productos[index].cantidad;
    cantidad++;
    carrito_store.actualizaCantidadProducto(index, cantidad);
};

const actualizaCantidadMenos = (index) => {
    let cantidad = carrito_store.productos[index].cantidad;
    if (cantidad > 1) {
        cantidad--;
        carrito_store.actualizaCantidadProducto(index, cantidad);
    }
};

const listConfiguracionPagos = ref([]);

const o_ordenVenta = reactive({
    codigo: "",
    configuracion_pago_id: "",
    celular: "",
    comprobante: "",
    lat: "",
    lng: "",
    total_sc: "",
    total: "",
    estado: "PENDIENTE",
});

const limpiaOrden = () => {
    o_ordenVenta.codigo = "";
    o_ordenVenta.configuracion_pago_id = "";
    o_ordenVenta.celular = "";
    o_ordenVenta.comprobante = "";
    o_ordenVenta.lat = "";
    o_ordenVenta.lng = "";
    o_ordenVenta.total_sc = "";
    o_ordenVenta.total = "";
    o_ordenVenta.estado = "PENDIENTE";
};

const comprobante = ref(null);
function cargaArchivo(e, key) {
    o_ordenVenta[key] = null;
    o_ordenVenta[key] = e.target.files[0];
}
const enviando = ref(false);
const errors = ref(null);
const registrarOrdenVenta = () => {
    enviando.value = true;
    let formData = new FormData();
    formData.append(
        "configuracion_pago_id",
        o_ordenVenta.configuracion_pago_id
            ? o_ordenVenta.configuracion_pago_id
            : ""
    );
    formData.append(
        "celular",
        o_ordenVenta.celular ? o_ordenVenta.celular : ""
    );
    formData.append(
        "comprobante",
        o_ordenVenta.comprobante ? o_ordenVenta.comprobante : ""
    );
    formData.append("lat", o_ordenVenta.lat ? o_ordenVenta.lat : "");
    formData.append("lng", o_ordenVenta.lng ? o_ordenVenta.lng : "");
    formData.append("total_sc", carrito_store.total_final);
    formData.append("total", carrito_store.total_final);
    formData.append("estado", o_ordenVenta.estado ? o_ordenVenta.estado : "");
    carrito_store.productos.forEach((elem) => {
        formData.append("productos[]", elem.producto.id);
        formData.append("cantidades[]", elem.cantidad);
        formData.append("precios[]", elem.precio);
        formData.append("precio_total[]", elem.precio_total);
    });

    let config = {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    };

    axios
        .post(route("orden_ventas.registraOrden"), formData, config)
        .then((response) => {
            limpiaOrden();
            carrito_store.vaciaCarrito();
            Swal.fire({
                icon: "success",
                title: "¡Enviado!",
                html: response.data.message,
                showConfirmButton: false,
                timer: 2000,
            });
        })
        .catch((error) => {
            enviando.value = false;
            if (error.response) {
                if (error.response.status === 422) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        html: `Debes completar todos los campos`,
                        showConfirmButton: true,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: `Aceptar`,
                    });
                    errors.value = error.response.data.errors;
                }
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
                        showConfirmButton: true,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: `Aceptar`,
                    });
                }
            }
        });
};

const cargaListas = async () => {
    listConfiguracionPagos.value = await getConfiguracionPagosPortal();
};

const getQr = computed(() => {
    if (o_ordenVenta.configuracion_pago_id != "") {
        let filter = listConfiguracionPagos.value.filter(
            (elem) => elem.id == o_ordenVenta.configuracion_pago_id
        )[0];
        return filter.url_qr;
    }
    return "";
});

const getNroCuenta = computed(() => {
    if (o_ordenVenta.configuracion_pago_id != "") {
        let filter = listConfiguracionPagos.value.filter(
            (elem) => elem.id == o_ordenVenta.configuracion_pago_id
        )[0];
        return filter.nro_cuenta;
    }
    return "";
});

let marker_map = null;

// GOOOGLE MAPS
const cargaMapaGoogle = async (lat, lng, drag = false, dir = "") => {
    o_ordenVenta.lat = lat;
    o_ordenVenta.lng = lng;
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
    marker_map = new AdvancedMarkerElement({
        map,
        position: { lat: lat, lng: lng },
        gmpDraggable: drag,
        // title:""
    });

    // Evento click sobre el mapa
    map.addListener("click", (event) => {
        const newPosition = event.latLng.toJSON();
        if (marker_map && marker_map.setMap) {
            marker_map.setMap(null); // Eliminar el marcador anterior si existe
        }
        marker_map = new AdvancedMarkerElement({
            map,
            position: newPosition,
            gmpDraggable: drag,
        });
        o_ordenVenta.lat = "" + newPosition.lat;
        o_ordenVenta.lng = "" + newPosition.lng;
        infoWindow.close();
    });

    // Escucha el evento de arrastrar del marcador
    marker_map.addListener("dragend", (event) => {
        const position = marker_map.position;
        // console.log(position.lat);
        // console.log(position.lng);
        o_ordenVenta.lat = "" + position.lat;
        o_ordenVenta.lng = "" + position.lng;
        console.log(o_ordenVenta.lat);
        console.log(o_ordenVenta.lng);
        // infoWindow.close();
        // infoWindow.setContent(
        //     `Pin dropped at: ${position.lat}, ${position.lng}`
        // );
        // infoWindow.open(AME.map, AME);
    });

    // evento click sobre el marcador
    infoWindow.close();
    infoWindow.setContent("Ubicación Entrega");
    marker_map.addListener("click", () => {
        infoWindow.open(marker_map.map, marker_map);
    });
};
// FIN GOOGLE MAP

onMounted(() => {
    cargaMapaGoogle("-16.496059", "-68.133345", true);
    carrito_store.inicializaCarrito();
    cargaListas();
    url_assets = props.url_assets;
    setTimeout(() => {
        menu_portal_store.setLoadingPage(false);
    }, 300);
});
</script>
<template>
    <Head title="Carrito"></Head>

    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Producto</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Precio</th>
                                    <th class="column-4">Cantidad</th>
                                    <th class="column-5">Total</th>
                                </tr>

                                <tr
                                    class="table_row"
                                    v-if="carrito_store.productos.length > 0"
                                    v-for="(
                                        item, index
                                    ) in carrito_store.productos"
                                >
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <button
                                                type="button"
                                                class="quitar"
                                                @click="quitar(index)"
                                            >
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <img
                                                :src="
                                                    item.producto
                                                        .foto_productos[0]
                                                        .url_foto
                                                "
                                                alt="IMG"
                                            />
                                        </div>
                                    </td>
                                    <td class="column-2">
                                        {{ item.producto.descripcion }}
                                    </td>
                                    <td class="column-3">
                                        Bs. {{ item.producto.precio_total }}
                                    </td>
                                    <td class="column-4">
                                        <div
                                            class="wrap-num-product flex-w m-l-auto m-r-0"
                                        >
                                            <div
                                                class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                @click="
                                                    actualizaCantidadMenos(
                                                        index
                                                    )
                                                "
                                            >
                                                <i
                                                    class="fs-16 zmdi zmdi-minus"
                                                ></i>
                                            </div>

                                            <input
                                                class="mtext-104 cl3 txt-center num-product"
                                                type="number"
                                                name="num-product1"
                                                :value="item.cantidad"
                                            />

                                            <div
                                                class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                @click="
                                                    actualizaCantidadMas(index)
                                                "
                                            >
                                                <i
                                                    class="fs-16 zmdi zmdi-plus"
                                                ></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-5">
                                        Bs. {{ item.precio_total }}
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="5" class="text-center">
                                        NO SE AGREGÓ NINGÚN PRODUCTO
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div
                        class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm"
                    >
                        <h4 class="mtext-109 text-center pb-3 bor12">
                            Información orden de venta
                        </h4>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-con">
                                    <label>Seleccionar:</label>
                                    <select
                                        v-model="
                                            o_ordenVenta.configuracion_pago_id
                                        "
                                        class="form-control"
                                    >
                                        <option value="">- Seleccione -</option>
                                        <option
                                            v-for="item in listConfiguracionPagos"
                                            :value="item.id"
                                        >
                                            {{ item.banco }}
                                        </option>
                                    </select>
                                    <div class="error">{{}}</div>
                                </div>
                            </div>
                            <div
                                class="col-12"
                                v-if="o_ordenVenta.configuracion_pago_id != ''"
                            >
                                <div class="row mt-2">
                                    <div class="col-12">
                                        Nro. de Cuenta:
                                        <span v-text="getNroCuenta"></span>
                                    </div>
                                    <div class="col-12 p-2">
                                        <img :src="getQr" class="w-100" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label>Selecciona tu ubicación:</label>
                                <div id="google_map"></div>
                            </div>
                            <div class="col-12 mt-2">
                                <label>Cargar comprobante:</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    ref="comprobante"
                                    @change="
                                        cargaArchivo($event, 'comprobante')
                                    "
                                />
                            </div>
                            <div class="col-12 mt-2">
                                <label>Celular:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="o_ordenVenta.celular"
                                />
                            </div>
                        </div>

                        <div
                            class="flex-w flex-t p-t-27 p-b-33 align-items-center"
                        >
                            <div class="size-208">
                                <span class="mtext-101 cl2"> Total: </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="ltext-102 cl2">
                                    Bs. {{ carrito_store.total_final }}
                                </span>
                            </div>
                        </div>
                        <div class="bor12"></div>
                        <button
                            type="button"
                            v-if="
                                user &&
                                user.tipo == 'CLIENTE' &&
                                carrito_store.productos.length > 0
                            "
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                            @click="registrarOrdenVenta"
                        >
                            Confirmar orden de venta
                        </button>
                        <div
                            v-if="user && user.tipo != 'CLIENTE'"
                            class="text-info text-center mt-3"
                        >
                            DEBES INICIAR SESIÓN COMO
                            <strong>CLIENTE</strong> PARA PODER REALIZAR
                            COMPRA<br />
                            <a :href="route('login')">Inicar sesión</a>
                        </div>
                        <div v-if="!user" class="text-center mt-3">
                            DEBES INICIAR SESIÓN PARA PROCEDER CON LA COMPRA<br />
                            <a :href="route('login')">Inicar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<style scoped>
#google_map {
    width: 100%;
    height: 300px;
}
</style>
