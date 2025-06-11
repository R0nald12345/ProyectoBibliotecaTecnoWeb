<!-- filepath: resources/js/Pages/Estudiantes/Create.vue -->
<template>
  <div>
    <h1>Nuevo Estudiante</h1>
    <form @submit.prevent="submit">
      <div>
        <label>Reg:</label>
        <input v-model="form.reg" type="number" required />
      </div>
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
      <button type="submit">Guardar</button>
    </form>
    <Link href="/estudiantes">Volver</Link>
  </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  reg: '',
  nombre: '',
  carrera: '',
  fecha_emision: '',
  codigo: ''
})

function submit() {
  form.post('/estudiantes')
}
</script>