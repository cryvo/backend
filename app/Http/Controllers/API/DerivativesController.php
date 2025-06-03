import { useState, useEffect } from 'react';
import PageHeader from '../components/PageHeader';
import Card from '../components/Card';
import fetcher from '../utils/fetcher';
import { ResponsiveContainer, ComposedChart, Bar, Line, XAxis, YAxis, Tooltip } from 'recharts';

export default function FuturesPage() {
  const [market, setMarket] = useState('BTC-USD');
  const [orderbook, setBook] = useState<any>(null);
  const [stats, setStats]     = useState<any>(null);

  useEffect(() => {
    fetcher(`/futures/orderbook?market=${market}`).then(setBook);
    fetcher(`/futures/stats?market=${market}`).then(setStats);
  }, [market]);

  return (
    <>
      <PageHeader title="Perpetual Futures" />
      <div className="p-6 space-y-6 max-w-4xl mx-auto">
        <Card className="flex space-x-4">
          <label>Market:</label>
          <select
            value={market}
            onChange={e => setMarket(e.target.value)}
            className="border rounded p-2"
          >
            <option>BTC-USD</option>
            <option>ETH-USD</option>
            <option>SOL-USD</option>
          </select>
        </Card>

        {stats && (
          <Card className="grid grid-cols-3 gap-4 text-center">
            <div>
              <p className="text-sm">Funding Rate</p>
              <p>{(+stats.fundingRate * 100).toFixed(3)}%</p>
            </div>
            <div>
              <p className="text-sm">Open Interest</p>
              <p>{(+stats.openInterest).toLocaleString()}</p>
            </div>
            <div>
              <p className="text-sm">Mark Price</p>
              <p>${(+stats.markPrice).toFixed(2)}</p>
            </div>
          </Card>
        )}

        {orderbook && (
          <ResponsiveContainer width="100%" height={300}>
            <ComposedChart
              data={[...orderbook.asks.slice(0,20).reverse(), ...orderbook.bids.slice(0,20)]}
            >
              <XAxis dataKey="price" />
              <YAxis />
              <Tooltip />
              <Bar dataKey="size" fill="#C026D3" />
              <Line dataKey="size" stroke="#7C3AED" dot={false} />
            </ComposedChart>
          </ResponsiveContainer>
        )}
      </div>
    </>
  );
}
