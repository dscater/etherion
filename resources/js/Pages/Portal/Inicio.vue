<script setup>
import { useApp } from "@/composables/useApp";
import { onMounted } from "vue";
const { setLoading } = useApp();
onMounted(() => {
    setTimeout(() => {
        setLoading(false);
    }, 300);
});
</script>
<template>HOLA MUNDO</template>
