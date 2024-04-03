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
                            <v-dialog v-model="isDialogOpen"  @update:modelValue="updateDialogStatus"  width="900px" >
                                <ProtocolForm  :isDialogOpen="isDialogOpen" @closeDialog="closeDialog"  />
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

import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import NavBar from '@/Components/NavBar.vue';
import ProtocolForm from '@/Components/ProtocolForm.vue';
import axios from 'axios';

const isDialogOpen = ref(false);


const props = defineProps({
    protocols: Object
});

const updateDialogStatus = (value) => {
  isDialogOpen.value = value;
};

const closeDialog = () => {
  isDialogOpen.value = false;
};


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
    margin-top: -1200px;
    margin-left: 300px;
}

.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
