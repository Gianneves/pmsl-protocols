<template>
    <v-app>
    <AuthenticatedLayout>

            <Head title="Editar protocolo" />
            <v-card class="card-container" width="900px">
                <v-card-title class="text-center">Editar Protocolo</v-card-title>
                <v-form @submit.prevent="submit">
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6" class="input-col">
                                <v-text-field label="Data" type="date" id="created_data" for="created_data"
                                    v-model="form.created_data" required variant="outlined"
                                    @change="form.validate('created_data')">
                                </v-text-field>
                                <span v-if="form.invalid('created_data')" class="text-base text-red-500">
                                    {{ form.errors.created_data }}
                                </span>
                            </v-col>
                            <v-col cols="12" md="6" class="input-col">
                                <v-text-field label="Prazo" id="deadline" type="number" v-model="form.deadline" required
                                    variant="outlined" @change="form.validate('deadline')"></v-text-field>
                                <span v-if="form.invalid('deadline')" class="text-base text-red-500">
                                    {{ form.errors.deadline }}
                                </span>
                            </v-col>
                            <v-col cols="12" md="6" class="input-col">
                                <v-select label="Contribuinte" v-model="form.person_id"
                                    @change="form.validate('person_id')" :items="people" item-title="name"
                                    item-value="id">
                                </v-select>
                                <span v-if="form.invalid('person_id')" class="text-base text-red-500">
                                    {{ form.errors.person_id }}
                                </span>
                            </v-col>
                            <v-col cols="12" md="6" class="input-col">
                                <v-textarea label="Descrição" id="description" v-model="form.description" required
                                    variant="outlined" maxlength="2000" @change="form.validate('description')">
                                </v-textarea>
                                <span v-if="form.invalid('description')" class="text-base text-red-500">
                                    {{ form.errors.description }}
                                </span>
                            </v-col>
                            <v-col cols="12" class="input-col">
                                <div v-if="props.protocol.files">
                                    <v-card-title>Arquivos:</v-card-title>
                                    <ul>
                                        <li v-for="file in props.protocol.files" :key="file">
                                            <div>

                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-else>
                                    <v-file-input label="Anexar arquivos" id="files" v-model="form.files"
                                        variant="outlined" multiple maxlength="2000" style="width: 300px;"
                                        @change="form.validate('files')">
                                    </v-file-input>
                                    <span v-if="form.invalid('files')" class="text-base text-red-500">
                                        {{ form.errors.files }}
                                    </span>
                                </div>
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn variant="tonal" @click="submit" color="success">Editar</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>

    </AuthenticatedLayout>
</v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/Components/NavBar.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { defineProps, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

const props = defineProps({
    people: Array,
    protocol: Object,
});



const form = useForm('put', route('protocols.update', { id: props.protocol.id }), {
    description: props.protocol?.description,
    created_data: props.protocol?.created_data,
    deadline: props.protocol?.deadline,
    person_id: props.protocol?.person_id,
    files: ''
});


const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success("Protocolo editado com Sucesso!", {
            position: 'top-right',
        });
    },
    onError: () => {
        toast.error("Erro ao editar Protocolo!", {
            position: 'top-right',
        });
    }
});

console.log(props.protocol.files)

</script>


<style scoped>
    .card-container {
        margin-top: 100px;
        margin-left: 300px;
    }

</style>
