<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class Feedback_validate extends Controller
{
    public function index(Request $request)
    {
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);
        $feedback = Feedback::create($validated);
        // dd($feedback);

        $data = [
            'status' => 1,
            'result' => 'success',
            'data' => $feedback,
            'message' => 'Feedback submitted successfully!'
        ];

        return response()->json([$data]);

        // return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }
        public function updateAddressed(Request $request, $id)
        {
            $feedback = Feedback::findOrFail($id);
            $feedback->addressed = $request->input('addressed');
            $feedback->save();

            return response()->json(['success' => true, 'addressed' => $feedback->addressed]);
        }

}