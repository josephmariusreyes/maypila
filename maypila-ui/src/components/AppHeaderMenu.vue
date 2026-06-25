<script setup lang="ts">

//#region > Imports
import {
    Dialog,
    DialogContent,
    DialogTrigger,
} from '@/components/ui/dialog'
import { RouterLink } from 'vue-router'
import Card from './ui/card/Card.vue';
import { ref } from 'vue';
import { useAuthStore } from '@/features/user-accounts/stores/user-accounts.store.ts';
//#endregion

//#region > Component variables
const authStore = useAuthStore();
const isMenuOpen = ref(false);

const appMenu = [
    {
        'name': 'create-queue-session',
        'redirectTo': '/queue-session/create-queue-session',
        'label': 'CREATE ONLINE QUEUE',
        'requiredRoles': ''
    }
];

//#endregion

//#region > Event methods
const handleLogout = () => {
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
                                Jon Consumer
                            </p>
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
                        <li>
                            <RouterLink to="/queue-session/create-queue-session"
                                class="transition-colors hover:text-blue-600" @click="isMenuOpen = false">
                                CREATE ONLINE QUEUE
                            </RouterLink>
                        </li>

                        <li>
                            <RouterLink to="/user-accounts/user-listing" class="transition-colors hover:text-blue-600"
                                @click="isMenuOpen = false">
                                MANAGE USERS
                            </RouterLink>
                        </li>

                        <li>
                            <RouterLink to="/user-accounts/create-users" class="transition-colors hover:text-blue-600"
                                @click="isMenuOpen = false">
                                CREATE USERS
                            </RouterLink>
                        </li>

                        <li>
                            <RouterLink to="/dashboard" class="transition-colors hover:text-blue-600"
                                @click="isMenuOpen = false">
                                DASHBOARD
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