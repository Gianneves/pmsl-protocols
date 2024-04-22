<template>
    <v-app>
        <AuthenticatedLayout>
            <v-card class="card-container" width="900px">
                <v-card-title class="text-center">Editar Departamento</v-card-title>
                <v-form @submit.prevent="grantPermission">
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6" class="input-col">
                                <v-select label="Usuários" :items="filteredUser" v-model="accessForm.user_id"
                                    item-title="name" item-value="id" required variant="outlined">
                                </v-select>
                                <span v-if="accessForm.invalid('user_id')" class="text-base text-red-500">
                                {{ accessForm.errors.user_id }}
                            </span>
                            </v-col>
                            <v-col>
                                <v-btn type="submit">Liberar Acesso</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
                <v-container>
                    <div class="mt-3 mb-3" v-if="grantAccess.length > 0">
                        <v-card-text>Usuários com acesso:</v-card-text>
                        <v-card class="m-1 border-style">
                            <ul class="d-flex justify-between px-3 my-2 ml-2" v-for="access in grantAccess" :key="access.id">
                                <div class="d-flex flex-row" >
                                    <li class="mr-2"><b>ID:</b> {{ access.id }}</li>
                                    <li class="mr-3"><b>Nome do Usuário:</b> {{ access.user.name }}</li>
                                    <li><b>Data de Liberação:</b> {{ formatData(access.user.created_at) }}</li>
                                </div>
                                <div>
                                    <v-btn color="red" dark class="ml-3 delete-btn" @click="deleteAccess(access.id)" >
                                        <v-icon dark class="mdi mdi-delete-forever md-2"></v-icon>
                                    </v-btn>
                                </div>
                            </ul>
                        </v-card>
                    </div>
                </v-container>

                <v-form @submit.prevent="submit">
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field class="w-full md:w-96" label="Departamento" v-model="form.name"
                                    @change="form.validate('name')" required variant="outlined">
                                </v-text-field>
                                <span v-if="form.invalid('name')" class="text-base text-red-500">
                                    {{ form.errors.name }}
                                </span>
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn variant="tonal" type="submit" color="success">Salvar</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { computed } from 'vue';
import { defineProps, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import axios from 'axios';


const toast = useToast();

const props = defineProps({
    users: Array,
    departament: Object,
    grantAccess: Array
});


const filteredUser = computed(() => {
    return props.users.filter(user => {
        return !props.grantAccess.some(permission => permission.user_id === user.id);
    })
})

const form = useForm('put', route('departaments.update', { id: props.departament?.id }), {
    name: props.departament?.name,
});

const accessForm = useForm('post', route('departaments.permission', { id: props.departament?.id }), {
    user_id: ''
});

const formatData = (created_at) => {
    const dateObject = new Date(created_at);
    const day = dateObject.getDate();
    const month = dateObject.getMonth() + 1;
    const year = dateObject.getFullYear();
    const formattedDate = `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
    return formattedDate;
}

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success("Departamento editado com Sucesso!", {
            position: 'top-right',
        });
    },
    onError: () => {
        toast.error("Erro ao editar departamento!", {
            position: 'top-right',
        });
    }
});

const grantPermission = () => accessForm.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.success("Acesso criado com sucesso!", {
            position: 'top-right',
        });
    },
    onError: () => {
        toast.error("Erro ao criar acesso!", {
            position: 'top-right',
        });

    }
});


const deleteAccess = (accessId) => {
    axios.delete(`/departaments/${props.departament.id}/permission/${accessId}`)
        .then(response => {
            const index = props.grantAccess.findIndex(access => access.id === accessId);
            if (index !== -1) {
                props.grantAccess.splice(index, 1);
            }
            toast.success("Acesso excluído com sucesso!", {
                position: 'top-right',
            });
        })
        .catch(error => {
            toast.error("Erro ao excluir acesso!", {
                position: 'top-right',
            });
        });
}

</script>

<style scoped>
.card-container {
    margin-top: 100px;
    margin-left: 300px;
    padding: 20px;
}

.border-style {
    background-color: #FFF;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
}

.delete-btn {
    min-width: 10px; 
    padding: 10px;
}

.delete-btn .v-icon {
    font-size: 20px; 
}
</style>
