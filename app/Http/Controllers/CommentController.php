<?php


namespace App\Http\Controllers;


use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($doctorId)
    {
        $comments = Comment::where('doctor_id', $doctorId)->get();

        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->doctor_id = $request->doctor_id;
        $comment->patient_id = $request->patient_id;
        $comment->rating = $request->rating;
        $comment->save();

        return response()->json($comment, 201);
    }
}
