<!-- filepath: resources/js/Pages/Estudiantes/Show.vue -->
<template>
  <div>
    <h1>Detalle del Estudiante</h1>
    <p><strong>Reg:</strong> {{ estudiante.reg }}</p>
    <p><strong>Nombre:</strong> {{ estudiante.nombre }}</p>
    <p><strong>Carrera:</strong> {{ estudiante.carrera }}</p>
    <p><strong>Fecha Emisión:</strong> {{ estudiante.fecha_emision }}</p>
    <p><strong>Código:</strong> {{ estudiante.codigo }}</p>
    <Link href="/estudiantes">Volver</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
defineProps({ estudiante: Object })
</script>