<template>
    <v-card class="d-flex justify-center p-5">
        <v-container class="d-flex flex-col p-5">
            <v-card-title class="text-center mt-4">
                Registro de acompanhamento
            </v-card-title>
            <ul class="mx-3 my-4 register-list">
                <li v-for="register in filteredAttendance" :key="register.id" class="register-item p-2">
                    <template v-if="register.description !== '' && register.description !== null">
                        <div>Descrição: {{ register.description }}</div>
                    </template>

                    <div>Situação: {{ getSituationName(register.situation) }}</div>
                    <div>Data: {{ formatData(register.created_at) }}</div>
                </li>
            </ul>
        </v-container>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn variant="text" @click="$emit('closeRegister')">Voltar</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import { computed } from 'vue';
import { defineProps } from 'vue';
const emit = defineEmits(['closeRegister']);

const props = defineProps({
    attendance: Array,
    protocolId: Number
});

const filteredAttendance = computed(() => {
    return props.attendance.filter(register => register.protocol_id === props.protocolId);
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

<style scoped>
.register-list {
    max-height: 300px;
    overflow-y: auto;
    
}

.register-item {
    margin-bottom: 10px;
    background-color: #FFCDD2;
}
</style>
