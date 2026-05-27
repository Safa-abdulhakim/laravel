<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MessageReplyRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(15);
        $newCount = Message::where('status', 'new')->count();
        return view('admin.messages.index', compact('messages', 'newCount'));
    }

    public function create()
    {
        return redirect()->route('admin.messages.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.messages.index');
    }

    public function show(Message $message)
    {
        $message->markAsRead();
        return view('admin.messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        return view('admin.messages.edit', compact('message'));
    }

    public function update(MessageReplyRequest $request, Message $message)
    {
        $message->update([
            'reply' => $request->reply,
            'status' => 'replied',
            'replied_at' => now(),
        ]);
        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Reply saved successfully!');
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully!');
    }

    public function markRead(Message $message)
    {
        $message->update(['status' => 'read']);
        return back()->with('success', 'Message marked as read.');
    }
}
