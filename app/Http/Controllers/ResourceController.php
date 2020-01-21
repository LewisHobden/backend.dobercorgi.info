<?php

namespace App\Http\Controllers;

use App\Resource;
use App\ResourceCategory;
use Illuminate\Http\Request;

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

        $resources = Resource::where(["category_id" => $category_id]);

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param \App\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
