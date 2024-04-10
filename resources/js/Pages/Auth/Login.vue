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
    usuario: "",
    password: "",
});

const visible = ref(false);

const submit = () => {
    form.post(route("login"), {
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
    <Head title="Login" />
    <v-container class="ma-0 login">
        <v-row align="center" justify="center">
            <v-col cols="12" md="4" xl="4">
                <v-card class="elevation-6 mt-10 contenedor">
                    <v-row>
                        <v-col cols="12" class="border">
                            <v-card-text>
                                <v-img
                                    :src="oInstitucion.url_logo"
                                    class="w-50 mx-auto"
                                ></v-img>
                            </v-card-text>
                            <v-card-title class="">
                                <h4 class="text-center">
                                    {{ oInstitucion.nombre }}
                                </h4>
                            </v-card-title>
                            <form @submit.prevent="submit">
                                <v-card-text>
                                    <h4 class="text-center grey--text">
                                        Iniciar Sesión
                                    </h4>
                                    <p
                                        class="text-caption text-center text-medium-emphasis"
                                    >
                                        Ingresa tu correo y contraseña
                                    </p>
                                    <v-row
                                        align="center"
                                        justify="center"
                                        class="mb-8"
                                    >
                                        <v-col cols="12" sm="10">
                                            <div
                                                class="text-subtitle-1 text-medium-emphasis"
                                            >
                                                Correo
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :error="
                                                    form.errors?.usuario
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.usuario
                                                        ? form.errors?.usuario
                                                        : ''
                                                "
                                                placeholder="Ingresa tu correo electrónico"
                                                prepend-inner-icon="mdi-email"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.usuario"
                                                autofocus=""
                                            ></v-text-field>

                                            <div
                                                class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                                            >
                                                Contraseña
                                            </div>

                                            <v-text-field
                                                :append-inner-icon="
                                                    visible
                                                        ? 'mdi-eye-off'
                                                        : 'mdi-eye'
                                                "
                                                :type="
                                                    visible
                                                        ? 'text'
                                                        : 'password'
                                                "
                                                :error="
                                                    form.errors?.password
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.password
                                                        ? form.errors?.password
                                                        : ''
                                                "
                                                density="compact"
                                                placeholder="Ingresa tu contraseña"
                                                prepend-inner-icon="mdi-lock-outline"
                                                variant="outlined"
                                                color="primary"
                                                @click:append-inner="
                                                    visible = !visible
                                                "
                                                autocomplete="false"
                                                v-model="form.password"
                                            ></v-text-field>
                                            <v-btn
                                                class="mt-2"
                                                elevation="4"
                                                rounded="0"
                                                color="primary"
                                                dark
                                                block
                                                type="submit"
                                                >ACCEDER</v-btn
                                            >
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="10"
                                            class="text-center pt-0"
                                        >
                                            <Link
                                                :href="route('registro')"
                                                class="v-btn v-btn--block text-body-2 bg-orange-darken-3 v-btn--density-default rounded-0 v-btn--size-default v-btn--variant-elevated mt-2"
                                                >Registrarme</Link
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
body {
    overflow: hidden !important;
}
.v-container {
    background-color: var(--fondo_app);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    min-width: 100vw;
}
</style>
