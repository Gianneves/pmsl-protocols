<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Login" />
        <v-main class="d-flex  custom-background">
            <v-container class="d-flex align-center justify-center" style="height: 100vh;" >
                <v-card  class="border d-flex flex-col text-center custom-card" width="35%">
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <v-card-title> <v-avatar image="/img/9774779.jpg" size="80" ></v-avatar> </v-card-title>
                    <v-card-title> Atende Cidadão - PMSL </v-card-title>
                    <v-form @submit.prevent="submit">
                        <div class="mt-4" >
                            <v-text-field id="email" type="email" class="mt-1" label="Email" v-model="form.email" required autofocus
                                autocomplete="username"  variant="outlined"></v-text-field>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <v-text-field id="password" type="password" label="Senha" class="mt-1" v-model="form.password" required
                                autocomplete="current-password"  variant="outlined"></v-text-field>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-2">
                            <label>
                                <Checkbox name="remember" class="border" v-model:checked="form.remember" />
                                <span class="ms-2 text-sm text-gray-600">Lembrar me</span>
                            </label>
                        </div>

                        <div class="mt-5">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Entrar
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

.custom-background {
    background-image: url('/public/img/bg-login.jpg'); 
    background-size: cover;
    background-position: center; 
}



</style>