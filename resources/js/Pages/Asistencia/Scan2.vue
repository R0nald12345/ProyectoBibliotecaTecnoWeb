<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-6">
    <!-- Header Profesional -->
    <div class="text-center mb-8">
      <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-800 to-red-600 bg-clip-text text-transparent mb-2">
        Sistema de Identificación Universitaria
      </h1>
      <p class="text-gray-600 text-lg font-medium">Escáner de Código QR - Carnet Digital UAGRM</p>
      <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-red-600 mx-auto mt-3 rounded-full"></div>
    </div>

    <!-- Mensajes de Estado -->
    <div v-if="mensaje" class="mb-6 max-w-md mx-auto">
      <div class="p-4 rounded-lg shadow-lg border-l-4" :class="mensajeEstilo">
        <div class="flex items-center">
          <svg v-if="mensaje.includes('Error')" class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          <svg v-else class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
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
          <button
            @click="toggleCamara"
            class="px-8 py-3 rounded-xl font-semibold text-white shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
            :class="camaraActiva ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-blue-500 to-blue-600'"
          >
            <span class="flex items-center justify-center">
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path v-if="!camaraActiva" fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2h-1.586l-.707-.707A1 1 0 0013 2H7a1 1 0 00-.707.293L5.586 3H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                <path v-else fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v3.586l1.293-1.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8 10.586V7z" clip-rule="evenodd"/>
              </svg>
              {{ camaraActiva ? 'Pausar Cámara' : 'Activar Cámara' }}
            </span>
          </button>
        </div>

        <!-- Vista del Escáner -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Vista del Escáner</h3>
          <div class="relative mx-auto bg-gray-900 rounded-xl overflow-hidden" style="width: 500px; height: 400px;">
            <video
              id="qr-preview"
              class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-xl"
              style="min-width: 100%; min-height: 100%; object-fit: cover;"
              autoplay
              muted
            ></video>
            <!-- Marco de Enfoque -->
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
              <div class="relative w-48 h-48">
                <!-- Esquinas del marco -->
                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-green-400 rounded-tl-lg"></div>
                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-green-400 rounded-tr-lg"></div>
                <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-green-400 rounded-bl-lg"></div>
                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-green-400 rounded-br-lg"></div>
                <!-- Línea de escaneo animada -->
                <div class="absolute inset-x-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-green-400 to-transparent animate-pulse"></div>
              </div>
            </div>
            <!-- Indicador de estado -->
            <div class="absolute top-4 right-4 flex items-center space-x-2 bg-black bg-opacity-50 rounded-full px-3 py-1">
              <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
              <span class="text-white text-sm font-medium">{{ camaraActiva ? 'Escaneando...' : 'Inactivo' }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Panel del Carnet -->
      <div v-if="estudianteData" class="flex justify-center items-center">
        <div class="bg-white rounded-2xl shadow-xl p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Carnet Universitario Digital</h3>

          <div
            class="relative w-96 h-64 transition-all duration-700 ease-in-out cursor-pointer"
            :style="{
              transformStyle: 'preserve-3d',
              transform: flipped ? 'rotateY(180deg)' : 'rotateY(0deg)'
            }"
            @click="toggleFlip"
          >
            <!-- Frente de la tarjeta -->
            <div
              class="absolute inset-0 professional-card rounded-xl overflow-hidden card-shadow"
              :style="{ backfaceVisibility: 'hidden' }"
            >
              <div class="flex h-full">
                <!-- Sección Izquierda -->
                <div class="flex flex-col items-center justify-between bg-gradient-to-b from-blue-50 to-blue-100 w-[40%] p-4">
                  <!-- Logo y Título -->
                  <div class="text-center">
                    <div class="text-blue-800 font-black text-center">
                      <div class="text-2xl tracking-tight">CARNET</div>
                      <div class="text-xs tracking-widest font-bold">UNIVERSITARIO</div>
                    </div>
                    <div class="mt-1 text-xs text-blue-600 font-semibold">UAGRM</div>
                  </div>

                  <!-- Foto del Estudiante -->
                  <div class="photo-frame flex items-center justify-center" style="width: 35mm; height: 35mm;">
                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center rounded">
                      <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                      </svg>
                    </div>
                  </div>

                  <!-- Código QR pequeño -->
                  <div class="w-12 h-12 bg-gray-200 border border-gray-300 rounded flex items-center justify-center">
                    <div class="w-8 h-8 bg-black opacity-20"></div>
                  </div>
                </div>

                <!-- Sección Derecha -->
                <div class="relative w-[60%] p-4 bg-white">
                  <!-- Header de Facultad -->
                  <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1 text-[0.5rem] font-bold text-center clip-path-trapezoid absolute right-0 top-0 shadow-md">
                    {{ estudianteData.FACULTAD }}
                  </div>

                  <!-- Información del Estudiante -->
                  <div class="mt-8 space-y-3 text-xs">
                    <div class="border-l-3 border-blue-600 pl-2">
                      <span class="text-red-600 font-bold block text-xs">ESTUDIANTE:</span>
                      <div class="font-bold text-blue-800 text-sm leading-tight">{{ estudianteData.ESTUDIANTE }}</div>
                    </div>

                    <div class="border-l-3 border-blue-600 pl-2">
                      <span class="text-red-600 font-bold block text-xs">CARRERA:</span>
                      <div class="font-semibold text-blue-800 text-xs leading-tight">{{ estudianteData.CARRERA }}</div>
                    </div>

                    <div class="flex space-x-4">
                      <div class="border-l-3 border-blue-600 pl-2 flex-1">
                        <span class="text-red-600 font-bold block text-xs">REGISTRO:</span>
                        <div class="font-bold text-blue-800">{{ estudianteData.REGISTRO }}</div>
                      </div>

                      <div class="border-l-3 border-blue-600 pl-2 flex-1">
                        <span class="text-red-600 font-bold block text-xs">C.I.:</span>
                        <div class="font-bold text-blue-800">{{ estudianteData['DOCUMENTO DE IDENTIDAD'] }}</div>
                      </div>
                    </div>
                  </div>

                  <!-- Logos y Elementos Decorativos -->
                  <div class="absolute bottom-3 right-3 flex items-center space-x-2">
                    <img class="h-8 w-8 rounded-full shadow-sm" src="https://scontent-lim1-1.xx.fbcdn.net/v/t39.30808-6/254492065_4876233149083206_1107629317053811200_n.jpg?nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_ohc=KpJMXcNRa8QQ7kNvwGp8QzO&_nc_oc=Adnqlykj79OX8pxkiNcyv1uFZBvU995Ocybax2XXrGKr-fI4MSUFgXWu9Qmy5pOFl8&_nc_zt=23&_nc_ht=scontent-lim1-1.xx&_nc_gid=lVQAFLn9WCNtx4Y8nqgzNQ&oh=00_AfMskGLqAQgKMEMYjKXt5wszEXVnxdM_0jpVLEHo9c1lkg&oe=684BC23D" alt="UAGRM" />
                    <div class="w-8 h-8 bg-gradient-to-brflex items-center justify-center shadow-sm">
                      <img src="https://www.ficct.uagrm.edu.bo:3000/uploads/faculty/Escudo_FICCT.png" alt="FICCT" class="w-7 h-9" />
                    </div>
                  </div>

                  <!-- Elementos decorativos de fondo -->
                  <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-5">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-600 rounded-full"></div>
                    <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-red-600 rounded-full"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Reverso de la tarjeta -->
            <div
              class="absolute inset-0 professional-card rounded-xl overflow-hidden card-shadow flex"
              :style="{ backfaceVisibility: 'hidden', transform: 'rotateY(180deg)' }"
            >
              <!-- Sección Izquierda del Reverso -->
              <div class="flex flex-col items-center justify-center bg-gradient-to-b from-blue-50 to-blue-100 w-[40%] p-4">
                <!-- Código de Barras -->
                <div class="bg-black w-24 h-16 rounded mb-4 flex items-center justify-center">
                  <div class="text-white text-xs font-mono">||||||||||</div>
                </div>

                <!-- Información de Validez -->
                <div class="text-center text-xs text-blue-800">
                  <div class="font-bold">VÁLIDO HASTA</div>
                  <div class="font-bold text-sm">2025</div>
                </div>
              </div>

              <!-- Sección Derecha del Reverso -->
              <div class="relative w-[60%] p-4 bg-white">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-7 py-1 text-[0.8rem] font-bold text-center clip-path-trapezoid absolute right-0 top-0 shadow-md">
                  INFORMACIÓN ACADÉMICA
                </div>

                <!-- Información Detallada -->
                <div class="mt-10 space-y-4 text-xs">
                  <div class="flex items-start space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div class="flex-1">
                      <span class="text-red-600 font-bold block">REGISTRO ACADÉMICO:</span>
                      <div class="font-bold text-blue-800">{{ estudianteData.REGISTRO }}</div>
                    </div>
                  </div>

                  <div class="flex items-start space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div class="flex-1">
                      <span class="text-red-600 font-bold block">FACULTAD:</span>
                      <div class="font-semibold text-blue-800 text-[0.5rem] leading-tight">{{ estudianteData.FACULTAD }}</div>
                    </div>
                  </div>

                  <div class="flex items-start space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                    <div class="flex-1">
                      <span class="text-red-600 font-bold block">PROGRAMA:</span>
                      <div class="font-semibold text-blue-800 text-xs leading-tight">{{ estudianteData.CARRERA }}</div>
                    </div>
                  </div>
                </div>

                <!-- Footer del reverso -->
                <div class="absolute bottom-3 left-4 right-4">
                  <div class="text-center text-xs text-gray-600 border-t pt-2">
                    <div class="font-bold">Universidad Autónoma Gabriel René Moreno</div>
                    <div>Santa Cruz - Bolivia</div>
                  </div>
                </div>

                <!-- Elementos decorativos del reverso -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-5">
                  <div class="absolute -top-10 -left-10 w-32 h-32 bg-red-600 rounded-full"></div>
                  <div class="absolute -bottom-10 -right-10 w-24 h-24 bg-blue-600 rounded-full"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Instrucción para voltear -->
          <p class="text-center text-sm text-gray-500 mt-4 font-medium">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 9H17a1 1 0 110 2h-5.586l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
            </svg>
            Haz clic para voltear el carnet
          </p>
        </div>
      </div>
    </div>

    <!-- Modal de Carga -->
    <div v-if="cargandoDatos" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 backdrop-blur-sm">
      <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full mx-4">
        <div class="text-center">
          <div class="w-16 h-16 mx-auto mb-4">
            <svg class="w-16 h-16 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-800 mb-2">Procesando datos</h3>
          <p class="text-gray-600">Extrayendo información del estudiante...</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { BrowserQRCodeReader } from '@zxing/browser'
