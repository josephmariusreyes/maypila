import type { PostApiQueueSessionsData } from '@/app/api'

export type addCustomerToQueueRequest = {
    userId: number
    queueSessionId: number
    companyId: number
}

export type createQueueSessionRequest = PostApiQueueSessionsData['body']

export type AddCustomerToQueueFormValues = {
    firstName: string
    lastName: string
    phoneNumber: string
}

export type CreateQueueSessionFormValues = {
    queueSessionName: string
    queueDescription: string
}
