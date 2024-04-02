<template>
    <v-app>
        <Head title="Atendimento Cidadão" />
        <NavBar />

        <v-main class="main-content">
            <v-container class="container">
                <h1>Atende Cidadão</h1>
                <v-img class="img-content" :width="500" aspect-ratio="16/9" cover
                    src="/img/Wavy_Bus-26_Single-04.jpg"></v-img>
            </v-container>

        </v-main>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/Components/NavBar.vue';

</script>

<style scoped>

.container {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin-top: -800px;
}


h1  {
    font-weight: bold;
    font-size: 45px;
    margin-bottom: 50px;
}


</style>
