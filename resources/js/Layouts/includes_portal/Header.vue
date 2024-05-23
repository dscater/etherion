<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { useInstitucion } from "@/composables/institucion/useInstitucion";
import { useCarritoStore } from "@/stores/carritoStore";
import { useMenuPortalStore } from "@/stores/menuPortalStore";
const carrito_store = useCarritoStore();
const menu_portal_store = useMenuPortalStore();
const { oInstitucion } = useInstitucion();
const { props } = usePage();
const user = props.auth.user;
var url_assets = "";
var url_principal = "";

const inicializaScriptsPage = () => {
    /*==================================================================
    [ Fixed Header ]*/
    var headerDesktop = $(".container-menu-desktop");
    var wrapMenu = $(".wrap-menu-desktop");

    if ($(".top-bar").length > 0) {
        var posWrapHeader = $(".top-bar").height();
    } else {
        var posWrapHeader = 0;
    }

    if ($(window).scrollTop() > posWrapHeader) {
        $(headerDesktop).addClass("fix-menu-desktop");
        $(wrapMenu).css("top", 0);
    } else {
        $(headerDesktop).removeClass("fix-menu-desktop");
        $(wrapMenu).css("top", posWrapHeader - $(this).scrollTop());
    }

    $(window).on("scroll", function () {
        if ($(this).scrollTop() > posWrapHeader) {
            $(headerDesktop).addClass("fix-menu-desktop");
            $(wrapMenu).css("top", 0);
        } else {
            $(headerDesktop).removeClass("fix-menu-desktop");
            $(wrapMenu).css("top", posWrapHeader - $(this).scrollTop());
        }
    });

    /*==================================================================
    [ Menu mobile ]*/
    $(".btn-show-menu-mobile").on("click", function () {
        $(this).toggleClass("is-active");
        $(".menu-mobile").slideToggle();
    });

    var arrowMainMenu = $(".arrow-main-menu-m");

    for (var i = 0; i < arrowMainMenu.length; i++) {
        $(arrowMainMenu[i]).on("click", function () {
            $(this).parent().find(".sub-menu-m").slideToggle();
            $(this).toggleClass("turn-arrow-main-menu-m");
        });
    }

    $(window).resize(function () {
        if ($(window).width() >= 992) {
            if ($(".menu-mobile").css("display") == "block") {
                $(".menu-mobile").css("display", "none");
                $(".btn-show-menu-mobile").toggleClass("is-active");
            }

            $(".sub-menu-m").each(function () {
                if ($(this).css("display") == "block") {
                    $(this).css("display", "none");
                    $(arrowMainMenu).removeClass("turn-arrow-main-menu-m");
                }
            });
        }
    });
};

const muestra_carrito = ref(false);
const abrirCarrito = () => {
    muestra_carrito.value = true;
};

const cierraCarrito = () => {
    muestra_carrito.value = false;
};

const listMenu = ref([
    {
        label: "Inicio",
        url: route("portal.inicio"),
        ruta: "portal.inicio",
    },
    {
        label: "Carrito",
        url: route("portal.carrito"),
        ruta: "portal.carrito",
    },
]);

const cambiarRuta = (ruta) => {
    menu_portal_store.setLoadingPage(true);
    menu_portal_store.setRutaActual(ruta);
};

const quitar = (index) => {
    carrito_store.deleteProducto(index);
};

