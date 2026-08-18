import type { UserAccount } from '@/features/user-accounts/types/user-accounts.types'
import { client, postApiQueueSessions, postApiQueueSessionsAddQueueUsers } from '@/app/api'
import type { addCustomerToQueueRequest } from '@/features/queue-sessions/types/queue-session.types'
import type { createQueueSessionRequest } from '@/features/queue-sessions/types/queue-session.types'

const createStaticUsers = (): UserAccount[] => [
    {
        id: 1,
        firstName: 'Juan',
        lastName: 'Dela Cruz',
        mobileNumber: '0912345678',
        email: 'juan.delacruz@example.com',
        onlineQueueSession: 'Morning Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 2,
        firstName: 'Maria',
        lastName: 'Santos',
        mobileNumber: '0912345679',
        email: 'maria.santos@example.com',
        onlineQueueSession: 'Afternoon Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 3,
        firstName: 'Jose',
        lastName: 'Reyes',
        mobileNumber: '0912345680',
        email: 'jose.reyes@example.com',
        onlineQueueSession: 'Evening Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 4,
        firstName: 'Ana',
        lastName: 'Garcia',
        mobileNumber: '0912345681',
        email: 'ana.garcia@example.com',
        onlineQueueSession: 'Morning Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 5,
        firstName: 'Luis',
        lastName: 'Torres',
        mobileNumber: '0912345682',
        email: 'luis.torres@example.com',
        onlineQueueSession: 'Afternoon Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 6,
        firstName: 'Carla',
        lastName: 'Flores',
        mobileNumber: '0912345683',
        email: 'carla.flores@example.com',
        onlineQueueSession: 'Evening Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 7,
        firstName: 'Miguel',
        lastName: 'Navarro',
        mobileNumber: '0912345684',
        email: 'miguel.navarro@example.com',
        onlineQueueSession: 'Morning Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 8,
        firstName: 'Liza',
        lastName: 'Mendoza',
        mobileNumber: '0912345685',
        email: 'liza.mendoza@example.com',
        onlineQueueSession: 'Afternoon Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 9,
        firstName: 'Paolo',
        lastName: 'Castillo',
        mobileNumber: '0912345686',
        email: 'paolo.castillo@example.com',
        onlineQueueSession: 'Evening Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
    {
        id: 10,
        firstName: 'Nina',
        lastName: 'Aquino',
        mobileNumber: '0912345687',
        email: 'nina.aquino@example.com',
        onlineQueueSession: 'Morning Session',
        password: 'Password123',
        confirmPassword: 'Password123',
        active: true,
    },
]

export const queueSessionService = {

    //Temporary methods for UI
    getUser(id: number): UserAccount | null {
        const users = createStaticUsers()
        return users.find((user) => user.id === id) ?? null
    },

    getAllqueueSessions(): UserAccount[] {
        return createStaticUsers()
    },

    updateUser(user: UserAccount): UserAccount {
        window.alert(`UpdateUser payload: ${JSON.stringify(user, null, 2)}`)
        return user
    },

    deleteUser(id: number): UserAccount | null {
        const users = createStaticUsers()
        const user = users.find((item) => item.id === id)

        if (!user) {
            window.alert(`DeleteUser: user with id ${id} not found.`)
            return null
        }

        const updatedUser = {
            ...user,
            active: false,
        }

        window.alert(`DeleteUser result: ${JSON.stringify(updatedUser, null, 2)}`)
        return updatedUser
    },

    async addCustomerToQueue(request: addCustomerToQueueRequest) {
        return postApiQueueSessionsAddQueueUsers({
            client,
            body: request,
        })
    },

    async createQueueSession(request: createQueueSessionRequest) {
        return postApiQueueSessions({
            client,
            body: request,
        })
    }

}
