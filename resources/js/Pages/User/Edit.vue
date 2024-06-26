<template>
    <AuthenticatedLayout>

        <Head title="Editar Usuário" />

        <v-main>
            <v-card-text class="mt-3 ml-5 font-weight-bold">Usuários > Editar Usuário</v-card-text>
            <v-container class="d-flex align-center justify-center">

                <v-card class="border d-flex flex-col text-center custom-card" width="50%">
                    <v-card-title> <v-avatar image="/img/9774779.jpg" size="80"></v-avatar> </v-card-title>
                    <v-form @submit.prevent="submit">
                        <div class="mt-4">
                            <v-text-field id="name" type="text" label="Nome Completo" v-model="form.name" required
                                autofocus autocomplete="name" @change="form.validate('name')"
                                variant="outlined"></v-text-field>
                            <span v-if="form.invalid('name')" class="text-base text-red-500">
                                {{ form.errors.name }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-text-field id="email" type="email" class="mt-1" label="Email" v-model="form.email"
                                readonly required autofocus autocomplete="email" @change="form.validate('email')"
                                variant="outlined"></v-text-field>
                            <span v-if="form.invalid('email')" class="text-base text-red-500">
                                {{ form.errors.email }}
                            </span>
                        </div>
                        <div class="mt-4" v-if="authProfile === 'T'">
                            <v-select id="profile" label="Perfil" :items="Object.values(profileLabels)" v-model="form.profile"
                                required autofocus autocomplete="profile" @change="form.validate('profile')"
                                variant="outlined"></v-select>
                            <span v-if="form.invalid('profile')" class="text-base text-red-500">
                                {{ form.errors.profile }}
                            </span>
                        </div>
                        <div class="mt-4" v-else>
                            <v-select id="profile" label="Perfil" :items="Object.values(systemLabel)" v-model="form.profile" required
                                autofocus autocomplete="profile" @change="form.validate('profile')"
                                variant="outlined"></v-select>
                            <span v-if="form.invalid('profile')" class="text-base text-red-500">
                                {{ form.errors.profile }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-text-field id="cpf" type="text" label="CPF" v-model="form.cpf"
                                @change="form.validate('cpf')" required autofocus autocomplete="cpf"
                                v-mask="'###.###.###-##'" readonly variant="outlined"></v-text-field>
                            <span v-if="form.invalid('cpf')" class="text-base text-red-500">
                                {{ form.errors.cpf }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-select id="active" :items="Object.values(activeLabels)" label="Ativo" v-model="form.active"
                                @change="form.validate('active')" required autofocus autocomplete="active"
                                variant="outlined"></v-select>
                            <span v-if="form.invalid('active')" class="text-base text-red-500">
                                {{ form.errors.active }}
                            </span>
                        </div>
                        <div class="mt-5">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Salvar
                            </PrimaryButton>
                        </div>
                    </v-form>
                </v-card>
            </v-container>
        </v-main>

    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

const props = defineProps({
    user: Array,
    authProfile: Object
});

const translateProfileForm = (profile) => {
    if(profile === 'A') return 'Atendente'
    if(profile === 'S') return 'Administrador Sistema'
    if(profile === 'T') return 'Administrador Ti'
}


const translateActiveForm = (active) => {
    if(active === 'S') return 'Sim'
    if(active === 'N') return 'Não'
}

const form = useForm('put', route('user.update', { id: props.user.id }), {
    name: props.user?.name,
    email: props.user?.email,
    profile: translateProfileForm(props.user.profile),
    cpf: props.user?.cpf,
    active:  translateActiveForm(props.user.active) 
});



const submit = () => {
    const profileValue = Object.keys(profileLabels).find(key => profileLabels[key] === form.profile);
    const activeValue = Object.keys(activeLabels).find(key => activeLabels[key] === form.active);
    form.profile = profileValue;
    form.active = activeValue;
    form.submit({

        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success("Usuário editado com Sucesso!", {
                position: 'top-right',
            });
        },
        onError: () => {
            toast.error("Erro ao editar usuário!", {
                position: 'top-right',
            });
        }
    });
}


const profileLabels = {
    'T': 'Administrador TI',
    'S': 'Administrador Sistema',
    'A': 'Atendente'
}

const activeLabels = {
    'S': 'Sim',
    'N': 'Não'
}


const systemLabel = {
    'A': 'Atendente'
}



</script>



<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
    padding: 15px;
}
</style>
