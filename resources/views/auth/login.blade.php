<form method="POST" action="{{ route('login') }}">
  @csrf

  <!-- Email & Password fields -->
  <div>
    <label for="email">Email</label>
    <input id="email" type="email" name="email" required autofocus>
    @error('email') <div class="text-red-600">{{ $message }}</div> @enderror
  </div>

  <div>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @error('password') <div class="text-red-600">{{ $message }}</div> @enderror
  </div>

  <!-- reCAPTCHA -->
  {!! ReCaptcha::htmlScriptTagJsApi() !!}
  {!! ReCaptcha::htmlFormSnippet() !!}
  @error('g-recaptcha-response')
    <div class="text-red-600">{{ $message }}</div>
  @enderror

  <button type="submit">Login</button>
</form>
