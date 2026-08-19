import type { UserAccount } from '@/features/user-accounts/types/user-accounts.types'
import { client, getApiQueueSessionsGetAllQueueSessions } from '@/app/api'
import type { GetAllQueueSession } from '@/features/queue-sessions/types/queue-session.types';

export const queueSessionService = {

    //Temporary methods for UI
    getUser(id: number): null {
        return null;
    },

    async getAllqueueSessions(request: GetAllQueueSession) {
        const result = await getApiQueueSessionsGetAllQueueSessions({
            client,
            query: {
                companyId: request.companyId,
                page: request.page,
                perPage: request.perPage
            }
        })

        return result.data?.data ?? [];
    },

    updateUser(user: UserAccount): UserAccount {
        window.alert(`UpdateUser payload: ${JSON.stringify(user, null, 2)}`)
        return user
    },

    deleteUser(id: number): null {
        // const users = createStaticUsers()
        // const user = users.find((item) => item.id === id)

        // if (!user) {
        //     window.alert(`DeleteUser: user with id ${id} not found.`)
        //     return null
        // }

        // const updatedUser = {
        //     ...user,
        //     active: false,
        // }

        // window.alert(`DeleteUser result: ${JSON.stringify(updatedUser, null, 2)}`)
        // return updatedUser
        return null;
    },



}
