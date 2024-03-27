<template>
    <Head title="Pessoas" />
    <v-app>
        <v-main>
            <v-container>
                <v-card flat class="border mb-4">
                    <div class="d-flex justify-space-between">
                        <v-card-title>Pessoas</v-card-title>
                        <v-card-title>
                            <v-btn @click="isDialogOpen = true">Cadastrar</v-btn>

                            <v-dialog v-model="isDialogOpen">

                            </v-dialog>
                        </v-card-title>
                       
                    </div>
                    <v-table>
                        <thead>
                            <tr></tr>
                        </thead>
                    </v-table>
                </v-card>
            </v-container>
        </v-main>
    </v-app>

</template>

<script setup>

import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const isDialogOpen = ref('false');

</script>