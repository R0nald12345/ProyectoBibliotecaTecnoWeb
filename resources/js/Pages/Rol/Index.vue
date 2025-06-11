<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import axios from 'axios'

const roles = ref([])
const rol = ref({
    nombre: ''
})

const editando = ref(false)

const cargarRoles = async () => {
    try {
        const response = await axios.get('/api/roles')
        console.log('Roles cargados:', response.data) // Para depuración
        roles.value = response.data
    } catch (error) {
        console.error('Error al cargar roles:', error)
    }
}

const guardarRol = async () => {
    if (!rol.value.nombre) {
        alert('El nombre del rol es requerido')
        return
    }

    try {
        const endpoint = editando.value 
            ? `/api/roles/${rol.value.id}` 
            : '/api/roles'
        
        const response = await axios({
            method: editando.value ? 'put' : 'post',
            url: endpoint,
            data: rol.value
        })
        
        console.log('Respuesta del servidor:', response) // Para depuración
        
        if (response.status === 201 || response.status === 200) {
            alert(editando.value ? 'Rol actualizado con éxito' : 'Rol creado con éxito')
            await cargarRoles()
            limpiarFormulario()
        }
    } catch (error) {
        console.error('Error completo:', error)
        alert(error.response?.data?.message || 'Error al guardar el rol')
    }
}


const editarRol = (rolData) => {
    rol.value = { ...rolData }
    editando.value = true
}


const eliminarRol = async (id) => {
    if (!confirm('¿Está seguro de eliminar este rol?')) return
    
    try {
        await axios.delete(`/api/roles/${id}`)
        await cargarRoles()
        alert('Rol eliminado con éxito')
    } catch (error) {
        console.error('Error al eliminar rol:', error)
        alert('Error al eliminar el rol')
    }
}

const limpiarFormulario = () => {
    rol.value = { nombre: '' }
    editando.value = false
}

onMounted(() => {
    cargarRoles()
})

</script>

<template>
    <AppLayout title="Gestión de Roles">
        <Head title="Roles" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Roles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    
                    <!-- Formulario -->
                    <form @submit.prevent="guardarRol" class="mb-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Nombre del Rol
                            </label>
                            <input 
                                v-model="rol.nombre" 
                                type="text" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                required
                                placeholder="Ingrese el nombre del rol"
                            >
                        </div>
                        <div class="flex items-center gap-4">
                            <button 
                                type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            >
                                {{ editando ? 'Actualizar' : 'Crear' }}
                            </button>
                            <button 
                                v-if="editando" 
                                @click="limpiarFormulario" 
                                type="button" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            >
                                Cancelar
                            </button>
                        </div>
                    </form>

                    <!-- Tabla -->
                    <table class="min-w-full divide-y divide-gray-200 mt-6">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="rolItem in roles" :key="rolItem.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ rolItem.nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        @click="editarRol(rolItem)"
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded mr-2"
                                    >
                                        Editar
                                    </button>
                                    <button 
                                        @click="eliminarRol(rolItem.id)"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                                    >
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>