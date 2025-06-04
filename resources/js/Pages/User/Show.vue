<template>

    <Head title="Detalle de usuario" />
     <AuthenticatedLayout>
        <div class="py-4">
        <section class="py-8 antialiased md:py-16 h-screen">
            <div class="mx-auto max-w-5xl px-4 2xl:px-0">
                <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl mb-2">Detalles del usuario
                </h2>
                <p class="text-gray-500 mb-6 md:mb-8">
                    Aquí puedes ver los detalles del usuario que has seleccionado. Asegúrate de revisar toda la
                    información
                </p>
                <div
                    class="space-y-4 sm:space-y-2 rounded-lg border border-gray-100 bg-gray-50 p-6 mb-6 md:mb-8">
                    <dl class="sm:flex items-center justify-between gap-4">
                        <dt class="font-normal mb-1 sm:mb-0 text-gray-500 ">Fecha de creación</dt>
                        <dd class="font-medium text-gray-900  sm:text-end">{{ formatDate(user.created_at) }}</dd>
                    </dl>
                    <dl class="sm:flex items-center justify-between gap-4">
                        <dt class="font-normal mb-1 sm:mb-0 text-gray-500 ">Nombre</dt>
                        <dd class="font-medium text-gray-900 sm:text-end">{{ user.name }}</dd>
                    </dl>
                    <dl class="sm:flex items-center justify-between gap-4">
                        <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-900  sm:text-end">{{ user.email }}</dd>
                    </dl>
                    <dl class="sm:flex items-center justify-between gap-4">
                        <dt class="font-normal mb-1 sm:mb-0 text-gray-500 ">Rol</dt>
                        <dd class="font-medium text-gray-900 sm:text-end">{{ getRole(user.is_admin) }}</dd>
                    </dl>
                </div>
                <div class="flex items-center space-x-4">
                    <Link :href="route('users.index')"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Regresar</Link>
                </div>
            </div>
        </section>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    user: Array
});

const getRole = (role) => {
    return role === 1 ? 'Administrador' : 'Propietario';
}

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('es-ES', options);
};

</script>
