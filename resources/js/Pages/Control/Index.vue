<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
import { router } from '@inertiajs/vue3'; // importante para navegación


// Registrar todos los componentes de Chart.js
Chart.register(...registerables);

// Props del backend
const props = defineProps({
    estadisticas: Object,
    filtros: Object
});

// Referencias reactivas para los gráficos
const entradasChart = ref(null);
const entradasChart2 = ref(null);
const salidasChart = ref(null);
const salidasChart2 = ref(null);
const ocupacionChart = ref(null);
const estudiantesChart = ref(null);

const estadisticas = ref(props.estadisticas);


const fechaInicio = ref(props.filtros?.fecha_inicio || null);
const fechaFin = ref(props.filtros?.fecha_fin || null);

const filtrarDatos = () => {
    if (!fechaInicio.value || !fechaFin.value) {
        alert("Debes seleccionar ambas fechas.");
        return;
    }

    router.get(route('dashboard'), {
        fecha_inicio: fechaInicio.value,
        fecha_fin: fechaFin.value
    }, {
        preserveScroll: true,
        preserveState: false
    });

};
// Funciones para crear gráficos usando datos reales
const crearGraficoEntradas = () => {
    const ctx = entradasChart.value.getContext('2d');
    const labels = Object.keys(estadisticas.value.entradasPorHora).map(h => `${h.padStart(2, '0')}:00`);
    const data = Object.values(estadisticas.value.entradasPorHora);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Entradas',
                data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Entradas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};


const crearGraficoEntradas2 = () => {
    const ctx = entradasChart2.value.getContext('2d');
    const labels = Object.keys(estadisticas.value.salidasPorHora).map(h => `${h.padStart(2, '0')}:00`);
    const data = Object.values(estadisticas.value.salidasPorHora);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Salidas',
                data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Salidas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};

const crearGraficoSalidas = () => {
    const ctx = salidasChart.value.getContext('2d');
    const labels = Object.keys(estadisticas.value.salidasPorHora).map(h => `${h.padStart(2, '0')}:00`);
    const data = Object.values(estadisticas.value.salidasPorHora);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Salidas',
                data,
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Salidas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};

const crearGraficoSalidas2 = () => {
    const ctx = salidasChart2.value.getContext('2d');
    const labels = Object.keys(estadisticas.value.entradasPorHora).map(h => `${h.padStart(2, '0')}:00`);
    const data = Object.values(estadisticas.value.entradasPorHora);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Entradas',
                data,
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Entradas'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
};

const crearGraficoOcupacion = () => {
    const ctx = ocupacionChart.value.getContext('2d');
    const ocupados = estadisticas.value.estudiantesActuales;
    const disponibles = estadisticas.value.capacidadMaxima - ocupados;


    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Ocupado', 'Disponible'],
            datasets: [{
                data: [ocupados, disponibles],
                backgroundColor: [
                    ocupados > 0.8 * estadisticas.value.capacidadMaxima ? 'rgb(239, 68, 68)' :
                        ocupados > 0.5 * estadisticas.value.capacidadMaxima ? 'rgb(245, 158, 11)' :
                            'rgb(34, 197, 94)',
                    'rgb(229, 231, 235)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: `Asistencia Hoy (${ocupados} Estudiantes)`
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

};

const crearGraficoUsuariosPorRol = () => {
    const ctx = estudiantesChart.value.getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(estadisticas.value.usuariosPorRol),
            datasets: [{
                data: Object.values(estadisticas.value.usuariosPorRol),
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(147, 51, 234)',
                    'rgb(234, 179, 8)',
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Usuarios por Rol'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
};


onMounted(() => {
    setTimeout(() => {
        crearGraficoEntradas();
        crearGraficoEntradas2();
        crearGraficoSalidas();
        crearGraficoSalidas2();
        crearGraficoOcupacion();
        crearGraficoUsuariosPorRol();
    }, 100);
});
</script>


<template>
    <AppLayout title="Dashboard">

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Encabezado -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Sistema de Control de Acceso - Biblioteca FICCT
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Universidad Autónoma Gabriel René Moreno
                    </p>

                </div>


                <!-- Filtro por fecha -->
                <div class="mb-6 bg-white shadow-lg rounded-lg p-6 flex flex-col sm:flex-row sm:items-end gap-4">
                    <div class="flex-1">
                        <label for="fechaInicio" class="block text-sm font-medium text-gray-700">Fecha inicio</label>
                        <input v-model="fechaInicio" type="date" id="fechaInicio"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    </div>
                    <div class="flex-1">
                        <label for="fechaFin" class="block text-sm font-medium text-gray-700">Fecha fin</label>
                        <input v-model="fechaFin" type="date" id="fechaFin"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    </div>
                    <div>
                        <button @click="filtrarDatos"
                            class="mt-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                            Filtrar
                        </button>
                    </div>
                </div>



                <!-- Tarjetas de estadísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Estudiantes Actuales</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ estadisticas.estudiantesActuales }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Entradas Hoy</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ estadisticas.entradasHoy }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Salidas Hoy</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ estadisticas.salidasHoy }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Capacidad</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ estadisticas.capacidadMaxima }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Gráfico de entradas -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <canvas ref="entradasChart" class="w-full h-64"></canvas>
                    </div>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <canvas ref="entradasChart2" class="w-full h-64"></canvas>
                    </div>

                    <!-- Gráfico de salidas -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <canvas ref="salidasChart2" class="w-full h-64"></canvas>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <canvas ref="salidasChart" class="w-full h-64"></canvas>
                    </div>

                    <!-- Gráfico de ocupación -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <canvas ref="ocupacionChart" class="w-full h-64"></canvas>
                    </div>

                    <!-- Gráfico de estudiantes por carrera -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <canvas ref="estudiantesChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Estilos adicionales si los necesitas */
</style>
