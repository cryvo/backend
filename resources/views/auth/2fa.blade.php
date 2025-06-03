<form method="POST" action="{{ route('2fa.post') }}">
  @csrf
  <label>Enter the code sent to your email:</label>
  <input name="code" required />
  @error('code') <div class="text-red-600">{{ $message }}</div> @enderror
  <button type="submit">Verify</button>
</form>
