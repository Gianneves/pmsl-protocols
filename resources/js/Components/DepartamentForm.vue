<template>
    <v-card-text class="custom-card">
        <v-card-text>
            <v-card-title>Cadastrar Departamento</v-card-title>
            <v-form @submit.prevent="submit">
                <v-container fuid>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field class="w-full md:w-96" label="Nome" id="name" v-model="form.name" @change="form.validate('name')"
                                required variant="outlined">
                            </v-text-field>
                            <span v-if="form.invalid('name')" class="text-base text-red-500">
                                {{ form.errors.name }}
                            </span>
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn variant="text" @click="$emit('closeDialog')">Cancelar</v-btn>
                    <v-btn variant="tonal" color="success" @click="submit">Salvar</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card-text>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


const toast = useToast();
const emit = defineEmits(['closeDialog']);

const form = useForm('post', route('departaments.store'), {
    name: '',
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success("Departamento criado com Sucesso!", {
            position: 'top-right',
        });
        emit('closeDialog');
    },
    onError: () => {
        toast.error("Erro ao criar departamento!", {
            position: 'top-right',
        });
        
    }
});




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