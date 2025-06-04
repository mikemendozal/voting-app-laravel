<template>

    <Head title="Preguntas" />
    <AuthenticatedLayout>
        <div class="mx-4 mt-4 p-4">
            <div class="flex justify-between flex-col gap-2">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="flex justify-start">
                        <h2 class="text-3xl font-bold">Preguntas</h2>
                    </div>
                    <div class="flex justify-end">
                        <button @click="handleModal()"
                            class="flex justify-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                            Añadir Pregunta
                        </button>
                    </div>
                </div>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Titulo
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Contenido
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Esta Activa?
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Creada Por
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Actualizada Por
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Opciones
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="question in questions" :key="question.id"
                                class="bg-white border-b border-gray-200 hover:bg-slate-50 ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                    {{ question.title }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ question.content }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ question.active ? 'Si' : 'No' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ question.creator?.name }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ question.updater?.name ?? 'No Actualizada' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <li
                                        v-for="option in question.options.filter(option => option.question_id === question.id)">
                                        {{ option.content }}
                                    </li>
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-3">
                                    <Link :href="route('questions.show', question)"
                                        class="p-2 font-medium text-gray-500 hover:text-blue-600 hover:underline"
                                        title="Ver pregunta">
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
                                    <button @click="toggleEditModal(question)"
                                        class="p-2 font-medium text-gray-500 hover:text-yellow-600 hover:underline"
                                        title="Editar pregunta">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>
                                    <button @click="deleteQuestion(question.id, question.title)"
                                        class="p-2 font-medium text-gray-500 hover:text-red-600 hover:underline"
                                        title="Eliminar pregunta">
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
                            <tr v-if="questions.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center">
                                    No se encontraron preguntas registradas
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Modal para crear pregunta -->
    <div v-if="showCreateModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-900/60 backdrop-blur-[2px] z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-xl h-[90vh] overflow-y-auto relative">
            <h2 class="text-xl font-bold mb-4">{{ isEditing ? 'Modificar Pregunta' : 'Nueva Pregunta' }}</h2>

            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titulo</label>
                    <input v-model="form.title" type="text" placeholder="Ejemplo: Pregunta 1"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    <div v-if="errors.title" class="text-red-500 text-sm mt-1">
                        {{ errors.title }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contenido</label>
                    <textarea v-model="form.content" type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    <div v-if="errors.content" class="text-red-500 text-sm mt-1">
                        {{ errors.content }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 pb-2">Esta activa?</label>
                    <div class="mb-6 flex flex-wrap items-center gap-6 sm:gap-8">
                        <label for="toggle2"
                            class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                            <div class="relative">
                                <input type="checkbox" id="toggle2" class="sr-only" v-model="form.active" />
                                <div class="block h-6 w-11 rounded-full"
                                    :class="form.active ? 'bg-indigo-500 dark:bg-indigo-500' : 'bg-gray-200 dark:bg-white/10'">
                                </div>
                                <div :class="form.active ? 'translate-x-full' : 'translate-x-0'"
                                    class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
                                </div>
                            </div>
                            <label for="toggle2">{{ form.active ? 'Si' : 'No' }}</label>
                        </label>
                    </div>
                    <div v-if="errors.active" class="text-red-500 text-sm mt-1">
                        {{ errors.active }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Opciones de respuesta</label>

                    <!-- Campo de búsqueda -->
                    <span class="relative block">
                        <input type="text" v-model="searchOptions" placeholder="Buscar opciones..."
                            class="block rounded-md border-gray-300 shadow-sm py-2 px-4 w-full pr-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                        </svg>
                    </span>

                    <!-- Lista desplegable de opciones que coinciden con la búsqueda -->
                    <ul v-if="searchOptions.length > 0" class="absolute w-[89%] bg-gray-50 shadow-md p-2"
                        :class="{ 'h-28 overflow-y-auto': filteredOptions.length > 0, 'h-10': filteredOptions.length === 0 }">
                        <li v-for="option in filteredOptions" :key="option.id"
                            class="mb-2 px-2 border-b border-gray-200 hover:bg-gray-100">
                            <a @click="addExistingOption(option)" class="cursor-pointer">{{ option.content }}</a>
                        </li>
                        <li v-if="filteredOptions.length === 0" class="mb-2 px-2">
                            No se encontraron opciones...
                        </li>
                    </ul>



                    <div v-for="(option, index) in form.options" :key="index" class="flex items-center gap-2 mb-2 mt-4">
                        <input v-model="option.content" type="text"
                            class="flex-1 block rounded-md border-gray-300 shadow-sm"
                            placeholder="Ejemplo: Sí, No, Tal vez..." />
                        <button type="button" @click="removeOption(index)"
                            class="text-red-600 hover:text-red-800 font-semibold" title="Eliminar opción">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <button type="button" @click="addOption"
                        class="mt-1 text-blue-600 hover:text-blue-800 text-sm font-medium">
                        + Añadir opción
                    </button>

                    <div v-if="errors.options" class="text-red-500 text-sm mt-1">
                        {{ errors.options }}
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
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';

const page = usePage()
const showCreateModal = ref(false);
const isEditing = ref(false);
const searchOptions = ref('');
const filteredOptions = ref([]);

// Watch for changes in searchOptions and update filteredOptions accordingly
watch(
    searchOptions,
    (newValue) => {
        filteredOptions.value = (page.props.options || []).filter(option => {
            return option.content.toLowerCase().includes(newValue.toLowerCase());
        });
    }
);

// Watch for flash messages and show alerts
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
    questions: Array,
    errors: Object,
    options: Array,
})


const form = useForm({
    title: '',
    content: '',
    active: true,
    options: [],
})

const addOption = () => {
    form.options.push({ content: '' }); // Nueva opción sin ID
};

const addExistingOption = (option) => {
   // Verificar si la opción ya está agregada
    const exists = form.options.some(opt => opt.id === option.id);
    
    if (!exists) {
        form.options.push({ 
            id: option.id, 
            content: option.content 
        });
        searchOptions.value = '';
    }
}

const removeOption = (index) => {
    form.options.splice(index, 1);
};

const handleModal = () => {
    form.reset();
    isEditing.value = false;
    showCreateModal.value = true;
}

const toggleEditModal = (question) => {
    isEditing.value = true;
    showCreateModal.value = true;
    form.reset();

    form.id = question.id;
    form.title = question.title;
    form.content = question.content;
    form.active = question.active;
    // Mapeamos las opciones existentes con su id y content
    form.options = question.options.map(option => ({
        id: option.id,
        content: option.content
    }));
}



const submit = () => {
    console.log('formulario',form)
    if (isEditing.value) {
        form.put(route('questions.update', form.id), {
            onSuccess: () => {
                form.reset();
                showCreateModal.value = false
            }
        });
    } else {
        form.post(route('questions.store'), {
            onSuccess: () => {

                showCreateModal.value = false
                form.reset()
            }
        })
    }
}

const deleteQuestion = (id, name) => {
    Swal.fire({
        title: `¿Estás seguro de eliminar la ${name}?`,
        text: "¡No podrás deshacer esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo'

    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('questions.destroy', id));
        } else {
            Swal.fire('Cancelado', 'La pregunta no fue eliminada.', 'info');
        }
    })

}
</script>