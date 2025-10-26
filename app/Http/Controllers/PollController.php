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


class PollController extends Controller
{
    public function vote(Request $request, Poll $poll)
    {
        $request->validate([
            'option_id' => 'required|exists:poll_options,id',
        ]);

        if ($poll->is_multiple_choice) {
            $existingVote = PollVote::where('poll_id', $poll->id)
                ->where('user_id', Auth::id())
                ->where('poll_option_id', $request->option_id)
                ->exists();

            if (!$existingVote) {
                PollVote::create([
                    'poll_id' => $poll->id,
                    'poll_option_id' => $request->option_id,
                    'user_id' => Auth::id(),
                ]);
            }
        } else {
            PollVote::where('poll_id', $poll->id)
                ->where('user_id', Auth::id())
                ->delete();

            PollVote::create([
                'poll_id' => $poll->id,
                'poll_option_id' => $request->option_id,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Vote enregistré !');
    }
}