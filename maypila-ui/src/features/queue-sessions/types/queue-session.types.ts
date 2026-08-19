import type {
    PostApiQueueSessionsCrateQueueSessionData
} from '@/app/api'

export type CreateQueueSessionRequest = PostApiQueueSessionsCrateQueueSessionData['body']

export type AddCustomerToQueueFormValues = {
    firstName: string
    lastName: string
    phoneNumber: string
}

export type CreateQueueSessionFormValues = {
    queueSessionName: string
    queueDescription: string
}

export type GetAllQueueSession = {
    companyId: number,
    page: number,
    perPage: number
}