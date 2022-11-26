<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return response()->json(Author::all());
    }

    public function store(Request $request)
    {
        // $data = $request->name;
        Author::create([
            'name' => $request->name
        ]);

        return response()->json(["message" => "Inserted"], 201);
    }

    public function show($id)
    {
        $author = Author::with('posts')->findOrFail($id);
        return response()->json(["data" => $author], 200);
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->name = $request->name;
        $author->save();
        return response()->json($author);
    }

    public function filter($input)
    {
        $authors = Author::where('name', 'like', "%$input%")->get();
        return response()->json(["data" => $authors], 200);
    }
}