import { router } from '@inertiajs/vue3';
const iframeUrl = ref(null)
const mensaje = ref(null)
const mensajeEstilo = ref('bg-blue-100 text-blue-800')
const camaraActiva = ref(false)
const camaras = ref([])
const flipped = ref(false)
const estudianteData = ref(null)
const cargandoDatos = ref(false)

let codeReader = null
let controlIntervalId = null

// Función para alternar la animación flip de la tarjeta
const toggleFlip = () => {
  flipped.value = !flipped.value
}


// Función para extraer los datos del estudiante desde la URL

const extraerDatosEstudiante = async (url) => {
  try {
    cargandoDatos.value = true;

    const response = await fetch(`/inf513/grupo10sa/proyecto2.1/ProyectoBibliotecaTecnoWeb/public/scrap-estudiante?url=${url}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      }
    });

    if (!response.ok) {
      throw new Error('Error al hacer scraping en el servidor');
    }

    const data = await response.json();
    estudianteData.value = data;

    const esValido = data && Object.keys(data).length > 0 && !data.error;

    estudianteData.value = esValido ? data : {};

    if (!esValido) {
      mensaje.value = 'Documento no válido';
      mensajeEstilo.value = 'bg-red-100 text-red-800';
      return; // Salir temprano si no es válido
    }

    console.log(data);

    // Registrar entrada automáticamente
    const entradaData = {
      descripcion: 'Estudiante aceptado',
      fecha: new Date().toISOString().split('T')[0],
      hora: new Date().toTimeString().split(' ')[0],
      user_id: parseInt(data.REGISTRO),
      tipoalerta_id: 1,
    };

   axios.post(route('salida.store'), entradaData)
            .then(res => {
                mensaje.value = res.data.message;
                mensajeEstilo.value = 'bg-green-100 text-green-800';
            })
            .catch(err => {
                mensaje.value = err.response?.data?.message || 'Error al registrar entrada';
                mensajeEstilo.value = 'bg-red-100 text-red-800';
            })
            .finally(() => {
                cargandoDatos.value = false;
            });


  } catch (error) {
    console.error('Error al extraer datos:', error);
    mensaje.value = `Error: ${error.message || 'No se pudieron extraer los datos'}`;
    mensajeEstilo.value = 'bg-red-100 text-red-800';
  } finally {
    cargandoDatos.value = false;
  }
};


// Función para iniciar el escáner
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
            zoom: 2.0  // Zoom del 200%
          }
        ],
        focusMode: 'continuous'  // Autofocus continuo
      }
    }

    // Iniciar el escáner con las restricciones definidas
    await codeReader.decodeFromConstraints(
      constraints,
      previewElem,
      (result, err) => {
        if (result) {
          const textoQR = result.getText()

          try {
            const url = new URL(textoQR)
            iframeUrl.value = url.href
            mensaje.value = 'QR leído correctamente. Extrayendo datos...'
            mensajeEstilo.value = 'bg-blue-100 text-blue-800'

            // Extraer los datos del estudiante a partir de la URL
            extraerDatosEstudiante(url.href)

          } catch {
            mensaje.value = 'El contenido del QR no es una URL válida: ' + textoQR
            mensajeEstilo.value = 'bg-yellow-100 text-yellow-800'
          }
        }

        if (err && !(err instanceof TypeError)) {
          // Ignoramos TypeError que puede ocurrir durante operaciones normales
          console.error('Error de escaneo:', err)
        }
      }
    )

    camaraActiva.value = true

    // Intentar aplicar configuraciones adicionales de zoom usando MediaStream Track API
    try {
      const stream = previewElem.srcObject
      const videoTrack = stream.getVideoTracks()[0]

      if (videoTrack) {
        const capabilities = videoTrack.getCapabilities()

        // Si la cámara soporta zoom, intentamos aplicarlo mediante la API de MediaStreamTrack
        if (capabilities.zoom) {
          const zoomValue = Math.min(capabilities.zoom.max, 2.0) // Intentamos un zoom de 2.0 (200%)
          await videoTrack.applyConstraints({
            advanced: [{ zoom: zoomValue }]
          })
          mensaje.value = `Cámara activada con zoom ${Math.round(zoomValue * 100)}%`
          mensajeEstilo.value = 'bg-green-100 text-green-800'

          // Iniciamos un intervalo para reportar el zoom actual
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

  // 🔄 Iniciar el auto-flip cada 3 segundos
  autoFlipIntervalId = setInterval(() => {
    toggleFlip()
  }, 3000)
})

onBeforeUnmount(() => {
  detenerEscaner()

  if (autoFlipIntervalId) {
    clearInterval(autoFlipIntervalId)
    autoFlipIntervalId = null
  }
})
</script>
