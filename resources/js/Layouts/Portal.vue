<script setup>
// includes
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";
import Header from "./includes_portal/Header.vue";
import Footer from "./includes_portal/Footer.vue";
import { useMenuPortalStore } from "@/stores/menuPortalStore";
const menu_portal_store = useMenuPortalStore();
menu_portal_store.setLoadingPage(true);

var url_assets = "";

const { props } = usePage();

const inicializaScriptsPage = () => {
    // SCROLL DESDE ABAJO
    var windowH = $(window).height() / 2;

    $(window).on("scroll", function () {
        if ($(this).scrollTop() > windowH) {
            $("#myBtn").css("display", "flex");
        } else {
            $("#myBtn").css("display", "none");
        }
    });

    $("#myBtn").on("click", function () {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            300
        );
    });
    // Initiate the wowjs
    new WOW().init();

    // OPCIONAL
    $(".js-addwish-b2").on("click", function (e) {
        e.preventDefault();
    });

    $(".js-addwish-b2").each(function () {
        var nameProduct = $(this).parent().parent().find(".js-name-b2").html();
        $(this).on("click", function () {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass("js-addedwish-b2");
            $(this).off("click");
        });
    });

    $(".js-addwish-detail").each(function () {
        var nameProduct = $(this)
            .parent()
            .parent()
            .parent()
            .find(".js-name-detail")
            .html();

        $(this).on("click", function () {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass("js-addedwish-detail");
            $(this).off("click");
        });
    });

    /*---------------------------------------------*/

    $(".js-addcart-detail").each(function () {
        var nameProduct = $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".js-name-detail")
            .html();
        $(this).on("click", function () {
            swal(nameProduct, "is added to cart !", "success");
        });
    });
    // FIN OPCIONAL

    $(".js-select2").each(function () {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next(".dropDownSelect2"),
        });
    });

    $(".parallax100").parallax100();

    $(".gallery-lb").each(function () {
        // the containers for all your galleries
        $(this).magnificPopup({
            delegate: "a", // the selector for gallery item
            type: "image",
            gallery: {
                enabled: true,
            },
            mainClass: "mfp-fade",
        });
    });

    $(".js-pscroll").each(function () {
        $(this).css("position", "relative");
        $(this).css("overflow", "hidden");
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on("resize", function () {
            ps.update();
        });
    });
};

onMounted(() => {
    url_assets = props.url_assets;
    inicializaScriptsPage();
});
</script>
<template>
    <div class="animsitio">
        <div class="loadingPage" v-show="menu_portal_store.loadingPage">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        <Header></Header>

        <slot></slot>

        <Footer></Footer>

        <!-- Back to top -->
        <div class="btn-back-to-top" id="myBtn">
            <span class="symbol-btn-back-to-top">
                <i class="zmdi zmdi-chevron-up"></i>
            </span>
        </div>
    </div>
</template>