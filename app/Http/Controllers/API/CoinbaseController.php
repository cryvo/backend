import fetcher from './fetcher'

export function getCoinbaseAccounts() {
  return fetcher('/coinbase/accounts')
}

export function createCoinbaseCharge(amount:number, currency:string) {
  return fetcher('/coinbase/charge', {
    method:'POST',
    body: JSON.stringify({ amount, currency })
  })
}
