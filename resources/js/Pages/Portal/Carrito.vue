<script setup>
import { useApp } from "@/composables/useApp";
import { onMounted, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
var url_assets = "";
const { props } = usePage();
const { setLoading } = useApp();
const muestra_modal = ref(false);

onMounted(() => {
    url_assets = props.url_assets;

    setTimeout(() => {
        setLoading(false);
    }, 300);
});
</script>
<template>
    <Head title="Carrito"></Head>
</template>

<style></style>
