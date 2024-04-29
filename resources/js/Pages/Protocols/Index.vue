<template>
    <v-app>
        <AuthenticatedLayout>
            <v-main>
                <v-container class="container">
                    <v-card flat class="border" width="90%">
                        <div class="d-flex justify-space-between my-5 mx-5">
                            <div>
                                <v-btn color="indigo">
                                    <a href="pdf/protocolPdf">
                                        <v-icon icon="mdi-download-outline" class="mr-3"></v-icon> Gerar PDF
                                    </a>
                                </v-btn>
                            </div>
                            <div>
                                <v-btn @click="isDialogOpen = true">Cadastrar</v-btn>
                                <v-dialog v-model="isDialogOpen" @update:modelValue="updateDialogStatus" width="900px">
                                    <ProtocolForm :isDialogOpen="isDialogOpen" @closeDialog="closeDialog"
                                        :people="people" :departament="departament" />
                                </v-dialog>
                            </div>
                        </div>
                      
                        <v-card-title>Protocolos</v-card-title>
                        <div class="input-search">
                            <v-text-field label="Buscar" dense v-model="searchFilter" variant="outlined"></v-text-field>
                        </div>
                        <hr>
                        <v-table v-if="protocols.data.length > 0">
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
                                        Departamento
                                    </th>
                                    <th class="text-left">
                                        Situação
                                    </th>
                                    <th class="text-left">
                                        Ações:
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="protocol in displayedProtocol" :key="protocol.id">
                                    <td>{{ protocol.id }}</td>
                                    <td>{{ protocol.created_data }}</td>
                                    <td>{{ formatDeadline(protocol.created_data, protocol.deadline) }}</td>
                                    <td>{{ protocol.person.name }}</td>
                                    <td>{{ protocol.departaments.name }}</td>
                                    <td>
                                        <div :class="getSituationStyle(protocol.latest_attendance_situation)"></div>
                                        {{ getSituationName(protocol.latest_attendance_situation) }}
                                    </td>
                                    <td>
                                        <div>
                                            <Link :href="route('protocols.edit', protocol.id)">
                                            <v-btn color="white">
                                                <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                            </v-btn>
                                            </Link>
                                            <v-btn @click="deleteSelectProtocol(protocol.id)" color="red" dark
                                                class="ml-3">
                                                <v-icon dark class="mdi mdi-delete-forever md-4"></v-icon>
                                            </v-btn>
                                        </div>
                                        <v-dialog v-model="isDeleteProtocolOpen"
                                            @update:model-value="updateDeleteStatus">
                                            <DeleteProtocol :isDeleteProtocolOpen="isDeleteProtocolOpen"
                                                @closeDeleteProtocol="closeDeleteProtocol"
                                                :protocol="selectedProtocol" />
                                        </v-dialog>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                        <v-card v-else>
                            <v-card-text class="flex justify-center items-center h-full">
                                Nenhum protocolo encontrado!
                            </v-card-text>
                        </v-card>
                        <v-pagination v-model="page" :length="pageCount"></v-pagination>
                    </v-card>
                </v-container>
            </v-main>

        </AuthenticatedLayout>
    </v-app>

    <Head title="Protocolos" />



</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { ref, computed } from 'vue';
import ProtocolForm from '@/Components/ProtocolForm.vue';
import DeleteProtocol from '@/Components/DeleteProtocol.vue';


const isDialogOpen = ref(false);
const isDeleteProtocolOpen = ref(false);

const props = defineProps({
    protocols: Object,
    people: Array,
    departament: Array,
    authUser: Object
});


const selectedProtocol = ref(null);

const updateDialogStatus = (value) => {
    isDialogOpen.value = value;
};

const closeDialog = () => {
    isDialogOpen.value = false;
};

const deleteSelectProtocol = (protocol) => {
    selectedProtocol.value = protocol;
    isDeleteProtocolOpen.value = true;
}

const closeDeleteProtocol = () => {
    isDeleteProtocolOpen.value = false;
};

const updateDeleteStatus = (value) => {
    isDeleteProtocolOpen.value = value;
};


const searchFilter = ref('');
const page = ref(1);
const itemPerPage = 10;



const filteredProtocol = computed(() => {
    if (searchFilter.value !== '') {
        return props.protocols.data.filter(protocol =>
            protocol.created_data.includes(searchFilter.value) ||
            protocol.person.name.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }
    return props.protocols.data;
});


const displayedProtocol = computed(() => {
    const start = (page.value - 1) * itemPerPage;
    const end = start + itemPerPage;
    return filteredProtocol.value.slice(start, end);
});

const pageCount = computed(() => {
    return Math.ceil(filteredProtocol.value.length / itemPerPage);
});


const formatDeadline = (created_data, deadline) => {
    const created_date_parts = created_data.split("/");
    const startDate = new Date(
        created_date_parts[2],
        created_date_parts[1] - 1,
        created_date_parts[0]
    );

    let endDate = new Date(startDate);

    let daysToAdd = deadline;
    let weekdaysAdded = 0;
    while (weekdaysAdded < daysToAdd) {
        endDate.setDate(endDate.getDate() + 1);
        if (endDate.getDay() !== 0 && endDate.getDay() !== 6) {
            weekdaysAdded++;
        }
    }
    const formattedEndDate = `${endDate.getDate()}/${endDate.getMonth() + 1}/${endDate.getFullYear()}`;
    return formattedEndDate;
}



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

const getSituationStyle = (situation) => {
    switch (situation) {
        case 'A':
            return 'situation-red';
        case 'E':
            return 'situation-yellow';
        case 'S':
            return 'situation-green ';
        default:
            return '';
    }
};



</script>

<style scoped>
.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}


.situation-green {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: green;
}

.situation-yellow {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: yellow;
}

.situation-red {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: red;
}
</style>
