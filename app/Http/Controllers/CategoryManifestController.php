<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * A controller for the API, for loading all resource categories from the database in a format for the frontend site.
 */
class CategoryManifestController
{
    /**
     * Runs the class, getting the manifest from the database.
     * @return array
     */
    public function getManifest()
    {
        $query = DB::table("resource_categories")
            ->select(["title","id","icon","description"])
            ->whereNull("deleted_at");

        // @todo Include data expiry.
        $manifest = [];

        foreach($query->get() as $result)
        {
            $resources = DB::table("resources")
                ->select(["title","content","action","file_key"])
                ->where("category_id","=",$result->id)
                ->get();

            $result->items = collect($resources->toArray())->map(function($resource)
            {
                return $this->transformRow($resource);
            });

            $manifest[] = $result;
        }

        return $manifest;
    }
    /**
     * Transforms a single resource row to provide the store URL.
     * @param $resource
     * @return mixed
     */
    private function transformRow($resource)
    {
        if("" === $resource->file_key)
            return $resource;

        $resource->imageUrl = Storage::url($resource->file_key);

        unset($resource->file_key);

        return $resource;
    }
}
