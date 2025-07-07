<template>
    <div class="min-h-screen p-6" style="background-color: var(--bg-body); color: var(--text-color)">
        <!-- Botón Atrás -->
        <div class="mb-4">
            <button
                @click="goBack"
                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Atrás
            </button>
        </div>
        <!-- Header Profesional -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-800 to-red-600 bg-clip-text text-transparent mb-2">
                Sistema de Identificación Universitaria
            </h1>
            <p class="text-lg font-medium" style="color: var(--text-muted)">Escáner de Código QR - Carnet Digital UAGRM
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-red-600 mx-auto mt-3 rounded-full"></div>
        </div>

        <!-- Mensajes de Estado -->
        <div v-if="mensaje" class="mb-6 max-w-md mx-auto">
            <div class="p-4 rounded-lg shadow-lg border-l-4" :class="mensajeEstilo"
                style="background-color: var(--alert-bg); color: var(--alert-text); border-color: var(--alert-border)">
                <div class="flex items-center">
                    <svg v-if="mensaje.includes('Error')" class="w-5 h-5 mr-3 text-red-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg v-else class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ mensaje }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 max-w-7xl mx-auto">
            <!-- Panel del Escáner -->
            <div class="space-y-6">
                <!-- Control de Cámara -->
                <div class="text-center">
                    <button @click="toggleCamara"
                        class="px-8 py-3 rounded-xl font-semibold text-white shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
                        :class="camaraActiva ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-blue-500 to-blue-600'">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path v-if="!camaraActiva" fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2h-1.586l-.707-.707A1 1 0 0013 2H7a1 1 0 00-.707.293L5.586 3H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                    clip-rule="evenodd" />
                                <path v-else fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v3.586l1.293-1.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8 10.586V7z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ camaraActiva ? 'Pausar Cámara' : 'Activar Cámara' }}
                        </span>
                    </button>
                </div>

                <!-- Vista del Escáner -->
                <div class="rounded-2xl shadow-xl p-6"
                    style="background-color: var(--bg-panel); color: var(--text-color)">
                    <h3 class="text-xl font-bold mb-4 text-center" style="color: var(--text-color)">Vista del Escáner
                    </h3>
                    <div class="relative mx-auto bg-gray-900 rounded-xl overflow-hidden"
                        style="width: 500px; height: 400px;">
                        <video id="qr-preview"
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-xl"
                            style="min-width: 100%; min-height: 100%; object-fit: cover;" autoplay muted></video>
                        <!-- Marco de Enfoque -->
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                            <div class="relative w-48 h-48">
                                <!-- Esquinas del marco -->
                                <div
                                    class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-green-400 rounded-tl-lg">
                                </div>
                                <div
                                    class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-green-400 rounded-tr-lg">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-green-400 rounded-bl-lg">
                                </div>
                                <div
                                    class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-green-400 rounded-br-lg">
                                </div>
                                <!-- Línea de escaneo animada -->
                                <div
                                    class="absolute inset-x-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-green-400 to-transparent animate-pulse">
                                </div>
                            </div>
                        </div>
                        <!-- Indicador de estado -->
                        <div
                            class="absolute top-4 right-4 flex items-center space-x-2 bg-black bg-opacity-50 rounded-full px-3 py-1">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-sm font-medium">{{ camaraActiva ? 'Escaneando...' : 'Inactivo'
                            }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel del Carnet -->
            <div v-if="estudianteData" class="flex justify-center items-center">
                <!-- Tarjeta de estudiante -->
                <div v-if="role === 'estudiante'" class="rounded-2xl shadow-xl p-6"
                    style="background-color: var(--bg-card); color: var(--text-color)">
                    <h3 class="text-xl font-bold mb-6 text-center" style="color: var(--text-color)">Carnet Universitario
                        Digital</h3>

                    <div class="relative w-96 h-64 transition-all duration-700 ease-in-out cursor-pointer" :style="{
                        transformStyle: 'preserve-3d',
                        transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)'
                    }" @click="toggleFlip">
                        <TarjetaEstudiante v-if="role === 'estudiante'" :estudianteData="estudianteData"
                            :flipped="flipped" @toggleFlip="toggleFlip" />

                    </div>


                </div>
            </div>
            <!-- Tarjeta de usuario externo con flip -->
            <div v-else-if="role === 'externo'" class="rounded-2xl shadow-xl p-6"
                style="background-color: var(--bg-card); color: var(--text-color)">
                <h3 class="text-xl font-bold mb-6 text-center" style="color: var(--text-color)">
                    Carnet de Usuario
                </h3>

                <div class="relative w-96 h-64 transition-all duration-700 ease-in-out cursor-pointer" :style="{
                    transformStyle: 'preserve-3d',
                    transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)'
                }" @click="toggleFlip">
                    <TarjetaExterno :estudianteData="estudianteData" :flipped="flipped" @toggleFlip="toggleFlip" />
                </div>
            </div>
        </div>

        <ModalCargando v-if="cargandoDatos" />
    </div>
