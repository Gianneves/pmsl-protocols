<template>
  <v-card-text class="custom-card">
      <v-card-text>
          <v-card-title>Editar Pessoa</v-card-title>
          <v-form @submit.prevent="editPerson">
              <v-container>
                  <v-row>
                      <v-col cols="12" md="4">
                          <v-text-field label="Nome" id="name" v-model="form.name"
                              required variant="outlined">
                          </v-text-field>
                      </v-col>

                      <v-col cols="12" md="4">
                          <v-text-field label="Data de nascimento" type="date" id="date" for="date"
                              v-model="form.birthdate" required variant="outlined">
                          </v-text-field>
                       
                      </v-col>

                      <v-col cols="12" md="4">
                          <v-text-field label="CPF" id="cpf" v-model="form.cpf" required
                               variant="outlined" readonly></v-text-field>
                          
                      </v-col>

                      <v-col cols="12" md="4">
                          <v-select label="Sexo" v-model="form.gender" required 
                              :items="['Masculino', 'Feminino', 'Outro']">
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
                  <v-btn variant="text" @click="$emit('closeEditPerson')" >Cancelar</v-btn>
                  <v-btn variant="tonal" @click="editPerson" color="success">Salvar</v-btn>
              </v-card-actions>
          </v-form>
      </v-card-text>
  </v-card-text>
</template>

<script setup>
/* import { useForm } from 'laravel-precognition-vue-inertia'; */
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    isEditPersonOpen: Boolean,
    person: Object
});

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


onMounted(() => {
    if (props.person) {
        form.name = props.person.name;
        form.birthdate = props.person.birthdate;
        form.cpf = props.person.cpf;
        form.gender = props.person.gender;
        form.city = props.person.city;
        form.district = props.person.district;
        form.street = props.person.street;
        form.number = props.person.number;
        form.complement = props.person.complement;

        if (props.person.birthdate) {
            form.birthdate = new Date(props.person.birthdate).toISOString().substr(0, 10);
        }

    }
});


const editPerson = () => {
    Inertia.post(`/person/${props.person.id}`, {
        _method: "put",
        name: form.name,
        birthdate: form.birthdate,
        cpf: form.cpf,
        gender: form.gender,
        city: form.city,
        district: form.district,
        street: form.street,
        number: form.number,
        complement: form.complement

    });
}

</script>

<style scoped>
.custom-card {
  background-color: #FFF;
  box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}

</style> 