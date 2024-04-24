<template>
    <v-card>
        <v-card-title class="text-center">Acompanhamento</v-card-title>
        <v-form @submit.prevent="attendanceSubmit">
            <v-container>
                <v-row>
                    <v-col cols="12" md="6" class="input-col">
                        <v-text-field label="Descrição" type="text" v-model="attendanceForm.description"
                            maxlength="2000" variant="outlined" @change="attendanceForm.validate('description')">
                        </v-text-field>
                        <span v-if="attendanceForm.invalid('description')" class="text-base text-red-500">
                            {{ attendanceForm.errors.description }}
                        </span>
                    </v-col>

                    <v-col cols="12" md="6" class="input-col">
                        <v-select label="Situação" v-model="attendanceForm.situation"
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