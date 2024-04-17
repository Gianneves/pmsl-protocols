<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';


const showingNavigationDropdown = ref(false);
const isDrawerOpen = ref(false);

</script>

<template>

    <v-app>
        <v-navigation-drawer v-model="isDrawerOpen">
            <v-list>
                <v-list-item-title class="headline mb-5 mt-5"><v-avatar image="/img/455809-PFEHU6-634.jpg"
                        size="58"></v-avatar> Atende
                    Cidadão</v-list-item-title>
                <v-list-item prepend-icon="mdi-home">
                    <Link :href="route('dashboard')">Home</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-badge-account-horizontal-outline">
                    <Link :href="route('person.index')">Pessoas</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-school">
                    <Link :href="route('protocols.index')">Protocolos</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-account-group">
                    <Link :href="route('user.index')">Usuários</Link>
                </v-list-item>
                <v-list-item prepend-icon="mdi-cog-outline">Auditoria</v-list-item>
            </v-list>

        </v-navigation-drawer>
        <v-app-bar flat class="border-b flex justify-between" color="indigo-darken-1">
            <v-app-bar-nav-icon @click="isDrawerOpen = !isDrawerOpen"></v-app-bar-nav-icon>
            <div class="flex-grow"></div>
            <div class="hidden sm:flex sm:items-end mr-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                <v-btn id="menu-activator" color="light">
                    {{ $page.props.auth.user.name }}
                    <v-icon>mdi-chevron-down</v-icon>
                </v-btn>

                <v-menu activator="#menu-activator">
                    <v-list class="text-center" >
                        <Link :href="route('logout')" method="post">Sair</Link>
                    </v-list>
                </v-menu>
            </div>

            </div>
    
        </v-app-bar>

        <main>
            <slot />
        </main>
    </v-app>
</template>