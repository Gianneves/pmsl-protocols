<template>
     <AuthenticatedLayout>

        <Head title="Cadastrar" />

        <v-main class="d-flex">
            <v-container class="d-flex align-center justify-center">
                <v-card class="border d-flex flex-col text-center custom-card" width="40%">
                    <v-card-title> <v-avatar image="/img/9774779.jpg" size="80"></v-avatar> </v-card-title>
                    <v-form @submit.prevent="submit">
                        <div class="mt-4">
                            <v-text-field id="name" type="text" label="Nome Completo" v-model="form.name" required
                                autofocus autocomplete="name" @change="form.validate('name')" variant="outlined"></v-text-field>
                                <span v-if="form.invalid('name')" class="text-base text-red-500">
                                {{ form.errors.name }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-text-field id="email" type="email" class="mt-1" label="Email" v-model="form.email"
                                required autofocus autocomplete="email" @change="form.validate('email')" variant="outlined"></v-text-field>
                                <span v-if="form.invalid('email')" class="text-base text-red-500">
                                {{ form.errors.email }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-text-field id="password" type="password" label="Senha" class="mt-1"
                                v-model="form.password" required @change="form.validate('password')" autocomplete="current-password"
                                variant="outlined"></v-text-field>
                                <span v-if="form.invalid('password')" class="text-base text-red-500">
                                {{ form.errors.password }}
                            </span>
                        </div>

                        <div class="mt-4">
                            <v-text-field id="password_confirmation" type="password" label="Confirmar Senha"
                                v-model="form.password_confirmation" @change="form.validate('password_confirmation')"  required autocomplete="new-password"
                                variant="outlined"></v-text-field>
                                <span v-if="form.invalid('password_confirmation')" class="text-base text-red-500">
                                {{ form.errors.password_confirmation }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-select id="profile"  label="Perfil" :items="['T', 'S', 'A']" v-model="form.profile" required
                                autofocus autocomplete="profile" @change="form.validate('profile')" variant="outlined"></v-select>
                                <span v-if="form.invalid('profile')" class="text-base text-red-500">
                                {{ form.errors.profile }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-text-field id="cpf" type="text" label="CPF" v-model="form.cpf" @change="form.validate('cpf')" required autofocus
                                autocomplete="cpf"  @input="formatCPF" v-mask="'###.###.###-##'" variant="outlined"></v-text-field>
                                <span v-if="form.invalid('cpf')" class="text-base text-red-500">
                                {{ form.errors.cpf }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <v-select id="active" :items="['S', 'N']" label="Ativo" v-model="form.active" @change="form.validate('active')" required autofocus
                                autocomplete="active" variant="outlined"></v-select>
                                <span v-if="form.invalid('active')" class="text-base text-red-500">
                                {{ form.errors.active }}
                            </span>
                        </div>
                        <div class="mt-5">
                            <Link :href="route('login')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Já possui cadastro?
                            </Link>

                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Cadastrar
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
import { useForm } from 'laravel-precognition-vue-inertia';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

const form = useForm('post', route('register'), {
    name: '',
    email: '',
    password: '',
    profile: '',
    cpf: '',
    password_confirmation: '',
    active: ''
});

const submit = () => form.submit ({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success("Usuário criado com Sucesso!", {
            position: 'top-right',
        });
    },
    onError: () => {
        toast.error("Erro ao criar Usuário!", {
            position: 'top-right',
        });
    }
});


const formatCPF = () => {
    let cpf = form.cpf.replace(/\D/g, ''); 
    cpf = cpf.replace(/^(\d{3})(\d)/, '$1.$2'); 
    cpf = cpf.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3'); 
    cpf = cpf.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/, '$1.$2.$3-$4'); 
    form.cpf = cpf;
    form.validate('cpf');
}

</script>



<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
    padding: 15px;
}
</style>