</template>

<script setup>

import { ref, onMounted, onBeforeUnmount } from 'vue'
import { BrowserQRCodeReader } from '@zxing/browser'
import axios from 'axios'
import ModalCargando from '@/Components/ModalCargando.vue'
import TarjetaEstudiante from '@/Components/TarjetaEstudiante.vue'
import TarjetaExterno from '@/Components/TarjetaExterno.vue'
import { useSound } from '@/composables/useSound'
import { useCooldown } from '@/composables/useCooldown'

const {
    mostrarAlertaSalidaExitosa,
    puedeMarcarAsistencia
} = useSound()

// ✅ Usar el composable de cooldown
const {
    puedeEscanear,
    contadorCooldown,
    bloquearEscaneoTemporal,
    resetearCooldown,
    puedeEjecutar,
    tiempoRestante,
    limpiarTimers
} = useCooldown(5000) // 5 segundos de cooldown

const iframeUrl = ref(null)
const mensaje = ref(null)
const mensajeEstilo = ref('bg-blue-100 text-blue-800')
const camaraActiva = ref(false)
const camaras = ref([])
const flipped = ref(false)
const estudianteData = ref(null)
const cargandoDatos = ref(false)
const role = ref('estudiante')
const baseUrl = import.meta.env.VITE_WEBSITE_URL
let codeReader = null
let controlIntervalId = null
let autoFlipIntervalId = null

// ✅ Callbacks para el cooldown
const onCooldownStart = (segundos) => {
    mensaje.value = `QR procesado. Espera ${segundos} segundos para escanear otro...`
    mensajeEstilo.value = 'bg-yellow-100 text-yellow-800'
}

const onCooldownEnd = () => {
    mensaje.value = 'ACEPTADO'
    mostrarAlertaSalidaExitosa()
    mensajeEstilo.value = 'bg-green-100 text-green-800'
}

// Función para alternar la animación flip de la tarjeta
const toggleFlip = () => {
    flipped.value = !flipped.value
}

function goBack() {
    window.location.href = '/dashboard'
}

