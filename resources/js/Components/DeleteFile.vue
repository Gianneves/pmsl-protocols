<template>
    <v-container class="d-flex align-center justify-center">
        <v-card class="custom-card" width="400px">
            <v-card-text>Tem certeza que deseja excluir {{ props.file }}?</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="closeDeleteFile">Cancelar</v-btn>
                <v-btn variant="tonal" color="red" @click="deleteFile">Deletar</v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script setup>
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import { defineProps, defineEmits } from 'vue';


const toast = useToast();

const emit = defineEmits(['closeDeleteFile', 'fileDeleted']);

const props = defineProps({
    file: String,
    protocol: Object,
    files: Array
});

const deleteFile = async () => {
    try {
        const response = await axios.delete(route('protocols.deleteFile', { protocol: props.protocol.id, fileName: props.file }));
        if (response.status === 200) {
            const updatedFiles = props.files.filter(file => file !== props.file);
            emit('fileDeleted', updatedFiles);
            emit('closeDeleteFile');
            toast.success("Arquivo excluído com sucesso!", { position: 'top-right' });
        } else {
            throw new Error("Erro ao excluir o arquivo");
        }
    } catch (error) {
        toast.error("Erro ao excluir o arquivo!", { position: 'top-right' });
    }
};

const closeDeleteFile = () => {
    emit('closeDeleteFile');
};


</script>

<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}
</style>
