<?php
import useSWR from 'swr'
import fetcher from '../utils/fetcher'
import Layout from '../components/Layout'

export default function FAQPage() {
  const { data: faq = [] } = useSWR('/admin/settings/general-faq', fetcher)
  return (
    <Layout>
      <div className="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h1 className="text-3xl font-bold mb-6">Frequently Asked Questions</h1>
        <dl className="space-y-6">
          {faq.map((item: any, idx: number) => (
            <div key={idx}>
              <dt className="font-medium">{item.q}</dt>
              <dd className="mt-1 text-gray-700">{item.a}</dd>
            </div>
          ))}
        </dl>
      </div>
    </Layout>
  )
}
