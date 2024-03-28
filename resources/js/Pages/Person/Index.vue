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
                                <v-card-text class="custom-card">
                                    <v-card-text>
                                        <v-card-title>Cadastrar Pessoa</v-card-title>
                                        <v-form @submit.prevent="submit">
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12" md="4">
                                                        <v-text-field label="Nome" id="name" v-model="form.name"
                                                            required variant="outlined">
                                                        </v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-text-field label="Data de nascimento" type="date" id="date"
                                                            for="date" v-model="form.birthdate" required
                                                            variant="outlined">
                                                        </v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-text-field label="CPF" id="cpf" v-model="form.cpf" required
                                                            variant="outlined"></v-text-field>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-select label="Sexo" v-model="form.gender"
                                                            :items="['Masculino', 'Feminino']">
                                                        </v-select>
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
                                                        <v-text-field label="Complemento" id="complement"
                                                            v-model="form.complement" variant="outlined"></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn variant="text" @click="isDialogOpen = false">Cancelar</v-btn>
                                                <v-btn variant="tonal" color="success" @click="submit">Salvar</v-btn>
                                            </v-card-actions>
                                        </v-form>
                                    </v-card-text>

                                </v-card-text>


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

import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const isDialogOpen = ref(false);

const form = useForm({
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

const submit = async () => {
    await form.post(route('person.store'));
    form.reset();
    isDialogOpen.value = false;
}

</script>

<style scoped>
.custom-card {
    background-color: #FFF;
    /* Mudar cor de fundo */
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
    /* Adicionar sombra */
}
</style>
