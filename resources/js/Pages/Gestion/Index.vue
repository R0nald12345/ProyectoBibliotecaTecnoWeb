<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

defineProps({ gestiones: Array })

const flash = usePage().props.flash

const message = computed(() => flash.success || flash.message)

function deleteGestion(id) {
    router.delete(route('gestion.destroy', id), {
        preserveScroll: true,
        preserveState: false,
    })
}
</script>

<template>
    <div style="color: var(--text-color)">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Gestiones</h1>
            <Link :href="route('gestion.create')"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                + Nueva gestión
            </Link>
        </div>

        <div v-if="message"
            class="mb-4 p-4 rounded border shadow"
            style="background-color: var(--success-bg); color: var(--success-text); border-color: var(--success-border)">
            {{ message }}
        </div>

        <div class="overflow-x-auto shadow rounded-lg" style="background-color: var(--bg-color)">
            <table class="min-w-full divide-y divide-gray-300" style="color: var(--text-color)">
                <thead style="background-color: var(--bg-secondary)">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Estado</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="g in gestiones" :key="g.id">
                        <td class="px-6 py-4">{{ g.nombre }}</td>
                        <td class="px-6 py-4">{{ g.estado }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <Link :href="route('gestion.edit', g.id)"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow">
                                Editar
                            </Link>
                            <form @submit.prevent="deleteGestion(g.id)" class="inline">
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

