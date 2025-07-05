<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const form = useForm({
    descripcion: ''
})

function submit() {
    form.post(route('tipoalerta.store')) 
}
</script>

<template>
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Tipo de Alerta</h1>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <input id="descripcion" v-model="form.descripcion" type="text"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    placeholder="Descripción de la alerta" />
                <p v-if="form.errors.descripcion" class="mt-1 text-sm text-red-600">{{ form.errors.descripcion }}</p>
            </div>

            <div class="flex justify-between items-center">
                <Link :href="route('tipoalerta.index')"
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
