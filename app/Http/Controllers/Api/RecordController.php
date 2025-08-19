<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Services\GoogleSheetService;
use App\Models\Setting;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        return Record::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'status' => 'required|in:Allowed,Prohibited',
        ]);
        $record = Record::create($data);
        $this->syncWithGoogleSheets();
        return response()->json($record, 201);
    }
    protected function syncWithGoogleSheets()
    {
            $googleSheetService = new GoogleSheetService();
            $googleSheetService->syncRecord();

            cache()->put('google_sheet_sync_lock', true, now()->addMinute());
    }

    public function show($id)
    {
        return Record::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $record = Record::findOrFail($id);
        $data = $request->validate([
            'text' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:Allowed,Prohibited',
        ]);
        $record->update($data);
        $this->syncWithGoogleSheets();
        return response()->json($record);
    }

    public function destroy($id)
    {
        $record = Record::findOrFail($id);
        $record->delete();
        return response()->json(null, 204);
    }

    public function generate()
    {
        $records = [];
        for ($i = 0; $i < 1000; $i++) {
            $status = $i % 2 === 0 ? 'Allowed' : 'Prohibited';
            $records[] = [
                'text' => 'Text row ' . ($i + 1),
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Record::insert($records);
        $this->syncWithGoogleSheets();

        return response()->json(['message' => '1000 records generated']);
    }

    public function clear()
    {
        Record::truncate();
        $this->syncWithGoogleSheets();
        return response()->json(['message' => 'Table cleared']);
    }
}
