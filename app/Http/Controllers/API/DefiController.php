import { useEffect, useState } from 'react'
import useSWR from 'swr'
import fetcher from '../utils/fetcher'
import PageHeader from '../components/PageHeader'
import Card from '../components/Card'

export default function DeFiPage() {
  const { data: aave, error: e1 } = useSWR('/defi/aave', fetcher)
  const { data: comp, error: e2 } = useSWR('/defi/compound', fetcher)

  return (
    <>
      <PageHeader title="DeFi Lending & Staking" />
      <div className="p-6 max-w-3xl mx-auto space-y-6">
        <Card>
          <h2 className="text-lg font-semibold">Aave Supply Rates</h2>
          {!aave ? <p>Loading…</p> : (
            Object.entries(aave).map(([sym, rate]) => (
              <p key={sym}>{sym}: {(Number(rate)/1e27*100).toFixed(2)} % APY</p>
            ))
          )}
        </Card>

        <Card>
          <h2 className="text-lg font-semibold">Compound Supply Rates</h2>
          {!comp ? <p>Loading…</p> : (
            Object.entries(comp).map(([sym, rate]) => (
              <p key={sym}>{sym}: {Number(rate).toFixed(2)} % APY</p>
            ))
          )}
        </Card>
      </div>
    </>
  )
}
