<template>

    <Head title="Usuarios" />
    <AuthenticatedLayout>
        <div class="mx-4 mt-4 p-4">
            <div class="flex justify-between flex-col gap-2">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="flex justify-start">
                        <h2 class="text-3xl font-bold">Usuarios</h2>
                    </div>
                    <div class="flex justify-end">
                        <button @click="handleModal()"
                            class="flex justify-end text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                            Añadir Usuario
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
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Rol
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id"
                                class="bg-white border-b border-gray-200 hover:bg-slate-50 ">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                    {{ user.id }}
                                </th>
                                <td class="px-6 py-4 text-center">
                                    {{ user.name }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ user.email }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ getRole(user.is_admin) }}
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-3">
                                    <Link :href="route('users.show', user)"
                                        class="p-2 font-medium text-gray-500 hover:text-blue-600 hover:underline"
                                        title="Ver Usuario">
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
                                    <button @click="toggleEditModal(user)"
                                        class="p-2 font-medium text-gray-500 hover:text-yellow-600 hover:underline"
                                        title="Editar Usuario">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>
                                    <button @click="deleteUser(user.id, user.name)"
                                        class="p-2 font-medium text-gray-500 hover:text-red-600 hover:underline"
                                        title="Eliminar Usuario">
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
                            <tr v-if="users.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center">
                                    No se encontraron usuarios registrados
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>

    <!-- Modal para crear Usuario -->
    <div v-if="showCreateModal"
        class="fixed inset-0 flex items-center justify-center bg-gray-900/60 backdrop-blur-[2px] z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md shadow-xl relative">
            <h2 class="text-xl font-bold mb-4">{{ isEditing ? 'Modificar Usuario' : 'Nuevo Usuario' }}</h2>

            <form @submit.prevent="submit" class="flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input v-model="form.name" type="text" placeholder="Juan Perez"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    <div v-if="errors.name" class="text-red-500 text-sm mt-1">
                        {{ errors.name }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" type="email" placeholder="user@example.com"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                    <div v-if="errors.email" class="text-red-500 text-sm mt-1">
                        {{ errors.email }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de Usuario</label>
                    <select v-model="form.is_admin"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm placeholder:text-gray-300">
                        <option value="" disabled>Seleccione una opción</option>
                        <option value=1>Administrador</option>
                        <option value=0>Usuario</option>
                    </select>
                    <div v-if="errors.is_admin" class="text-red-500 text-sm mt-1">
                        {{ errors.is_admin }}
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" v-model="form.password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                        <span @click="showPassword = !showPassword"
                            class="absolute z-30 text-gray-500 -translate-y-1/2 cursor-pointer right-4 top-1/2">
                            <svg v-if="!showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                                    fill="#98A2B3" />
                            </svg>
                            <svg v-if="showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"
                                    fill="#98A2B3" />
                            </svg>
                        </span>
                    </div>
                    <div v-if="errors.password" class="text-red-500 text-sm mt-1">
                        {{ errors.password }}
                    </div>
                </div>

                <!-- Confirmar Contraseña -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                    <div class="relative">
                        <input :type="showPasswordConfirmation ? 'text' : 'password'" v-model="form.password_confirmation" autocomplete="new-password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                        <span @click="showPasswordConfirmation = !showPasswordConfirmation"
                            class="absolute z-30 text-gray-500 -translate-y-1/2 cursor-pointer right-4 top-1/2">
                            <svg v-if="!showPasswordConfirmation" class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                                    fill="#98A2B3" />
                            </svg>
                            <svg v-if="showPasswordConfirmation" class="fill-current" width="20" height="20" viewBox="0 0 20 20"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"
                                    fill="#98A2B3" />
                            </svg>
                        </span>
                    </div>
                    <div v-if="errors.password_confirmation" class="text-red-500 text-sm mt-1">
                        {{ errors.password_confirmation }}
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Swal from 'sweetalert2';

const showCreateModal = ref(false);
const isEditing = ref(false);
const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

defineProps({
    users: Array,
    errors: Object
})

const form = useForm({
    name: '',
    email: '',
    is_admin: '',
    password: '',
    password_confirmation: ''
})

const handleModal = () => {
    form.reset();
    isEditing.value = false;
    showCreateModal.value = true;
}

const toggleEditModal = (user) => {
    isEditing.value = true;
    showCreateModal.value = true;
    form.reset();

    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.is_admin = user.is_admin;
    form.password = user.password;
}

const getRole = (role) => {
    return role === 1 ? 'Administrador' : 'Propietario';
}

const submit = () => {

    if (form.password !== form.password_confirmation) {
        return Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Las contraseñas no coinciden.',
            confirmButtonText: 'Aceptar'
        })
    }

    if (isEditing.value) {
        form.put(route('users.update', form.id), {
            onSuccess: () => {
                form.reset();
                showCreateModal.value = false
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario actualizado',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            onError: () => {
                Swal.fire('Error', 'Revisa los campos del formulario.', 'error');
            }
        });
    } else {
        form.post(route('users.store'), {
            onSuccess: () => {
                showCreateModal.value = false
                form.reset()
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario creado',
                    text: 'El Usuario se ha guardado correctamente.',
                    timer: 2500,
                    showConfirmButton: false
                })
            },
            onError: () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Revisa los campos del formulario.',
                    confirmButtonText: 'Aceptar'
                })
            }
        })
    }
}

const deleteUser = (id, name) => {
    Swal.fire({
        title: `¿Estás seguro de eliminar a ${name}?`,
        text: "¡No podrás deshacer esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminarlo'

    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('users.destroy', id), {
                onSuccess: () => {
                    Swal.fire('Eliminado', 'El usuario fue eliminado.', 'success');
                }
            });
        } else {
            Swal.fire('Cancelado', 'El usuario no fue eliminado.', 'info');
        }
    })

}
</script>