<!-- filepath: resources/js/Pages/Estudiantes/Edit.vue -->
<template>
  <div>
    <h1>Editar Estudiante</h1>
    <form @submit.prevent="submit">
      <div>
        <label>Nombre:</label>
        <input v-model="form.nombre" type="text" required />
      </div>
      <div>
        <label>Carrera:</label>
        <input v-model="form.carrera" type="text" required />
      </div>
      <div>
        <label>Fecha Emisión:</label>
        <input v-model="form.fecha_emision" type="date" required />
      </div>
      <div>
        <label>Código:</label>
        <input v-model="form.codigo" type="text" required />
      </div>
      <button type="submit">Actualizar</button>
    </form>
    <Link href="/estudiantes">Volver</Link>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
const props = defineProps({ estudiante: Object })

const form = useForm({
  nombre: props.estudiante.nombre,
  carrera: props.estudiante.carrera,
  fecha_emision: props.estudiante.fecha_emision,
  codigo: props.estudiante.codigo
})

function submit() {
  form.put(`/estudiantes/${props.estudiante.reg}`)
}
</script>