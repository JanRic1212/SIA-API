<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    // Create a new poll
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'end_time' => 'required|date|after:now',
        ]);

        $poll = Poll::create([
            'question' => $request->question,
            'options' => $request->options,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'message' => 'Poll created successfully',
            'poll' => $poll
        ], 201);
    }

    // Get all polls
    public function index()
    {
        return Poll::all();
    }

    // Get single poll (without votes)
    public function show(Poll $poll)
    {
        return $poll;
    }
}
