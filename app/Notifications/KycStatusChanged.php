import useSWR from 'swr'
import fetcher from '../../utils/fetcher'
import PageHeader from '../../components/PageHeader'
import Card from '../../components/Card'
import Button from '../../components/Button'
import { useState } from 'react'

interface PendingUser {
  id: number
  uid: string
  email: string
  kyc_document_path: string
  kyc_selfie_path: string
}

export default function AdminKycPage() {
  const { data: users = [], mutate } = useSWR<PendingUser[]>('/admin/kyc/pending', fetcher)
  const [loadingId, setLoadingId] = useState<number|null>(null)

  const update = async (userId: number, status: 'approved'|'rejected') => {
    setLoadingId(userId)
    await fetcher(`/admin/kyc/${userId}/status`, {
      method: 'POST',
      body: JSON.stringify({ status })
    })
    setLoadingId(null)
    mutate()  // refresh list
  }

  return (
    <>
      <PageHeader title="KYC Review" />
      <div className="p-6 space-y-4">
        {users.length === 0 && <p>No pending KYC requests.</p>}
        {users.map(u => (
          <Card key={u.id} className="flex flex-col md:flex-row md:items-center justify-between">
            <div>
              <p><strong>UID:</strong> {u.uid}</p>
              <p><strong>Email:</strong> {u.email}</p>
              <p className="mt-2">
                <a
                  href={u.kyc_document_path}
                  target="_blank" rel="noopener"
                  className="underline"
                >
                  View Document
                </a>{' '}
                |{' '}
                <a
                  href={u.kyc_selfie_path}
                  target="_blank" rel="noopener"
                  className="underline"
                >
                  View Selfie
                </a>
              </p>
            </div>
            <div className="space-x-2 mt-4 md:mt-0">
              <Button
                onClick={()=>update(u.id,'approved')}
                disabled={loadingId===u.id}
              >
                {loadingId===u.id ? '…' : 'Approve'}
              </Button>
              <Button
                variant="outline"
                onClick={()=>update(u.id,'rejected')}
                disabled={loadingId===u.id}
              >
                {loadingId===u.id ? '…' : 'Reject'}
              </Button>
            </div>
          </Card>
        ))}
      </div>
    </>
  )
}