onMounted(() => {
    url_assets = props.url_assets;
    url_principal = props.url_principal;
    inicializaScriptsPage();
});
</script>
<template>
    <!-- Header -->
    <header class="header-v4">
        <!-- Header desktop -->
        <div class="container-menu-desktop"
        >
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar"></div>

                    <div class="right-top-bar flex-w h-full">
                        <a
                            v-if="!user"
                            :href="url_principal + '/login'"
                            class="flex-c-m trans-04 p-lr-25"
                        >
                            <i class="fa fa-sign-in"></i>&nbsp; Iniciar Sesión
                        </a>
                        <a
                            v-if="user"
                            :href="url_principal + '/admin/inicio'"
                            class="flex-c-m trans-04 p-lr-25"
                        >
                            <i class="fa fa-user"></i>&nbsp;
                            {{ user.full_name }}
                        </a>
                        <a
                            v-if="user && user.tipo == 'CLIENTE'"
                            :href="url_principal + '/admin/orden_ventas'"
                            class="flex-c-m trans-04 p-lr-25"
                        >
                            <i class="fa fa-list"></i>&nbsp; Ordenes de venta
                        </a>
                        <a
                            href="#"
                            v-if="user"
                            class="flex-c-m trans-04 p-lr-25"
                            @click.prevent="
                                menu_portal_store.cambiarUrl(
                                    route('logout'),
                                    'post'
                                )
                            "
                        >
                            <i class="fa fa-sign-out"></i>&nbsp; Salir
                        </a>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop how-shadow1">
                <nav class="limiter-menu-desktop container">
                    <!-- Logo desktop -->
                    <a href="#" class="logo">
                        <img
                            v-if="oInstitucion"
                            :src="oInstitucion.url_logo"
                            alt="IMG-LOGO"
                        />
                        <img
                            v-else
                            :src="url_assets + '/images/icons/logo-01.png'"
                            alt="IMG-LOGO"
                        />
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <!-- active-menu -->
                        <ul class="main-menu">
                            <li
                                v-for="item in listMenu"
                            >
                                <Link
                                    :href="item.url"
                                    @click="cambiarRuta(item.ruta)"
                                    >{{ item.label }}</Link
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div
                            class="icon-header-item cl2 hov-cl2 trans-04 p-l-22 p-r-11 icon-header-noti text-white"
                            @click="abrirCarrito"
                            :data-notify="carrito_store.productos.length"
                        >
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div
            class="wrap-header-mobile"
            style="background-image: url('imgs/fondo_inicio3.jpg')"
        >
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <Link
                    :href="route('portal.inicio')"
                    @click="cambiarRuta(item.ruta)"
                >
                    <img
                        v-if="oInstitucion"
                        :src="oInstitucion.url_logo"
                        alt="IMG-LOGO" />
                    <img
                        v-else
                        :src="url_assets + '/images/icons/logo-01.png'"
                        alt="IMG-LOGO"
                /></Link>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <div
                    class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                    @click="abrirCarrito"
                    :data-notify="carrito_store.productos.length"
                >
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div
            class="menu-mobile"
        >
            <ul class="topbar-mobile">
                <!-- <li>
                    <div class="left-top-bar"></div>
                </li> -->

                <li>
                    <div class="right-top-bar flex-w h-full">
                        <a
                            v-if="!user"
                            :href="url_principal + '/login'"
                            class="flex-c-m p-lr-10 trans-04"
                        >
                            <i class="fa fa-sign-in"></i>&nbsp;Iniciar sesión
                        </a>
                        <a
                            v-if="user"
                            :href="url_principal + '/admin/inicio'"
                            class="flex-c-m trans-04 p-lr-10"
                        >
                            <i class="fa fa-user"></i>&nbsp;
                            {{ user.full_name }}
                        </a>
                        <a
                            v-if="user && user.tipo == 'CLIENTE'"
                            :href="url_principal + '/admin/orden_ventas'"
                            class="flex-c-m trans-04 p-lr-10"
                        >
                            <i class="fa fa-list"></i>&nbsp;
                        </a>
                        <a
                            href="#"
                            v-if="user"
                            class="flex-c-m trans-04 p-lr-10"
                            @click.prevent="
                                menu_portal_store.cambiarUrl(
                                    route('logout'),
                                    'post'
                                )
                            "
                        >
                            <i class="fa fa-sign-out"></i>&nbsp;
                        </a>
                    </div>
                </li>
            </ul>

            <ul class="main-menu-m">
                <li v-for="item in listMenu">
                    <Link :href="item.url">{{ item.label }}</Link>
                </li>
            </ul>
        </div>
    </header>

    <!-- Title page -->
    <section
        class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url('imgs/fondo_inicio3.jpg')"
    >
        <h2 class="ltext-105 cl0 txt-center">
            {{ oInstitucion.razon_social }}
        </h2>
    </section>

    <!-- Cart -->
    <div
        class="wrap-header-cart"
        :class="[muestra_carrito ? 'show-header-cart' : '']"
    >
        <div class="s-full" @click="cierraCarrito"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2"> Tú carrito </span>

                <div
                    class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04"
                    @click="cierraCarrito"
                >
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w">
                <ul
                    class="header-cart-wrapitem w-full"
                    v-if="carrito_store.productos.length > 0"
                >
                    <li
                        class="header-cart-item flex-w flex-t align-items-center"
                        v-for="(item, index) in carrito_store.productos"
                    >
                        <button class="quitar" @click="quitar(index)">
                            <i class="fa fa-times"></i>
                        </button>
                        <div class="header-cart-item-img">
                            <img
                                :src="item.producto.foto_productos[0].url_foto"
                                alt="IMG"
                            />
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a
                                href="#"
                                class="header-cart-item-name m-b-18 hov-cl1 trans-04"
                            >
                                {{ item.producto.descripcion }}
                            </a>

                            <span class="header-cart-item-info">
                                {{ item.cantidad }} x Bs. {{
                                    item.producto.precio_total
                                }}
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="w-full" v-if="carrito_store.productos.length > 0">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: Bs. {{ carrito_store.total_final }}
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <Link
                            :href="route('portal.carrito')"
                            @click="
                                cambiarRuta('portal.carrito');
                                cierraCarrito();
                            "
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10"
                        >
                            Ver carrito
                        </Link>
                    </div>
                </div>

                <div class="row" v-else>
                    <div class="col-12">
                        <h4 class="text-center text-md">
                            Aún no agregaste nada al carrito
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
