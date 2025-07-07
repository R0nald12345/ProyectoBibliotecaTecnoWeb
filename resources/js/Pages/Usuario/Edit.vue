<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  usuario: Object,
  roles: Array,
})

const form = useForm({
  name: props.usuario.name,
  email: props.usuario.email,
  password: '',
  password_confirmation: '',
  celular: props.usuario.celular ?? '',
  role: props.usuario.roles.length ? props.usuario.roles[0].name : '',
})

function submit() {
  form.put(route('usuarios.update', props.usuario.id), {
    preserveScroll: true,
  });
}

</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Editar Usuario</h1>
     <Link :href="route('usuarios.index')" class="text-blue-600 hover:underline font-semibold">← Volver</Link>
    </div>

    <form @submit.prevent="submit" class="bg-white p-6 rounded shadow space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Nombre</label>
        <input v-model="form.name" type="text"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200" />
        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="form.email" type="email"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200" />
        <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Nueva Contraseña (opcional)</label>
        <input v-model="form.password" type="password"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200" />
        <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
        <input v-model="form.password_confirmation" type="password"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Celular</label>
        <input v-model="form.celular" type="text"
               class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200" />
        <div v-if="form.errors.celular" class="text-red-500 text-sm mt-1">{{ form.errors.celular }}</div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
        <select v-model="form.role"
                class="w-full mt-1 px-4 py-2 border rounded shadow-sm focus:ring focus:ring-blue-200">
          <option value="" disabled>Seleccione un rol</option>
          <option v-for="r in roles" :key="r.id" :value="r.name">{{ r.name }}</option>
        </select>
        <div v-if="form.errors.role" class="text-red-500 text-sm mt-1">{{ form.errors.role }}</div>
      </div>

      <div class="mt-6">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow"
                :disabled="form.processing">
          Actualizar
        </button>
      </div>
    </form>
  </div>
</template>
