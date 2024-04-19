<template>
    <v-app>
        <AuthenticatedLayout>
            <v-main class="d-flex">
                <v-container class="container">
                    <v-card flat class="border mb-4" width="90%">
                        <div class="d-flex justify-space-between mt-5">
                            <v-card-title>Departamentos</v-card-title>
                            <v-card-title>
                                <v-btn @click="isDialogOpen = true">Cadastrar</v-btn>
                                <v-dialog v-model="isDialogOpen" @update:modelValue="updateDialogStatus" width="500px">
                                    <DepartamentForm :isDialogOpen="isDialogOpen" @closeDialog="closeDialog" />
                                </v-dialog>
                            </v-card-title>
                        </div>
                        <div class="input-search">
                            <v-text-field label="Buscar" dense v-model="searchFilter" variant="outlined"></v-text-field>
                        </div>
                        <hr>
                        <v-table v-if="departament && departament.data && departament.data.length > 0">
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        #
                                    </th>
                                    <th class="text-left">
                                        Nome
                                    </th>
                                    <th class="text-left">
                                        Ações:
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="dep in displayedDepartament" :key="dep.id">
                                    <td>{{ dep.id }}</td>
                                    <td>{{ dep.name }}</td>
                                    <td>
                                        <div>
                                            <Link :href="route('departamentos.edit', dep.id)">
                                            <v-btn color="white">
                                                <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                            </v-btn>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                        <v-card v-else>
                            <v-card-text class="flex justify-center items-center h-full">
                                Nenhum departamento encontrado!
                            </v-card-text>
                        </v-card>
                        <v-pagination v-model="page" :length="pageCount"></v-pagination>
                    </v-card>
                </v-container>
            </v-main>

        </AuthenticatedLayout>
    </v-app>

    <Head title="Departamentos" />



</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { ref, computed } from 'vue';
import DepartamentForm from '@/Components/DepartamentForm.vue';

const isDialogOpen = ref(false);

const updateDialogStatus = (value) => {
    isDialogOpen.value = value;
};

const closeDialog = () => {
    isDialogOpen.value = false;
};


const props = defineProps({
    departament: Object
});


const searchFilter = ref('');
const page = ref(1);
const itemPerPage = 10;

const filteredDepartament = computed(() => {
    if (searchFilter.value !== '') {
        return props.departament.data.filter(dep =>
            dep.name.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }
    return props.departament.data;
});


const displayedDepartament = computed(() => {
    const start = (page.value - 1) * itemPerPage;
    const end = start + itemPerPage;
    return filteredDepartament.value.slice(start, end);
});

const pageCount = computed(() => {
    return Math.ceil(filteredDepartament.value.length / itemPerPage);
});

const updatePage = (newPage) => {
    page.value = newPage;
}

</script>

<style scoped>
.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
