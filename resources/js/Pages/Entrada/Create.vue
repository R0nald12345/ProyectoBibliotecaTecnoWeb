<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  usuarios: Array,
  tipos_alerta: Array,
  fecha_actual: String,
  hora_actual: String,
})

const form = useForm({
  descripcion: '',
  fecha: props.fecha_actual,
  hora: props.hora_actual,
  user_id: props.usuarios.length > 0 ? props.usuarios[0].id : '',
  tipoalerta_id: props.tipos_alerta.length > 0 ? props.tipos_alerta[0].id : '',
})

function submit() {
  form.post('/entrada', {
    preserveScroll: true,
  })
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Crear Entrada</h1>
      <Link href="/entrada" class="text-blue-600 hover:underline font-semibold">← Volver</Link>
    </div>

    <form @submit.prevent="submit" class="bg-white p-6 rounded shadow space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Descripción</label>
        <input v-model="form.descripcion" type="text"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200"/>
        <div v-if="form.errors.descripcion" class="text-red-500 text-sm mt-1">{{ form.errors.descripcion }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Fecha</label>
        <input v-model="form.fecha" type="date"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Hora</label>
        <input v-model="form.hora" type="time"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200"/>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Usuario</label>
        <select v-model="form.user_id"
                class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200">
          <option disabled value="">Seleccione un usuario</option>
          <option v-for="u in usuarios" :key="u.id" :value="u.id">{{ u.name }}</option>
        </select>
        <div v-if="form.errors.user_id" class="text-red-500 text-sm mt-1">{{ form.errors.user_id }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Tipo de Alerta</label>
        <select v-model="form.tipoalerta_id"
                class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200">
          <option disabled value="">Seleccione una alerta</option>
          <option v-for="t in tipos_alerta" :key="t.id" :value="t.id">{{ t.descripcion }}</option>
        </select>
        <div v-if="form.errors.tipoalerta_id" class="text-red-500 text-sm mt-1">{{ form.errors.tipoalerta_id }}</div>
      </div>

      <div class="mt-6">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow"
                :disabled="form.processing">
          Guardar Entrada
        </button>
      </div>
    </form>
  </div>
</template>
