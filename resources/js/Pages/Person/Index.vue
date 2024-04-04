<template>

    <Head title="Pessoas" />
    <NavBar />
    <v-app>
        <v-main class="d-flex">
            <v-container class="container">
                <v-card flat class="border mb-4" width="900">
                    <div class="d-flex justify-space-between mt-5">
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
                    <v-table>
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
                                <td>{{ person.cpf }}</td>
                                <td>{{ person.birthdate }}</td>
                                <td>{{ person.gender }}</td>
                                <td>
                                    <div>
                                        <v-btn @click="editSelectedPerson(person)" color="white">
                                            <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                        </v-btn>

                                        <v-btn @click="deletePerson(person.id)" color="red" dark class="ml-3">
                                            <v-icon dark class="mdi mdi-delete-forever md-4"></v-icon>
                                        </v-btn>
                                    </div>
                                    <v-dialog v-model="isEditPersonOpen" @update:modelValue="updateEditStatus" >
                                            <EditPerson :isEditPersonOpen="isEditPersonOpen" @closeEditPerson="closeEditPerson" :person="selectedPerson" />
                                     </v-dialog>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                    <v-pagination v-model="page" :length="pageCount"></v-pagination>
                </v-card>
            </v-container>
        </v-main>
    </v-app>

</template>

<script setup>

import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import NavBar from '@/Components/NavBar.vue';
import PersonForm from '@/Components/PersonForm.vue';
import EditPerson from '@/Components/EditPerson.vue';
import axios from 'axios';

const selectedPerson = ref(null);

const editSelectedPerson = (person) => { 
    selectedPerson.value = person
    isEditPersonOpen.value = true;
}


const isDialogOpen = ref(false);
const isEditPersonOpen = ref(false);

const page = ref(1);
const itemPerPage = 10;
const searchFilter = ref('');

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


const closeEditPerson = () => {
    isEditPersonOpen.value = false;
}


const filteredPerson = computed(() => {
    if (searchFilter.value !== '') {
        return props.people.data.filter(person =>
            person.name.toLowerCase().includes(searchFilter.value.toLowerCase()) ||
            person.birthdate.includes(searchFilter.value) ||
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


const deletePerson = (id) => {
    axios.delete(`/person/${id}`)
        .then(response => {
            location.reload();
        })
        .catch(error => {
            console.error('Error deleting person:', error);
        });
}

</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    margin-top: -800px;
    margin-left: 300px;
}

.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}

.error-msg {
    color: red;
}
</style>
