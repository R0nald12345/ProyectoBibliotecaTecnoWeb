<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<template>
  <AppLayout title="Biblioteca Digital">
    <div class="flex items-center justify-center min-h-[80vh]">
      <div class="bg-white dark:bg-blue-900 shadow-2xl rounded-3xl p-10 text-center max-w-2xl w-full border border-amber-200 dark:border-emerald-600">
        
        <!-- Ícono decorativo con emoji -->
        <div class="text-6xl mb-4">📚</div>

        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-emerald-200 font-serif mb-4 tracking-wide">
          Bienvenido al Sistema de Control de Biblioteca FICCT
        </h1>

        <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed max-w-xl mx-auto">
         Asistencia de entrada y salida de los Usuarios, control de gestiones y Reportes.
        </p>

        <div class="mt-8">
          <button
            class="bg-amber-600 hover:bg-amber-700 dark:bg-emerald-600 dark:hover:bg-emerald-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition"
          >
            Ir al catálogo
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
