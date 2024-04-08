<script>
const breadbrums = [
    {
        title: "Inicio",
        disabled: false,
        url: route("inicio"),
        name_url: "inicio",
    },
    {
        title: "Afiliados",
        disabled: false,
        url: "",
        name_url: "",
    },
];
</script>
<script setup>
import BreadBrums from "@/Components/BreadBrums.vue";
import { useApp } from "@/composables/useApp";
import { Head } from "@inertiajs/vue3";
import { useAfiliados } from "@/composables/afiliados/useAfiliados";
import { ref, onMounted } from "vue";
import { useMenu } from "@/composables/useMenu";
const { mobile, identificaDispositivo } = useMenu();
const { setLoading } = useApp();
onMounted(() => {
    identificaDispositivo();
    setTimeout(() => {
        setLoading(false);
    }, 300);
});

const { getUsuariosApi, setUsuario, limpiarUsuario, deleteUsuario } =
    useAfiliados();
const responseUsuarios = ref([]);
const listUsuarios = ref([]);
const itemsPerPage = ref(5);
const headers = ref([
    {
        title: "Id",
        align: "start",
        key: "id",
        sortable: false,
    },
    { title: "Correo", key: "email", align: "start", sortable: false },
    { title: "Nombre", key: "full_name", align: "start", sortable: false },
    { title: "C.I.", key: "full_ci", align: "start", sortable: false },
    { title: "Dirección", key: "dir", align: "start", sortable: false },
    { title: "Teléfono/Celular", key: "fono", align: "start", sortable: false },
    { title: "Foto Perfil", key: "foto", align: "start", sortable: false },
    { title: "Acceso", key: "acceso", align: "start", sortable: false },
    { title: "Acción", key: "accion", align: "end", sortable: false },
]);

const search = ref("");
const options = ref({
    page: 1,
    itemsPerPage: itemsPerPage,
    sortBy: "",
    sortOrder: "desc",
    search: "",
});

const loading = ref(true);
const totalItems = ref(0);
let setTimeOutLoadData = null;
const loadItems = async ({ page, itemsPerPage, sortBy }) => {
    loading.value = true;
    options.value.page = page;
    if (sortBy.length > 0) {
        options.value.sortBy = sortBy[0].key;
        options.value.sortOrder = sortBy[0].order;
    }
    options.value.search = search.value;

    clearInterval(setTimeOutLoadData);
    setTimeOutLoadData = setTimeout(async () => {
        responseUsuarios.value = await getUsuariosApi(options.value);
        listUsuarios.value = responseUsuarios.value.data;
        totalItems.value = parseInt(responseUsuarios.value.total);
        loading.value = false;
    }, 300);
};
const recargaUsuarios = async () => {
    loading.value = true;
    listUsuarios.value = [];
    options.value.search = search.value;
    responseUsuarios.value = await getUsuariosApi(options.value);
    listUsuarios.value = responseUsuarios.value.data;
    totalItems.value = parseInt(responseUsuarios.value.total);
    setTimeout(() => {
        loading.value = false;
        open_dialog.value = false;
    }, 300);
};

const actualizaAcceso = (value, item) => {
    axios
        .patch(route("usuarios.actualizaAcceso", item.id), {
            acceso: value,
        })
        .then((response) => {
            item.acceso = response.data.user.acceso;
        });
};

