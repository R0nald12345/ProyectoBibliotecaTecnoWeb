<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    entradas: Object
})

const flash = usePage().props.flash
const message = computed(() => flash.success || flash.message)

const search = ref('')

const filteredEntradas = computed(() => {
    const filtro = search.value.toLowerCase()
    return props.entradas.data.filter(e => {
        const user = e.user?.name?.toLowerCase() || ''
        const tipo = e.tipoalerta?.descripcion?.toLowerCase() || ''
        return (
            e.descripcion.toLowerCase().includes(filtro) ||
            e.fecha.toLowerCase().includes(filtro) ||
            e.hora.toLowerCase().includes(filtro) ||
            user.includes(filtro) ||
            tipo.includes(filtro)
        )
    })
})

function deleteEntrada(id) {
    if (confirm('¿Estás seguro de eliminar esta entrada?')) {
        router.delete(`/entrada/${id}`, {
            preserveScroll: true,
            preserveState: false,
        })
    }
}
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Entradas</h1>
            <Link :href="route('entrada.create')"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
            + Nueva entrada
            </Link>
        </div>


        <div v-if="message" class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">
            {{ message }}
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <div class="mb-4">
                <input v-model="search" type="text" placeholder="Buscar entrada..."
                    class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Descripción</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Hora</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Usuario</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipo de Alerta</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="e in filteredEntradas" :key="e.id">
                        <td class="px-6 py-4 text-gray-800">{{ e.descripcion }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ e.fecha }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ e.hora }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ e.user?.name || '—' }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ e.tipoalerta?.descripcion || '—' }}</td>
                        <td class="px-6 py-4 text-right space-x-2">

                            <form @submit.prevent="deleteEntrada(e.id)" class="inline">
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="filteredEntradas.length === 0" class="text-center text-gray-500 py-4">
                No se encontraron entradas.
            </div>

            <div class="mt-4 flex justify-center space-x-2" v-if="!search">
                <template v-for="link in entradas.links" :key="link.label">
                    <component :is="link.url ? Link : 'span'" :href="link.url" class="px-3 py-1 rounded border text-sm"
                        :class="{
                            'bg-blue-600 text-white font-semibold': link.active,
                            'bg-white text-gray-700 hover:bg-gray-100': !link.active,
                            'cursor-not-allowed opacity-50': !link.url
                        }" v-html="link.label" />
                </template>
            </div>
        </div>
    </div>
</template>
