<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\Comment;
use App\Models\PostVote;
use App\Models\CommentVote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DeletedPost; 

class ForumController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'poll', 'poll.options', 'poll.votes', 'comments', 'votes'])->orderBy('created_at', 'desc')->get();
        
        // Check if the current user is blocked
        $isBlocked = false;
        if (Auth::check()) {
            $user = Auth::user();
            // Add your blocking logic here - this is just an example
            // You might have a 'blocked_users' table or a 'is_blocked' column
            $isBlocked = $user->is_blocked ?? false; // Adjust this based on your actual blocking logic
        }
        
        return view('forum.index', compact('posts', 'isBlocked'));
    }
}