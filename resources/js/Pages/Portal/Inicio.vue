<script setup>
import { useApp } from "@/composables/useApp";
import { onMounted, ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
var url_assets = "";
const { props } = usePage();
const { setLoading } = useApp();

const muestra_modal = ref(false);

const initSlick3 = () => {
    // wrap-slick3
    let existe_wrap_slick3 = $("#modal_producto").find(".wrap-slick3");
    if (existe_wrap_slick3.length > 0) {
        $(".wrap-slick3").each(function () {
            existe_wrap_slick3.find(".slick3-dots").remove();
            $(this)
                .find(".slick3")
                .slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    infinite: true,
                    autoplay: false,
                    autoplaySpeed: 6000,
                    arrows: true,
                    appendArrows: $(this).find(".wrap-slick3-arrows"),
                    prevArrow:
                        '<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                    nextArrow:
                        '<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',

                    dots: true,
                    appendDots: $(this).find(".wrap-slick3-dots"),
                    dotsClass: "slick3-dots",
                    customPaging: function (slick, index) {
                        var portrait = $(slick.$slides[index]).data("thumb");
                        return (
                            '<img src=" ' +
                            portrait +
                            ' "/><div class="slick3-dot-overlay"></div>'
                        );
                    },
                });
        });
    }

    // GALERIA
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
};

const accionesModal = () => {
    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        var nameTab = $(e.target).attr("href");
        $(nameTab).find(".slick2").slick("reinit");
    });
};

const inicializaScriptsPage = () => {
    /*==================================================================
    [ Filter / Search product ]*/
    $(".js-show-filter").on("click", function () {
        $(this).toggleClass("show-filter");
        $(".panel-filter").slideToggle(400);

        if ($(".js-show-search").hasClass("show-search")) {
            $(".js-show-search").removeClass("show-search");
            $(".panel-search").slideUp(400);
        }
    });

    $(".js-show-search").on("click", function () {
        $(this).toggleClass("show-search");
        $(".panel-search").slideToggle(400);

        if ($(".js-show-filter").hasClass("show-filter")) {
            $(".js-show-filter").removeClass("show-filter");
            $(".panel-filter").slideUp(400);
        }
    });

    /*==================================================================
    [ +/- num product ]*/
    $(".btn-num-product-down").on("click", function () {
        var numProduct = Number($(this).next().val());
        if (numProduct > 0)
            $(this)
                .next()
                .val(numProduct - 1);
    });

    $(".btn-num-product-up").on("click", function () {
        var numProduct = Number($(this).prev().val());
        $(this)
            .prev()
            .val(numProduct + 1);
    });
};

const oProducto = ref(null);
const listProductos = ref([]);
const cargando_producto = ref(false);
const showProducto = (item) => {
    console.log(item);
    cargando_producto.value = true;
    muestra_modal.value = true;
    oProducto.value = item;

    setTimeout(function () {
        initSlick3();
        cargando_producto.value = false;
    }, 500);
};

const cierraModal = () => {
    oProducto.value = null;
    muestra_modal.value = false;
};

const params_productos = {
    categoria_id: "",
    search: "",
};

const getProductos = () => {
    axios
        .get(route("productos.portal"), {
            params: params_productos,
        })
        .then((response) => {
            listProductos.value = response.data.productos.data;
        });
};

