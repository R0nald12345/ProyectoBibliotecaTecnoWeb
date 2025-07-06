<script setup>

import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

// Inertia pasa automáticamente los datos del controlador como props.
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    mensaje: {
        type: String,
        default: '',
    },
});

// Computed property para manejar la URL de la foto de perfil.
// Asume que las fotos están en 'public/storage' y que has corrido 'php artisan storage:link'.
const fotoUrl = computed(() => {
    return props.user.foto ? `/storage/${props.user.foto}` : null;
});
</script>

<template>



        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 md:p-8 text-center">

                        <!-- Mensaje de confirmación del controlador -->
                        <div v-if="mensaje" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                            <p class="font-bold">Éxito</p>
                            <p>{{ mensaje }}</p>
                        </div>

                        <!-- Foto de perfil -->
                        <div class="mb-4">
                            <img v-if="fotoUrl" :src="fotoUrl" alt="Foto de perfil" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200 shadow-lg">
                            <!-- Placeholder si no hay foto -->
                            <div v-else class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <!-- Nombre del usuario -->
                        <h1 class="text-3xl font-bold text-gray-900">{{ user.name }}</h1>
                        <p class="text-md text-gray-500 mb-6">{{ user.email }}</p>

                        <!-- Detalles del usuario -->
                        <div class="border-t border-gray-200 pt-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 text-left">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">C.I.</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ user.ci || 'No especificado' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Celular</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ user.celular || 'No especificado' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Carrera</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ user.carrera || 'No especificado' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Semestre</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ user.semestre || 'No especificado' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">ID de Usuario</dt>
                                    <dd class="mt-1 text-lg text-gray-900">{{ user.id }}</dd>
                                </div>
                            </dl>
                        </div>

                         <!-- Botón de acción -->
                         <div class="mt-8">
                            <Link 
                                :href="route('dashboard')"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Volver al Inicio
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
</template>