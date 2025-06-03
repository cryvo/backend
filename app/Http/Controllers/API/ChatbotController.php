// File: frontend/components/ChatbotWidget.tsx

import { useState, useRef, useEffect } from 'react'
import fetcher from '../utils/fetcher'

export default function ChatbotWidget() {
  const [history, setHistory] = useState<{ from: 'user'|'bot'; text: string }[]>([])
  const [input, setInput]     = useState('')
  const scrollRef = useRef<HTMLDivElement>(null)

  const sendMessage = async () => {
    if (!input.trim()) return
    setHistory(h => [...h, { from: 'user', text: input }])
    setInput('')
    try {
      const { reply } = await fetcher('/chat', {
        method: 'POST',
        body: JSON.stringify({ message: input })
      })
      setHistory(h => [...h, { from: 'bot', text: reply }])
    } catch {
      setHistory(h => [...h, { from: 'bot', text: 'Sorry, something went wrong.' }])
    }
  }

  // auto‐scroll to bottom
  useEffect(() => {
    scrollRef.current?.scrollTo(0, scrollRef.current.scrollHeight)
  }, [history])

  return (
    <div className="fixed bottom-4 right-4 w-80 max-h-96 bg-white shadow-lg rounded-lg flex flex-col overflow-hidden">
      <div ref={scrollRef} className="flex-1 p-3 overflow-y-auto space-y-2">
        {history.map((m, i) => (
          <div key={i} className={m.from==='user' ? 'text-right' : 'text-left'}>
            <span className={`inline-block px-3 py-1 rounded ${
              m.from==='user' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800'
            }`}>
              {m.text}
            </span>
          </div>
        ))}
      </div>
      <div className="flex border-t">
        <input
          className="flex-1 px-3 py-2 focus:outline-none"
          placeholder="Ask C.V.A...."
          value={input}
          onChange={e => setInput(e.target.value)}
          onKeyDown={e => e.key==='Enter' && sendMessage()}
        />
        <button
          className="px-4 bg-indigo-600 text-white"
          onClick={sendMessage}
        >
          Send
        </button>
      </div>
    </div>
  )
}
