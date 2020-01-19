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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
        $resourceCategory = ResourceCategory::find($id);

        if(null === $resourceCategory)
            return abort(404);

        return view("resource_category.edit")->withCategory($resourceCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,int $id)
    {
        //
        $request->validate([
            'title' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);

        ResourceCategory::findOrFail($id)
            ->fill($request->toArray())
            ->update();

        return Redirect::to('categories')->with('success','Your category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        //
        ResourceCategory::findOrFail($id)->delete();

        return Redirect::to('categories')->with('success','Your category has been deleted.');
    }
}
