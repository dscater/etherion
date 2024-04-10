<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useConfiguracionPagos } from "@/composables/configuracion_pagos/useConfiguracionPagos";
import { watch, ref, computed, defineEmits } from "vue";
const props = defineProps({
    open_dialog: {
        type: Boolean,
        default: false,
    },
    accion_dialog: {
        type: Number,
        default: 0,
    },
});

const { oConfiguracionPago, limpiarConfiguracionPago } =
    useConfiguracionPagos();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
let form = useForm(oConfiguracionPago.value);
watch(
    () => props.open_dialog,
    (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            form = useForm(oConfiguracionPago.value);
        }
    }
);
watch(
    () => props.accion_dialog,
    (newValue) => {
        accion.value = newValue;
    }
);

const { flash } = usePage().props;

const qr = ref(null);
function cargaArchivo(e, key) {
    form[key] = null;
    form[key] = e.target.files[0];
}
const tituloDialog = computed(() => {
    return accion.value == 0 ? `Agregar Categoría` : `Editar Categoría`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("configuracion_pagos.store")
            : route("configuracion_pagos.update", form.id);

    form.post(url, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            Swal.fire({
                icon: "success",
                title: "Correcto",
                text: `${flash.bien ? flash.bien : "Proceso realizado"}`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
            limpiarConfiguracionPago();
            emits("envio-formulario");
        },
        onError: (err) => {
            Swal.fire({
                icon: "info",
                title: "Error",
                text: `${
                    flash.error
                        ? flash.error
                        : err.error
                        ? err.error
                        : "Hay errores en el formulario"
                }`,
                confirmButtonColor: "#3085d6",
                confirmButtonText: `Aceptar`,
            });
        },
    });
};

const emits = defineEmits(["cerrar-dialog", "envio-formulario"]);

watch(dialog, (newVal) => {
    if (!newVal) {
        emits("cerrar-dialog");
    }
});

const cerrarDialog = () => {
    dialog.value = false;
};
</script>

<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" width="1024" persistent scrollable>
            <v-card>
                <v-card-title class="border-b bg-primary pa-5">
                    <v-icon
                        icon="mdi-close"
                        class="float-right"
                        @click="cerrarDialog"
                    ></v-icon>

                    <v-icon
                        :icon="accion == 0 ? 'mdi-plus' : 'mdi-pencil'"
                    ></v-icon>
                    <span class="text-h5" v-html="tituloDialog"></span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <form>
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.banco ? false : true
                                        "
                                        :error="
                                            form.errors?.banco ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.banco
                                                ? form.errors?.banco
                                                : ''
                                        "
                                        variant="outlined"
                                        label="Nombre de banco*"
                                        required
                                        density="compact"
                                        v-model="form.banco"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="6" md="6">
                                    <v-textarea
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
                                                ? form.errors?.nro_cuenta
                                                : ''
                                        "
                                        variant="outlined"
                                        density="compact"
                                        label="Nro. de cuenta*"
                                        rows="1"
                                        auto-grow
                                        v-model="form.nro_cuenta"
                                    ></v-textarea>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                    <v-file-input
                                        :hide-details="
                                            form.errors?.qr ? false : true
                                        "
                                        :error="form.errors?.qr ? true : false"
                                        :error-messages="
                                            form.errors?.qr
                                                ? form.errors?.qr
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        accept="image/png, image/jpeg, image/bmp"
                                        placeholder="QR"
                                        prepend-icon="mdi-camera"
                                        label="QR"
                                        @change="cargaArchivo($event, 'qr')"
                                        ref="qr"
                                    ></v-file-input>
                                </v-col>
                            </v-row>
                        </form>
                    </v-container>
                </v-card-text>
                <v-card-actions class="border-t">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey-darken-4"
                        variant="text"
                        @click="cerrarDialog"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        class="bg-primary"
                        prepend-icon="mdi-content-save"
                        @click="enviarFormulario"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
