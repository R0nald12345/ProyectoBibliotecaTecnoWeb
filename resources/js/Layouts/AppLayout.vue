<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const showingNavigationDropdown = ref(false);

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
