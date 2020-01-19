<?php

namespace App\Http\Controllers;

use App\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ResourceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("resource_category.index")->withCategories(ResourceCategory::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("resource_category.create");
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
        $request->validate([
            'title' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);

        ResourceCategory::create($request->all());

        return Redirect::to('categories')->with('success','New category has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ResourceCategory $resourceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceCategory $resourceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ResourceCategory $resourceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceCategory $resourceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ResourceCategory $resourceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ResourceCategory $resourceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ResourceCategory $resourceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceCategory $resourceCategory)
    {
        //
    }
}
