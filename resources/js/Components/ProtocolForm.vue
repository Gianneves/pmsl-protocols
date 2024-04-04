<template>
    <v-card-text class="custom-card">
        <v-card-text>
            <v-card-title>Cadastrar Protocolo</v-card-title>
            <v-form @submit.prevent="handleSubmit">
                <v-container>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field label="Data" type="date" id="created_data" for="created_data"
                                v-model="form.created_data" required variant="outlined">
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field label="Prazo" id="deadline" type="number" v-model="form.deadline" required
                                variant="outlined"></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-select label="Contribuinte" v-model="form.person_id" name="person_id">
                                <option v-for="person in people" :key="person.id" :value="person.id">{{ person.name }}
                                </option>
                            </v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-textarea label="Descrição" id="description" v-model="form.description" required
                                variant="outlined" maxlength="2000"
                                style="width: 500px;" >
                            </v-textarea>
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn variant="text" @click="$emit('closeDialog')">Cancelar</v-btn>
                    <v-btn variant="tonal" color="success" >Salvar</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card-text>
</template>

<script setup>


import { useForm } from '@inertiajs/vue3';


const form = useForm({
    description: '',
    created_data: '',
    deadline: '',
    person_id: ''
});

const handleSubmit = () => {
    
}


const props = defineProps({
    people: Array,
    isDialogOpen: Boolean
});

</script>


<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}
</style>
