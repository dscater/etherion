<script setup>
import { useApp } from "@/composables/useApp";
import { onMounted } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
const { setLoading } = useApp();
onMounted(() => {
    setTimeout(() => {
        setLoading(false);
    }, 300);
});
</script>
<template>
    <Head title="Inicio"></Head>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
</template>
