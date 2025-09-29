<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\BaseContoller;
use App\Http\Controllers\Controller;
use App\Http\Requests\History\CreateRecordRequest;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends BaseContoller
{
    // Create History Record
    public function createHistory(CreateRecordRequest $request)
    {
        $user = auth()->user();

        $request->validated();
        $history = History::create([
            'user_id' => $user->id,
            'indication' => $request->indication,
        ]);

        return $this->successResponse($history, 'History record created successfully.', 201);
    }

    // Get User History
    public function fetchHistoryUser(Request $request)
    {
        $user = auth()->user();

        $query = History::where('user_id', $user->id);

        if ($request->has('indication')) {
            $query->where('indication', $request->indication);
        }

        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        $histories = $query->get();

        return $this->successResponse($histories, 'User history fetched successfully.');
    }
}
