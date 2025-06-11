<!-- filepath: resources/js/Pages/Estudiantes/Index.vue -->
<template>
  <div>
    <h1>Estudiantes</h1>
    <Link href="/estudiantes/create">Nuevo Estudiante</Link>
    <table>
      <thead>
        <tr>
          <th>Reg</th>
          <th>Nombre</th>
          <th>Carrera</th>
          <th>Fecha Emisión</th>
          <th>Código</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="est in estudiantes" :key="est.reg">
          <td>{{ est.reg }}</td>
          <td>{{ est.nombre }}</td>
          <td>{{ est.carrera }}</td>
          <td>{{ est.fecha_emision }}</td>
          <td>{{ est.codigo }}</td>
          <td>
            <Link :href="`/estudiantes/${est.reg}/edit`">Editar</Link>
            <Link :href="`/estudiantes/${est.reg}`">Ver</Link>
            <button @click="borrar(est.reg)">Borrar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
defineProps({ estudiantes: Array })

function borrar(reg) {
  if (confirm('¿Seguro que deseas borrar este estudiante?')) {
    router.delete(`/estudiantes/${reg}`)
  }
}
</script>