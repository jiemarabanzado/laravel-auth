<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view("admin.projects.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.projects.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        
        $new_project = new Project();
        $new_project->fill($data);
        $new_project->slug = Str::slug($new_project->name);

        if( isset($data["project_image"]) ){
            $image_path = Storage::disk("public")->put("uploads", $data["project_image"]);
            $new_project->project_image = $image_path;
        }

        $new_project->save();

        return redirect()->route("admin.projects.index")->with("message", "Il progetto è stato creato con successo!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view("admin.projects.edit", compact("project"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        $project->slug = Str::slug($data["name"]);

        if( isset($data["project_image"]) ){
            $image_path = Storage::disk("public")->put("uploads", $data["project_image"]);
            $project->project_image = $image_path;
        }

        $project->update($data);

        return redirect()->route("admin.projects.index")->with("message", "Il progetto $project->name è stato modificato con successo!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project_name = $project->name;
        $project->delete();

        return redirect()->route("admin.projects.index")->with("message", "Il progetto $project_name è stato eliminato!");
    }
}
