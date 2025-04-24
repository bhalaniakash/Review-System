<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class Feedback_validate extends Controller
{
    public function submit(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
        'email' => 'nullable|email',
    ]);
    Feedback::create($validated);
    return response()->json(['success' => true]);
    
}

        public function updateAddressed(Request $request, $id)
        {
            $feedback = Feedback::findOrFail($id);
            $feedback->addressed = $request->input('addressed');
            $feedback->save();

            return response()->json(['success' => true, 'addressed' => $feedback->addressed]);
        }

}