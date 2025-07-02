<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
    usuarios: Object,
    filters: Object
})

const flash = usePage().props.flash
const message = computed(() => flash.success || flash.message)

const search = ref('')

// 🔍 Filtro en frontend sin tocar backend
const filteredUsuarios = computed(() => {
    const filtro = search.value.toLowerCase()

    return props.usuarios.data.filter(u => {
        const roles = u.roles.map(r => r.name).join(' ').toLowerCase()
        return (
            u.name.toLowerCase().includes(filtro) ||
            u.email.toLowerCase().includes(filtro) ||
            (u.celular && u.celular.toLowerCase().includes(filtro)) ||
            roles.includes(filtro)
        )
    })
})


function deleteUsuario(id) {
    if (confirm('¿Estás seguro de eliminar este usuario?')) {
        router.delete(`/usuarios/${id}`, {
            preserveScroll: true,
            preserveState: false,
        })
    }
}
</script>

<template>
    <div>
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Usuarios</h1>
            <Link href="/usuarios/create"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
            + Nuevo usuario
            </Link>
        </div>

        <div v-if="message" class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">
            {{ message }}
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <div class="mb-4">
                <input v-model="search" type="text" placeholder="Buscar usuario..."
                    class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Celular</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Rol(es)</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="u in filteredUsuarios" :key="u.id">
                        <td class="px-6 py-4 text-gray-800">{{ u.name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ u.email }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ u.celular ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-800">
                            <span v-if="u.roles.length > 0">
                                {{u.roles.map(r => r.name).join(', ')}}
                            </span>
                            <span v-else class="text-gray-500">Sin rol</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <Link :href="`/usuarios/${u.id}/edit`"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow">
                            Editar
                            </Link>
                            <form :action="`/usuarios/${u.id}`" method="POST" @submit.prevent="deleteUsuario(u.id)"
                                class="inline">
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="filteredUsuarios.length === 0" class="text-center text-gray-500 py-4">
                No se encontraron usuarios.
            </div>

            <div class="mt-4 flex justify-center space-x-2" v-if="!search">
                <template v-for="link in usuarios.links" :key="link.label">
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
