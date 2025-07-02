<script setup>
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  entradasPorGestion: Array
})

const canvasRef = ref(null)

onMounted(() => {
  if (!props.entradasPorGestion || props.entradasPorGestion.length === 0) {
    console.warn('⚠️ No hay datos para mostrar.')
    return
  }

  const ctx = canvasRef.value.getContext('2d')
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: props.entradasPorGestion.map(e => e.gestion),
      datasets: [{
        label: 'Entradas por Gestión',
        data: props.entradasPorGestion.map(e => e.total),
        backgroundColor: 'rgba(37, 99, 235, 0.6)',
        borderColor: 'rgba(37, 99, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true }
      }
    }
  })
})
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Gráfico de Entradas por Gestión</h1>
    <div class="bg-white p-4 rounded shadow w-full h-[400px]">
      <canvas ref="canvasRef" class="w-full h-full"></canvas>
    </div>
  </div>
</template>
