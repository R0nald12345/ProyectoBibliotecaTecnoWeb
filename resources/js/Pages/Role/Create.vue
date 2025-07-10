<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, Link } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const form = useForm({
    name: '',
    guard_name: 'web'
})

function submit() {
    form.post(route('roles.store'));
}

</script>

<template>
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Rol</h1>

        <form @submit.prevent="submit" class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input id="name" v-model="form.name" type="text"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    placeholder="Nombre del rol" />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <div>
                <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-1">Guard</label>
                <input id="guard_name" v-model="form.guard_name" type="text"
                    class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none"
                    placeholder="web, api, etc." />
                <p v-if="form.errors.guard_name" class="mt-1 text-sm text-red-600">{{ form.errors.guard_name }}</p>
            </div>

            <div class="flex justify-between items-center">
                <Link :href="route('roles.index')"
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
