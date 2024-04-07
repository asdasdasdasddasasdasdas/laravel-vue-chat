<?php

namespace App\Http\Controllers;


use App\Models\Chat;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Events\Chat\ChatCreated;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Chat::with(['messages', 'messages.user'])->get();

        return response()->json(['chats' => $chats]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {




        $chat = Chat::create(['name' => 'test' . Str::random(4)]);
        $chat->users()->create(['chat_id' => $chat->id, 'user_id' => Auth::user()->id]);

        broadcast(new ChatCreated($chat))->toOthers();
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
