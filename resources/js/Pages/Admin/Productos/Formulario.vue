<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useProductos } from "@/composables/productos/useProductos";
import { useCategorias } from "@/composables/categorias/useCategorias";
import { useProductoTamanos } from "@/composables/producto_tamanos/useProductoTamanos";
import { watch, ref, computed, defineEmits, onMounted } from "vue";
import MiDropZone from "@/Components/MiDropZone.vue";
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

const { oProducto, limpiarProducto } = useProductos();
const { getCategorias } = useCategorias();
const { getProductoTamanos } = useProductoTamanos();
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);
const listCategorias = ref([]);
const listProductoTamanos = ref([]);

let form = useForm(oProducto);
watch(
    () => props.open_dialog,
    (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            cargarListas();
            form = useForm(oProducto);
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
    return accion.value == 0 ? `Agregar Producto` : `Editar Producto`;
});

const enviarFormulario = () => {
    let url =
        form["_method"] == "POST"
            ? route("productos.store")
            : route("productos.update", form.id);

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
            limpiarProducto();
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

const disabled = ref(false);
const detectaArchivos = (files) => {
    disabled.value = true;
    form.foto_productos = [];
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        form.foto_productos.push(file.file);
    }
    setTimeout(() => {
        disabled.value = false;
    }, 500);
};

const detectaEliminados = (files) => {
    disabled.value = true;
    form.eliminados = [];
    for (let i = 0; i < files.length; i++) {
        const id = files[i];
        form.eliminados.push(id);
    }
    setTimeout(() => {
        disabled.value = false;
    }, 500);
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

const cargarListas = async () => {
    listCategorias.value = await getCategorias();
    listProductoTamanos.value = await getProductoTamanos();
};

onMounted(() => {
    cargarListas();
});
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
                                    <v-textarea
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
                                        density="compact"
                                        label="Descripción del producto*"
                                        rows="1"
                                        auto-grow
                                        v-model="form.descripcion"
                                    ></v-textarea>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-select
                                        no-data-text="Sin registros"
                                        :hide-details="
                                            form.errors?.categoria_id
                                                ? false
                                                : true
                                        "
                                        :error="
                                            form.errors?.categoria_id
                                                ? true
                                                : false
                                        "
                                        :error-messages="
                                            form.errors?.categoria_id
                                                ? form.errors?.categoria_id
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        clearable
                                        :items="listCategorias"
                                        item-value="id"
                                        item-title="nombre"
                                        label="Seleccionar Categoria*"
                                        v-model="form.categoria_id"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.color ? false : true
                                        "
                                        :error="
                                            form.errors?.color ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.color
                                                ? form.errors?.color
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        label="Color"
                                        v-model="form.color"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.modelo ? false : true
                                        "
                                        :error="
                                            form.errors?.modelo ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.modelo
                                                ? form.errors?.modelo
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        label="Modelo"
                                        v-model="form.modelo"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.marca ? false : true
                                        "
                                        :error="
                                            form.errors?.marca ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.marca
                                                ? form.errors?.marca
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        label="Marca"
                                        v-model="form.marca"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.otros ? false : true
                                        "
                                        :error="
                                            form.errors?.otros ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.otros
                                                ? form.errors?.otros
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        label="Otros"
                                        v-model="form.otros"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-select
                                        no-data-text="Sin registros"
                                        :hide-details="
                                            form.errors?.producto_tamano_id
                                                ? false
                                                : true
                                        "
                                        :error="
                                            form.errors?.producto_tamano_id
                                                ? true
                                                : false
                                        "
                                        :error-messages="
                                            form.errors?.producto_tamano_id
                                                ? form.errors
                                                      ?.producto_tamano_id
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        clearable
                                        :items="listProductoTamanos"
                                        item-value="id"
                                        item-title="nombre"
                                        label="Seleccionar Tamaño del Producto*"
                                        v-model="form.producto_tamano_id"
                                        required
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        :hide-details="
                                            form.errors?.precio ? false : true
                                        "
                                        :error="
                                            form.errors?.precio ? true : false
                                        "
                                        :error-messages="
                                            form.errors?.precio
                                                ? form.errors?.precio
                                                : ''
                                        "
                                        density="compact"
                                        variant="outlined"
                                        type="number"
                                        step="0.01"
                                        label="Precio de Venta (Bs.)*"
                                        v-model="form.precio"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <label>Cargar Imagenes/Fotos (máximo 3):</label>
                                    <MiDropZone
                                        :files="form.foto_productos"
                                        :maximo="3"
                                        @UpdateFiles="detectaArchivos"
                                        @addEliminados="detectaEliminados"
                                    ></MiDropZone>

                                    <p
                                        class="text-body-2 text-red-darken-3 text-center"
                                        v-if="form.errors?.foto_productos"
                                    >
                                        {{ form.errors?.foto_productos }}
                                    </p>
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
                        :disabled="disabled"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
