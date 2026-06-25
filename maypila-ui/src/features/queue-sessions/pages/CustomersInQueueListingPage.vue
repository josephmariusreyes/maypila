<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import { Button } from '@/components/ui/button'
import { ref } from 'vue';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

const queueStatuses = ['InProgress', 'Pending', 'Done'] as const
const selectedStatus = ref<(typeof queueStatuses)[number]>('InProgress')


const testCustomers = [
    {
        queueNumber: 1,
        fullName: 'Maria Santos',
        arrivalTime: '9:00am, June 1 2026',
        contactNumber: '0967-546-2345',
    },
    {
        queueNumber: 2,
        fullName: 'Juan Dela Cruz',
        arrivalTime: '9:15am, June 1 2026',
        contactNumber: '0918-234-6789',
    },
    {
        queueNumber: 3,
        fullName: 'Ana Reyes',
        arrivalTime: '9:30am, June 1 2026',
        contactNumber: '0927-345-7890',
    },
    {
        queueNumber: 4,
        fullName: 'Carlo Mendoza',
        arrivalTime: '9:45am, June 1 2026',
        contactNumber: '0956-456-8901',
    },
    {
        queueNumber: 5,
        fullName: 'Liza Garcia',
        arrivalTime: '10:00am, June 1 2026',
        contactNumber: '0935-567-9012',
    },
]

const acceptCustomer = (fullName: string) => {
    alert(`Accepted ${fullName}`)
}

const cancelCustomer = (fullName: string) => {
    alert(`Cancelled ${fullName}`)
}


</script>

<template>
    <section class="flex w-full max-w-md items-center justify-center">
        <div class="w-full space-y-4">
            <Card class="p-6 text-center">
                <h2 class="mb-1 font-heading text-3xl font-semibold tracking-tight text-slate-950">
                    Customers in Queue
                </h2>
                <div class="mt-4 flex justify-start">
                    <Select v-model="selectedStatus">
                        <SelectTrigger class="w-full max-w-[200px]">
                            <SelectValue placeholder="Select status" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="status in queueStatuses" :key="status" :value="status">
                                {{ status }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <Card v-for="customer in testCustomers" :key="customer.queueNumber" class="p-4 mt-6">
                    <div class="space-y-4">
                        <div class="flex justify-end">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 text-sm font-semibold text-white">
                                {{ customer.queueNumber }}
                            </div>
                        </div>

                        <div class="grid gap-2 text-left text-sm leading-6 text-slate-700 ">
                            <p>
                                <span class="font-medium text-slate-950">Arrival time:</span>
                                {{ customer.arrivalTime }}
                            </p>

                            <p>
                                <span class="font-medium text-slate-950">Full name:</span>
                                {{ customer.fullName }}
                            </p>

                            <p>
                                <span class="font-medium text-slate-950">Contact #:</span>
                                {{ customer.contactNumber }}
                            </p>
                        </div>

                        <div class="flex justify-end gap-2">
                            <Button size="sm" class="bg-green-600 text-white hover:bg-green-700"
                                @click="acceptCustomer(customer.fullName)">
                                Accept
                            </Button>

                            <Button size="sm" class="bg-red-600 text-white hover:bg-red-700"
                                @click="cancelCustomer(customer.fullName)">
                                Cancel
                            </Button>
                        </div>
                    </div>
                </Card>
                <div class="flex justify-end mt-6">
                    <div class="flex items-center gap-2">
                        <Button variant="outline" size="sm">
                            Previous
                        </Button>

                        <Button size="sm" class="main-theme-color">
                            1
                        </Button>

                        <Button variant="outline" size="sm">
                            2
                        </Button>

                        <Button variant="outline" size="sm">
                            3
                        </Button>

                        <Button variant="outline" size="sm">
                            Next
                        </Button>
                    </div>
                </div>
            </Card>
        </div>
    </section>
</template>
