<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

defineProps({ alertas: Array })

const flash = usePage().props.flash
const message = computed(() => flash.success || flash.message)

function deleteAlerta(id) {
    router.delete(route('tipoalerta.destroy', id), {
        preserveScroll: true,
        preserveState: false,
    })
}
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tipos de Alerta</h1>
            <Link :href="route('tipoalerta.create')"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                + Nuevo tipo de alerta
            </Link>
        </div>

        <div v-if="message" class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">
            {{ message }}
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Descripción</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="a in alertas" :key="a.id">
                        <td class="px-6 py-4 text-gray-800">{{ a.descripcion }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <Link :href="route('tipoalerta.edit', a.id)"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow">
                                Editar
                            </Link>
                            <form @submit.prevent="deleteAlerta(a.id)" class="inline">
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
