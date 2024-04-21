<template>
    <v-app>
        <AuthenticatedLayout>
            <v-card class="card-container" width="900px">
                <v-card-title class="text-center">Editar Departamento</v-card-title>
                <v-form>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6" class="input-col">
                                <v-select label="Usuários" :items="users" item-title="name" item-value="id"  variant="outlined" >
                                </v-select>

                            </v-col>
                            <v-col>
                                <v-btn>Liberar Acesso</v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn variant="tonal" color="success">Salvar</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </AuthenticatedLayout>
    </v-app>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import { defineProps, ref } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const toast = useToast();

const props = defineProps({
    users: Array
});

/* const accessForm = useForm({
    user_id: ''
});

const acessSubmit = () => form.accessSubmit({
    preserveScroll: true,
});
 */

/* const form = useForm('put', route('departamentos.update', { id: props.departament.id }), {
    name: props.departament?.name,

}); */


/* const submit = () => form.submit({
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
}); */

</script>

<style scoped>
.card-container {
    margin-top: 100px;
    margin-left: 300px;
    padding: 20px;
}
</style>

