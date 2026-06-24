import type { RouteRecordRaw } from 'vue-router'
import appMainLayout from '@/components/layouts/AppMainLayout.vue';
import { UserRole } from '@/features/company/enums/userRoleEnums';
import QueueSessionListingPage from '@/features/queue-sessions/pages/QueueSessionListingPage.vue';
import AddCustomerToQueuePage from '@/features/queue-sessions/pages/AddCustomerToQueuePage.vue';
import CreateQueueSessionPage from '@/features/queue-sessions/pages/CreateQueueSessionPage.vue';
import QueueDetailsPage from '@/features/queue-sessions/pages/QueueDetailsPage.vue';
import CustomerStatusPage from '@/features/queue-sessions/pages/CustomerStatusPage.vue';
import PublicLayout from '@/components/layouts/PublicLayout.vue';
import CustomersInQueueListingPage from '../pages/CustomersInQueueListingPage.vue';

export const queueSessionRoutes: RouteRecordRaw = {
    path: '/queue-session',
    meta: {
        requiresAuth: true,
    },
    children: [
        //Public routes
        {
            path: '',
            redirect: {
                name: 'customer-status'
            }
        },
        {
            path: '',
            component: PublicLayout,
            meta: {
                guestOnly: true
            },
            children: [
                {
                    path: 'customer-status',
                    name: 'customer-status',
                    component: CustomerStatusPage
                }
            ]
        },
        //logged in routes
        {
            path: '',
            component: appMainLayout,
            meta: {
                requiresAuth: true
            },
            children: [
                {
                    path: 'customers-in-que-listing',
                    name: 'customers-in-que-listing',
                    meta: {
                        requiredRoles: [UserRole.QueAdmin],
                    },
                    component: CustomersInQueueListingPage
                },
                {
                    path: 'queue-listing',
                    name: 'queue-listing',
                    meta: {
                        requiredRoles: [UserRole.CompanyAdmin],
                    },
                    component: QueueSessionListingPage
                },
                {
                    path: 'add-customer-to-que',
                    name: 'add-customer-to-que',
                    meta: {
                        requiredRoles: [UserRole.QueEncoder],
                    },
                    component: AddCustomerToQueuePage
                },
                {
                    path: 'queue-details',
                    name: 'queue-details',
                    meta: {
                        requiredRoles: [UserRole.QueAdmin],
                    },
                    component: QueueDetailsPage
                },
                {
                    path: 'create-queue-session',
                    name: 'create-queue-session',
                    meta: {
                        requiredRoles: [UserRole.CompanyAdmin],
                    },
                    component: CreateQueueSessionPage
                }
            ]
        }

    ]

}