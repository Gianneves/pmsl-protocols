<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
const isDrawerOpen = ref(false);
</script>

<template>
    <v-app>
        <main>
            <slot />
        </main>
    
    </v-app>
</template>
