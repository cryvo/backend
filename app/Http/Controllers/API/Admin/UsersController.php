import useSWR from 'swr'
import fetcher from '../../utils/fetcher'
import PageHeader from '../../components/PageHeader'
import Card from '../../components/Card'
import Button from '../../components/Button'

interface User {
  id: number
  uid: string
  name: string
  email: string
  is_active: boolean
  kyc_status: string
}

export default function AdminUsersPage() {
  const { data: users = [], error, mutate } = useSWR<User[]>('/admin/users', fetcher)

  const toggleActive = async (u: User) => {
    await fetcher(`/admin/users/${u.id}`, {
      method: 'PUT',
      body: JSON.stringify({ is_active: !u.is_active }),
    })
    mutate()
  }

  const deleteUser = async (u: User) => {
    if (!confirm(`Delete user ${u.email}?`)) return
    await fetcher(`/admin/users/${u.id}`, { method: 'DELETE' })
    mutate()
  }

  if (error) return <p className="p-6 text-red-600">Failed to load users.</p>

  return (
    <>
      <PageHeader title="User Management" />
      <div className="p-6 space-y-4">
        {users.map(u => (
          <Card
            key={u.id}
            className="flex flex-col md:flex-row md:items-center md:justify-between"
          >
            <div>
              <p><strong>UID:</strong> {u.uid}</p>
              <p><strong>Name:</strong> {u.name}</p>
              <p><strong>Email:</strong> {u.email}</p>
              <p>
                <strong>Status:</strong>{' '}
                {u.is_active ? 'Active' : 'Disabled'} / KYC: {u.kyc_status}
              </p>
            </div>
            <div className="mt-4 md:mt-0 space-x-2">
              <Button onClick={() => toggleActive(u)}>
                {u.is_active ? 'Disable' : 'Enable'}
              </Button>
              <Button variant="outline" onClick={() => deleteUser(u)}>
                Delete
              </Button>
            </div>
          </Card>
        ))}
      </div>
    </>
  )
}
