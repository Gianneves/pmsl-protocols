<template>

    <Head title="Pessoas" />
    <v-app>
        <AuthenticatedLayout>
            <v-main class="d-flex">
            <v-container class="container w-full lg:w-4/5 xl:w-3/4">
                <v-card flat class="border mb-4 w-full overflow-x-auto">
                    <div class="sm:flex justify-between items-center my-5 mx-5">
                        <v-card-title>Pessoas</v-card-title>
                        <v-card-title>
                            <v-btn @click="isDialogOpen = true">Cadastrar</v-btn>
                            <v-dialog v-model="isDialogOpen" @update:modelValue="updateDialogStatus" >
                              <PersonForm :isDialogOpen="isDialogOpen" @closeDialog="closeDialog" />
                            </v-dialog>
                        </v-card-title>
                    </div>
                    <div class="input-search">
                        <v-text-field label="Buscar" dense v-model="searchFilter" variant="outlined"></v-text-field>
                    </div>
                    <hr>
                    <v-table class="w-full" v-if="people.data.length > 0">
                        <thead>
                            <tr>
                                <th class="text-left">
                                    #
                                </th>
                                <th class="text-left">
                                    Nome
                                </th>
                                <th class="text-left">
                                    CPF
                                </th>
                                <th class="text-left">
                                    Data de Nascimento
                                </th>
                                <th class="text-left">
                                    Sexo
                                </th>
                                <th class="text-left">
                                    Ações:
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="person in displayedPerson" :key="person.id">
                                <td>{{ person.id }}</td>
                                <td>{{ person.name }}</td>
                                <td>{{ formatCPF(person.cpf) }}</td>
                                <td>{{ formatDate(person.birthdate) }}</td>
                                <td>{{ person.gender }}</td>
                                <td>
                                    <div class="flex items-center">
                                        <v-btn @click="editSelectedPerson(person)" color="white"  class="py-2 px-4" >
                                            <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                        </v-btn>

                                        <v-btn @click="deleteSelectPerson(person)" color="red" dark  class="py-2 px-4 ml-3">
                                            <v-icon dark class="mdi mdi-delete-forever md-4"></v-icon>
                                        </v-btn>
                                    </div>
                                    <v-dialog v-model="isDeletePersonOpen" @update:model-value="updateDeleteStatus" >
                                        <DeletePerson :isDeletePersonOpen="isDeletePersonOpen" @closeDeletePerson="closeDeletePerson" :person="selectedPerson" />
                                    </v-dialog>
                                    <v-dialog v-model="isEditPersonOpen" @update:modelValue="updateEditStatus" >
                                            <EditPerson :isEditPersonOpen="isEditPersonOpen" @closeEditPerson="closeEditPerson" :person="selectedPerson" />
                                     </v-dialog>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                    <v-card v-else>
                            <v-card-text class="flex justify-center items-center h-full">
                                Nenhuma pessoa encontrada!
                            </v-card-text>
                        </v-card>
                    <v-pagination v-model="page" :length="pageCount"></v-pagination>
                </v-card>
            </v-container>
        </v-main>
        </AuthenticatedLayout>
       
    </v-app>

</template>

<script setup>

import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PersonForm from '@/Components/PersonForm.vue';
import EditPerson from '@/Components/EditPerson.vue';
import DeletePerson from '@/Components/DeletePerson.vue';
import dayjs from 'dayjs';

const selectedPerson = ref(null);
const page = ref(1);
const itemPerPage = 10;
const searchFilter = ref('');


const isDialogOpen = ref(false);
const isEditPersonOpen = ref(false);
const isDeletePersonOpen = ref(false);


const editSelectedPerson = (person) => { 
    selectedPerson.value = person;
    isEditPersonOpen.value = true;
}


const deleteSelectPerson = (person) => {
    selectedPerson.value = person;
    isDeletePersonOpen.value = true;
}

const props = defineProps({
    people: Object,
});

const updateDialogStatus = (value) => {
  isDialogOpen.value = value;
};

const closeDialog = () => {
  isDialogOpen.value = false;
};

const updateEditStatus = (value) => {
  isEditPersonOpen.value = value;
};


const closeDeletePerson = () => {
  isDeletePersonOpen.value = false;
};

const updateDeleteStatus = (value) => {
  isDeletePersonOpen.value = value;
};

const closeEditPerson = () => {
    isEditPersonOpen.value = false;
}


const filteredPerson = computed(() => {
    if (searchFilter.value !== '') {
        return props.people.data.filter(person =>
            person.name.toLowerCase().includes(searchFilter.value.toLowerCase()) ||
            formatDate(person.birthdate).includes(searchFilter.value) ||
            person.cpf.includes(searchFilter.value) ||
            person.gender.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }
    return props.people.data;
});

const displayedPerson = computed(() => {
    const start = (page.value - 1) * itemPerPage;
    const end = start + itemPerPage;
    return filteredPerson.value.slice(start, end);
});

const pageCount = computed(() => {
    return Math.ceil(filteredPerson.value.length / itemPerPage);
});

const updatePage = (newPage) => {
    page.value = newPage;
}

const formatDate = (value) => {
    const formattedDate = dayjs(value).format('DD/MM/YYYY');
    return formattedDate;
}

const formatCPF = (cpf) => {
    return cpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
} 

</script>

<style scoped>

.container {
    display: flex;
    justify-content: center;
    flex-direction: column;
 
}  

.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}

</style>