// Función para extraer los datos del estudiante desde la URL
const extraerDatosEstudiante = async (url) => {
    try {
        if (url.includes('/qr/')) {
            role.value = 'externo'
        }

        cargandoDatos.value = true

        if (role.value === 'estudiante') {
            // Verificar si puede marcar asistencia antes de proceder
            if (!puedeMarcarAsistencia()) {
                cargandoDatos.value = false
                return
            }

            const response = await fetch(`${baseUrl}/scrap-estudiante?url=${url}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })

            if (!response.ok) {
                throw new Error('Error al hacer scraping en el servidor')
            }

            const data = await response.json()
            estudianteData.value = data
            const esValido = data && Object.keys(data).length > 0 && !data.error
            estudianteData.value = esValido ? data : {}

            if (!esValido) {
                mensaje.value = 'Documento no válido'
                mensajeEstilo.value = 'bg-red-100 text-red-800'
                return
            }

            console.log(data)

            // Registrar entrada automáticamente
            const entradaData = {
                descripcion: 'Estudiante aceptado',
                fecha: new Date().toISOString().split('T')[0],
                hora: new Date().toTimeString().split(' ')[0],
                user_id: parseInt(data.REGISTRO),
                tipoalerta_id: 1,
            }

            axios.post(route('salida.store'), entradaData)
                .then(res => {
                    mensaje.value = res.data.message
                    mensajeEstilo.value = 'bg-green-100 text-green-800'

                    // Mostrar alert de entrada exitosa
                    mostrarAlertaSalidaExitosa()
                })
                .catch(err => {
                    mensaje.value = err.response?.data?.message || 'Error al registrar entrada'
                    mensajeEstilo.value = 'bg-red-100 text-red-800'
                })
                .finally(() => {
                    cargandoDatos.value = false
                })
        } else {
            // Usuario externo - también verificar antes de proceder
            if (!puedeMarcarAsistencia()) {
                cargandoDatos.value = false
                return
            }

            // Extraer token de la URL
            const urlParts = url.split('/')
            const token = urlParts[urlParts.length - 1]

            // Obtener datos del usuario usando la nueva ruta
            const userResponse = await axios.get(`${baseUrl}/qr/${token}`)
            console.log('Datos del usuario:', userResponse.data)

            if (!userResponse.data.success) {
                throw new Error('Error al obtener datos del usuario')
            }

            estudianteData.value = userResponse.data.user
            console.log('Role:', role.value)

            // Registrar entrada usando la nueva ruta
            const entradaResponse = await axios.post(`${baseUrl}/qr/salida`, {
                user_id: userResponse.data.user.id,
                tipo: 'salida',
                descripcion: 'Salida vía QR - Usuario externo'
            })

            if (entradaResponse.data.success) {
                // Mostrar SweetAlert para usuario externo
                mostrarAlertaSalidaExitosa()

                mensaje.value = entradaResponse.data.mensaje
                mensajeEstilo.value = 'bg-green-100 text-green-800'
            } else {
                throw new Error('Error al registrar la salida')
            }
        }
    } catch (error) {
        console.error('Error al extraer datos:', error)
        mensaje.value = `Error: ${error.message || 'No se pudieron extraer los datos'}`
        mensajeEstilo.value = 'bg-red-100 text-red-800'
    } finally {
        cargandoDatos.value = false
    }
}

// ✅ Función para iniciar el escáner CON COOLDOWN usando el composable
const iniciarEscaner = async () => {
    try {
        mensaje.value = 'Inicializando cámara con zoom 200%...'
        mensajeEstilo.value = 'bg-blue-100 text-blue-800'

        if (!codeReader) {
            codeReader = new BrowserQRCodeReader()
        }

        const previewElem = document.getElementById('qr-preview')

        // Configurar las restricciones de la cámara con zoom mejorado
        const constraints = {
            video: {
                width: { ideal: 1920 },
                height: { ideal: 1080 },
                advanced: [
                    {
                        zoom: 3.0  // Zoom del 200%
                    }
                ],
                focusMode: 'continuous'  // Autofocus continuo
            }
        }

        // ✅ Iniciar el escáner con COOLDOWN usando el composable
        await codeReader.decodeFromConstraints(
            constraints,
            previewElem,
            (result, err) => {
                if (result && puedeEjecutar()) { // ✅ Usar método del composable
                    const textoQR = result.getText()

                    try {
                        const url = new URL(textoQR)
                        iframeUrl.value = url.href
                        mensaje.value = 'QR leído correctamente. Extrayendo datos...'
                        mensajeEstilo.value = 'bg-blue-100 text-blue-800'

                        // ✅ Bloquear escaneo usando el composable
                        bloquearEscaneoTemporal(onCooldownStart, onCooldownEnd)

                        // Extraer los datos del estudiante a partir de la URL
                        extraerDatosEstudiante(url.href)

                    } catch {
                        mensaje.value = 'El contenido del QR no es una URL válida: ' + textoQR
                        mensajeEstilo.value = 'bg-yellow-100 text-yellow-800'
                        // ✅ También bloquear en caso de error
                        bloquearEscaneoTemporal(onCooldownStart, onCooldownEnd)
                    }
                } else if (result && !puedeEjecutar()) {
                    // ✅ QR detectado pero en cooldown
                    console.log('QR detectado pero en período de cooldown')
                }

                if (err && !(err instanceof TypeError)) {
                    console.error('Error de escaneo:', err)
                }
            }
        )

        camaraActiva.value = true

        // Intentar aplicar configuraciones adicionales de zoom
        try {
            const stream = previewElem.srcObject
            const videoTrack = stream.getVideoTracks()[0]

            if (videoTrack) {
                const capabilities = videoTrack.getCapabilities()

                if (capabilities.zoom) {
                    const zoomValue = Math.min(capabilities.zoom.max, 2.0)
                    await videoTrack.applyConstraints({
                        advanced: [{ zoom: zoomValue }]
                    })
                    mensaje.value = `Cámara activada con zoom ${Math.round(zoomValue * 100)}%`
                    mensajeEstilo.value = 'bg-green-100 text-green-800'

                    if (controlIntervalId) clearInterval(controlIntervalId)
                    controlIntervalId = setInterval(() => {
                        const actualSettings = videoTrack.getSettings()
                        if (actualSettings.zoom) {
                            mensaje.value = `Cámara activa con zoom ${Math.round(actualSettings.zoom * 100)}%`
                        }
                    }, 5000)
                } else {
                    mensaje.value = 'Cámara activada (zoom digital aplicado visualmente)'
                    mensajeEstilo.value = 'bg-green-100 text-green-800'
                }
            }
        } catch (e) {
            console.warn('No se pudo aplicar configuración avanzada de zoom:', e)
        }
    } catch (error) {
        console.error('Error al inicializar la cámara:', error)
        mensaje.value = `Error: ${error.message || 'No se pudo iniciar la cámara'}`
        mensajeEstilo.value = 'bg-red-100 text-red-800'
        camaraActiva.value = false
    }
}

// Función para detener el escáner
const detenerEscaner = () => {
    if (codeReader) {
        codeReader.reset()
        camaraActiva.value = false
        if (controlIntervalId) {
            clearInterval(controlIntervalId)
            controlIntervalId = null
        }
        mensaje.value = 'Cámara pausada'
        mensajeEstilo.value = 'bg-yellow-100 text-yellow-800'
    }
}

// Función para alternar el estado de la cámara
const toggleCamara = () => {
    if (camaraActiva.value) {
        detenerEscaner()
    } else {
        iniciarEscaner()
    }
}

onMounted(async () => {
    mensaje.value = 'Buscando cámaras disponibles...'
    mensajeEstilo.value = 'bg-blue-100 text-blue-800'

    try {
        const devices = await BrowserQRCodeReader.listVideoInputDevices()
        camaras.value = devices

        if (devices.length === 0) {
            mensaje.value = 'No se encontró ninguna cámara'
            mensajeEstilo.value = 'bg-red-100 text-red-800'
            return
        }

        await iniciarEscaner()
    } catch (error) {
        console.error('Error al enumerar dispositivos:', error)
        mensaje.value = `Error: ${error.message || 'No se pudo enumerar las cámaras'}`
        mensajeEstilo.value = 'bg-red-100 text-red-800'
    }

    // 🔄 Iniciar el auto-flip cada 4 segundos
    autoFlipIntervalId = setInterval(() => {
        toggleFlip()
    }, 4000)
})

onBeforeUnmount(() => {
    detenerEscaner()

    if (autoFlipIntervalId) {
        clearInterval(autoFlipIntervalId)
        autoFlipIntervalId = null
    }

    // ✅ Limpiar timers del composable
    limpiarTimers()
})
</script>