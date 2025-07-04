<script setup>
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref, onMounted, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  salidas: Object
})

const flash = usePage().props.flash
const message = computed(() => flash.success || flash.message)

const search = ref('')
const fechaInicio = ref('')
const fechaFin = ref('')

const salidasFiltradasPorFecha = ref([])

function aplicarFiltro() {
  salidasFiltradasPorFecha.value = props.salidas.data.filter(e => {
    const fecha = new Date(e.fecha)
    const inicio = fechaInicio.value ? new Date(fechaInicio.value) : null
    const fin = fechaFin.value ? new Date(fechaFin.value) : null

    if (inicio && fecha < inicio) return false
    if (fin && fecha > fin) return false
    return true
  })
}

function limpiarFiltro() {
  fechaInicio.value = ''
  fechaFin.value = ''
  salidasFiltradasPorFecha.value = props.salidas.data
}

onMounted(() => {
  salidasFiltradasPorFecha.value = props.salidas.data
})

watch(() => props.salidas, (nuevo) => {
  salidasFiltradasPorFecha.value = nuevo.data
})

const filteredSalidas = computed(() => {
  let base = salidasFiltradasPorFecha.value
  const filtro = search.value.toLowerCase()
  if (!filtro) return base
  return base.filter(e => {
    const user = e.user?.name?.toLowerCase() || ''
    const tipo = e.tipoalerta?.descripcion?.toLowerCase() || ''
    const gestion = e.gestion?.nombre?.toLowerCase() || ''
    return (
      e.descripcion.toLowerCase().includes(filtro) ||
      e.fecha.toLowerCase().includes(filtro) ||
      e.hora.toLowerCase().includes(filtro) ||
      user.includes(filtro) ||
      tipo.includes(filtro) ||
      gestion.includes(filtro)
    )
  })
})

function deleteSalida(id) {
<<<<<<< HEAD
    if (confirm('¿Estás seguro de eliminar esta salida?')) {
        router.delete(route('salida.destroy', id), {
            preserveScroll: true,
            preserveState: false,
        })
    }
=======
  if (confirm('¿Estás seguro de eliminar esta salida?')) {
    router.delete(route('salida.destroy', id), {
      preserveScroll: true,
      preserveState: false,
    })
  }
>>>>>>> d506f30c229d9fa8c5d880a192c744887c2cc21c
}

function exportarExcel() {
  const params = new URLSearchParams()
  if (fechaInicio.value) params.append('inicio', fechaInicio.value)
  if (fechaFin.value) params.append('fin', fechaFin.value)
  window.open(route('salida.export.excel') + '?' + params.toString(), '_blank')
}

const mostrarPaginacion = computed(() =>
  !search.value && !fechaInicio.value && !fechaFin.value
)
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Salidas</h1>
      <Link :href="route('salida.create')"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
        + Nueva salida
      </Link>
    </div>

    <div v-if="message" class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow">
      {{ message }}
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <div class="mb-4">
        <input v-model="search" type="text" placeholder="Buscar salida..."
          class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring focus:ring-blue-200" />
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-4">
        <div class="flex gap-2 items-center">
          <input type="date" v-model="fechaInicio" class="border rounded px-3 py-2" />
          <input type="date" v-model="fechaFin" class="border rounded px-3 py-2" />
          <button @click="aplicarFiltro"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-2 rounded shadow">
            Filtrar
          </button>
          <button @click="limpiarFiltro"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-3 py-2 rounded shadow">
            Limpiar
          </button>
        </div>
        <div class="flex gap-2">
          <button @click="exportarExcel"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">
            Exportar Excel
          </button>
        </div>
      </div>

      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Descripción</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Hora</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Usuario</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Gestión</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipo de Alerta</th>
            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="s in filteredSalidas" :key="s.id">
            <td class="px-6 py-4 text-gray-800">{{ s.descripcion }}</td>
            <td class="px-6 py-4 text-gray-800">{{ s.fecha }}</td>
            <td class="px-6 py-4 text-gray-800">{{ s.hora }}</td>
            <td class="px-6 py-4 text-gray-800">{{ s.user?.name || '—' }}</td>
            <td class="px-6 py-4 text-gray-800">{{ s.gestion?.nombre || '—' }}</td>
            <td class="px-6 py-4 text-gray-800">{{ s.tipoalerta?.descripcion || '—' }}</td>
            <td class="px-6 py-4 text-right space-x-2">
              <form @submit.prevent="deleteSalida(s.id)" class="inline">
                <button type="submit"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="filteredSalidas.length === 0" class="text-center text-gray-500 py-4">
        No se encontraron salidas.
      </div>

      <div class="mt-4 flex justify-center space-x-2" v-if="mostrarPaginacion">
        <template v-for="link in props.salidas.links" :key="link.label">
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
