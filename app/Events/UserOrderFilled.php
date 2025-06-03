import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

export const echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.NEXT_PUBLIC_PUSHER_APP_KEY,
  wsHost: window.location.hostname,
  wsPort: 6001,
  forceTLS: false,
  disableStats: true,
  authEndpoint: '/api/broadcasting/auth',
  auth: {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('authToken')}`
    }
  }
})
