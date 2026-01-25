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
        return view('portfolio', compact('projects'));
    }

    public function adminIndex()
    {
        $projects = Project::with('images')->latest()->get(); 
        return view('admin.portfolio', compact('projects'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create([
            'title' => $request->title,
            'category' => $request->category,
            'year' => $request->year,
            'image_path' => '', 
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $storedPath = 'storage/' . $image->store('portfolio', 'public');
                $project->images()->create(['path' => $storedPath]);
                if ($index === 0) {
                    $project->update(['image_path' => $storedPath]);
                }
            }
        }

        return back()->with('success', "Project bundle created successfully!");
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
            ]);

            return redirect()->route('admin.portfolio.index')->with('success', 'Project details updated!');
        }
    /**
     * Add more images to an existing bundle
     */
    public function addImages(Request $request, Project $project)
    {
        $request->validate(['new_images.*' => 'required|image|max:5120']);

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = 'storage/' . $image->store('portfolio', 'public');
                $project->images()->create(['path' => $path]);
                
                // If project had no cover, set this as cover
                if (empty($project->image_path)) {
                    $project->update(['image_path' => $path]);
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
            Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        }
        $project->delete();
        return back()->with('success', 'Project and bundle deleted.');
    }

    public function destroyImage(ProjectImage $image)
    {
        $project = $image->project;
        Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        $image->delete();

        if ($project->image_path == $image->path) {
            $next = $project->images()->first();
            $project->update(['image_path' => $next ? $next->path : '']);
        }

        return back()->with('success', 'Image removed from bundle.');
    }
}