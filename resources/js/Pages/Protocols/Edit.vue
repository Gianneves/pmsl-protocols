<template>

    <Head title="Editar protocolo" />
    <v-app>
        <AuthenticatedLayout>
            <v-main>
                <div class="d-flex justify-between mx-4 my-5">
                    <div>
                        <Link :href="route('protocols.index')">
                        <v-btn rounded outlined color="indigo">Voltar</v-btn>
                        </Link>
                    </div>
                    <div>
                        <v-btn color="indigo">
                            <a :href="`/pdf/${protocol.id}`">
                                <v-icon icon="mdi-download-outline" class="mr-3"></v-icon> Gerar PDF
                            </a>
                        </v-btn>
                    </div>
                </div>
                <v-card class="card-container md:w-3/4 lg:w-1/2 mx-auto" width="900px">
                    <v-card-title class="text-center">Editar Protocolo</v-card-title>
                    <v-container class="flex flex-col md:flex-row justify-between">
                        <div class="mb-4 md:mb-0 md:w-1/2">
                            <v-btn @click="isDialogOpen = true">Acompanhamento</v-btn>
                            <v-dialog v-model="isDialogOpen" @update:modelValue="updateDialogStatus">
                                <AttendanceModal :isDialogOpen="isDialogOpen" @closeDialog="closeDialog"
                                    :protocol="protocol" width="900px" />
                            </v-dialog>
                        </div>
                        <div v-if="attendance.length > 0">
                            <v-btn @click="isRegisterOpen = true">
                                <v-icon dark class="mdi mdi-file-document-multiple"></v-icon>
                                 <span class="ml-2">Registros</span>
                            </v-btn>
                            <v-dialog v-model="isRegisterOpen" @update:modelValue="updateRegisterStatus">
                                <RegisterModal :isRegisterOpen="isRegisterOpen" @closeRegister="closeRegister"
                                    :attendance="attendance" :protocolId="protocol.id" />
                            </v-dialog>
                        </div>
                    </v-container>
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
                                    <v-text-field label="Prazo" id="deadline" type="number" v-model="form.deadline"
                                        required variant="outlined" @change="form.validate('deadline')"></v-text-field>
                                    <span v-if="form.invalid('deadline')" class="text-base text-red-500">
                                        {{ form.errors.deadline }}
                                    </span>
                                </v-col>
                                <v-col cols="12" md="6" class="input-col">
                                    <v-select label="Contribuinte" v-model="form.person_id"
                                        @change="form.validate('person_id')" :items="people" item-title="name"
                                        item-value="id" required>
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

                                <v-col cols="12" md="6" class="input-col">
                                    <v-textarea label="Descrição" id="description" v-model="form.description" required
                                        variant="outlined" maxlength="2000" @change="form.validate('description')">
                                    </v-textarea>
                                    <span v-if="form.invalid('description')" class="text-base text-red-500">
                                        {{ form.errors.description }}
                                    </span>
                                </v-col>
                                <v-col cols="12" class="input-col">
                                    <v-card-title v-if="props.protocol.files">
                                        Arquivos:
                                        <ul>
                                            <li v-for="(file, index) in files" :key="index" class="mt-1">
                                                <a :href="`/storage/protocols/${file}`" target="_blank">{{ file }}</a>
                                            </li>
                                        </ul>

                                    </v-card-title>
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
                            <v-btn variant="tonal" @click="submit" color="success">Salvar</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-main>
        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import AttendanceModal from '@/Components/AttendanceModal.vue';
import RegisterModal from '@/Components/RegisterModal.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { defineProps, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();
const isDialogOpen = ref(false);
const isRegisterOpen = ref(false);

const props = defineProps({
    people: Array,
    protocol: Object,
    departament: Array,
    attendance: Array,
    files: Array
});

const updateDialogStatus = (value) => {
    isDialogOpen.value = value;
};

const closeDialog = () => {
    isDialogOpen.value = false;
};

const updateRegisterStatus = (value) => {
    isRegisterOpen.value = value;
};

const closeRegister = () => {
    isRegisterOpen.value = false;
};

const form = useForm('put', route('protocols.update', { id: props.protocol.id }), {
    description: props.protocol?.description,
    created_data: props.protocol?.created_data,
    deadline: props.protocol?.deadline,
    person_id: props.protocol?.person_id,
    departament_id: props.protocol?.departament_id,
    files: []
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
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


</script>


<style scoped>
.card-container {
 
    background-color: #FFF;
    box-shadow: 0px 0px 6px 0px rgba(0, 0, 0, 0.5);
}
</style>
