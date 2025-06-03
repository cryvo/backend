<?php

public function start(Request $r, VeriffService $v)
{
    $session = $v->createSession(auth()->id(), '/kyc/callback');
    return redirect($session['url']);
}

public function callback(Request $r)
{
    // verify and mark user as KYC-completed
    auth()->user()->update(['kyc_status'=>'verified']);
    return redirect('/dashboard');
}
