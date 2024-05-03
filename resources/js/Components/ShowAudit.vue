<template>

    <v-card class="text-center">
        <v-card-title>Auditoria</v-card-title>
        <div class="py-4">
            <ul class="flex justify-around py-3">
                <li><b>Id:</b> {{ props.audits.id }}</li>
                <li><b>Data:</b> {{ formatDate(props.audits.created_at) }}</li>
                <li><b>Usuário:</b> {{ props.audits.user.name }}</li>
            </ul>
            <ul class="flex justify-around py-3">
                <li><b>Evento:</b> {{ translateEvents(props.audits.event) }}</li>
                <li><b>Tabela:</b> {{ translateTables(props.audits.auditable_type) }}</li>
                <li><b>ID Auditado:</b> {{ props.audits.auditable_id }}</li>
            </ul>
            <ul class="flex justify-around py-3">
                <li style="max-width: 300px; word-wrap: break-word;" ><b>Dados Anteriores:</b> {{  props.audits.old_values}}</li>
                <li style="max-width: 300px; word-wrap: break-word;" ><b>Dados Novos:</b> {{ props.audits.new_values }}</li>
               
            </ul>
            <ul class="flex justify-around py-3">
                <li><b>URL:</b> {{ props.audits.url }}</li>
                <li><b>IP:</b> {{ props.audits.ip_address }}</li>
            </ul>
        </div>
        <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="$emit('closeDialog')">Voltar</v-btn>
            </v-card-actions>
    </v-card>

</template>

<script setup>
import dayjs from 'dayjs';

const props = defineProps({
    audits: Object
});

const emit = defineEmits(['closeDialog']);

const translateEvents = (value) => {
    switch (value) {
        case 'created':
            return 'Criado';
        case 'updated':
            return 'Atualizado';
        case 'deleted':
            return 'Deletado';
        case 'restored':
            return 'Restaurado';
        default:
            return ''
    }
}

const translateTables = (value) => {
    switch (value) {
        case 'App\\Models\\Person':
            return 'Pessoas';
        case 'App\\Models\\Departaments':
            return 'Departamentos';
        case 'App\\Models\\Protocols':
            return 'Protocolos';
        case 'App\\Models\\User':
            return 'Usuários';
        case 'App\\Models\\Attendance':
            return 'Atendimento';
        case 'App\\Models\\GrantAccess':
            return 'Liberar Acesso';
        default:
            return ''
    }
}



const formatDate = (created_at) => {
    return dayjs(created_at).format('DD/MM/YYYY HH:mm:ss');
};

</script>