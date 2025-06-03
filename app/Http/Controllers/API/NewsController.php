import useSWR from 'swr'
import fetcher from '../utils/fetcher'

export default function NewsFeed({ query = 'crypto' }) {
  const { data, error } = useSWR(() => `/api/v1/news?query=${query}`, fetcher)

  if (error) return <p>Error loading news</p>
  if (!data)   return <p>Loading news…</p>

  return (
    <div className="space-y-4">
      {data.map((art:any, i:number) => (
        <a key={i} href={art.url} target="_blank" className="block p-4 bg-white rounded shadow hover:bg-gray-50">
          <h3 className="font-semibold">{art.title}</h3>
          <p className="text-sm text-gray-600">{art.source.name}</p>
        </a>
      ))}
    </div>
  )
}
