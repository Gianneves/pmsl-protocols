<template>

    <Head title="Usuários" />
    <v-app>
        <AuthenticatedLayout>
            <v-main class="d-flex">
                <v-container class="container">
                    <v-card flat class="border mb-4" width="90%">
                        <div class="d-flex justify-space-between mt-5">
                            <v-card-title>Usuários</v-card-title>
                            <v-card-title v-if="authUser.profile == 'T' || authUser.profile == 'S'">
                                <Link :href="route('register')">
                                <v-btn>Cadastrar Usuário</v-btn>
                                </Link>
                            </v-card-title>
                        </div>
                        <div class="input-search">
                            <v-text-field label="Buscar" dense v-model="searchFilter" variant="outlined"></v-text-field>
                        </div>
                        <hr>
                        <v-table v-if="user.length > 0">
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
                                <tr v-for="user in displayedUser" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ formatedProfile(user.profile) }}</td>
                                    <td>{{ user.active }}</td>
                                    <td>
                                        <div>
                                            <Link :href="route('user.edit', {user: user.id})" >
                                                <v-btn color="white">
                                                    <v-icon class="mdi mdi-eye" color="indigo"></v-icon>
                                                 </v-btn>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                        <v-card v-else>
                            <v-card-text class="flex justify-center items-center h-full">
                                Nenhum Usuário encontrado!
                            </v-card-text>
                        </v-card>
                        <v-pagination v-model="page" :length="pageCount"></v-pagination>
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


const page = ref(1);
const itemPerPage = 10;
const searchFilter = ref('');

const props = defineProps({
    user: Array,
    authUser: Object
});

const formatedProfile = (profile) => {
    if (profile === 'T') return 'Administrador TI'
    if (profile === 'S') return 'Administrador Sistema'
    if (profile === 'A') return 'Atendente'
}

const filteredUser = computed(() => {
    if (searchFilter.value !== '') {
        return props.user.filter(u =>
            u.email.includes(searchFilter.value.toLowerCase()));
    }
    return props.user;
});


const displayedUser = computed(() => {
    const start = (page.value - 1) * itemPerPage;
    const end = start + itemPerPage;
    return filteredUser.value.slice(start, end);
});

const pageCount = computed(() => {
    return Math.ceil(filteredUser.value.length / itemPerPage);
});

const updatePage = (newPage) => {
    page.value = newPage;
}




</script>

<style scoped>
.input-search {
    width: 400px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
