<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const form = useForm({
    nombre: ''
})

function submit() {
    form.post(route('gestion.store'))
}
</script>

<template>
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Gestión</h1>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input id="nombre" v-model="form.nombre" type="text"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    placeholder="Nombre de la gestión" />
                <p v-if="form.errors.nombre" class="mt-1 text-sm text-red-600">{{ form.errors.nombre }}</p>
            </div>
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" v-model="form.estado"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    <option value="" disabled>Seleccione un estado</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
                <p v-if="form.errors.estado" class="mt-1 text-sm text-red-600">{{ form.errors.estado }}</p>
            </div>
            <div class="flex justify-between items-center">
                <Link :href="route('gestion.index')"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-md shadow">
                Volver
                </Link>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-md shadow">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</template>
