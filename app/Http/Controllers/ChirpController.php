<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $chirps = [
        //     [
        //         'author' => 'Jane Doe',
        //         "message" => "Just deployed the laravel app",
        //         'time' => '5 minutes ago'
        //     ],
        //     [
        //         'author' => 'John Smith',
        //         'message' => 'Laravel makes web development fun again!',
        //         'time' => '1 hour ago'
        //     ],
        //     [
        //         'author' => 'Alice Johnson',
        //         'message' => 'Working on something cool with Chirper...',
        //         'time' => '3 hours ago'
        //     ]
        // ];

        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();
            
        return view('home', ['chirps' => $chirps]);
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
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);
        // \App\Models\Chirp::create([
        //     'message' => $validated['message']
        // ]);

        auth()->user()->chirps()->create($validated);

        return redirect('/')->with('success','Chirp has been posted');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        return view('chirp.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message'=> 'required|string|max:255',
        ], [
            'message.required'=> 'Pleae write something',
        ], [
            'message'=> 'temp',
        ]);

        $chirp->update($validated);

        return redirect('/')->with('success','Chirp Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        return redirect('/')->with('success','Chirp Deleted');
    }
}
