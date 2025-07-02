<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingNavigationDropdown = ref(false);
const theme = ref('theme-kids'); // Tema por defecto

function setTheme(newTheme) {
  theme.value = newTheme;
  document.documentElement.className = newTheme; // Cambia la clase del <html>
}

// Cambia el tema automáticamente según la hora (opcional)
onMounted(() => {
  const hour = new Date().getHours();
  if (hour >= 19 || hour < 7) setTheme('theme-night');
  else setTheme('theme-young');
});

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>

        <Head :title="title" />

        <div class="min-h-screen flex bg-gray-100">
            <!-- Sidebar -->
            <aside class="w-64 bg-[#1f2937] text-white p-4 hidden md:block min-h-screen">
                <div class="mb-6">
                    <Link :href="route('dashboard')">
                    <ApplicationMark class="h-10 w-auto" />
                    </Link>
                </div>

                <nav class="space-y-2 text-sm">
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] from-violet-100/[0.12] to-violet-100/[0.04]"
                        :class="{ 'from-violet-100/[0.24]': route().current('dashboard') }">
                        <Link :href="route('dashboard')"
                            class="flex items-center text-gray-100 transition hover:text-orange-400"
                            :class="{ 'text-orange-400': route().current('dashboard') }">
                        <svg class="shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24">
                            <path d="M3 12l9-9 9 9-1.5 1.5L12 5.5 4.5 13.5z" />
                        </svg>
                        <span class="ml-4">Dashboard</span>
                        </Link>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] from-violet-100/[0.12] to-violet-100/[0.04]"
                        :class="{ 'from-violet-100/[0.24]': route().current('gestion.*') }">
                        <Link href="/gestion" class="flex items-center text-gray-100 transition hover:text-orange-400"
                            :class="{ 'text-orange-400': route().current('gestion.*') }">
                        <svg class="shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24">
                            <path d="M4 4h16v2H4zm0 6h16v2H4zm0 6h16v2H4z" />
                        </svg>
                        <span class="ml-4">Gestiones</span>
                        </Link>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] from-violet-100/[0.12] to-violet-100/[0.04]"
                        :class="{ 'from-violet-100/[0.24]': route().current('usuarios.*') }">
                        <Link href="/usuarios" class="flex items-center text-gray-100 transition hover:text-orange-400"
                            :class="{ 'text-orange-400': route().current('usuarios.*') }">
                        <svg class="shrink-0 fill-current" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z" />
                        </svg>
                        <span class="ml-4">Usuarios</span>
                        </Link>
                    </li>
                </nav>
            </aside>


            <!-- Main content -->
            <div class="flex-1 flex flex-col">
                <!-- Top nav -->
                <nav class="bg-white border-b border-gray-100 px-4 py-2 flex items-center justify-between">
                    <div class="block md:hidden">
                        <button class="text-gray-500" @click="showingNavigationDropdown = !showingNavigationDropdown">
                            ☰
                        </button>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-700">{{ $page.props.auth.user.name }}</span>
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="text-gray-500 hover:text-gray-700">Opciones</button>
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
                <main class="flex-1 p-6">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
