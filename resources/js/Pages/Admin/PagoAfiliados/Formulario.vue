<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { usePagoAfiliados } from "@/composables/pago_afiliados/usePagoAfiliados";
import { useOrdenVentas } from "@/composables/orden_ventas/useOrdenVentas";
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

const { oPagoAfiliado, limpiarPagoAfiliado } = usePagoAfiliados();
const { getOrdenVentas } = useOrdenVentas();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
let form = useForm(oPagoAfiliado.value);
watch(
    () => props.open_dialog,
    (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            form = useForm(oPagoAfiliado.value);
            cargaListas();
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

const tituloDialog = computed(() => {
    return accion.value == 0
        ? `Agregar Pago a Afiliado`
        : `Editar Pago a Afiliado`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("pago_afiliados.store")
            : route("pago_afiliados.update", form.id);

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
            limpiarPagoAfiliado();
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
const listOrdenVentas = ref([]);

const cargaListas = async () => {
    if (form.id && form.id != "") {
        listOrdenVentas.value = await getOrdenVentas({
            order: "desc",
            sin_pago: true,
            id: form.orden_venta_id,
        });
    } else {
        listOrdenVentas.value = await getOrdenVentas({
            order: "desc",
            sin_pago: true,
        });
    }
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
                                    <v-autocomplete
                                        :hide-details="
                                            form.errors?.orden_venta_id
                                                ? false
                                                : true
                                        "
                                        :error="
                                            form.errors?.orden_venta_id
                                                ? true
                                                : false
                                        "
                                        :error-messages="
                                            form.errors?.orden_venta_id
                                                ? form.errors?.orden_venta_id
                                                : ''
                                        "
                                        variant="outlined"
                                        density="compact"
                                        label="Orden de Venta"
                                        :items="listOrdenVentas"
                                        item-title="codigo"
                                        item-value="id"
                                        v-model="form.orden_venta_id"
                                    ></v-autocomplete>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.descripcion
                                                ? false
                                                : true
                                        "
                                        :error="
                                            form.errors?.descripcion
                                                ? true
                                                : false
                                        "
                                        :error-messages="
                                            form.errors?.descripcion
                                                ? form.errors?.descripcion
                                                : ''
                                        "
                                        variant="outlined"
                                        label="Descripción*"
                                        required
                                        density="compact"
                                        v-model="form.descripcion"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-select
                                        :hide-details="
                                            form.errors?.estado ? false : true
                                        "
                                        :error="
                                            form.errors?.estado ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.estado
                                                ? form.errors?.estado
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        :items="['ENTREGADO', 'DEVOLUCIÓN']"
                                        label="Estado*"
                                        v-model="form.estado"
                                        required
                                    ></v-select>
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
