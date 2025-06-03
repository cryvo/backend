<?php
import { useState, useMemo } from 'react'
import useSWR from 'swr'
import fetcher from '../utils/fetcher'
import AdminLayout from '../components/Layout'
import MarketFilter from '../components/MarketFilter'
import MarketTable from '../components/MarketTable'

export default function MarketsPage() {
  const { data: markets = [] } = useSWR('/markets', fetcher)
  const [category, setCategory] = useState<'all'|'favourites'|'spot'>('all')
  const [quote, setQuote]       = useState<string>('USDT')
  const [search, setSearch]     = useState<string>('')

  // filter by category, quote asset, search term
  const filtered = useMemo(() => {
    return markets
      .filter(m => category==='all' || m.category === category)
      .filter(m => quote==='All' || m.quoteAsset === quote)
      .filter(m =>
        m.symbol.toLowerCase().includes(search.toLowerCase())
      )
  }, [markets, category, quote, search])

  return (
    <AdminLayout>
      <div className="p-6 bg-white rounded shadow">
        <h1 className="text-2xl font-semibold mb-4">Markets</h1>

        <MarketFilter
          category={category}
          onCategoryChange={setCategory}
          quote={quote}
          onQuoteChange={setQuote}
        />

        <div className="my-4 flex items-center">
          <input
            type="text"
            placeholder="Search pairs..."
            value={search}
            onChange={e => setSearch(e.target.value)}
            className="border rounded px-3 py-2 w-full md:w-1/3"
          />
        </div>

        <MarketTable rows={filtered} />
      </div>
    </AdminLayout>
  )
}
