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

    <div class="min-h-screen flex" :style="{ backgroundColor: 'var(--color-bg)', color: 'var(--color-text)', fontSize: 'var(--font-size)' }">
      <!-- Sidebar -->
      <aside class="w-64 bg-white shadow-md p-4 hidden md:block">
        <div class="mb-6">
          <Link :href="route('dashboard')">
            <ApplicationMark class="h-10 w-auto" />
          </Link>
        </div>
        <nav class="space-y-2">
          <Link href="/dashboard" class="block px-4 py-2 rounded hover:bg-gray-200" :class="{ 'bg-gray-200 font-bold': route().current('dashboard') }">Dashboard</Link>
          <Link href="/gestion" class="block px-4 py-2 rounded hover:bg-gray-200" :class="{ 'bg-gray-200 font-bold': route().current('gestion.*') }">Gestiones</Link>
          <Link href="/usuarios" class="block px-4 py-2 rounded hover:bg-gray-200" :class="{ 'bg-gray-200 font-bold': route().current('usuarios.*') }">Usuarios</Link>
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
            <select v-model="theme" @change="setTheme(theme)" class="border rounded px-2 py-1 text-sm mr-4">
              <option value="theme-kids">Niños</option>
              <option value="theme-young">Jóvenes</option>
              <option value="theme-adult">Adultos</option>
              <option value="theme-night">Noche</option>
            </select>
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
