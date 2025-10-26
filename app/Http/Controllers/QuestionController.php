<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class QuestionController extends Controller
{
    // User view - submit question form
    public function index()
    {
        return view('questions.index');
    }

    // Store user question
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        Question::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your question has been submitted successfully!'
        ]);
    }

    // Public view - all answered questions
    public function public()
    {
        $questions = Question::with(['user', 'answeredBy'])
            ->answered()
            ->public()
            ->latest('answered_at')
            ->paginate(10);

        return view('questions.public', compact('questions'));
    }

    // Admin view - manage questions
    public function admin()
    {
        if (!Auth::user()->isAdminOrSuperAdmin()) {
            abort(403);
        }

        $unansweredQuestions = Question::with('user')
            ->unanswered()
            ->latest()
            ->get();

        $answeredQuestions = Question::with(['user', 'answeredBy'])
            ->answered()
            ->latest('answered_at')
            ->paginate(10);

        return view('questions.admin', compact('unansweredQuestions', 'answeredQuestions'));
    }

    // Show single question for admin to answer
    public function show(Question $question)
    {
        // Vérifier les permissions
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        abort(403, 'Accès non autorisé');
    }

        return view('questions.show', compact('question'));
    }

    // Store/Update admin answer
    public function answer(Request $request, Question $question)
    {
        // Vérifier les permissions
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        abort(403, 'Accès non autorisé');
    }

        $request->validate([
            'answer_content' => 'required|string',
            'answer_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'answer_videos.*' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
            'is_public' => 'boolean'
        ]);

        $imageFilenames = [];
        $videoFilenames = [];

        // Handle image uploads
        if ($request->hasFile('answer_images')) {
            foreach ($request->file('answer_images') as $image) {
                $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('questions/images', $filename, 'public');
                $imageFilenames[] = $filename;
            }
        }

        // Handle video uploads
        if ($request->hasFile('answer_videos')) {
            foreach ($request->file('answer_videos') as $video) {
                $filename = Str::random(40) . '.' . $video->getClientOriginalExtension();
                $video->storeAs('questions/videos', $filename, 'public');
                $videoFilenames[] = $filename;
            }
        }

        // If updating existing answer, delete old files
        if ($question->is_answered) {
            $this->deleteOldFiles($question);
        }

        $question->update([
            'is_answered' => true,
            'answered_by' => Auth::id(),
            'answered_at' => now(),
            'answer_content' => $request->answer_content,
            'answer_images' => !empty($imageFilenames) ? $imageFilenames : null,
            'answer_videos' => !empty($videoFilenames) ? $videoFilenames : null,
            'is_public' => $request->boolean('is_public', true),
            'status' => 'answered'
        ]);

        return response()->json([
            'success' => true,
            'message' => $question->wasRecentlyCreated ? 'Answer posted successfully!' : 'Answer updated successfully!'
        ]);
    }

    // Delete old files when updating answer
    private function deleteOldFiles(Question $question)
    {
        if ($question->answer_images) {
            foreach ($question->answer_images as $image) {
                Storage::disk('public')->delete('questions/images/' . $image);
            }
        }

        if ($question->answer_videos) {
            foreach ($question->answer_videos as $video) {
                Storage::disk('public')->delete('questions/videos/' . $video);
            }
        }
    }

    // Toggle question visibility
    public function toggleVisibility(Question $question)
    {
        // Vérifier les permissions
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    if (!($user->role === 'superadmin' || 
          ($user->role === 'admin' && $user->is_active && 
           $user->affectation && in_array('article', $user->affectation->modules ?? [])))) {
        abort(403, 'Accès non autorisé');
    }

        $question->update([
            'is_public' => !$question->is_public
        ]);

        return response()->json([
            'success' => true,
            'is_public' => $question->is_public
        ]);
    }
}