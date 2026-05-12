<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('images')->latest()->get();
        return view('portfolio.index', compact('projects'));
    }

    public function portalIndex()
    {
        $projects = Project::with('images')->latest()->get();
        return view('client.portfolio', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load('images');
        return view('portfolio.show', compact('project'));
    }

    public function adminIndex()
    {
        $projects = Project::with('images')->latest()->get(); 
        return view('admin.portfolio', compact('projects'));
    }

    public function store(StoreProjectRequest $request)
    {
        // 1. Handle the Main Cover Image
        $coverPath = '';
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('', 'supabase');
            $coverPath = Storage::disk('supabase')->url($path);
        }

        // 2. Create the Project
        $project = Project::create([
            'title' => $request->title,
            'category' => $request->category,
            'year' => $request->year,
            'location' => $request->location,
            'description' => $request->description,
            'image_path' => $coverPath, 
        ]);

        // 3. Handle the Perspective Gallery
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('', 'supabase');
                $storedPath = Storage::disk('supabase')->url($path);
                $project->images()->create(['path' => $storedPath]);
            }
        }

        return back()->with('success', "Architectural project fully curated and uploaded!");
    }

    /**
     * Update metadata (Title/Year/Category)
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update([
            'title' => $request->title,
            'year' => $request->year,
            'category' => $request->category,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        // Handle new perspective uploads
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('', 'supabase');
                $storedPath = Storage::disk('supabase')->url($path);
                $project->images()->create(['path' => $storedPath]);
            }
        }

        return redirect()->route('admin.portfolio.index')->with('success', 'Project bundle updated successfully!');
    }
    /**
     * Add more images to an existing bundle
     */
    public function addImages(Request $request, Project $project)
    {
        $request->validate(['new_images.*' => 'required|image|max:5120']);

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('', 'supabase');
                $storedPath = Storage::disk('supabase')->url($path);
                
                $project->images()->create(['path' => $storedPath]);
                
                // If project had no cover, set this as cover
                if (empty($project->image_path)) {
                    $project->update(['image_path' => $storedPath]);
                }
            }
        }
        return back()->with('success', 'Additional renders uploaded!');
    }

    /**
     * Delete entire project and all associated files
     */
    public function destroy(Project $project)
    {
        foreach ($project->images as $image) {
            // Extract path from URL to delete from storage
            $path = parse_url($image->path, PHP_URL_PATH);
            $path = str_replace('/storage/v1/object/public/' . env('SUPABASE_STORAGE_BUCKET') . '/', '', $path);
            if (!empty($path) && $path !== '/') {
                Storage::disk('supabase')->delete($path);
            }
        }
        $project->delete();
        return back()->with('success', 'Project and bundle deleted.');
    }

    public function destroyImage(ProjectImage $image)
    {
        $project = $image->project;
        
        // Extract path from URL
        $path = parse_url($image->path, PHP_URL_PATH);
        $path = str_replace('/storage/v1/object/public/' . env('SUPABASE_STORAGE_BUCKET') . '/', '', $path);
        if (!empty($path) && $path !== '/') {
            Storage::disk('supabase')->delete($path);
        }
        
        $image->delete();

        if ($project->image_path == $image->path) {
            $next = $project->images()->first();
            $project->update(['image_path' => $next ? $next->path : '']);
        }

        return back()->with('success', 'Image removed from bundle.');
    }
}