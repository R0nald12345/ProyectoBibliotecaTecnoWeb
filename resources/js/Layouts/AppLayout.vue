<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingNavigationDropdown = ref(false);
const theme = ref('theme-kids');

function setTheme(newTheme) {
    theme.value = newTheme;
    document.documentElement.className = newTheme;
}

onMounted(() => {
    const hour = new Date().getHours();
    if (hour >= 19 || hour < 7) setTheme('theme-night');
    else setTheme('theme-young');
});

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <div class="min-h-screen flex bg-gradient-to-br from-indigo-100 via-white to-orange-100">
            <!-- Sidebar -->
            <aside
                class="w-64 bg-gradient-to-b from-indigo-900 to-indigo-700 text-white p-6 hidden md:flex flex-col shadow-xl min-h-screen">
                <div class="mb-8 flex items-center gap-2">
                    <Link :href="route('dashboard')">
                    <ApplicationMark class="h-10 w-auto" />
                    </Link>
                    <span class="font-bold text-lg tracking-wide">Biblioteca</span>
                </div>
                <nav class="flex-1 space-y-2">
                    <Link :href="route('dashboard')"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition hover:bg-indigo-800"
                        :class="{ 'bg-indigo-800 font-semibold': route().current('dashboard') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l9-9 9 9M4 10v10h16V10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Dashboard
                    </Link>
                    <Link :href="route('gestion.index')"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition hover:bg-indigo-800"
                        :class="{ 'bg-indigo-800 font-semibold': route().current('gestion.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Gestiones
                    </Link>

                    <Link :href="route('usuarios.index')"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition hover:bg-indigo-800"
                        :class="{ 'bg-indigo-800 font-semibold': route().current('usuarios.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Usuarios
                    </Link>
                    <Link :href="route('roles.index')"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition hover:bg-indigo-800"
                        :class="{ 'bg-indigo-800 font-semibold': route().current('usuarios.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Roles
                    </Link>
                    <Link :href="route('asistencia.index')"
                        class="flex items-center gap-3 px-4 py-2 rounded-lg transition hover:bg-indigo-800"
                        :class="{ 'bg-indigo-800 font-semibold': route().current('usuarios.*') }">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Asistencia
                    </Link>


                </nav>
                <div class="mt-auto pt-6 border-t border-indigo-800">
                    <span class="text-xs text-indigo-200">© 2024 Biblioteca</span>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 flex flex-col">
                <!-- Top nav -->
                <nav
                    class="bg-white/80 backdrop-blur border-b border-gray-200 px-6 py-3 flex items-center justify-between shadow-sm">
                    <div class="block md:hidden">
                        <button class="text-indigo-700 text-2xl"
                            @click="showingNavigationDropdown = !showingNavigationDropdown">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sx text-gray-700 font-medium">{{ $page.props.auth.user.name }}</span>
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex items-center gap-2 px-3 py-1 rounded hover:bg-indigo-100 transition text-indigo-700">
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
                </nav>

                <!-- Page content -->
                <main class="flex-1 p-8 bg-white/70">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
