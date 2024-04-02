<template>

    <Head title="Protocolos" />
    <NavBar />
    <v-app>
        <v-main class="d-flex">
            <v-container class="container">
                <v-card flat class="border mb-4" width="900">
                    <div class="d-flex justify-space-between mt-5">
                        <v-card-title>Protocolos</v-card-title>
                        <v-card-title>
                            <v-btn @click="isDialogOpen = true">Cadastrar</v-btn>
                            <v-dialog v-model="isDialogOpen">
                                <v-card-text class="custom-card">
                                    <v-card-text>
                                        <v-card-title>Cadastrar Protocolo</v-card-title>
                                        <v-form @submit.prevent="submit">
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" md="4">
                                                        <v-text-field label="Descrição" id="description"
                                                            v-model="form.description" required variant="outlined">
                                                        </v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-text-field label="Data" type="date" id="created_data"
                                                            for="created_at" v-model="form.created_data" required
                                                            variant="outlined">
                                                        </v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-text-field label="Prazo" id="deadline" type="number"
                                                            v-model="form.deadline" required
                                                            variant="outlined"></v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-select label="Contribuinte" v-model="form.protocols_id"
                                                            name="protocols_id">
                                                            <option v-for="person in people" :key="person.id"
                                                                :value="person.id">{{ person.name }}</option>
                                                        </v-select>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn variant="text" @click="isDialogOpen = false">Cancelar</v-btn>
                                                <v-btn variant="tonal" color="success" @click="submit">Salvar</v-btn>
                                            </v-card-actions>
                                        </v-form>
                                    </v-card-text>
                                </v-card-text>
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
                                    Número
                                </th>
                                <th class="text-left">
                                    Data
                                </th>
                                <th class="text-left">
                                    Prazo
                                </th>
                                <th class="text-left">
                                    Nome do Contribuinte
                                </th>
                                <th class="text-left">
                                    Ações:
                                </th>
                            </tr>
                        </thead>
                        <!--     <tbody>
                            <tr v-for="protocol in people" :key="protocol.id">
                                <td>{{ protocol.id }}</td>
                                <td>
                                    <div>
                                        <v-btn @click="isEditOpen = true" color="white">
                                            <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                        </v-btn>

                                        <v-btn @click="deletePerson(protocol.id)" color="red" dark class="ml-3">
                                            <v-icon dark class="mdi mdi-delete-forever md-4"></v-icon>
                                        </v-btn>
                                    </div>
                                </td>
                            </tr>
                        </tbody> -->
                    </v-table>
                </v-card>
            </v-container>
        </v-main>
    </v-app>

</template>

<script setup>

import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import NavBar from '@/Components/NavBar.vue';
import axios from 'axios';

const isDialogOpen = ref(false);

const form = useForm({
    description: '',
    created_data: '',
    deadline: '',
    protocols_id: ''
});



const submit = () => {
    form.post(route('protocols.store'));
    form.reset();
    isDialogOpen.value = false;
}

defineProps({
    people: Array
});





/* const searchFilter = ref('');

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
  */

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
    margin-top: -1700px;
    margin-left: 500px;
}

.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}

.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
