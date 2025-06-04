<template>

    <Head title="Opciones" />
    <AuthenticatedLayout>
        <div class="mx-4 mt-4 p-4">
            <div class="flex justify-between flex-col gap-2">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="flex justify-start">
                        <h2 class="text-3xl font-bold">Opciones</h2>
                    </div>
                    <div class="flex justify-end">
                        <button @click="handleModal()"
                            class="flex justify-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                            Añadir Opción
                        </button>
                    </div>
                </div>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Id
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Contenido
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    vinculada a pregunta
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="option in options" :key="option.id"
                                class="bg-white border-b border-gray-200 hover:bg-slate-50 ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                    {{ option.id }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ option.content }}
                                </td>
                                <td class="px-6 py-4 text-center hover:text-blue-600">
                                    <Link :href="route('questions.show', option.question)">
                                        {{ option.question?.title  ?? 'No vinculado' }}
                                    </Link>
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-3">
                                    <Link :href="route('options.show', option)"
                                        class="p-2 font-medium text-gray-500 hover:text-blue-600 hover:underline"
                                        title="Ver Opción">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                    </Link>
                                    <button @click="toggleEditModal(option)"
                                        class="p-2 font-medium text-gray-500 hover:text-yellow-600 hover:underline"
                                        title="Editar Opción">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>
                                    <button @click="deleteOption(option.id)"
                                        class="p-2 font-medium text-gray-500 hover:text-red-600 hover:underline"
                                        title="Eliminar Opción">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="options.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center">
                                    No se encontraron opciones registradas
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Modal para crear Opción -->
    <div v-if="showCreateModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-900/60 backdrop-blur-[2px] z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-xl relative">
            <h2 class="text-xl font-bold mb-4">{{ isEditing ? 'Modificar Opción' : 'Nueva Opción' }}</h2>

            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contenido</label>
                    <textarea v-model="form.content" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    <div v-if="errors.content" class="text-red-500 text-sm mt-1">
                        {{ errors.content }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pregunta a vincular</label>
                    <select v-model="form.question_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300">
                        <option value="" disabled>Seleccione una opción</option>
                        <option v-for="question in questions" :key="question.id" :value="question.id">
                            {{ question.title }}
                        </option>
                    </select>
                    <div v-if="errors.is_admin" class="text-red-500 text-sm mt-1">
                        {{ errors.is_admin }}
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="showCreateModal = false"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" :disabled="form.processing"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"> {{ form.processing ?
                            'Guardando...' : 'Guardar' }}</button>
                </div>
            </form>

            <!-- Botón para cerrar en esquina -->
            <button @click="showCreateModal = false" class="absolute top-6 right-5 text-gray-500 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { watch } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';

const page = usePage()
const showCreateModal = ref(false);
const isEditing = ref(false);

watch(
  () => page.props.flash,
  (flash) => {
    if (flash.success) {
      Swal.fire({
        icon: 'success',
        title: flash.success,
        timer: 2000,
        showConfirmButton: false
      })
    }

    if (flash.error) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: flash.error,
        confirmButtonText: 'Aceptar'
      })
    }
  },
  { immediate: true }
)

defineProps({
    options: Array,
    questions: Array,
    errors: Object
})

const form = useForm({
    content: '',
    question_id: '',
})

const handleModal = () => {
    form.reset();
    isEditing.value = false;
    showCreateModal.value = true;
}

const toggleEditModal = (option) => {
    isEditing.value = true;
    showCreateModal.value = true;
    form.reset();

    form.id = option.id;
    form.content = option.content;
    form.question_id = option.question_id;
}


const submit = () => {

    if (isEditing.value) {
        form.put(route('options.update', form.id), {
            onSuccess: () => {
                form.reset();
                showCreateModal.value = false
            }
        });
    } else {
        form.post(route('options.store'), {
            onSuccess: () => {
                showCreateModal.value = false
                form.reset()
            }
        })
    }
}

const deleteOption = (id, name) => {
    Swal.fire({
        title: `¿Estás seguro de eliminar la opción #${id}?`,
        text: "¡No podrás deshacer esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo'

    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('options.destroy', id));
        } else {
            Swal.fire('Cancelado', 'La Opción no fue eliminada.', 'info');
        }
    })

}
</script>