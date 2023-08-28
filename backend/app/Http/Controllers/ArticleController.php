<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all articles from the database
        $articles = Article::all();

        // Convert to array
        $articlesArray = $articles->toArray();

        // Return the array of articles
        return response()->json([
            'articles' => $articlesArray
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'user' => 'required',
        ]);

        if ($validatedData['user']['can_edit'] === 0) {
            return response()->json([
                'message' => 'User is not authorized to create articles',
            ], 403);
        }

        // Create a new Article instance and save it
        $article = new Article([
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => $validatedData['user']['id'], 
        ]);

        $article->save();

        // Return a JSON response with a success message and the saved article
        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article,
            'data' => $validatedData,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Validate and update the title and body using the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'user' => 'required',
        ]);

        if ($validatedData['user']['can_edit'] === 0) {
            return response()->json([
                'message' => 'User is not authorized to edit articles',
            ], 403);
        }

        $validatedData["last_edit_user_id"] = $validatedData['user']['id'];

        $article->update($validatedData);

        return response()->json([
            'message' => 'Article updated successfully',
            'article' => $article,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $canDeleteHeader = $request->header('can_edit');

        if ($canDeleteHeader === 'false') {
            return response()->json([
                'message' => 'User is not authorized to delete articles',
            ], 403);
        }

        $article = Article::find($id);

        // Check if the article exists
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Delete the article
        $article->delete();

        return response()->json([
            'message' => 'Article successfully deleted',
            'article' => $article,
        ], 201);
    }
}
