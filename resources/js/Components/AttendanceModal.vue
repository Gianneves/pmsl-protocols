<template>
    <v-card class="card-container">
        <v-card-title class="text-center">Acompanhamento</v-card-title>
        <v-form @submit.prevent="attendanceSubmit">
            <v-container fluid>
                <v-row>
                    <v-col cols="12" md="6" class="input-col">
                        <v-textarea label="Descrição" type="text" v-model="attendanceForm.description" variant="outlined"
                            maxlength="2000" :width="400" @change="attendanceForm.validate('description')">
                        </v-textarea>
                        <span v-if="attendanceForm.invalid('description')" class="text-base text-red-500">
                            {{ attendanceForm.errors.description }}
                        </span>
                    </v-col>
                    <v-col cols="12" md="6" class="input-col">
                        <v-select label="Situação" v-model="attendanceForm.situation" variant="outlined"
                            @change="attendanceForm.validate('situation')" :items="['A', 'E', 'S']" required>
                        </v-select>
                        <span v-if="attendanceForm.invalid('situation')" class="text-base text-red-500">
                            {{ attendanceForm.errors.situation }}
                        </span>
                    </v-col>
                </v-row>
            </v-container>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn variant="text" @click="$emit('closeDialog')">Cancelar</v-btn>
                <v-btn variant="tonal" @click="attendanceSubmit" color="success">Enviar</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>

</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { defineProps, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


const toast = useToast();
const emit = defineEmits(['closeDialog']);

const props = defineProps({
    protocol: Object,
});

const attendanceForm = useForm('post', route('attendances.store'), {
    protocol_id: props.protocol.id,
    description: '',
    situation: '',
});

const attendanceSubmit = () => attendanceForm.submit({
    preserveScroll: true,
    onSuccess: () => {
        attendanceForm.reset();
        toast.success("Atendimento criado com Sucesso!", {
            position: 'top-right',
        });
        emit('closeDialog');
    },
    onError: () => {
        toast.error("Erro ao criar acompanhamento!", {
            position: 'top-right',
        });
    }
});

</script>


<style scoped>

.card-container {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}
</style>