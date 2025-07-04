<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const props = defineProps({ gestion: Object })

const form = useForm({
  nombre: props.gestion.nombre
})

function submit() {
  form.put(route('gestion.update', props.gestion.id))
}
</script>

<template>
  <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Gestión</h1>

    <form @submit.prevent="submit" class="space-y-6">
      <div>
        <label
          for="nombre"
          class="block text-sm font-medium text-gray-700 mb-1"
        >
          Nombre
        </label>
        <input
          id="nombre"
          v-model="form.nombre"
          type="text"
          class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-green-200 focus:outline-none"
          placeholder="Nombre de la gestión"
        />
        <p v-if="form.errors.nombre" class="mt-1 text-sm text-red-600">
          {{ form.errors.nombre }}
        </p>
      </div>

      <div class="flex justify-end gap-3">
        <button
          type="submit"
          class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-md shadow"
        >
          Actualizar
        </button>
      </div>
    </form>
  </div>
</template>
