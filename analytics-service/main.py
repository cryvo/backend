import { useEffect, useState } from 'react'
import useSWR from 'swr'
import fetcher from '../utils/fetcher'
import PageHeader from '../components/PageHeader'
import Card from '../components/Card'
import Button from '../components/Button'

interface RiskResp { user_id: number; risk_score: number }
interface FraudResp { transaction_id: string; is_fraud: boolean; confidence: number }
interface Signal { type: string; symbol: string; score: number }
interface SignalsResp { user_id: number; signals: Signal[] }

export default function AnalyticsPage() {
  const { data: risk } = useSWR<RiskResp>('/analytics/risk', fetcher)
  const { data: sigs } = useSWR<SignalsResp>('/analytics/signals', fetcher)
  const [txId, setTxId] = useState('')
  const [fraud, setFraud] = useState<FraudResp|null>(null)

  const checkFraud = async () => {
    if (!txId) return
    const res = await fetcher<FraudResp>(`/analytics/fraud?tx_id=${txId}`)
    setFraud(res)
  }

  return (
    <>
      <PageHeader title="AI-Powered Analytics & Alerts" />
      <div className="p-6 space-y-8 max-w-3xl mx-auto">

        <Card>
          <h2 className="font-semibold">Risk Score</h2>
          <p className="text-2xl">
            {risk ? (risk.risk_score * 100).toFixed(1) + '%' : '—'}
          </p>
        </Card>

        <Card>
          <h2 className="font-semibold">Trading Signals</h2>
          {sigs?.signals.length ? (
            <ul className="list-disc list-inside space-y-1">
              {sigs.signals.map((s,i) => (
                <li key={i}>
                  <strong>{s.symbol}</strong> [{s.type}]: {Math.round(s.score*100)}%
                </li>
              ))}
            </ul>
          ) : (
            <p>No signals available</p>
          )}
        </Card>

        <Card className="space-y-2">
          <h2 className="font-semibold">Fraud Detection</h2>
          <div className="flex space-x-2">
            <input
              type="text" value={txId}
              onChange={e => setTxId(e.target.value)}
              placeholder="Transaction ID"
              className="border rounded p-2 flex-grow"
            />
            <Button onClick={checkFraud}>Check</Button>
          </div>
          {fraud && (
            <p className={`mt-2 ${fraud.is_fraud ? 'text-red-600' : 'text-green-600'}`}>
              {fraud.is_fraud
                ? `🚨 Fraud detected (confidence ${Math.round(fraud.confidence*100)}%)`
                : `✅ Clear (confidence ${Math.round(fraud.confidence*100)}%)`}
            </p>
          )}
        </Card>

      </div>
    </>
  )
}
