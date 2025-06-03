<?php
// backend/app/Http/Controllers/API/ComplianceController.php
public function submitKYC(Request $req)
{
    $req->validate([
      'full_name'=>'required',
      'document_type'=>'required',
      'document_file'=>'required|file|mimes:jpg,png,pdf',
    ]);
    $path = $req->file('document_file')->store('kyc');
    // queue third-party API call...
    return response()->json(['status'=>'pending','path'=>$path], 202);
}