const eliminarUsuario = (item) => {
    Swal.fire({
        title: "¿Quierés eliminar este registro?",
        html: `<strong>${item.full_name}</strong>`,
        showCancelButton: true,
        confirmButtonColor: "#B61431",
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        denyButtonText: `No, cancelar`,
    }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            let respuesta = await deleteUsuario(item.id);
            if (respuesta && respuesta.sw) {
                recargaUsuarios();
            }
        }
    });
};
</script>
<template>
    <Head title="Afiliados"></Head>
    <v-container>
        <BreadBrums :breadbrums="breadbrums"></BreadBrums>
        <v-row class="mt-0">
            <v-col cols="12">
                <v-card flat>
                    <v-card-title>
                        <v-row class="bg-primary d-flex align-center pa-3">
                            <v-col cols="12" sm="6" md="4"> Afiliados </v-col>
                            <v-col cols="12" sm="6" md="4" offset-md="4">
                                <v-text-field
                                    v-model="search"
                                    label="Buscar"
                                    append-inner-icon="mdi-magnify"
                                    variant="underlined"
                                    clearable
                                    hide-details
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table-server
                            v-model:items-per-page="itemsPerPage"
                            :headers="!mobile ? headers : []"
                            :class="[mobile ? 'mobile' : '']"
                            :items-length="totalItems"
                            :items="listUsuarios"
                            :loading="loading"
                            :search="search"
                            @update:options="loadItems"
                            height="auto"
                            no-data-text="No se encontrarón registros"
                            loading-text="Cargando..."
                            page-text="{0} - {1} de {2}"
                            items-per-page-text="Registros por página"
                            :items-per-page-options="[
                                { value: 10, title: '10' },
                                { value: 25, title: '25' },
                                { value: 50, title: '50' },
                                { value: 100, title: '100' },
                                {
                                    value: -1,
                                    title: 'Todos',
                                },
                            ]"
                        >
                            <template v-slot:item="{ item }">
                                <tr v-if="!mobile">
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.email }}</td>
                                    <td class="text-xs-right">
                                        {{ item.full_name }}
                                    </td>
                                    <td>{{ item.full_ci }}</td>
                                    <td>{{ item.dir }}</td>
                                    <td>{{ item.fono }}</td>
                                    <td>
                                        <v-avatar color="primary">
                                            <v-img
                                                v-if="item.url_foto"
                                                :src="item.url_foto"
                                                cover
                                                :lazy-src="item.url_foto"
                                            ></v-img>
                                            <span v-else>{{
                                                item.iniciales_nombre
                                            }}</span>
                                        </v-avatar>
                                    </td>
                                    <td>
                                        <div
                                            class="contenedor-acceso w-100 text-center pt-3"
                                        >
                                            <v-chip
                                                :color="
                                                    item.acceso == 1
                                                        ? 'success'
                                                        : 'error'
                                                "
                                                :prepend-icon="
                                                    item.acceso == 1
                                                        ? 'mdi-check'
                                                        : 'mdi-lock'
                                                "
                                            >
                                                <span
                                                    v-text="
                                                        item.acceso == 1
                                                            ? 'Habilitado'
                                                            : 'Denegado'
                                                    "
                                                ></span>
                                            </v-chip>
                                            <v-switch
                                                :model-value="item.acceso + ''"
                                                color="success"
                                                value="success"
                                                false-value="0"
                                                true-value="1"
                                                hide-details
                                                class="switch-center"
                                                @update:model-value="
                                                    actualizaAcceso(
                                                        $event,
                                                        item
                                                    )
                                                "
                                            ></v-switch>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <v-btn
                                            color="error"
                                            size="small"
                                            class="pa-1 ma-1"
                                            @click="eliminarUsuario(item)"
                                            icon="mdi-trash-can"
                                        ></v-btn>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td>
                                        <ul class="flex-content">
                                            <li
                                                class="flex-item"
                                                data-label="Id"
                                            >
                                                {{ item.id }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Correo"
                                            >
                                                {{ item.email }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Nombre"
                                            >
                                                {{ item.full_name }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="C.I:"
                                            >
                                                {{ item.full_ci }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Dirección"
                                            >
                                                {{ item.dir }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Teléfono/Celular"
                                            >
                                                {{ item.fono }}
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Foto Perfil"
                                            >
                                                <v-avatar color="primary">
                                                    <v-img
                                                        v-if="item.url_foto"
                                                        :src="item.url_foto"
                                                        cover
                                                        :lazy-src="
                                                            item.url_foto
                                                        "
                                                    ></v-img>
                                                    <span v-else>{{
                                                        item.iniciales_nombre
                                                    }}</span>
                                                </v-avatar>
                                            </li>
                                            <li
                                                class="flex-item"
                                                data-label="Acceso"
                                            >
                                                <div
                                                    class="contenedor-acceso w-100 pt-3"
                                                >
                                                    <v-chip
                                                        :color="
                                                            item.acceso == 1
                                                                ? 'success'
                                                                : 'error'
                                                        "
                                                        :prepend-icon="
                                                            item.acceso == 1
                                                                ? 'mdi-check'
                                                                : 'mdi-lock'
                                                        "
                                                    >
                                                        <span
                                                            v-text="
                                                                item.acceso == 1
                                                                    ? 'Habilitado'
                                                                    : 'Denegado'
                                                            "
                                                        ></span>
                                                    </v-chip>
                                                    <v-switch
                                                        :model-value="
                                                            item.acceso + ''
                                                        "
                                                        color="success"
                                                        value="success"
                                                        false-value="0"
                                                        true-value="1"
                                                        hide-details
                                                        @update:model-value="
                                                            actualizaAcceso(
                                                                $event,
                                                                item
                                                            )
                                                        "
                                                    ></v-switch>
                                                </div>
                                            </li>
                                        </ul>
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                class="text-center pa-5"
                                            >
                                                <v-btn
                                                    color="error"
                                                    size="small"
                                                    class="pa-1 ma-1"
                                                    @click="
                                                        eliminarUsuario(item)
                                                    "
                                                    icon="mdi-trash-can"
                                                ></v-btn>
                                            </v-col>
                                        </v-row>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table-server>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<style scoped>
.switch-center {
    display: flex;
    justify-content: center;
}
</style>
