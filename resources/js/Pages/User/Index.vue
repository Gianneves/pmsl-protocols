<template>
    <Head title="Usuários" />
    <v-app>
        <AuthenticatedLayout>
            <v-main class="d-flex">
                <v-container class="container">
                    <v-card flat class="border mb-4" width="90%">
                        <div class="d-flex justify-space-between mt-5">
                            <v-card-title>Usuários</v-card-title>
                            <v-card-title>
                                <v-btn>Cadastrar Usuário</v-btn>
                            </v-card-title>
                        </div>
                        <div class="input-search">
                            <v-text-field label="Buscar" dense v-model="searchFilter" variant="outlined"></v-text-field>
                        </div>
                        <hr>
                        <v-data-table v-if="protocols.data.length > 0">
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        #
                                    </th>
                                    <th class="text-left">
                                        E-mail
                                    </th>
                                    <th class="text-left">
                                        Perfil
                                    </th>
                                    <th class="text-left">
                                        Ativo
                                    </th>
                                    <th class="text-left">
                                        Ações:
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="protocol in filteredProtocol" :key="protocol.id">
                                    <td>id</td>
                                    <td>email</td>
                                    <td></td>
                                    <td>perfil</td>
                                    <td>ativo</td>
                                    <td>
                                        <div>
                                            <Link :href="route('protocols.edit', protocol.id)">
                                            <v-btn color="white">
                                                <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                            </v-btn>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </v-data-table>
                        <v-card v-else>
                            <v-card-text class="flex justify-center items-center h-full">
                                Nenhum Usuário encontrado!
                            </v-card-text>
                        </v-card>
                    </v-card>
                </v-container>
            </v-main>

        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { ref, computed } from 'vue';



const isDialogOpen = ref(false);
const isDeleteProtocolOpen = ref(false);

const props = defineProps({
});




const searchFilter = ref('');

const filteredProtocol = computed(() => {
    if (searchFilter.value !== '') {
        return props.protocols.data.filter(protocol =>
            /*       protocol.id.includes(searchFilter.value) || */
            protocol.created_data.includes(searchFilter.value) ||
            protocol.deadline.includes(searchFilter.value) ||
            protocol.person.name.toLowerCase().includes(searchFilter.value.toLowerCase()));
    }
    return props.protocols.data;
});





</script>

<style scoped>
.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
