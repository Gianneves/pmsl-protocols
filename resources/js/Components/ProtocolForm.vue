<template>
    <v-card-text :class="[ 'custom-card', { 'overflow-auto': form.files.length > 2 } ]">
        <v-card-text>
            <v-card-title>Criar Protocolo</v-card-title>
            <v-form @submit.prevent="submit">
                <v-container>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field label="Data" type="date" id="created_data" for="created_data"
                                v-model="form.created_data" required variant="outlined"
                                @change="form.validate('created_data')">
                            </v-text-field>
                            <span v-if="form.invalid('created_data')" class="text-base text-red-500">
                                {{ form.errors.created_data }}
                            </span>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-text-field label="Prazo" id="deadline" type="number" v-model="form.deadline" required
                                variant="outlined" @change="form.validate('deadline')"></v-text-field>
                            <span v-if="form.invalid('deadline')" class="text-base text-red-500">
                                {{ form.errors.deadline }}
                            </span>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-select label="Contribuinte" v-model="form.person_id" @change="form.validate('person_id')"
                                :items="people" item-title="name" item-value="id" required>
                            </v-select>
                            <span v-if="form.invalid('person_id')" class="text-base text-red-500">
                                {{ form.errors.person_id }}
                            </span>
                        </v-col>

                        <v-col cols="12" md="4">
                            <v-select label="Departamento" v-model="form.departament_id"
                                @change="form.validate('departament_id')" :items="departament" item-title="name"
                                item-value="id" required>
                            </v-select>
                            <span v-if="form.invalid('departament_id')" class="text-base text-red-500">
                                {{ form.errors.departament_id }}
                            </span>
                        </v-col>

                        <v-row>
                            <v-col>
                                <v-textarea label="Descrição" id="description" v-model="form.description" required
                                    variant="outlined" maxlength="2000" style="width: 440px;"
                                    @change="form.validate('description')">
                                </v-textarea>
                                <span v-if="form.invalid('description')" class="text-base text-red-500">
                                    {{ form.errors.description }}
                                </span>
                            </v-col>
                            <v-col>
                                <v-file-input label="Anexar arquivos" id="files" v-model="form.files" variant="outlined"
                                    multiple maxlength="2000" style="width: 300px; overflow-x: auto;" @change="form.validate('files')">
                                </v-file-input>
                                <span v-if="form.invalid('files')" class="text-base text-red-500">
                                    {{ form.errors.files }}
                                </span>
                                <div v-if="form.files.length > 0">
                                    <h3 class="font-bold">Arquivos Selecionados:</h3>
                                    <ul>
                                        <li v-for="(file, index) in form.files" :key="index" class="mt-2">
                                            {{ file.name }} 
                                            <v-btn @click="removeFile(index)" rounded="xl"  color="red" size="x-small" >
                                                X
                                            </v-btn>
                                        </li>
                                    </ul>
                                </div>
                            </v-col>
                        </v-row>

                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn variant="text" @click="$emit('closeDialog')">Cancelar</v-btn>
                    <v-btn variant="tonal" @click="submit" color="success">Salvar</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card-text>
</template>

<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import { defineProps } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();
const emit = defineEmits(['closeDialog']);

const form = useForm('post', route('protocols.store'), {
    description: '',
    created_data: '',
    deadline: '',
    person_id: '',
    departament_id: '',
    files: []
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success("Protocolo criado com Sucesso!", {
            position: 'top-right',
        });
        emit('closeDialog');
    },
    onError: () => {
        toast.error("Erro ao criar Protocolo!", {
            position: 'top-right',
        });
    }
});

const removeFile = (index) => {
    form.files.splice(index, 1); 
}

const props = defineProps({
    isDialogOpen: Boolean,
    people: Array,
    departament: Array
});

</script>


<style scoped>
.custom-card {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
   
}

.overflow-auto {
    overflow-y: auto; 
}

</style>
