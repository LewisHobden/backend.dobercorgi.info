<?php

namespace App\Http\Controllers;

use App\ManifestRequest;
use App\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * A controller for the API, for loading all resource categories from the database in a format for the frontend site.
 */
class CategoryManifestController
{
    /**
     * Runs the class, getting the manifest from the database.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function __invoke(Request $request)
    {
        $query = ResourceCategory::select(["id","title","icon","description"])->whereNull("deleted_at");

        // @todo Include data expiry.
        $manifest = [];

        foreach($query->getModels() as $result)
        {
            $resources = $result->resources()->orderByDesc("file_key")->getModels();
            $result->items = collect($resources)->map(\Closure::fromCallable([$this,"transformRow"]));

            $manifest[] = $result;
        }

        $this->logRequest($request->ip());

        return $manifest;
    }
    /**
     * Logs the request in the database.
     * @param string $ip_address
     * @return void
     */
    private function logRequest(string $ip_address): void
    {
        ManifestRequest::create(["ip_address" => $ip_address]);
    }
    /**
     * Transforms a single resource row to provide the store URL.
     * @param $resource
     * @return mixed
     */
    private function transformRow($resource)
    {
        $datum = [
            "id" => $resource->id,
            "title" => $resource->title,
            "content" => $resource->content,
            "action" => $resource->action
        ];

        if($resource->file_key)
            $datum["imageUrl"] = Storage::url($resource->file_key);

        return $datum;
    }
}
