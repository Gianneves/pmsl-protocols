<template>
    <v-container class="d-flex align-center justify-center" >
        <v-card class="custom-card" width="400px">
            <v-card-text>Tem certeza que deseja excluir protocolo de N.º {{ props.protocol }} ?</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="$emit('closeDeleteProtocol')">Cancelar</v-btn>
                <v-btn variant="tonal" color="red" @click="deleteProtocol(props.protocol)" >Deletar</v-btn>
            </v-card-actions>
        </v-card>
    </v-container>

</template>


<script setup>
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

const emit = defineEmits(['closeDeleteProtocol']);

const props = defineProps({
    isDeletePersonOpen: Boolean,
    protocol: Object
});

const deleteProtocol = (protocol) => {
    axios.delete(`/protocols/${protocol}`)
        .then(response => {
            toast.success("Protocolo excluído com sucesso!", {
                position: 'top-right',
            });
            emit('closeDeleteProtocol');
            window.location.reload();
        })
        .catch(error => {
            console.error('Error deleting protocol:', error);
            toast.error("Erro ao excluir protocolo!", {
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