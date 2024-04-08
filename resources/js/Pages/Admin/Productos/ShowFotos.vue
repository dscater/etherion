<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useProductos } from "@/composables/productos/useProductos";
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
const accion = ref(props.accion_dialog);
const dialog = ref(props.open_dialog);

let form = useForm(oProducto);
watch(
    () => props.open_dialog,
    (newValue) => {
        dialog.value = newValue;
        if (dialog.value) {
            form = useForm(oProducto);
        }
    }
);
watch(
    () => props.accion_dialog,
    (newValue) => {
        console.log("eee");
        accion.value = newValue;
    }
);

const { flash } = usePage().props;

const tituloDialog = computed(() => {
    return accion.value == 0 ? `Imágenes/Fotos Cargadas` : `Editar Producto`;
});

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
                        :icon="accion == 0 ? 'mdi-image-multiple' : 'mdi-pencil'"
                    ></v-icon>
                    <span class="text-h5" v-html="tituloDialog"></span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row align="center" justify="center">
                            <v-col
                                cols="auto"
                                v-for="foto in oProducto.foto_productos"
                            >
                                <v-img
                                    :src="foto.url_foto"
                                    width="300"
                                    cover
                                    aspect-ratio="16/9"
                                ></v-img>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions class="border-t">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey-darken-4"
                        variant="text"
                        @click="cerrarDialog"
                    >
                        Cerrar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
