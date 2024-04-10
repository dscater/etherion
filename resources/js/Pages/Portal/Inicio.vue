<script setup>
import { useApp } from "@/composables/useApp";
import { onMounted, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useCategorias } from "@/composables/categorias/useCategorias";
import { useCarritoStore } from "@/stores/carritoStore";
import { useMenuPortalStore } from "@/stores/menuPortalStore";
const menu_portal_store = useMenuPortalStore();
if (menu_portal_store) {
    menu_portal_store.setLoadingPage(true);
}
var url_assets = "";
const carrito_store = useCarritoStore();
const { props } = usePage();
const { getCategoriasPortal } = useCategorias();
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

// const accionesModal = () => {
//     $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
//         var nameTab = $(e.target).attr("href");
//         $(nameTab).find(".slick2").slick("reinit");
//     });
// };

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
};

const oProducto = ref(null);
const listProductos = ref([]);
const cargando_producto = ref(false);
const cantidad = ref(1);
const aumentaCantidad = () => {
    cantidad.value++;
};

const disminuyeCantidad = () => {
    if (cantidad.value > 1) {
        cantidad.value--;
    }
};

const detectaCambioCantidad = () => {
    if ((cantidad.value + "").trim() != "" && cantidad.value < 1) {
        cantidad.value = 1;
    }
};

const showProducto = (item) => {
    cantidad.value = 1;
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

const params_productos = ref({
    categoria_id: "",
    order: "desc",
    orderBy: "id",
    search: "",
    page: 1,
});
const currentPage = ref(1);
const total_items = ref(1);
const per_page = ref(1);
watch(
    () => currentPage,
    (newValue) => {
        getProductos(newValue);
    }
);

const aplicaFiltro = (key, value, value2 = "") => {
    loadingProductos.value = true;
    params_productos.value[key] = value;
    if (key == "order") {
        params_productos.value["orderBy"] = value2;
    }
    getProductos();
};

const timeOutSearch = ref(null);
const loadingProductos = ref(false);
const preparaBusqueda = () => {
    loadingProductos.value = true;
    clearTimeout(timeOutSearch.value);
    timeOutSearch.value = setTimeout(() => {
        aplicaFiltro("search", params_productos.value["search"]);
    }, 700);
};

const getProductos = (page = 1) => {
    params_productos.value.page = page;
    axios
        .get(route("productos.portal"), {
            params: params_productos.value,
        })
        .then((response) => {
            listProductos.value = response.data.productos.data;
            total_items.value = response.data.productos.total;
            per_page.value = response.data.productos.per_page;
            loadingProductos.value = false;
        });
};
const onClickHandler = (value) => {
    getProductos(currentPage.value);
    setTimeout(() => {
        scrollPaginacion();
    }, 300);
};

const scrollPaginacion = () => {
    var contenedor_productos = document.getElementById("contenedor_productos");
    var primerProducto = contenedor_productos.querySelector(".item_producto");
    if (contenedor_productos && primerProducto) {
        var posicionTopPrimerProducto = primerProducto.offsetTop - 100;
        window.scrollTo({
            top: posicionTopPrimerProducto,
            behavior: "smooth",
        });
    }
};

const listCategorias = ref([]);

const cargaListas = async () => {
    listCategorias.value = await getCategoriasPortal();
};

const agregarProducto = () => {
    if ((cantidad.value + "").trim() != "") {
        let precio_carrito =
            parseFloat(cantidad.value) *
            parseFloat(oProducto.value.precio_total);
        carrito_store.addProducto({
            orden_venta_id: 0,
            producto_id: 0,
            cantidad: cantidad.value,
            precio: oProducto.value.precio_total,
            precio_total: parseFloat(precio_carrito).toFixed(2),
            producto: oProducto.value,
        });

        Swal.fire({
            icon: "success",
            title: "Correcto",
            text: `¡Producto agregado!`,
            confirmButtonColor: "#3085d6",
            confirmButtonText: `Aceptar`,
        });

        cierraModal();
    } else {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: `Debes ingresar la cantidad`,
            confirmButtonColor: "#3085d6",
            confirmButtonText: `Aceptar`,
        });
    }
};

