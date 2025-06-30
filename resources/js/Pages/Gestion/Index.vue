<template>
  <div>
    <h1 class="text-2xl font-bold">Gestiones</h1>
    <Link href="/gestion/create">Crear nueva</Link>
    <ul>
      <li v-for="g in gestiones" :key="g.id">
        {{ g.nombre }}
        <Link :href="`/gestion/${g.id}/edit`">Editar</Link>
        <form :action="`/gestion/${g.id}`" method="POST" @submit.prevent="deleteGestion(g.id)">
          <input type="hidden" name="_method" value="DELETE" />
          <button type="submit">Eliminar</button>
        </form>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
defineProps({ gestiones: Array })

function deleteGestion(id) {
  router.delete(`/gestion/${id}`)
}
</script>
