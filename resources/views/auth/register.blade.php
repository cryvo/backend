<form method="POST" action="{{ route('register') }}">
  @csrf

  <!-- Name, Email, Password, Confirm Password fields... -->

  <!-- reCAPTCHA -->
  {!! ReCaptcha::htmlScriptTagJsApi() !!}
  {!! ReCaptcha::htmlFormSnippet() !!}
  @error('g-recaptcha-response')
    <div class="text-red-600">{{ $message }}</div>
  @enderror

  <button type="submit">Register</button>
</form>
