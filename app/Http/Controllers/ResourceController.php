<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function index(int $category_id)
    {
        //
        $category = ResourceCategory::find($category_id);

        if(null === $category)
            return abort(404);

        $resources = Resource::where(["category_id" => $category_id])->get();

        return view("resource_category.resource.index")->withCategory($category)->withResources($resources);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $category_id
     * @return \Illuminate\Http\Response
     */
    public function create(int $category_id)
    {
        //
        $category = ResourceCategory::find($category_id);

        if(null === $category)
            return abort(404);

        return view("resource_category.resource.create")->withCategory($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $category_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(int $category_id,Request $request)
    {
        // Validation.
        $request->validate([
            "title" => "required|max:255",
            "action" => "required",
            "content" => "required"
        ]);

        // Write the file to the CDN.
        if($request->file("banner_image")) {
            $file_prefix = "category/{$category_id}/resource";
            $filename = $request->file("banner_image")
                ->storePubliclyAs($file_prefix,$request->file("banner_image")->getClientOriginalName(),"public");
        }

        // Add the resource to the database.
        Resource::create([
            "category_id" => $category_id,
            "title" => $request->get("title"),
            "action" => $request->get("action"),
            "content" => $request->get("content"),
            "file_key" => $filename ?? ""
        ]);

        return Redirect::to(route('categories.resources.index',$category_id))->with('success','New resource has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $category_id
     * @param \App\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(int $category_id,Resource $resource)
    {
        //
        $category = ResourceCategory::find($category_id);

        if(null === $category)
            return abort(404);

        return view("resource_category.resource.edit")
            ->withCategory($category)
            ->withResource($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $category_id
     * @param \Illuminate\Http\Request $request
     * @param \App\Resource $resource
     * @return void
     */
    public function update(int $category_id,Request $request,Resource $resource)
    {
        //
        // Validation.
        $request->validate([
            "title" => "required|max:255",
            "action" => "required",
            "content" => "required"
        ]);

        // Write the file to the CDN.
        if($request->file("banner_image")) {
            $file_prefix = "category/{$category_id}/resource";
            $filename = $request->file("banner_image")
                ->storePubliclyAs($file_prefix,$request->file("banner_image")->getClientOriginalName(),"public");

            $resource->file_key = $filename;
        }

        // Add the resource to the database.
        $resource->title = $request->get("title");
        $resource->action = $request->get("action");
        $resource->content = $request->get("content");

        $resource->save();

        return Redirect::to(route('categories.resources.index',$category_id))->with('success','New resource has been edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $category_id
     * @param \App\Resource $resource
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(int $category_id,Resource $resource)
    {
        //
        Storage::delete($resource->file_key);

        $resource->delete();

        return Redirect::to(route('categories.resources.index',$category_id))->with('success','Resource has been deleted!');
    }
}
