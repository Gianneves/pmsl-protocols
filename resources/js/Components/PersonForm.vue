<template>
    <v-card-text class="custom-card">
        <v-card-text>
            <v-card-title>Cadastrar Pessoa</v-card-title>
            <v-form @submit.prevent="submit">
                <v-container>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field label="Nome" id="name" v-model="form.name" @change="form.validate('name')"
                                required variant="outlined">
                            </v-text-field>
                            <v-messages :messages="form.errors.name" class="error-msg"
                                v-if="form.errors.name"></v-messages>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field label="Data de nascimento" type="date" id="date" for="date"
                                v-model="form.birthdate" required @change="form.validate('date')" variant="outlined">
                            </v-text-field>
                            <v-messages :messages="form.errors.birthdate" class="error-msg"
                                v-if="form.errors.birthdate"></v-messages>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field label="CPF" id="cpf" v-model="form.cpf" required
                                @change="form.validate('cpf')" variant="outlined"></v-text-field>
                            <v-messages :messages="form.errors.birthdate" class="error-msg"
                                v-if="form.errors.cpf"></v-messages>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-select label="Sexo" v-model="form.gender" required @change="form.validate('gender')"
                                :items="['Masculino', 'Feminino', 'Outro']">
                            </v-select>
                            <v-messages :messages="form.errors.birthdate" class="error-msg"
                                v-if="form.errors.gender"></v-messages>
                        </v-col>


                        <v-col cols="12" md="4">
                            <v-text-field label="Cidade" id="city" v-model="form.city"
                                variant="outlined"></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field label="Bairro" id="district" for="district" v-model="form.district"
                                variant="outlined"></v-text-field>
                        </v-col>


                        <v-col cols="12" md="4">
                            <v-text-field label="Rua" id="street" for="street" v-model="form.street"
                                variant="outlined"></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field label="N.º" id="number" v-model="form.number"
                                variant="outlined"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field label="Complemento" id="complement" v-model="form.complement"
                                variant="outlined"></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn variant="text" @click="$emit('closeDialog')" >Cancelar</v-btn>
                    <v-btn variant="tonal" color="success" @click="submit">Salvar</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card-text>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { Inertia } from '@inertiajs/inertia';

const form = useForm('post', route('person.store'), {
    name: '',
    birthdate: '',
    cpf: '',
    gender: '',
    city: '',
    district: '',
    street: '',
    number: '',
    complement: '',
});

const submit = () => {
    Inertia.post('/person', form.data())
        .then(() => {
            form.reset();
            isDialogOpen.value = false;
        })
        .catch((error) => {
            console.error('Erro ao enviar formulário:', error);
        });
}

const props = defineProps({
  isDialogOpen: Boolean
});

</script>

<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}

</style>