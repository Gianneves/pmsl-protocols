<template>
  <v-card-text class="custom-card">
      <v-card-text>
          <v-card-title>Editar Pessoa</v-card-title>
          <v-form @submit.prevent="submit">
              <v-container>
                  <v-row>
                      <v-col cols="12" md="4">
                          <v-text-field label="Nome" id="name" v-model="form.name"
                              required variant="outlined">
                          </v-text-field>
                          <span v-if="form.invalid('name')" class="text-base text-red-500">
                                {{ form.errors.name }}
                            </span>
                      </v-col>

                      <v-col cols="12" md="4">
                          <v-text-field label="Data de nascimento" type="date" id="birthdate"
                              v-model="form.birthdate" required variant="outlined"  @change="form.validate('birthdate')">
                          </v-text-field>
                          <span v-if="form.invalid('birthdate')" class="text-base text-red-500">
                                {{ form.errors.birthdate }}
                            </span>
                      </v-col>

                      <v-col cols="12" md="4">
                          <v-text-field label="CPF" id="cpf" v-model="form.cpf" required
                               variant="outlined" readonly></v-text-field>
                      </v-col>

                      <v-col cols="12" md="4">
                          <v-select label="Sexo" v-model="form.gender" required 
                              :items="['Masculino', 'Feminino', 'Outro']">
                          </v-select>
                          <span v-if="form.invalid('gender')" class="text-base text-red-500">
                                {{ form.errors.gender }}
                            </span>
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
                  <v-btn variant="text" @click="$emit('closeEditPerson')" >Cancelar</v-btn>
                  <v-btn variant="tonal" @click="submit" color="success">Salvar</v-btn>
              </v-card-actions>
          </v-form>
      </v-card-text>
  </v-card-text>
</template>

<script setup>

import { useForm } from 'laravel-precognition-vue-inertia';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const emit = defineEmits(['closeEditPerson']);

const toast = useToast();


const props = defineProps({
  isEditPersonOpen: Boolean,
  person: Object
});

const form = useForm('put', route('person.update', { id: props.person.id }), {
  name: props.person.name,
  birthdate: props.person.birthdate,
  cpf: props.person.cpf,
  gender: props.person.gender,
  city: props.person.city,
  district: props.person.district,
  street: props.person.street,
  number: props.person.number,
  complement: props.person.complement
 
});


const submit = () => form.submit({
  preserveScroll: true,
  onSuccess: () => {
    toast.success("Pessoa atualizada com sucesso!", 
        { position: 'top-right' });
    emit('closeEditPerson');
  },
  onError: () => {
    toast.error("Erro ao atualizar Pessoa!", { position: 'top-right' });
  }
});

</script>

<style scoped>
.custom-card {
  background-color: #FFF;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}

</style> 