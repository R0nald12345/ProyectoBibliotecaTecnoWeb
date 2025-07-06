<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const page = usePage();
const user = page.props.auth.user;

const showingNavigationDropdown = ref(false);
const currentTheme = ref('theme-light');
const showThemeSelector = ref(false);
const title = 'Biblioteca';

const themes = [
    {
        id: 'theme-light',
        name: 'Claro',
        icon: '☀️',
        description: 'Tema claro y profesional'
    },
    {
        id: 'theme-dark',
        name: 'Oscuro',
        icon: '🌙',
        description: 'Tema oscuro para reducir fatiga visual'
    },
    {
        id: 'theme-kids',
        name: 'Niños',
        icon: '🎨',
        description: 'Tema colorido y divertido para niños'
    }
];

function setTheme(newTheme) {
    currentTheme.value = newTheme;
    // Remover todas las clases de tema anteriores
    document.documentElement.classList.remove('theme-light', 'theme-dark', 'theme-kids');
    // Agregar la nueva clase de tema
    document.documentElement.classList.add(newTheme);
    localStorage.setItem('biblioteca-theme', newTheme);
    showThemeSelector.value = false;
}

onMounted(() => {
    const saved = localStorage.getItem('biblioteca-theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = saved || (prefersDark ? 'theme-dark' : 'theme-light');
    setTheme(theme);
});

const logout = () => {
    router.post(route('logout'));
};

const hasRole = (roleName) => {
    return Array.isArray(user?.roles) && user.roles.some(r => r.name === roleName);
};

const searchQuery = ref('');
const searchResults = ref([]);
const searchActive = ref(false);

// Solo mostrar el buscador si es admin o administrativo
const canSearchSidebar = computed(() => hasRole('admin') || hasRole('administrativo'));

// Filtrar los ítems del sidebar según el texto
function updateSearchResults() {
    if (!searchQuery.value.trim()) {
        searchResults.value = [];
        return;
    }
    // Busca por inicial o coincidencia en el nombre
    searchResults.value = sidebarItems.value.filter(item =>
        item.nombre.toLowerCase().startsWith(searchQuery.value.toLowerCase())
    );
    searchActive.value = searchResults.value.length > 0;
}

// Navegar al hacer click en un resultado
function goToSidebarItem(item) {
    searchQuery.value = '';
    searchResults.value = [];
    searchActive.value = false;
    router.visit(item.ruta);
}

// Los ítems del sidebar (puedes adaptar esto si usas menuItems dinámico)
const sidebarItems = ref([
    { nombre: 'Dashboard', ruta: route('dashboard') },
    { nombre: 'Mi QR', ruta: route('qr.mostrar') },
    { nombre: 'Gestiones', ruta: route('gestion.index') },
    { nombre: 'Usuarios', ruta: route('usuarios.index') },
    { nombre: 'Asistencia E', ruta: route('asistencia.index') },
    { nombre: 'Asistencia S', ruta: route('asistencia.index2') },
    { nombre: 'Roles', ruta: route('roles.index') },
    { nombre: 'Asistencia Entrada', ruta: route('entrada.index') },
    { nombre: 'Asistencia Salida', ruta: route('salida.index') },
]);

</script>

<template>
    <div>

        <Head :title="title" />

        <div class="min-h-screen flex theme-container">
            <!-- Sidebar -->

            <aside class="w-64 sidebar text-white p-6 hidden md:flex flex-col shadow-xl min-h-screen">
                <div class="mb-8 flex items-center gap-2">
                    <Link :href="route('dashboard')">
                    <ApplicationMark class="h-10 w-auto" />
                    </Link>
                    <span class="font-bold text-lg tracking-wide">Biblioteca</span>
                </div>

                <!-- Theme Selector -->
                <div class="mb-6 relative">
                    <button @click="showThemeSelector = !showThemeSelector"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition theme-selector-button">
                        <span class="text-lg">{{themes.find(t => t.id === currentTheme)?.icon}}</span>
                        <div class="flex-1 text-left">
                            <div class="font-medium">{{themes.find(t => t.id === currentTheme)?.name}}</div>
                            <div class="text-xs opacity-75">Cambiar tema</div>
                        </div>
                        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': showThemeSelector }"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <!-- Theme Dropdown -->
                    <div v-if="showThemeSelector"
                        class="absolute top-full left-0 right-0 mt-2 theme-dropdown rounded-lg shadow-lg z-50">
                        <div class="p-2 space-y-1">
                            <button v-for="theme in themes" :key="theme.id" @click="setTheme(theme.id)"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition theme-option"
                                :class="{ 'theme-option-active': currentTheme === theme.id }">
                                <span class="text-lg">{{ theme.icon }}</span>
                                <div class="flex-1 text-left">
                                    <div class="font-medium">{{ theme.name }}</div>
                                    <div class="text-xs opacity-75">{{ theme.description }}</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 space-y-2">
                    <!-- Todos los roles -->
                    <Link :href="route('dashboard')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('dashboard') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l9-9 9 9M4 10v10h16V10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Dashboard
                    </Link>

                    <Link :href="route('qr.mostrar')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('mi-qr') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l9-9 9 9M4 10v10h16V10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Mi QR
                    </Link>

                    <!-- Solo admin y administrativo -->
                    <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('gestion.index')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('gestion.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Gestiones
                    </Link>

                    <!-- Solo admin -->
                    <Link v-if="hasRole('admin')" :href="route('usuarios.index')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('usuarios.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Usuarios
                    </Link>

                    <!-- Solo admin y administrativo -->
                    <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('asistencia.index')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('asistencia.index') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Asistencia E
                    </Link>

                    <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('asistencia.index2')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('asistencia.index2') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Asistencia S
                    </Link>

                    <!-- Solo admin -->
                    <Link v-if="hasRole('admin')" :href="route('roles.index')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('roles.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Roles
                    </Link>

                    <!-- Solo admin y administrativo -->
                    <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('entrada.index')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('entrada.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Asistencia Entrada
                    </Link>

                    <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('salida.index')"
                        class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                        :class="{ 'nav-link-active': route().current('salidas.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Asistencia Salida
                    </Link>
                </nav>

                <div class="mt-auto pt-6 border-t sidebar-footer">
                    <span class="text-xs opacity-75">© 2024 Biblioteca</span>
                </div>
            </aside>

            <!-- Sidebar móvil -->
            <aside
                v-if="showingNavigationDropdown"
                class="fixed inset-0 z-50 bg-black bg-opacity-40 flex md:hidden"
            >
                <div class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-700 text-white p-6 flex flex-col shadow-xl min-h-screen">
                    <div class="mb-8 flex items-center gap-2">
                        <Link :href="route('dashboard')" @click="showingNavigationDropdown = false">
                            <ApplicationMark class="h-10 w-auto" />
                        </Link>
                        <span class="font-bold text-lg tracking-wide">Biblioteca</span>
                    </div>
                    <!-- Puedes copiar aquí el mismo contenido de tu sidebar de escritorio -->
                    <nav class="flex-1 space-y-2">
                        <!-- Todos los roles -->
                        <Link :href="route('dashboard')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('dashboard') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 12l9-9 9 9M4 10v10h16V10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Dashboard
                        </Link>

                        <Link :href="route('qr.mostrar')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('mi-qr') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 12l9-9 9 9M4 10v10h16V10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Mi QR
                        </Link>

                        <!-- Solo admin y administrativo -->
                        <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('gestion.index')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('gestion.*') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Gestiones
                        </Link>

                        <!-- Solo admin -->
                        <Link v-if="hasRole('admin')" :href="route('usuarios.index')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('usuarios.*') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Usuarios
                        </Link>

                        <!-- Solo admin y administrativo -->
                        <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('asistencia.index')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('asistencia.index') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Asistencia E
                        </Link>

                        <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('asistencia.index2')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('asistencia.index2') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Asistencia S
                        </Link>

                        <!-- Solo admin -->
                        <Link v-if="hasRole('admin')" :href="route('roles.index')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('roles.*') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Roles
                        </Link>

                        <!-- Solo admin y administrativo -->
                        <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('entrada.index')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('entrada.*') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Asistencia Entrada
                        </Link>

                        <Link v-if="hasRole('admin') || hasRole('administrativo')" :href="route('salida.index')"
                            class="nav-link flex items-center gap-3 px-4 py-2 rounded-lg transition"
                            :class="{ 'nav-link-active': route().current('salidas.*') }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Asistencia Salida
                        </Link>
                    </nav>
                    <div class="mt-auto pt-6 border-t sidebar-footer">
                        <span class="text-xs opacity-75">© 2024 Biblioteca</span>
                    </div>
                </div>
                <!-- Clic fuera del menú cierra el sidebar -->
                <div class="flex-1" @click="showingNavigationDropdown = false"></div>
            </aside>


            <!-- Main content HEADER -->
            <div class="flex-1 flex flex-col">
                <!-- Top nav -->
                <nav class="top-nav backdrop-blur border-b px-6 py-3 flex items-center justify-between shadow-sm">
                    <div class="block md:hidden">
                        <button class="text-2xl nav-toggle"
                            @click="showingNavigationDropdown = !showingNavigationDropdown">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <!-- Buscador INPUT-->
                    <div class="flex items-center justify-between gap-4 w-full">

                        <div class = "flex justify-center items-center">
                            <span class="text-sm font-medium user-name">{{ $page.props.auth.user.name }}</span>
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center gap-2 px-3 py-1 rounded transition profile-button">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                        Perfil
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.show')">Perfil</DropdownLink>
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">Cerrar sesión</DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>

                        </div>


                        <div v-if="canSearchSidebar" class="relative">
                            <input
                                v-model="searchQuery"
                                @input="updateSearchResults"
                                @focus="updateSearchResults"
                                @blur="() => setTimeout(() => searchActive.value = false, 200)"
                                type="text"
                                placeholder="Buscar menú..."
                                class="px-3 py-1 rounded border border-gray-300 focus:outline-none focus:ring w-40"
                            />
                            <ul v-if="searchActive && searchResults.length" class="absolute left-0 mt-1 w-full bg-white text-black rounded shadow z-50">
                                <li
                                    v-for="item in searchResults"
                                    :key="item.ruta"
                                    @mousedown.prevent="goToSidebarItem(item)"
                                    class="px-3 py-2 hover:bg-indigo-100 cursor-pointer"
                                >
                                    {{ item.nombre }}
                                </li>
                            </ul>
                        </div>

                    </div>


                </nav>

                <!-- Page content -->
                <main class="flex-1 p-8 main-content">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
