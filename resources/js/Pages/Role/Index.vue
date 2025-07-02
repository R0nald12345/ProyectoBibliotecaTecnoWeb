<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

defineProps({
  roles: Array
})

const flash = usePage().props.flash

const message = computed(() => flash.success || flash.message)

function deleteRole(id) {
  router.delete(`/roles/${id}`, {
    preserveScroll: true,
    preserveState: false,
  })
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Roles</h1>
      <Link
        href="/roles/create"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow"
      >
        + Nuevo rol
      </Link>
    </div>

    <div
      v-if="message"
      class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300 shadow"
    >
      {{ message }}
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Guard</th>
            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="r in roles" :key="r.id">
            <td class="px-6 py-4 text-gray-800">{{ r.name }}</td>
            <td class="px-6 py-4 text-gray-600">{{ r.guard_name }}</td>
            <td class="px-6 py-4 text-right space-x-2">
              <Link
                :href="`/roles/${r.id}/edit`"
                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow"
              >
                Editar
              </Link>
              <form
                :action="`/roles/${r.id}`"
                method="POST"
                @submit.prevent="deleteRole(r.id)"
                class="inline"
              >
                <input type="hidden" name="_method" value="DELETE" />
                <button
                  type="submit"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow"
                >
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
