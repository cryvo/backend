// File: frontend/pages/admin/fees.tsx

import React, { useState } from 'react'
import useSWR from 'swr'
import fetcher from '../../utils/fetcher'
import PageHeader from '../../components/PageHeader'
import Card from '../../components/Card'
import { TextInput } from '../../components/Form'
import Button from '../../components/Button'
import Toast from '../../components/Toast'

interface Fee { id: number; name: string; config: any }

export default function AdminFeesPage() {
  const { data: fees = [], mutate, error } = useSWR<Fee[]>('/admin/fees', fetcher)
  const [form, setForm] = useState({ name:'', config:'{}' })
  const [toast, setToast] = useState<{ message:string; type?:string }|null>(null)
  const [editing, setEditing] = useState<number|null>(null)

  const save = async () => {
    try {
      const payload = { name: form.name, config: JSON.parse(form.config) }
      if (editing) {
        await fetcher(`/admin/fees/${editing}`, {
          method:'PUT', body: JSON.stringify(payload)
        })
        setToast({ message:'Fee updated!', type:'success' })
      } else {
        await fetcher('/admin/fees', {
          method:'POST', body: JSON.stringify(payload)
        })
        setToast({ message:'Fee created!', type:'success' })
      }
      setForm({ name:'', config:'{}' })
      setEditing(null)
      mutate()
    } catch (e:any) {
      setToast({ message:e.message||'Error', type:'error' })
    }
  }

  const edit = (f: Fee) => {
    setEditing(f.id)
    setForm({ name:f.name, config: JSON.stringify(f.config||{},null,2) })
  }

  const remove = async (id:number) => {
    if (!confirm('Delete this fee?')) return
    await fetcher(`/admin/fees/${id}`, { method:'DELETE' })
    mutate()
  }

  if (error) return <p className="p-6 text-red-600">Failed to load fees.</p>

  return (
    <>
      {toast && <Toast {...toast} onClose={()=>setToast(null)} />}
      <PageHeader title="Fee Management" />
      <div className="p-6 space-y-6">
        <Card className="max-w-xl mx-auto space-y-4">
          <h2 className="text-xl font-semibold">{editing?'Edit Fee':'New Fee'}</h2>
          <div>
            <label className="block text-sm">Name</label>
            <TextInput
              value={form.name}
              onChange={e=>setForm(f=>({...f,name:e.target.value}))}
            />
          </div>
          <div>
            <label className="block text-sm">Config (JSON)</label>
            <textarea
              value={form.config}
              onChange={e=>setForm(f=>({...f,config:e.target.value}))}
              className="w-full h-32 border rounded p-2 font-mono"
            />
          </div>
          <Button onClick={save}>
            {editing?'Update Fee':'Create Fee'}
          </Button>
        </Card>

        <Card>
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-gray-100 dark:bg-gray-800">
                <th className="px-4 py-2">Name</th>
                <th className="px-4 py-2">Config</th>
                <th className="px-4 py-2">Actions</th>
              </tr>
            </thead>
            <tbody>
              {fees.map(f => (
                <tr key={f.id} className="border-t hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td className="px-4 py-2">{f.name}</td>
                  <td className="px-4 py-2"><pre className="text-xs">{JSON.stringify(f.config)}</pre></td>
                  <td className="px-4 py-2 space-x-2">
                    <Button size="sm" onClick={()=>edit(f)}>Edit</Button>
                    <Button size="sm" variant="outline" onClick={()=>remove(f.id)}>Delete</Button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </Card>
      </div>
    </>
  )
}
