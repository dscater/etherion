<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { useInstitucion } from "@/composables/institucion/useInstitucion";
const { oInstitucion } = useInstitucion();
const { props } = usePage();
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

    /*==================================================================
    [ Cart ]*/
    $(".js-show-cart").on("click", function () {
        $(".js-panel-cart").addClass("show-header-cart");
    });

    $(".js-hide-cart").on("click", function () {
        $(".js-panel-cart").removeClass("show-header-cart");
    });
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
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar"></div>

                    <div class="right-top-bar flex-w h-full">
                        <a
                            :href="url_principal + '/login'"
                            class="flex-c-m trans-04 p-lr-25"
                        >
                            <i class="fa fa-sign-in"></i>&nbsp; Iniciar Sesión
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
                            <li v-for="item in listMenu">
                                <Link :href="item.url">{{ item.label }}</Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m">
                        <div
                            class="icon-header-item cl2 hov-cl2 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                            data-notify="2"
                        >
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <Link :href="route('portal.inicio')">
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
                    class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                    data-notify="2"
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
        <div class="menu-mobile">
            <ul class="topbar-mobile">
                <!-- <li>
                    <div class="left-top-bar"></div>
                </li> -->

                <li>
                    <div class="right-top-bar flex-w h-full">
                        <a
                            :href="url_principal + '/login'"
                            class="flex-c-m p-lr-10 trans-04"
                        >
                            <i class="fa fa-sign-in"></i>&nbsp;Iniciar sesión
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

        <h1 class="text-sm text-center font-weight-bold ltext-101 mt-1">
            {{ oInstitucion.razon_social }}
        </h1>
    </header>

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2"> Your Cart </span>

                <div
                    class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart"
                >
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img
                                :src="url_assets + '/images/item-cart-01.jpg'"
                                alt="IMG"
                            />
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a
                                href="#"
                                class="header-cart-item-name m-b-18 hov-cl1 trans-04"
                            >
                                White Shirt Pleat
                            </a>

                            <span class="header-cart-item-info">
                                1 x $19.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img
                                :src="url_assets + '/images/item-cart-02.jpg'"
                                alt="IMG"
                            />
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a
                                href="#"
                                class="header-cart-item-name m-b-18 hov-cl1 trans-04"
                            >
                                Converse All Star
                            </a>

                            <span class="header-cart-item-info">
                                1 x $39.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img
                                :src="url_assets + '/images/item-cart-03.jpg'"
                                alt="IMG"
                            />
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a
                                href="#"
                                class="header-cart-item-name m-b-18 hov-cl1 trans-04"
                            >
                                Nixon Porter Leather
                            </a>

                            <span class="header-cart-item-info">
                                1 x $17.00
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $75.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a
                            href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10"
                        >
                            View Cart
                        </a>

                        <a
                            href="shoping-cart.html"
                            class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10"
                        >
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
