<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';

// Registrar todos los componentes de Chart.js
Chart.register(...registerables);

// Referencias reactivas para los gráficos
const entradasChart = ref(null);
const salidasChart = ref(null);
const ocupacionChart = ref(null);
const estudiantesChart = ref(null);

// Datos simulados para el dashboard
const estadisticas = ref({
    estudiantesActuales: 45,
    entradasHoy: 127,
    salidasHoy: 89,
    capacidadMaxima: 150,
    estudiantesPorCarrera: {
        'Ing. Sistemas': 25,
        'Ing. Telecomunicaciones': 15,
        'Ing. Informática': 5
    }
});

// Función para crear gráfico de entradas por hora
const crearGraficoEntradas = () => {
    const ctx = entradasChart.value.getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'],
            datasets: [{
                label: 'Entradas por hora',
                data: [8, 15, 22, 18, 25, 12, 20, 16, 10, 5],
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
                    text: 'Entradas por Hora - Hoy'
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

// Función para crear gráfico de salidas por hora
const crearGraficoSalidas = () => {
    const ctx = salidasChart.value.getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'],
            datasets: [{
                label: 'Salidas por hora',
                data: [2, 8, 12, 15, 20, 8, 15, 12, 8, 9],
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
                    text: 'Salidas por Hora - Hoy'
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

// Función para crear gráfico de ocupación
const crearGraficoOcupacion = () => {
    const ctx = ocupacionChart.value.getContext('2d');
    const ocupacion = (estadisticas.value.estudiantesActuales / estadisticas.value.capacidadMaxima) * 100;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Ocupado', 'Disponible'],
            datasets: [{
                data: [ocupacion, 100 - ocupacion],
                backgroundColor: [
                    ocupacion > 80 ? 'rgb(239, 68, 68)' : ocupacion > 50 ? 'rgb(245, 158, 11)' : 'rgb(34, 197, 94)',
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
                    text: 'Ocupación Actual de la Biblioteca'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
};

// Función para crear gráfico de estudiantes por carrera
const crearGraficoEstudiantes = () => {
    const ctx = estudiantesChart.value.getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(estadisticas.value.estudiantesPorCarrera),
            datasets: [{
                data: Object.values(estadisticas.value.estudiantesPorCarrera),
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Estudiantes por Carrera - Actualmente'
                },
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
};

// Montar los gráficos cuando el componente se monta
onMounted(() => {
    setTimeout(() => {
        crearGraficoEntradas();
        crearGraficoSalidas();
        crearGraficoOcupacion();
        crearGraficoEstudiantes();
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

                <!-- Tarjetas de estadísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Estudiantes Actuales</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ estadisticas.estudiantesActuales }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
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
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
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
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
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

                    <!-- Gráfico de salidas -->
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