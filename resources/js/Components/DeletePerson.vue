<template>
    <v-container class="d-flex align-center justify-center" >
        <v-card class="custom-card" width="400px">
            <v-card-text>Tem certeza que deseja excluir {{ props.person.name }} ?</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="$emit('closeDeletePerson')">Cancelar</v-btn>
                <v-btn variant="tonal" color="red" @click="deletePerson(props.person)" >Deletar</v-btn>
            </v-card-actions>
        </v-card>
    </v-container>

</template>


<script setup>
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

const emit = defineEmits(['closeDeletePerson']);

const props = defineProps({
    isDeletePersonOpen: Boolean,
    person: Object
});

const deletePerson = (person) => {
    axios.delete(`/person/${person.id}`)
        .then(response => {
            toast.success("Pessoa excluída com sucesso!", {
                position: 'top-right',
            });
            emit('closeDeletePerson');
        })
        .catch(error => {
            console.error('Error deleting person:', error);
            toast.error("Erro ao excluir a pessoa!", {
                position: 'top-right',
            });
        });
}

</script>

<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}
</style>