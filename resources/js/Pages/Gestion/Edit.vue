<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Editar Gestión</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block mb-1">Nombre</label>
        <input v-model="form.nombre" type="text" class="border rounded px-3 py-2 w-full" />
        <div v-if="form.errors.nombre" class="text-red-500">{{ form.errors.nombre }}</div>
      </div>

      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
const props = defineProps({ gestion: Object })

const form = useForm({
  nombre: props.gestion.nombre
})

function submit() {
  form.put(`/gestion/${props.gestion.id}`)
}
</script>
