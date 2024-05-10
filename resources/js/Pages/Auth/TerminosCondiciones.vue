<script>
import Login from "@/Layouts/Login.vue";
import { onMounted } from "vue";
export default {
    layout: Login,
};
</script>

<script setup>
import { useInstitucion } from "@/composables/institucion/useInstitucion";
import { useForm, Head, usePage, Link } from "@inertiajs/vue3";
import { ref } from "vue";
const { props } = usePage();
var url_principal = "";
var url_assets = "";

const { oInstitucion } = useInstitucion();
const form = useForm({
    password: "",
    password_confirmation: "",
    nombre: "",
    paterno: "",
    materno: "",
    ci: "",
    ci_exp: null,
    dir: "",
    email: "",
    fono: "",
    banco: "",
    nro_cuenta: "",
    tipo: null,
    acepto: false,
});
const listExpedido = [
    { value: "LP", label: "La Paz" },
    { value: "CB", label: "Cochabamba" },
    { value: "SC", label: "Santa Cruz" },
    { value: "CH", label: "Chuquisaca" },
    { value: "OR", label: "Oruro" },
    { value: "PT", label: "Potosi" },
    { value: "TJ", label: "Tarija" },
    { value: "PD", label: "Pando" },
    { value: "BN", label: "Beni" },
];
const listTipo = [
    { value: "AFILIADO", label: "Vender mis productos (Afiliado)" },
    { value: "CLIENTE", label: "Comprar productos (Cliente)" },
];

const visible = ref(false);

const submit = () => {
    let url = route("afiliados.registro");
    if (form.tipo == "AFILIADO") {
    } else {
        url = route("clientes.registro");
    }

    form.post(url, {
        onError: (err) => {
            if (err.acceso) {
                Swal.fire({
                    icon: "info",
                    title: "Error",
                    text: `${err.acceso}`,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: `Aceptar`,
                });
            }
        },
        onFinish: () => form.reset("password"),
    });
};

onMounted(() => {
    url_assets = props.url_assets;
    url_principal = props.url_principal;
});
</script>

<template>
    <Head title="Terminos y Condiciones" />
    <v-container class="ma-0 terminos_condiciones">
        <v-row align="center" justify="center">
            <v-col cols="12" sm="10" md="9" xl="8">
                <v-card class="elevation-6 contenedor">
                    <v-row>
                        <v-col cols="12" class="border">
                            <v-card-title class="">
                                <h2 class="text-center text-h4">
                                    {{ oInstitucion.nombre }}
                                </h2>
                            </v-card-title>
                            <form @submit.prevent="submit">
                                <v-card-text class="pt-0">
                                    <h4 class="text-center grey--text text-h5">
                                        Terminos y Condiciones
                                    </h4>
                                    <v-row>
                                        <v-col
                                            cols="12"
                                            v-html="
                                                oInstitucion.terminos_condiciones
                                            "
                                        ></v-col>
                                    </v-row>
                                    <v-row align="center" justify="center">
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="6"
                                            xl="4"
                                            class="mx-auto"
                                        >
                                            <Link
                                                :href="route('registro')"
                                                class="v-btn v-btn--block text-body-2 bg-orange-darken-3 v-btn--density-default rounded-0 v-btn--size-default v-btn--variant-elevated mt-2"
                                                >Registrarme</Link
                                            >
                                            <Link
                                                :href="route('login')"
                                                class="v-btn v-btn--block v-btn--elevated v-theme--light bg-default v-btn--density-default elevation-4 rounded-0 v-btn--size-default text-body-2 v-btn--variant-elevated mt-2"
                                                >Iniciar Sesión</Link
                                            >
                                        </v-col>
                                        <v-col cols="12" class="text-center">
                                            <a href="/">Volver al portal</a>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </form>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
.v-container {
    background-color: var(--fondo_app);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    min-width: 100vw;
}
</style>
