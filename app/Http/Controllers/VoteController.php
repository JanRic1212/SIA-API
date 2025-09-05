<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoteController extends Controller
{
    // Cast a vote
    public function store(Request $request, Poll $poll)
    {
        $request->validate([
            'voter' => 'required|string',
            'choice' => 'required|string',
        ]);

        // Check if poll is still open
        if (Carbon::now()->greaterThan($poll->end_time)) {
            return response()->json(['message' => 'This poll has ended'], 403);
        }

        // Check if choice is valid
        if (!in_array($request->choice, $poll->options)) {
            return response()->json(['message' => 'Invalid choice'], 400);
        }

        // Prevent duplicate voting by same voter
        if (Vote::where('poll_id', $poll->id)->where('voter', $request->voter)->exists()) {
            return response()->json(['message' => 'You already voted in this poll'], 403);
        }

        $vote = Vote::create([
            'poll_id' => $poll->id,
            'voter' => $request->voter,
            'choice' => $request->choice,
        ]);

        return response()->json(['message' => 'Vote submitted successfully', 'vote' => $vote], 201);
    }

    // View poll results
    public function results(Poll $poll)
    {
        // Unique twist: Hide votes until poll ends
        if (now()->lessThan($poll->end_time)) {
            return response()->json(['message' => 'Results are hidden until the poll ends.']);
        }

        // Count votes per option
        $results = $poll->votes()
            ->selectRaw('choice, COUNT(*) as count')
            ->groupBy('choice')
            ->get();

        return response()->json([
            'poll' => $poll->question,
            'results' => $results
        ]);
    }
}