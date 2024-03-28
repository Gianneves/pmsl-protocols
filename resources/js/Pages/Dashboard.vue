<template>
    <Head title="Atendimento Cidadão" />
    <NavBar />
    <v-app>
        <v-main class="main-content" >
            <v-container> <v-text class="bcd">content</v-text></v-container>
           
        </v-main>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/Components/NavBar.vue';

</script>

<style scoped>

.main-content {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    margin-top: -1600px;
}

.bcd {
    
    margin-top: 100px;
}
</style>
