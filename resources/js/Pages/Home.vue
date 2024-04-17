<template>
     <v-app>
        <v-navigation-drawer v-model="isDrawerOpen">
            <v-list>
                <v-list-item-title class="headline mb-5 mt-5"><v-avatar image="/img/455809-PFEHU6-634.jpg"
                        size="58"></v-avatar> Atende
                    Cidadão - Home</v-list-item-title>
                <v-list-item prepend-icon="mdi-home">
                    <Link href="/">Home</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi mdi-login">
                    <Link :href="route('login')">Entrar</Link>
                </v-list-item>
            </v-list>

        </v-navigation-drawer>
        <v-app-bar flat class="border-b flex justify-between" color="indigo-darken-1">
            <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
            <div class="flex-grow"></div> 
            <div class="hidden sm:flex sm:items-end mr-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <Dropdown>
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ $page.props.auth.user.name }}

                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>
                        </template>


                    </Dropdown>
                </div>
            </div>
        </v-app-bar>

        <main>
            <slot />
        </main>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
const isDrawerOpen = ref(false);
</script>