<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;

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

        return view ('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view ('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request -> all();
        // $formData['slug'] = Str::slug($formData['name'], '-'); ***metodo alternativo***
        
        
        $this->validation($formData);
        
        if($request->hasFile('cover_image')) {
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            
            $formData['cover_image'] = $img_path;
        }
            
            
        // dd($result);
        $newProject = new Project();
        $newProject->fill($formData);
        $newProject->slug = Str::slug($newProject->name, '-');
        $newProject->save();
        
        return redirect()->route('admin.projects.show', ['project' => $newProject->slug]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view ('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view ('admin.projects.edit', compact('project','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $formData = $request->all();
        // $formData['slug'] = Str::slug($formData['name'], '-'); metodo alternativo
        $this->validation($formData);
        
        if($request->hasFile('cover_image')) {
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);

            $formData['cover_image'] = $img_path;
        }


        $project->slug = Str::slug($formData['name'], '-'); 
        $project->update($formData);

        return redirect()-> route('admin.projects.show', ['project'=> $project->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }


    private function validation($data) {
        // dd($data);
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|min:5|max:200',
                'summary' => 'required|min:20|max:500',
                'client_name' => 'required|min:5|max:255',
                'cover_image' => 'nullable|image|max:256',
                'type_id'=> 'nullable|exists:types,id',
            ],
            [
                'name.required' => "Il campo 'Nome del progetto' è obbligatorio",
                'name.min' => "Il campo 'Nome del progetto' deve avere almeno 5 caratteri",
                'name.max' => "Il campo 'Nome del progetto' non può avere più di 200 caratteri",
                'summary.required' => "Il campo 'Descrizione del progetto' è obbligatorio",
                'summary.min' => "Il campo 'Descrizione del progetto' deve contenere più di 20 caratteri",
                'summary.max' => "Il campo 'Descrizione del progetto' deve contenere meno di 500 caratteri",
                'client_name.required' => "Il campo 'Cliente del progetto' è obbligatorio",
                'client_name.min' => "Il campo 'Cliente del progetto' deve avere almeno 5 caratteri",
                'client_name.max' => "Il campo 'Cliente del progetto' non può avere più di 255 caratteri",
                'cover_image.image' => "Il file caricato deve essere un immagine",
                'cover_image.max' => "Il file caricato deve essere inferiore a 256kb",
                'type_id.exists' => "Il campo 'Tipo di progetto' selezionato non esiste",
            ]
        // );
        )->validate();
        // dd($validator);

        return $validator;
    }
}
