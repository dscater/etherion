<script setup>
import { useMenu } from "@/composables/useMenu";
import { onMounted, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { useUser } from "@/composables/useUser";
const { oUser } = useUser();

// data
const {
    mobile,
    drawer,
    rail,
    width,
    menu_open,
    setMenuOpen,
    cambiarUrl,
    toggleDrawer,
} = useMenu();

const user_logeado = ref({
    permisos: [],
});

const submenus = {
    "reportes.productos": "Reportes",
    "reportes.productos": "Reportes",
    "reportes.orden_ventas": "Reportes",
    "reportes.ingresos_comision": "Reportes",
    "reportes.afiliados": "Reportes",
    "reportes.clientes": "Reportes",
    "reportes.g_orden_ventas": "Reportes",
    "reportes.g_ingresos_comision": "Reportes",
    "reportes.e_orden_ventas": "Reportes",
};

const route_current = ref("");

router.on("navigate", (event) => {
    route_current.value = route().current();
    if (mobile.value) {
        toggleDrawer(false);
    }
});

const { props: props_page } = usePage();

onMounted(() => {
    let route_actual = route().current();
    // buscar en submenus y abrirlo si uno de sus elementos esta activo
    setMenuOpen([]);
    if (submenus[route_actual]) {
        setMenuOpen([submenus[route_actual]]);
    }

    if (props_page.auth) {
        user_logeado.value = props_page.auth?.user;
    }

    setTimeout(() => {
        scrollActive();
    }, 300);
});

const scrollActive = () => {
    let sidebar = document.querySelector("#sidebar");
    let menu = null;
    let activeChild = null;
    if (sidebar) {
        menu = sidebar.querySelector(".v-navigation-drawer__content");
        activeChild = sidebar.querySelector(".active");
    }
    // Verifica si se encontró un hijo activo
    if (activeChild) {
        let offsetTop = activeChild.offsetTop - sidebar.offsetTop;
        setTimeout(() => {
            menu.scrollTo({
                top: offsetTop,
                behavior: "smooth", // desplazamiento suave
            });
        }, 500);
    }
};
</script>
<template>
    <v-navigation-drawer
        :permanent="!mobile"
        :temporary="mobile"
        v-model="drawer"
        class="border-0 elevation-2 __sidebar"
        :width="width"
        id="sidebar"
    >
        <v-sheet>
            <div
                class="w-100 d-flex flex-column align-center elevation-1 bg-primary pa-2 __info_usuario"
            >
                <v-avatar
                    class="mb-1"
                    color="blue-darken-4"
                    :size="`${!rail ? '64' : '32'}`"
                >
                    <v-img
                        cover
                        v-if="oUser.url_foto"
                        :src="oUser.url_foto"
                    ></v-img>
                    <span v-else class="text-h5">
                        {{ oUser.iniciales_nombre }}
                    </span>
                </v-avatar>
                <div v-show="!rail" class="text-caption font-weight-bold">
                    {{ oUser.tipo }}
                </div>
                <div v-show="!rail" class="text-body">
                    {{ oUser.full_name }}
                </div>
            </div>
        </v-sheet>

        <v-list class="mt-1 px-2" v-model:opened="menu_open">
            <v-list-item class="text-caption">
                <span v-if="rail && !mobile" class="text-center d-block"
                    ><v-icon>mdi-dots-horizontal</v-icon></span
                >
                <span v-else>INICIO</span></v-list-item
            >
            <v-list-item
                prepend-icon="mdi-home-outline"
                :class="[route_current == 'inicio' ? 'active' : '']"
                @click="cambiarUrl(route('inicio'))"
                link
            >
                <v-list-item-title>Inicio</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Inicio</v-tooltip
                >
            </v-list-item>
            <v-list-item
                class="text-caption"
                v-if="
                    oUser.permisos.includes('usuarios.index') ||
                    oUser.permisos.includes('productos.index') ||
                    oUser.permisos.includes('cateorias.index') ||
                    oUser.permisos.includes('producto_tamanos.index') ||
                    oUser.permisos.includes('clientes.index') ||
                    oUser.permisos.includes('afiliados.index') ||
                    oUser.permisos.includes('orden_ventas.index') ||
                    oUser.permisos.includes('orden_ventas.ventas') ||
                    oUser.permisos.includes('orden_ventas.show') ||
                    oUser.permisos.includes('pago_afiliados.show')
                "
            >
                <span v-if="rail && !mobile" class="text-center d-block"
                    ><v-icon>mdi-dots-horizontal</v-icon></span
                >
                <span v-else>ADMINISTRACIÓN</span></v-list-item
            >
            <v-list-item
                :class="[
                    route_current == 'pago_afiliados.index' ? 'active' : '',
                ]"
                v-if="oUser.permisos.includes('pago_afiliados.index')"
                prepend-icon="mdi-clipboard-check"
                @click="cambiarUrl(route('pago_afiliados.index'))"
                link
            >
                <v-list-item-title>Pago a Afiliados</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Pago a Afiliados</v-tooltip
                >
            </v-list-item>
            <v-list-item
                :class="[
                    route_current == 'orden_ventas.index' ||
                    route_current == 'orden_ventas.show'
                        ? 'active'
                        : '',
                ]"
                v-if="oUser.permisos.includes('orden_ventas.index')"
                prepend-icon="mdi-clipboard-edit"
                @click="cambiarUrl(route('orden_ventas.index'))"
                link
            >
                <v-list-item-title>{{
                    oUser.tipo != "CLIENTE" ? "Orden de Venta" : "Compras"
                }}</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >{{
                        oUser.tipo != "CLIENTE" ? "Orden de Venta" : "Compras"
                    }}</v-tooltip
                >
            </v-list-item>
            <v-list-item
                :class="[
                    route_current == 'orden_ventas.ventas' ? 'active' : '',
                ]"
                v-if="oUser.permisos.includes('orden_ventas.ventas')"
                prepend-icon="mdi-archive-check"
                @click="cambiarUrl(route('orden_ventas.ventas'))"
                link
            >
                <v-list-item-title>Ventas</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Ventas</v-tooltip
                >
            </v-list-item>
            <v-list-item
                :class="[route_current == 'productos.index' ? 'active' : '']"
                v-if="oUser.permisos.includes('productos.index')"
                prepend-icon="mdi-view-list"
                @click="cambiarUrl(route('productos.index'))"
                link
            >
                <v-list-item-title>{{
                    oUser.tipo != "CLIENTE" ? "Productos" : "Mis Productos"
                }}</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >{{
                        oUser.tipo != "CLIENTE" ? "Productos" : "Mis Productos"
                    }}</v-tooltip
                >
            </v-list-item>
            <v-list-item
                :class="[route_current == 'categorias.index' ? 'active' : '']"
                v-if="oUser.permisos.includes('categorias.index')"
                prepend-icon="mdi-tag-multiple"
                @click="cambiarUrl(route('categorias.index'))"
                link
            >
                <v-list-item-title>Categorías de Productos</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Categorías de Productos</v-tooltip
                >
            </v-list-item>
            <v-list-item
                :class="[
                    route_current == 'producto_tamanos.index' ? 'active' : '',
                ]"
                v-if="oUser.permisos.includes('producto_tamanos.index')"
                prepend-icon="mdi-ruler-square"
                @click="cambiarUrl(route('producto_tamanos.index'))"
                link
            >
                <v-list-item-title>Tamaño de Productos</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Tamaño de Productos</v-tooltip
                >
            </v-list-item>
            <v-list-item
                :class="[
                    route_current == 'configuracion_pagos.index'
                        ? 'active'
                        : '',
                ]"
                v-if="oUser.permisos.includes('configuracion_pagos.index')"
                prepend-icon="mdi-credit-card-edit"
                @click="cambiarUrl(route('configuracion_pagos.index'))"
                link
            >
                <v-list-item-title>Configuración de Pagos</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Configuración de Pagos</v-tooltip
                >
            </v-list-item>

            <v-list-item
                :class="[route_current == 'clientes.index' ? 'active' : '']"
                v-if="oUser.permisos.includes('clientes.index')"
                prepend-icon="mdi-account-group"
                @click="cambiarUrl(route('clientes.index'))"
                link
            >
                <v-list-item-title>Clientes</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Clientes</v-tooltip
                >
            </v-list-item>

            <v-list-item
                :class="[route_current == 'afiliados.index' ? 'active' : '']"
                v-if="oUser.permisos.includes('afiliados.index')"
                prepend-icon="mdi-account-group"
                @click="cambiarUrl(route('afiliados.index'))"
                link
            >
                <v-list-item-title>Afiliados</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Afiliados</v-tooltip
                >
            </v-list-item>

            <v-list-item
                :class="[route_current == 'usuarios.index' ? 'active' : '']"
                v-if="oUser.permisos.includes('usuarios.index')"
                prepend-icon="mdi-account-group"
                @click="cambiarUrl(route('usuarios.index'))"
                link
            >
                <v-list-item-title>Usuarios</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Usuarios</v-tooltip
                >
            </v-list-item>

            <v-list-item
                class="text-caption"
                v-if="
                    oUser.permisos.includes('reportes.productos') ||
                    oUser.permisos.includes('reportes.orden_ventas') ||
                    oUser.permisos.includes('reportes.ingresos_comision') ||
                    oUser.permisos.includes('reportes.afiliados') ||
                    oUser.permisos.includes('reportes.clientes') ||
                    oUser.permisos.includes('reportes.g_orden_ventas') ||
                    oUser.permisos.includes('reportes.g_ingresos_comision') ||
                    oUser.permisos.includes('reportes.e_orden_ventas')
                "
                ><span v-if="rail && !mobile" class="text-center d-block"
                    ><v-icon>mdi-dots-horizontal</v-icon></span
                >
                <span v-else>REPORTES</span></v-list-item
            >
            <!-- SUBGROUP -->
            <v-list-group
                value="Reportes"
                v-if="
                    oUser.permisos.includes('reportes.productos') ||
                    oUser.permisos.includes('reportes.orden_ventas') ||
                    oUser.permisos.includes('reportes.ingresos_comision') ||
                    oUser.permisos.includes('reportes.afiliados') ||
                    oUser.permisos.includes('reportes.clientes') ||
                    oUser.permisos.includes('reportes.g_orden_ventas') ||
                    oUser.permisos.includes('reportes.g_ingresos_comision') ||
                    oUser.permisos.includes('reportes.e_orden_ventas')
                "
            >
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-file-document-multiple"
                        title="Reportes"
                        :class="[
                            route_current == 'reportes.productos' ||
                            route_current == 'reportes.orden_ventas' ||
                            route_current == 'reportes.ingresos_comision' ||
                            route_current == 'reportes.afiliados' ||
                            route_current == 'reportes.clientes' ||
                            route_current == 'reportes.g_orden_ventas' ||
                            route_current == 'reportes.g_ingresos_comision' ||
                            route_current == 'reportes.e_orden_ventas'
                                ? 'active'
                                : '',
                        ]"
                    >
                        <v-tooltip
                            v-if="rail && !mobile"
                            color="white"
                            activator="parent"
                            location="end"
                            >Reportes</v-tooltip
                        ></v-list-item
                    >
                </template>
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.productos')"
                    prepend-icon="mdi-chevron-right"
                    title="Productos"
                    :class="[
                        route_current == 'reportes.productos' ? 'active' : '',
                    ]"
                    @click="cambiarUrl(route('reportes.productos'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Productos</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.orden_ventas')"
                    prepend-icon="mdi-chevron-right"
                    title="Lista Orden de Ventas"
                    :class="[
                        route_current == 'reportes.orden_ventas'
                            ? 'active'
                            : '',
                    ]"
                    @click="cambiarUrl(route('reportes.orden_ventas'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Lista Orden de Ventas</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.ingresos_comision')"
                    prepend-icon="mdi-chevron-right"
                    title="Ingresos por Comisión"
                    :class="[
                        route_current == 'reportes.ingresos_comision'
                            ? 'active'
                            : '',
                    ]"
                    @click="cambiarUrl(route('reportes.ingresos_comision'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Ingresos por Comisión</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.afiliados')"
                    prepend-icon="mdi-chevron-right"
                    title="Lista de Afiliados"
                    :class="[
                        route_current == 'reportes.afiliados' ? 'active' : '',
                    ]"
                    @click="cambiarUrl(route('reportes.afiliados'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Lista de Afiliados</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.clientes')"
                    prepend-icon="mdi-chevron-right"
                    title="Lista de Clientes"
                    :class="[
                        route_current == 'reportes.clientes' ? 'active' : '',
                    ]"
                    @click="cambiarUrl(route('reportes.clientes'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Lista de Clientes</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.g_orden_ventas')"
                    prepend-icon="mdi-chevron-right"
                    title="Gráfico Orden Ventas"
                    :class="[
                        route_current == 'reportes.g_orden_ventas'
                            ? 'active'
                            : '',
                    ]"
                    @click="cambiarUrl(route('reportes.g_orden_ventas'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Gráfico Orden Ventas</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="
                        oUser.permisos.includes('reportes.g_ingresos_comision')
                    "
                    prepend-icon="mdi-chevron-right"
                    title="Gráfico Ingresos Comisión"
                    :class="[
                        route_current == 'reportes.g_ingresos_comision'
                            ? 'active'
                            : '',
                    ]"
                    @click="cambiarUrl(route('reportes.g_ingresos_comision'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Gráfico Ingresos Comisión</v-tooltip
                    ></v-list-item
                >
                <v-list-item
                    v-if="oUser.permisos.includes('reportes.e_orden_ventas')"
                    prepend-icon="mdi-chevron-right"
                    title="Estado Orden de Ventas"
                    :class="[
                        route_current == 'reportes.e_orden_ventas'
                            ? 'active'
                            : '',
                    ]"
                    @click="cambiarUrl(route('reportes.e_orden_ventas'))"
                    link
                >
                    <v-tooltip
                        v-if="rail && !mobile"
                        color="white"
                        activator="parent"
                        location="end"
                        >Estado Orden de Ventas</v-tooltip
                    ></v-list-item
                >
            </v-list-group>
            <v-list-item class="text-caption"
                ><span v-if="rail && !mobile" class="text-center d-block"
                    ><v-icon>mdi-dots-horizontal</v-icon></span
                >
                <span v-else>OTROS</span></v-list-item
            >
            <v-list-item
                v-if="oUser.permisos.includes('institucions.index')"
                prepend-icon="mdi-cog-outline"
                :class="[route_current == 'institucions.index' ? 'active' : '']"
                @click="cambiarUrl(route('institucions.index'))"
                link
            >
                <v-list-item-title>Institución</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Institución</v-tooltip
                >
            </v-list-item>
            <v-list-item
                prepend-icon="mdi-account-circle"
                :class="[route_current == 'profile.edit' ? 'active' : '']"
                @click="cambiarUrl(route('profile.edit'))"
                link
            >
                <v-list-item-title>Perfil</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Perfil</v-tooltip
                >
            </v-list-item>
            <v-list-item
                prepend-icon="mdi-logout"
                @click="cambiarUrl(route('logout'), 'post')"
                link
            >
                <v-list-item-title>Salir</v-list-item-title>
                <v-tooltip
                    v-if="rail && !mobile"
                    color="white"
                    activator="parent"
                    location="end"
                    >Salir</v-tooltip
                >
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>
<style scoped></style>
