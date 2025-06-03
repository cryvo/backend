<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CrybotPlan;

class CrybotPlanController extends Controller
{
  // Admin views omitted—API only:
  public function indexApi(){ return CrybotPlan::all(); }
}
