<template>

    <Head title="Auditoria" />
    <v-app>
        <AuthenticatedLayout>
            <v-main class="d-flex">
                <v-container class="container">
                    <v-card flat class="border mb-4" width="90%">
                        <div class="d-flex justify-space-between mt-5">
                            <v-card-title>Auditoria</v-card-title>
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
                                        Usuário
                                    </th>
                                    <th class="text-left">
                                        Evento
                                    </th>
                                    <th class="text-left">
                                        Data
                                    </th>
                                    <th class="text-left">
                                        Tabela
                                    </th>
                                    <th class="text-left">
                                        ID Auditado
                                    </th>
                                    <th class="text-left">
                                        Ações:
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="audit in displayedAudits" :key="audit.id">
                                    <td>{{ audit.id }}</td>
                                    <td>{{ audit.user.name }}</td>
                                    <td>{{ translateEvents(audit.event) }}</td>
                                    <td>{{ formatDate(audit.created_at) }}</td>
                                    <td>{{ translateTables(audit.auditable_type) }}</td>
                                    <td>{{ audit.auditable_id }}</td>
                                    <td>
                                        <div>
                                            <v-btn @click="showingAudit(audit)" color="white">
                                                <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                            </v-btn>
                                        </div>
                                        <v-dialog v-model="isDialogOpen" @update:modelValue="updateDialogStatus">
                                            <ShowAudit :isDialogOpen="isDialogOpen"
                                                @closeDialog="closeDialog" :audits="selectedAudit" />
                                        </v-dialog>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                        <v-pagination v-model="page" :length="pageCount"></v-pagination>
                    </v-card>
                </v-container>
            </v-main>
        </AuthenticatedLayout>

    </v-app>

</template>

<script setup>

import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShowAudit from '@/Components/ShowAudit.vue';
import dayjs from 'dayjs';

const selectedAudit = ref(null);
const page = ref(1);
const itemPerPage = 10;
const searchFilter = ref('');

const isDialogOpen = ref(false);

const props = defineProps({
    audits: Array
});

const updateDialogStatus = (value) => {
  isDialogOpen.value = value;
};

const closeDialog = () => {
  isDialogOpen.value = false;
};


const showingAudit = (audit) => { 
    selectedAudit.value = audit;
    isDialogOpen.value = true;
}


const filteredAudit = computed(() => {
    if (searchFilter.value !== '') {
        return props.audits.filter(audit =>
            audit.user.name.toLowerCase().includes(searchFilter.value.toLowerCase()) ||
            formatDate(audit.created_at).includes(searchFilter.value) ||
            translateTables(audit.auditable_type).toLowerCase().includes(searchFilter.value.toLowerCase()) ||
            translateEvents(audit.event).toLowerCase().includes(searchFilter.value.toLowerCase())
        );
    }
 
    return props.audits;
});

const displayedAudits = computed(() => {
    const start = (page.value - 1) * itemPerPage;
    const end = start + itemPerPage;
    return filteredAudit.value.slice(start, end);
});

const pageCount = computed(() => {
    return Math.ceil(filteredAudit.value.length / itemPerPage);
});


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
        default:
            return ''
    }
}


const formatDate = (created_at) => {
    return dayjs(created_at).format('DD/MM/YYYY HH:mm:ss');
};

</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    flex-direction: column;

}

.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
