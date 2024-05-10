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
    <Head title="Registro" />
    <v-container class="ma-0 login">
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
                                        Crear Cuenta
                                    </h4>
                                    <v-row align="center" justify="center">
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Nombre(s)
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.nombre
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.nombre
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.nombre
                                                        ? form.errors?.nombre
                                                        : ''
                                                "
                                                placeholder="Ingresa tu nombre"
                                                prepend-inner-icon="mdi-account"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.nombre"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Ap. Paterno
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.paterno
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.paterno
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.paterno
                                                        ? form.errors?.paterno
                                                        : ''
                                                "
                                                placeholder="Apellido Paterno"
                                                prepend-inner-icon="mdi-account"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.paterno"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Ap. Materno
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.materno
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.materno
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.materno
                                                        ? form.errors?.materno
                                                        : ''
                                                "
                                                placeholder="Apellido Materno"
                                                prepend-inner-icon="mdi-account"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.materno"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Nro. C.I.
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.ci
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.ci
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.ci
                                                        ? form.errors?.ci
                                                        : ''
                                                "
                                                placeholder="Nro. C.I."
                                                prepend-inner-icon="mdi-card-account-details"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.ci"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Extensión C.I.
                                            </div>

                                            <v-select
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.ci_exp
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.ci_exp
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.ci_exp
                                                        ? form.errors?.ci_exp
                                                        : ''
                                                "
                                                :items="listExpedido"
                                                item-value="value"
                                                item-title="label"
                                                placeholder="Extensión C.I."
                                                prepend-inner-icon="mdi-card-account-details"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.ci_exp"
                                                autofocus=""
                                            ></v-select>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Registrarse para
                                            </div>

                                            <v-select
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.tipo
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.tipo
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.tipo
                                                        ? form.errors?.tipo
                                                        : ''
                                                "
                                                :items="listTipo"
                                                item-value="value"
                                                item-title="label"
                                                placeholder="Registrarse para"
                                                prepend-inner-icon="mdi-account-tag"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.tipo"
                                                autofocus=""
                                            ></v-select>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            xl="3"
                                            v-if="form.tipo == 'AFILIADO'"
                                        >
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Nombre de Banco
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.banco
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.banco
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.banco
                                                        ? form.errors?.banco
                                                        : ''
                                                "
                                                placeholder="Nombre de Banco"
                                                prepend-inner-icon="mdi-office-building"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.banco"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12"
                                            sm="6"
                                            md="4"
                                            xl="3"
                                            v-if="form.tipo == 'AFILIADO'"
                                        >
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Número de Cuenta Bancaria
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.nro_cuenta
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.nro_cuenta
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.nro_cuenta
                                                        ? form.errors
                                                              ?.nro_cuenta
                                                        : ''
                                                "
                                                placeholder="Número de Cuenta Bancaria"
                                                prepend-inner-icon="mdi-credit-card"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.nro_cuenta"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Celular
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.fono
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.fono
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.fono
                                                        ? form.errors?.fono
                                                        : ''
                                                "
                                                placeholder="Celular"
                                                prepend-inner-icon="mdi-phone"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.fono"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Dirección
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.dir
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.dir
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.dir
                                                        ? form.errors?.dir
                                                        : ''
                                                "
                                                placeholder="Dirección"
                                                prepend-inner-icon="mdi-map-marker"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.dir"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis"
                                            >
                                                Correo Electrónico
                                            </div>

                                            <v-text-field
                                                density="compact"
                                                :hide-details="
                                                    form.errors?.email
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.email
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.email
                                                        ? form.errors?.email
                                                        : ''
                                                "
                                                placeholder="Correo Electrónico"
                                                prepend-inner-icon="mdi-email"
                                                variant="outlined"
                                                color="primary"
                                                autocomplete="false"
                                                v-model="form.email"
                                                autofocus=""
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis d-flex align-center justify-space-between"
                                            >
                                                Contraseña
                                            </div>

                                            <v-text-field
                                                :append-inner-icon="
                                                    visible
                                                        ? 'mdi-eye-off'
                                                        : 'mdi-eye'
                                                "
                                                :hide-details="
                                                    form.errors?.password
                                                        ? false
                                                        : true
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
                                                placeholder="Contraseña"
                                                prepend-inner-icon="mdi-lock-outline"
                                                variant="outlined"
                                                color="primary"
                                                @click:append-inner="
                                                    visible = !visible
                                                "
                                                autocomplete="false"
                                                v-model="form.password"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <div
                                                class="text-caption text-medium-emphasis d-flex align-center justify-space-between"
                                            >
                                                Confirmar Contraseña
                                            </div>

                                            <v-text-field
                                                :append-inner-icon="
                                                    visible
                                                        ? 'mdi-eye-off'
                                                        : 'mdi-eye'
                                                "
                                                :hide-details="
                                                    form.errors
                                                        ?.password_confirmation
                                                        ? false
                                                        : true
                                                "
                                                :type="
                                                    visible
                                                        ? 'text'
                                                        : 'password'
                                                "
                                                :error="
                                                    form.errors
                                                        ?.password_confirmation
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors
                                                        ?.password_confirmation
                                                        ? form.errors
                                                              ?.password_confirmation
                                                        : ''
                                                "
                                                density="compact"
                                                placeholder="Confirmar Contraseña"
                                                prepend-inner-icon="mdi-lock-outline"
                                                variant="outlined"
                                                color="primary"
                                                @click:append-inner="
                                                    visible = !visible
                                                "
                                                autocomplete="false"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4" xl="3">
                                            <v-checkbox
                                                :hide-details="
                                                    form.errors?.acepto
                                                        ? false
                                                        : true
                                                "
                                                :error="
                                                    form.errors?.acepto
                                                        ? true
                                                        : false
                                                "
                                                :error-messages="
                                                    form.errors?.acepto
                                                        ? form.errors?.acepto
                                                        : ''
                                                "
                                                v-model="form.acepto"
                                                color="orange"
                                                hide-details
                                            >
                                                <template v-slot:label>
                                                    Aceptar&nbsp;
                                                    <a
                                                        :href="
                                                            route(
                                                                'terminos_condiciones'
                                                            )
                                                        "
                                                        target="_blank"
                                                        class="text-orange-darken-3"
                                                        >Terminos y
                                                        Condiciones</a
                                                    >
                                                </template>
                                            </v-checkbox>
                                        </v-col>
                                    </v-row>
                                    <v-row align="center" justify="center">
                                        <v-col
                                            cols="12"
                                            sm="12"
                                            md="6"
                                            xl="4"
                                            class="mx-auto"
                                        >
                                            <v-btn
                                                class="mt-2"
                                                elevation="4"
                                                rounded="0"
                                                color="primary"
                                                dark
                                                block
                                                type="submit"
                                                >Crear Cuenta</v-btn
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
