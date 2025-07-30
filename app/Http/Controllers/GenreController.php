<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::paginate(5);
        return view('genre.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $genre = Genre::create($data);

        return redirect()->route('genre.index')->with('success', 'Genre created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('genre.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $genre->edit($data);

            return redirect()->route('film.show', $genre->id)->with('success', 'Genre updated successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('film.show', $genre->id)->with('error', 'Genre not updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        try {
            $genre->delete();
            return 'Deleted!';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
