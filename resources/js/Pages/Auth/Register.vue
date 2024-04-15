<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    profile: '',
    cpf: '',
    password_confirmation: '',
    active: ''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Cadastrar" />

        <v-main class="d-flex">
            <v-container class="d-flex align-center justify-center">
                <v-card class="border d-flex flex-col text-center custom-card" width="40%">
                    <v-card-title> <v-avatar image="/img/9774779.jpg" size="80"></v-avatar> </v-card-title>
                    <v-form @submit.prevent="submit">
                        <div class="mt-4">
                            <v-text-field id="name" type="text" label="Nome Completo" v-model="form.name" required
                                autofocus autocomplete="name" variant="outlined"></v-text-field>
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-4">
                            <v-text-field id="email" type="email" class="mt-1" label="Email" v-model="form.email"
                                required autofocus autocomplete="email" variant="outlined"></v-text-field>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <v-text-field id="password" type="password" label="Senha" class="mt-1"
                                v-model="form.password" required autocomplete="current-password"
                                variant="outlined"></v-text-field>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <v-text-field id="password_confirmation" type="password" label="Confirmar Senha"
                                v-model="form.password_confirmation" required autocomplete="new-password"
                                variant="outlined"></v-text-field>

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                        <div class="mt-4">
                            <v-select id="profile"  label="Perfil" :items="['T', 'S', 'A']" v-model="form.profile" required
                                autofocus autocomplete="profile" variant="outlined"></v-select>
                            <InputError class="mt-2" :message="form.errors.profile" />
                        </div>
                        <div class="mt-4">
                            <v-text-field id="cpf" type="text" label="CPF" v-model="form.cpf" required autofocus
                                autocomplete="cpf" variant="outlined"></v-text-field>
                            <InputError class="mt-2" :message="form.errors.cpf" />
                        </div>
                        <div class="mt-4">
                            <v-select id="active" :items="['S', 'N']" label="Ativo" v-model="form.active" required autofocus
                                autocomplete="active" variant="outlined"></v-select>
                            <InputError class="mt-2" :message="form.errors.active" />
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

    </GuestLayout>
</template>

<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
    padding: 15px;
}
</style>
