<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: AppLayout })

const props = defineProps({ role: Object })

const form = useForm({
  name: props.role.name,
  guard_name: props.role.guard_name
})

function submit() {
  form.put(route('roles.update', props.role.id))
}
</script>

<template>
  <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Rol</h1>

    <form @submit.prevent="submit" class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-green-200 focus:outline-none"
          placeholder="Nombre del rol"
        />
        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
          {{ form.errors.name }}
        </p>
      </div>

      <div>
        <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-1">Guard</label>
        <input
          id="guard_name"
          v-model="form.guard_name"
          type="text"
          class="block w-full border border-gray-300 rounded-md px-4 py-2 focus:ring focus:ring-green-200 focus:outline-none"
          placeholder="web, api, etc."
        />
        <p v-if="form.errors.guard_name" class="mt-1 text-sm text-red-600">
          {{ form.errors.guard_name }}
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
