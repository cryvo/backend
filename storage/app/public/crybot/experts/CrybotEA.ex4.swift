public function downloadEa(Request $r)
{
    // Path on the public disk
    $file = storage_path('app/public/crybot/experts/CrybotEA.ex4');
    if (! file_exists($file)) {
        abort(404, 'Crybot EA not found');
    }
    return response()->download($file, 'CrybotEA.ex4', [
        'Content-Type' => 'application/octet-stream',
        'Content-Disposition' => 'attachment; filename="CrybotEA.ex4"'
    ]);
}
