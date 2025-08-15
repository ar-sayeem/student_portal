<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            $messages = Message::where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id)
                ->with(['sender', 'receiver', 'parent'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $messages = Message::with(['sender', 'receiver', 'parent'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }
        
        return view('messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $user = Auth::user();
        
        // Check if user has access to this message
        if ($user->isStudent() && $message->sender_id !== $user->id && $message->receiver_id !== $user->id) {
            abort(403);
        }
        
        // Mark as read if user is the receiver
        if ($message->receiver_id === $user->id && !$message->is_read) {
            $message->markAsRead();
        }
        
        $message->load(['sender', 'receiver', 'replies.sender', 'parent']);
        
        return view('messages.show', compact('message'));
    }

    public function create()
    {
        $user = Auth::user();
        $recipients = [];
        
        if ($user->isStudent()) {
            // Students can message admin and teachers
            $recipients = User::whereIn('role', ['admin', 'teacher'])
                ->orderBy('name')
                ->get();
        } else {
            // Admin/Teachers can message everyone
            $recipients = User::where('id', '!=', $user->id)
                ->orderBy('role')
                ->orderBy('name')
                ->get();
        }
        
        return view('messages.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'nullable|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // If no specific receiver (student contacting admin), set to null (broadcast to all admins)
        $receiverId = $validated['receiver_id'] ?? null;
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        if (Auth::user()->isStudent()) {
            return redirect()->route('dashboard')
                ->with('success', 'Message sent to admin successfully! You will receive a reply once they respond.');
        }

        return redirect()->route('messages.index')
            ->with('success', 'Message sent successfully!');
    }

    public function reply(Request $request, Message $message)
    {
        $user = Auth::user();
        
        // Check if user can reply to this message
        if ($user->isStudent() && $message->sender_id !== $user->id && $message->receiver_id !== $user->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Determine reply receiver (opposite of current user)
        $replyReceiverId = ($message->sender_id === $user->id) 
            ? $message->receiver_id 
            : $message->sender_id;

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $replyReceiverId,
            'subject' => 'Re: ' . $message->subject,
            'message' => $validated['message'],
            'parent_id' => $message->id,
        ]);

        return redirect()->route('messages.show', $message)
            ->with('success', 'Reply sent successfully!');
    }

    public function markAsRead(Message $message)
    {
        $user = Auth::user();
        
        if ($message->receiver_id === $user->id) {
            $message->markAsRead();
        }

        return redirect()->back()
            ->with('success', 'Message marked as read.');
    }

    public function destroy(Message $message)
    {
        $user = Auth::user();
        
        // Only sender or receiver can delete, and admins can delete any message
        if (!$user->isAdmin() && $message->sender_id !== $user->id && $message->receiver_id !== $user->id) {
            abort(403);
        }
        
        $message->delete();

        return redirect()->route('messages.index')
            ->with('success', 'Message deleted successfully!');
    }
}
