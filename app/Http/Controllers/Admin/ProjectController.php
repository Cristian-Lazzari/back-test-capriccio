<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private $validations = [
        'name'          => 'required|string|min:2|max:50',
        'price'         => 'required|string|min:1',
        'image'         => 'nullable|image',
    ];

    public function index()
    {
        // $projects = Project::paginate(25);
        $categories = Category::all();

        return view('admin.projects.index', compact('categories'));
    }

    public function showCategory($category_id)
    {
        if ($category_id == 0) {
            $projects = Project::orderBy('name')->get();
        } else {
            $projects = Project::where('category_id', $category_id)->orderBy('name')->get();
        }
        $category = Category::where('id', $category_id)->first();

        return view('admin.projects.showCategory', compact('projects', 'category_id', 'category'));
    }

    public function filter(Request $request)
    {
        $name = $request->input('name');
        $visible = $request->input('visible');
        $orderByUpdate = $request->has('orderByUpdate') ? true : false;
        $category_id = $request->input('category_id');

        $query = Project::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($visible == 1) {
            $query->where('visible', '=', 0);
        } else if ($visible == 2) {
            $query->where('visible', '=', 1);
        }
        if($category_id == 0){
            $projects = $query->orderBy('name')->get();
            
            $category = 0;
        }else{
           
            $projects = $query->where('category_id', $category_id)->orderBy('name')->get();
            $category = Category::where('id', $category_id)->first();
            
        }



        return view('admin.projects.showCategory', compact('projects', 'category_id', 'name', 'visible', 'category'));
    }


    public function create(Request $request)
    {
        $categories     = Category::all();
        $alltag         = Tag::all();
        $tags = [];
        $tagDescription = [];
        foreach ($alltag as $tag) {
            if($tag['price'] == 0){
                array_push($tagDescription, $tag);
            }else{
                array_push($tags, $tag);
            }
        }
        
        return view('admin.projects.create', compact('categories', 'tags', 'tagDescription'));
    }
    
    private $validations_tag = [
        'name_ing'          => 'required|string|min:2',
        'price_ing'         => 'required',
    ];
    public function store(Request $request)
    {
        $tag_name = $request->name_ing;
        $tag_price = $request->price_ing;
        $newi = $request->newi;
        if (isset($newi)) {
            $request->validate($this->validations_tag);
            
            $new_ing = new Tag();
            $new_ing->name = $tag_name;
            
            if ($tag_name > 50) {
                $new_ing->price = 0;
            } else {
                $new_ing->price = $tag_price;
            }
            
            $new_ing->save();
            
            return redirect()->route('admin.projects.create')->with('tag_success', true);
        }
        
        $request->validate($this->validations);
        $data = $request->all();
        
        $newProject = new Project();
        
        if (isset($data['image'])) {
            $imagePath = Storage::put('public/uploads', $data['image']);
            $newProject->image = $imagePath;
        }
        
        
        $newProject->name          = $data['name'];
        $newProject->price         = $data['price'];
        $newProject->counter       = 0;
        $newProject->slug          = Project::slugger($data['name']);
        $newProject->category_id   = $data['category_id'];
        
        $newProject->save();
        
        $tag = [];
        if(isset($data['tags']) || isset($data['description'])){
            if(isset($data['description'])){
                foreach ($data['description'] as $v ) {
                    array_push($tag, $v);
                }
            }
            if(isset($data['tags'])){
                foreach ($data['tags'] as $v) {
                    array_push($tag, $v);
                }
            }
      
            $newProject->tags()->sync($tag ?? []);
        }
        
        return to_route('admin.projects.show', ['project' => $newProject]);
    }
    
    public function show($id)
    {
        $project = Project::where('id', $id)->firstOrFail();
        return view('admin.projects.show', compact('project'));
    }
    
    
    
    public function edit($id)
    {
        
        $project        = Project::where('id', $id)->firstOrFail();
        $categories     = Category::all();
        $alltag         = Tag::all();
        $tags           = [];
        $tagDescription = [];

        foreach ($alltag as $tag) {
            if($tag['price'] == 0){
                array_push($tagDescription, $tag);
            }else{
                array_push($tags, $tag);
            }
        }

        return view('admin.projects.edit', compact('project', 'categories', 'tags', 'tagDescription'));
    }


    public function update(Request $request, $id)
    {
        $project = Project::where('id', $id)->firstOrFail();

        // validare i dati del form
        $request->validate($this->validations);

        $data = $request->all();

        if (isset($data['image'])) {
            // salvare l'immagine nuova
            $imagePath = Storage::put('public/uploads', $data['image']);

            // eliminare l'immagine vecchia
            if ($project->image) {
                Storage::delete($project->image);
            }

            // aggiormare il valore nella colonna con l'indirizzo dell'immagine nuova
            $project->image = $imagePath;
        }


        // aggiornare i dati nel db se validi
        $project->name          = $data['name'];
        $project->price         = $data['price'];
        $project->counter       = 0;
        $project->category_id   = $data['category_id'];
        $project->update();

        $tag = [];
        if(isset($data['tags']) || isset($data['description'])){
            if(isset($data['description'])){
                foreach ($data['description'] as $v ) {
                array_push($tag, $v);
                }
            }
            if(isset($data['tags'])){
                foreach ($data['tags'] as $v) {
                array_push($tag, $v);
                }
            }
            $project->tags()->sync($tag ?? []);
        }

        // ridirezionare su una rotta di tipo get
        return to_route('admin.projects.show', ['project' => $project]);
    }


    public function destroy($id)
    {
        $project = Project::where('id', $id)->firstOrFail();

        $project->delete();
        return to_route('admin.projects.index')->with('delete_success', $project);
    }



    public function restore($id)
    {
        Project::withTrashed()->where('id', $id)->restore();

        $project = Project::find($id);

        return to_route('admin.projects.index')->with('restore_success', $project);
    }


    public function trashed()
    {
        $trashedProjects = Project::onlyTrashed()->paginate(10);



        return view('admin.projects.trashed', compact('trashedProjects'));
    }

    public function hardDelete($id)
    {
        $project = Project::withTrashed()->find($id);
        $project->tags()->detach();
        $project->forceDelete();

        return to_route('admin.projects.trashed')->with('delete_success', $project);
    }

    public function updatestatus($id)
    {
        $project = Project::where('id', $id)->firstOrFail();
        if ($project) {
            $project->visible = !$project->visible; // Inverte lo stato corrente
            $project->save();
        }
        return redirect()->back();
    }
}
