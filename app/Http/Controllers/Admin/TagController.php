<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    private $validations = [
        'name'          => 'required|string|min:2',
        'price'         => 'required',
    ];

    public function index()
    {
        $tags = Tag::orderBy('name')->get();

        return view('admin.tags.index', compact('tags'));
    }


    public function create()
    {
        return view('admin.tags.create');
    }


    public function store(Request $request)
    {
        $request->validate($this->validations);

        $data = $request->all();

        $newTag = new Tag();

        $newTag->name          = $data['name'];
        $newTag->price          = $data['price'];

        $newTag->save();

        if (isset($data['fromProduct'])) {
            $categories = Category::all();
            $tags       = Tag::whereRaw('CHAR_LENGTH(name) <= 50')->orderBy('name')->get();
            return view('admin.projects.create', compact('categories', 'tags'));
        }
        return redirect()->route('admin.tags.index');
    }



    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {


        $data = $request->all();


        $tag->name          = $data['name'];
        $tag->price          = $data['price'];

        $tag->update();


        return to_route('admin.tags.index', ['tag' => $tag]);
    }

    public function destroy(Tag $tag)
    {
        $tag->projects()->detach();
        $tag->delete();
        return to_route('admin.tags.index')->with('delete_success', $tag);
    }
}