onMounted(() => {
    carrito_store.inicializaCarrito();
    cargaListas();
    url_assets = props.url_assets;
    inicializaScriptsPage();
    getProductos();
    setTimeout(() => {
        if (menu_portal_store) {
            menu_portal_store.setLoadingPage(false);
        }
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
                        Filtrar
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
                        Buscar
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
                            v-model="params_productos.search"
                            class="mtext-107 cl2 size-114 plh2 p-r-15"
                            type="text"
                            name="search-product"
                            @keyup.prevent="preparaBusqueda"
                            placeholder="Buscar"
                        />
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div
                        class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm"
                    >
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">Ordenar por</div>

                            <ul>
                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                        :class="[
                                            params_productos.order == 'desc' &&
                                            params_productos.orderBy == 'id'
                                                ? 'filter-link-active'
                                                : '',
                                        ]"
                                        @click.prevent="
                                            aplicaFiltro('order', 'desc', 'id')
                                        "
                                    >
                                        Nuevos
                                    </a>
                                </li>
                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                        :class="[
                                            params_productos.order == 'asc' &&
                                            params_productos.orderBy == 'id'
                                                ? 'filter-link-active'
                                                : '',
                                        ]"
                                        @click.prevent="
                                            aplicaFiltro('order', 'asc', 'id')
                                        "
                                    >
                                        Antiguos
                                    </a>
                                </li>
                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                        :class="[
                                            params_productos.order == 'asc' &&
                                            params_productos.orderBy ==
                                                'precio_total'
                                                ? 'filter-link-active'
                                                : '',
                                        ]"
                                        @click.prevent="
                                            aplicaFiltro(
                                                'order',
                                                'asc',
                                                'precio_total'
                                            )
                                        "
                                    >
                                        Precio: Más bajo
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                        :class="[
                                            params_productos.order == 'desc' &&
                                            params_productos.orderBy ==
                                                'precio_total'
                                                ? 'filter-link-active'
                                                : '',
                                        ]"
                                        @click.prevent="
                                            aplicaFiltro(
                                                'order',
                                                'desc',
                                                'precio_total'
                                            )
                                        "
                                    >
                                        Precio: Más alto
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">Categoría</div>
                            <ul>
                                <li class="p-b-6">
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                        :class="[
                                            params_productos.categoria_id == ''
                                                ? 'filter-link-active'
                                                : '',
                                        ]"
                                        @click.prevent="
                                            aplicaFiltro('categoria_id', '')
                                        "
                                    >
                                        Todos
                                    </a>
                                </li>

                                <li
                                    class="p-b-6"
                                    v-for="item in listCategorias"
                                >
                                    <a
                                        href="#"
                                        class="filter-link stext-106 trans-04"
                                        :class="[
                                            params_productos.categoria_id ==
                                            item.id
                                                ? 'filter-link-active'
                                                : '',
                                        ]"
                                        @click.prevent="
                                            aplicaFiltro(
                                                'categoria_id',
                                                item.id
                                            )
                                        "
                                    >
                                        {{ item.nombre }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="params_productos.search.trim() != ''">
                <div class="col-12">
                    Buscando: {{ params_productos.search }}
                </div>
            </div>
            <div
                class="row"
                id="contenedor_productos"
                v-show="!loadingProductos"
            >
                <div
                    class="col-sm-6 col-md-4 col-lg-3 p-b-35 item_producto"
                    v-for="item in listProductos"
                >
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img
                                :src="item.foto_productos[0].url_foto"
                                alt="IMG-PRODUCTO"
                            />
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <span
                                    class="stext-110 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 descripcion"
                                >
                                    {{ item.descripcion }}
                                </span>
                                <span
                                    class="stext-109 text-xs cl4 trans-04 js-name-b2 p-b-6"
                                >
                                    {{ item.categoria.nombre }} /
                                    {{ item.producto_tamano.nombre }}
                                </span>

                                <span class="stext-105 cl3">
                                    ${{ item.precio_total }}
                                </span>
                            </div>
                        </div>
                        <div class="block-btn">
                            <button
                                href="#"
                                class="btn btn-primary btn-flat btn-block"
                                @click.prevent="showProducto(item)"
                            >
                                <i class="fa fa-cart-plus"></i> Ver/Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="loadingProductos">
                <div class="col-12">
                    <h5 class="text-center">Cargando productos...</h5>
                </div>
            </div>

            <div class="row" v-show="total_items > 0 && !loadingProductos">
                <div class="col-12 text-center">
                    <vue-awesome-paginate
                        :total-items="total_items"
                        :items-per-page="per_page"
                        :max-pages-shown="2"
                        v-model="currentPage"
                        :on-click="onClickHandler"
                    />
                </div>
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
                            <!-- <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                Lightweight Jacket
                            </h4> -->

                            <span class="mtext-106 cl2">
                                ${{ oProducto?.precio_total }}
                            </span>

                            <p class="stext-102 cl3 p-t-23">
                                {{ oProducto?.descripcion }}
                            </p>

                            <!--  -->
                            <div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div
                                        class="size-204 flex-w flex-m respon6-next"
                                    >
                                        <div
                                            class="wrap-num-product flex-w m-r-20 m-tb-10"
                                        >
                                            <div
                                                class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                @click="disminuyeCantidad"
                                            >
                                                <i
                                                    class="fs-16 zmdi zmdi-minus"
                                                ></i>
                                            </div>

                                            <input
                                                class="mtext-104 cl3 txt-center num-product"
                                                type="number"
                                                name="num-product"
                                                v-model="cantidad"
                                                @keyup.prevent="
                                                    detectaCambioCantidad
                                                "
                                                @change="detectaCambioCantidad"
                                            />

                                            <div
                                                class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                @click="aumentaCantidad"
                                            >
                                                <i
                                                    class="fs-16 zmdi zmdi-plus"
                                                ></i>
                                            </div>
                                        </div>

                                        <button
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04"
                                            @click="agregarProducto"
                                        >
                                            Agregar al carrito
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