onMounted(() => {
    url_assets = props.url_assets;
    inicializaScriptsPage();

    getProductos();

    setTimeout(() => {
        setLoading(false);
    }, 300);
});
</script>
<template>
    <Head title="Inicio"></Head>

    <!-- Product -->
    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-10">
                <div class="flex-w flex-c-m m-tb-10">
                    <div
                        class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter"
                    >
                        <i
                            class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"
                        ></i>
                        <i
                            class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"
                        ></i>
                        Filter
                    </div>

                    <div
                        class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search"
                    >
                        <i
                            class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"
                        ></i>
                        <i
                            class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"
                        ></i>
                        Search
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button
                            class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04"
                        >
                            <i class="zmdi zmdi-search"></i>
                        </button>

                        <input
                            class="mtext-107 cl2 size-114 plh2 p-r-15"
                            type="text"
                            name="search-product"
                            placeholder="Search"
                        />
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div
                        class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm"
                    >
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">Sort By</div>

                            <ul>
                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Default
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Popularity
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Average rating
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04 filter-link-active"
                                    >
                                        Newness
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Price: Low to High
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Price: High to Low
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="filter-col2 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">Price</div>

                            <ul>
                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04 filter-link-active"
                                    >
                                        All
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        $0.00 - $50.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        $50.00 - $100.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        $100.00 - $150.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        $150.00 - $200.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        $200.00+
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="filter-col3 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">Color</div>

                            <ul>
                                <li class="p-b-6">
                                    <span
                                        class="fs-15 lh-12 m-r-6"
                                        style="color: #222"
                                    >
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Black
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span
                                        class="fs-15 lh-12 m-r-6"
                                        style="color: #4272d7"
                                    >
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04 filter-link-active"
                                    >
                                        Blue
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span
                                        class="fs-15 lh-12 m-r-6"
                                        style="color: #b3b3b3"
                                    >
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Grey
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span
                                        class="fs-15 lh-12 m-r-6"
                                        style="color: #00ad5f"
                                    >
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Green
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span
                                        class="fs-15 lh-12 m-r-6"
                                        style="color: #fa4251"
                                    >
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        Red
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span
                                        class="fs-15 lh-12 m-r-6"
                                        style="color: #aaa"
                                    >
                                        <i class="zmdi zmdi-circle-o"></i>
                                    </span>

                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                    >
                                        White
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="filter-col4 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">Tags</div>

                            <div class="flex-w p-t-4 m-r--5">
                                <a
                                    href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5"
                                >
                                    Fashion
                                </a>

                                <a
                                    href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5"
                                >
                                    Lifestyle
                                </a>

                                <a
                                    href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5"
                                >
                                    Denim
                                </a>

                                <a
                                    href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5"
                                >
                                    Streetstyle
                                </a>

                                <a
                                    href="#"
                                    class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5"
                                >
                                    Crafts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div
                    class="col-sm-6 col-md-4 col-lg-3 p-b-35"
                    v-for="item in listProductos"
                >
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img
                                :src="item.foto_productos[0].url_foto"
                                alt="IMG-PRODUCTO"
                            />

                            <a
                                href="#"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                @click.prevent="showProducto(item)"
                            >
                                <i class="fa fa-cart-plus"></i>&nbsp;Agregar
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <span
                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"
                                >
                                    Esprit Ruffle Shirt
                                </span>

                                <span class="stext-105 cl3">
                                    ${{ item.precio_total }}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">
                                <button
                                    href="#"
                                    class="btn btn-warning bg-orange dis-block pos-relative js-addwish-b2"
                                >
                                    <i class="fa fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45">
                <a
                    href="#"
                    class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04"
                >
                    Load More
                </a>
            </div>
        </div>
    </div>

    <!-- Modal1 -->
    <div
        class="wrap-modal1 js-modal1 p-t-60 p-b-20"
        :class="muestra_modal ? 'show-modal1' : ''"
        id="modal_producto"
    >
        <div class="overlay-modal1 js-hide-modal1"></div>

        <div class="container">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button
                    class="how-pos3 hov3 trans-04 js-hide-modal1"
                    @click.prevent="cierraModal"
                >
                    <img
                        :src="url_assets + '/images/icons/icon-close.png'"
                        alt="CLOSE"
                    />
                </button>
                <div class="row" v-show="cargando_producto">
                    <div
                        class="col-12"
                        style="
                            height: 70vh;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        "
                    >
                        <h5>Cargando producto...</h5>
                    </div>
                </div>
                <div class="row" v-show="!cargando_producto">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div
                                    class="wrap-slick3-arrows flex-sb-m flex-w"
                                ></div>

                                <div
                                    v-if="
                                        oProducto &&
                                        oProducto.foto_productos.length > 0
                                    "
                                    class="slick3 gallery-lb"
                                >
                                    <div
                                        class="item-slick3"
                                        :data-thumb="slick.url_foto"
                                        v-for="slick in oProducto.foto_productos"
                                    >
                                        <div class="wrap-pic-w pos-relative">
                                            <img
                                                :src="slick.url_foto"
                                                alt="IMG-PRODUCT"
                                            />

                                            <a
                                                class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                :href="slick.url_foto"
                                            >
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                Lightweight Jacket
                            </h4>

                            <span class="mtext-106 cl2"> $58.79 </span>

                            <p class="stext-102 cl3 p-t-23">
                                Nulla eget sem vitae eros pharetra viverra. Nam
                                vitae luctus ligula. Mauris consequat ornare
                                feugiat.
                            </p>

                            <!--  -->
                            <div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6">
                                        Size
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select
                                                class="js-select2"
                                                name="time"
                                            >
                                                <option>
                                                    Choose an option
                                                </option>
                                                <option>Size S</option>
                                                <option>Size M</option>
                                                <option>Size L</option>
                                                <option>Size XL</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6">
                                        Color
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select
                                                class="js-select2"
                                                name="time"
                                            >
                                                <option>
                                                    Choose an option
                                                </option>
                                                <option>Red</option>
                                                <option>Blue</option>
                                                <option>White</option>
                                                <option>Grey</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-w flex-r-m p-b-10">
                                    <div
                                        class="size-204 flex-w flex-m respon6-next"
                                    >
                                        <div
                                            class="wrap-num-product flex-w m-r-20 m-tb-10"
                                        >
                                            <div
                                                class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                            >
                                                <i
                                                    class="fs-16 zmdi zmdi-minus"
                                                ></i>
                                            </div>

                                            <input
                                                class="mtext-104 cl3 txt-center num-product"
                                                type="number"
                                                name="num-product"
                                                value="1"
                                            />

                                            <div
                                                class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                            >
                                                <i
                                                    class="fs-16 zmdi zmdi-plus"
                                                ></i>
                                            </div>
                                        </div>

                                        <button
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                                        >
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!--  -->
                            <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                <div class="flex-m bor9 p-r-10 m-r-11">
                                    <a
                                        href="#"
                                        class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                        data-tooltip="Add to Wishlist"
                                    >
                                        <i class="zmdi zmdi-favorite"></i>
                                    </a>
                                </div>

                                <a
                                    href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                    data-tooltip="Facebook"
                                >
                                    <i class="fa fa-facebook"></i>
                                </a>

                                <a
                                    href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                    data-tooltip="Twitter"
                                >
                                    <i class="fa fa-twitter"></i>
                                </a>

                                <a
                                    href="#"
                                    class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                    data-tooltip="Google Plus"
                                >
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
