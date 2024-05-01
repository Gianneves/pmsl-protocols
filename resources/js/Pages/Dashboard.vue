<template>

    <Head title="Atendimento Cidadão" />
    <v-app>
        <AuthenticatedLayout class="custom-background">
            <v-main>
                <div class="my-5 mx-5">
                    <v-card-title class="title ">
                        Atendimento ao Cidadão - PMSL
                    </v-card-title>
                </div>
            </v-main>

        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


</script>

<style scoped>
.custom-background {
    background-image: url('/public/img/2228834.jpg');
    background-size: cover;
    background-position-x: right;
}

.title {
    font-family: "Barlow", sans-serif;
    font-weight: 800;
    color: #536DFE;
    font-size: 30px;
}
</style>
