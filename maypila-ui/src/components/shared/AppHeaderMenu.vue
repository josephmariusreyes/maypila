<script setup lang="ts">

//#region > Imports
import {
    Dialog,
    DialogContent,
    DialogTrigger,
} from '@/components/ui/dialog'
import { RouterLink, useRoute } from 'vue-router'
import { computed, ref } from 'vue';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store.ts';
import { UserRole } from '@/features/company/enums/userRoleEnums.ts';
import { UserAccountsService } from '@/features/user-accounts/services/user-accounts.service.ts';
import Card from '../ui/card/Card.vue';
//#endregion

//#region > Component variables
const authStore = useAuthStore();
const route = useRoute();
let isMenuOpen = ref(false);

const user = authStore.user;
const roles = authStore.roles;

const appMenu = [
    //queue session feature
    {
        'name': 'create-queue-session',
        'redirectTo': '/queue-session/create-queue-session',
        'label': 'CREATE ONLINE QUEUE',
        'requiredRoles': [UserRole.CompanyAdmin]
    },
    {
        'name': 'queue-listing',
        'redirectTo': '/queue-session/queue-listing',
        'label': 'QUEUE LISTING',
        'requiredRoles': [UserRole.CompanyAdmin]
    },
    {
        'name': 'customers-in-que-listing',
        'redirectTo': '/queue-session/customers-in-que-listing',
        'label': 'CUSTOMERS IN QUEUE',
        'requiredRoles': [UserRole.QueAdmin, UserRole.CompanyAdmin]
    },
    //user accounts feature
    {
        'name': 'user-listing',
        'redirectTo': '/user-accounts/user-listing',
        'label': 'USERS ACCOUNTS',
        'requiredRoles': [UserRole.CompanyAdmin]
    },
    {
        'name': 'create-users',
        'redirectTo': '/user-accounts/create-users',
        'label': 'CREATE USERS',
        'requiredRoles': [UserRole.CompanyAdmin]
    },
    //company features
    {
        'name': 'create-company',
        'redirectTo': '/company/create-company',
        'label': 'CREATE COMPANY',
        'requiredRoles': [UserRole.SuperAdmin]
    },
    //dashboard features
    {
        'name': 'dashboard',
        'redirectTo': '/dashboard',
        'label': 'COMPANY ADMIN',
        'requiredRoles': [UserRole.CompanyAdmin]
    }

];

const visibleAppMenu = computed(() => {
    return appMenu.filter((menuItem) => authStore.hasAnyRole(menuItem.requiredRoles));
});

const isActiveMenuItem = (menuItemName: string) => {
    return route.name === menuItemName;
};

//#endregion

//#region > Event methods
const handleLogout = () => {
    isMenuOpen.value = false;
    UserAccountsService.logout();
}
//#endregion

</script>

<template>
    <Dialog v-model:open="isMenuOpen">
        <form>
            <!-- Fixed container -->
            <div class="fixed top-4 right-4 z-50 flex items-center gap-2">
                <!-- User Card -->
                <Card class="px-4 py-2 shadow-md">
                    <div class="flex items-center gap-2 cursor-pointer">
                        <!-- Display Photo -->
                        <div class="h-8 w-8 rounded-full bg-gray-300"></div>

                        <!-- User Name -->
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ user?.name }}
                            </p>
                            <div class="text-xs">
                                Role:
                                <span v-for="role in roles" :key="role">
                                    {{ role }}
                                    <span v-if="roles.length > 1">,</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </Card>

                <!-- Hamburger Menu -->
                <DialogTrigger as-child>
                    <button type="button"
                        class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-lg bg-white shadow-md transition hover:bg-gray-100">
                        <div class="flex flex-col gap-1">
                            <span class="h-1 w-7 rounded-full main-theme-color-bg"></span>
                            <span class="h-1 w-7 rounded-full main-theme-color-bg"></span>
                            <span class="h-1 w-7 rounded-full main-theme-color-bg"></span>
                        </div>
                    </button>
                </DialogTrigger>
            </div>

            <DialogContent class="sm:max-w-sm">
                <nav>
                    <ul class="flex flex-col items-center gap-6 py-6 text-center text-lg font-medium">
                        <li v-for="menuItem in visibleAppMenu" :key="menuItem.name">
                            <RouterLink :to="menuItem.redirectTo" class="transition-colors hover:text-blue-600"
                                :class="{ 'font-bold text-blue-600': isActiveMenuItem(menuItem.name) }"
                                @click="isMenuOpen = false">
                                {{ menuItem.label }}
                            </RouterLink>
                        </li>

                        <li>
                            <button type="button" class="transition-colors hover:text-red-600 cursor-pointer"
                                @click="handleLogout">
                                LOGOUT
                            </button>
                        </li>
                    </ul>
                </nav>
            </DialogContent>
        </form>
    </Dialog>
</template>
