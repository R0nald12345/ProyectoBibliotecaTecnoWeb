<template>
  <div class="p-6 max-w-md mx-auto bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Tu código QR personal</h2>

    <div class="flex justify-center">
      <img v-if="qrImage" :src="qrImage" alt="Código QR" class="border p-2 rounded" />
    </div>

    <div class="mt-6 flex justify-center space-x-4">
      <button
        @click="downloadQR"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Descargar QR
      </button>


    </div>

    <p v-if="mensaje" class="mt-4 text-green-700 font-semibold text-center">
      {{ mensaje }}
    </p>
  </div>
</template>

<script setup>
import QRCode from 'qrcode'
import download from 'downloadjs'
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const user = usePage().props.auth.user
const qrImage = ref(null)
const mensaje = ref('')

defineOptions({ layout: AppLayout })

// Generamos el endpoint personalizado para el QR
const qrEndpoint = `${window.location.origin}/qr/${user.qr_token}`

onMounted(async () => {
  // Generar el QR como dataURL
  qrImage.value = await QRCode.toDataURL(qrEndpoint, { width: 300 })
})

// Descargar imagen QR
const downloadQR = () => {
  if (qrImage.value) {
    download(qrImage.value, 'qr-' + user.name + '.png', 'image/png')
  }
}


</script>
