<!-- <template>
    <v-app>

        <v-card-text class="custom-card">
            <v-card-text>
                <v-card-title>Editar Pessoa</v-card-title>
                <v-form @submit.prevent="saveChanges">
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field label="Nome" id="name" v-model="form.name"  required
                                    variant="outlined">
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field label="Data de nascimento" type="date" id="date" for="date"
                                    v-model="form.birthdate" required variant="outlined">
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field label="CPF" id="cpf" v-model="form.cpf" required
                                    variant="outlined"></v-text-field>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-select label="Sexo" v-model="form.gender" :items="['Masculino', 'Feminino']">
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
                                <v-text-field label="Complemento" id="complement" v-model="form.complement"
                                    variant="outlined"></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn variant="text" @click="isOpen = false">Cancelar</v-btn>
                        <v-btn variant="tonal" color="success" @click="saveChanges">Salvar</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card-text>



    </v-app>
</template>

<script setup>

import { ref, defineProps } from 'vue';
import { Inertia } from "@inertiajs/inertia";
import { useForm } from '@inertiajs/vue3';


const props = defineProps({
    people: Object,
    isEditOpen: Boolean
});

const isOpen = ref(props.isEditOpen);

const saveChanges = () => {

    Inertia.post(`/person/${props.people.data.id}`, {
        _method: "put",
        name: form.name,
        birthdate: form.birthdate,
        cpf: form.cpf,
        gender: form.gender,
        city: form.city,
        district: form.district,
        street: form.street,
        number: form.number,
        complement: form.complement,

    });

    closeModal();
};

const closeModal = () => {
    // Fechar o modal
    isOpen.value = false;
};

const form = useForm({
    name: props.people?.name,
    birthdate: props.people?.birthdate,
    cpf: props.people?.cpf,
    gender: props.people?.gender,
    city: props.people?.city,
    district: props.people?.district,
    street: props.people?.street,
    number: props.people?.number,
    complement: props.people?.complement,
});


</script> -->