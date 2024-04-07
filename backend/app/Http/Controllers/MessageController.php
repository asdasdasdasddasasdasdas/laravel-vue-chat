<?php

namespace App\Http\Controllers;

use App\Events\Chat\MessageSent;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'required',
            'chat_id' => 'required'
        ]);
        $data['user_id'] = Auth::id();


        $message =  Message::create($data);


        $chat = Chat::find($request->chat_id);
        broadcast(new MessageSent($chat, $message, Auth::user()))->toOthers();
        return response()->json($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
