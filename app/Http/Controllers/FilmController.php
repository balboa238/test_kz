<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::paginate(5);
        return view('film.index', compact('films'));
    }

    public function changeStatus(Request $request, Film $film){
        try {
            $data = $request->validate([
                'status' => 'required|string|max:255'
            ]);

            $film->edit($data);

            return redirect()->route('film.show', $film->id)->with('success', 'Genre updated successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('film.show', $film->id)->with('error', 'Genre not updated.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('film.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|string',
            'poster' => 'nullable|file|mimes:png,jpg|max:10000',
            'genres_ids' => 'array',
            'genres_ids.*' => 'exists:genres,id'
        ]);

        if($request->hasFile('poster')){
            $request->file('poster')->store('posters',['disk' => 'public']);
        }
        else{
            $data['poster'] = 'poster.jpg';
        }

        $film = Film::create($data);

        if (isset($data['genres_ids'])) {
            $film->genres()->attach($data['genres_ids']);
        }

        return redirect()->route('film.index')->with('success', 'Film created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        return view('film.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        try {

            $request->mergeIfMissing([
                'status' => 'disabled'
            ]);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'nullable|string',
                'poster' => 'nullable|file|mimes:png,jpg|max:10000',
                'genres_ids' => 'array',
                'genres_ids.*' => 'exists:genres,id'
            ]);

            if($request->hasFile('poster')){
                $request->file('poster')->store('posters',['disk' => 'public']);
            }
            else{
                $data['poster'] = 'poster.jpg';
            }

            $film->edit($data);

            if (isset($data['genres_ids'])) {
                $film->tags()->attach($data['genres_ids']);
            }

            return redirect()->route('film.show', $film->id)->with('success', 'Film updated successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('film.show', $film->id)->with('error', 'Film not updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        try {
            $film->delete();
            return redirect()->route('film.index')->with('success', 'Item deleted successfully.');
        } catch (\Exception $exception) {
            return redirect()->route('film.index')->with('error', $exception->getMessage());
        }
    }
}
