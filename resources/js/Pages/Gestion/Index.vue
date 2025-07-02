<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

defineProps({ gestiones: Array })

const flash = usePage().props.flash

const message = computed(() => flash.success || flash.message)

function deleteGestion(id) {
    router.delete(`/gestion/${id}`, {
        preserveScroll: true,
        preserveState: false,
    })
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Gestiones</h1>
    <div
      v-if="message"
      class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300"
    >
      {{ message }}
    </div>

    <Link href="/gestion/create" class="text-blue-600 underline">Crear nueva</Link>

    <ul class="mt-4 space-y-2">
      <li
        v-for="g in gestiones"
        :key="g.id"
        class="border p-4 rounded shadow flex justify-between items-center"
      >
        <span>{{ g.nombre }}</span>
        <div class="space-x-2">
          <Link
            :href="`/gestion/${g.id}/edit`"
            class="bg-yellow-400 text-white px-3 py-1 rounded"
          >
            Editar
          </Link>
          <form
            :action="`/gestion/${g.id}`"
            method="POST"
            @submit.prevent="deleteGestion(g.id)"
            class="inline"
          >
            <input type="hidden" name="_method" value="DELETE" />
            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
              Eliminar
            </button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</template>
