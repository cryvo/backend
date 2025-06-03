<?php
// backend/app/Http/Controllers/API/BotController.php
namespace App\Http\Controllers\API;

public function execute(Request $req)
{
    // signature validation omitted
    BotManager::run($req->user(), $req->strategy, $req->params);
    return response()->json(['message'=>'Bot triggered']);
}
