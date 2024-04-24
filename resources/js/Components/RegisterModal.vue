<template>
    <v-card>
        <v-card-title>
            Registro de acompanhamento
        </v-card-title>
        <v-container>
            <ul v-for="register in attendance" :key="register.id" class="mx-3 my-4">
                <li>descrição: {{ register.description }}</li>
                <li>Situação: {{ getSituationName(register.situation) }}</li>
                <li>Data: {{ formatData(register.created_at) }}</li>
            </ul>

        </v-container>
        <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="$emit('closeRegister')">Voltar</v-btn>
            </v-card-actions>
    </v-card>
</template>

<script setup>
import { defineProps } from 'vue';
const emit = defineEmits(['closeRegister']);

const props = defineProps({
    attendance: Array
});


const getSituationName = (situation) => {
    switch (situation) {
        case 'A':
            return 'Aberto';
        case 'E':
            return 'Em atendimento'; 
        case 'S':
            return 'Solucionado'; 
        default:
            return ''; 
    }
}

const formatData = (created_at) => {
    const dateObject = new Date(created_at);
    const day = dateObject.getDate();
    const month = dateObject.getMonth() + 1;
    const year = dateObject.getFullYear();
    const formattedDate = `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
    return formattedDate;
}

</script>