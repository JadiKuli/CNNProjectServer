<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\BaseContoller;
use App\Http\Requests\History\CreateRecordRequest;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HistoryController extends BaseContoller
{
    // Create History Record
    public function createHistory(CreateRecordRequest $request)
    {
        $user = auth()->user();

        $request->validated();
        $mlUrl = env('ML_API_URL', 'https://cnnproject-model.kuncipintu.my.id');

        $response = Http::attach(
            'image',
            file_get_contents($request->file('image')->getRealPath()),
            $request->file('image')->getClientOriginalName()
        )->post(rtrim($mlUrl, '/').'/predict');

        if ($response->failed()) {
            Log::error('ML API failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $this->errorResponse('ML service failed', 500);
        }

        $history = History::create([
            'user_id' => $user->id,
            'indication' => 'CFRD',
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

    // Get Latest History
    public function fetchLatestHistory()
    {
        $user = auth()->user();
        $history = History::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return $this->successResponse($history, 'Latest history fetched successfully.');
    }
}
