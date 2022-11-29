<?php

namespace App\Http\Controllers;

use App\Traits\ManagesEndpoints;
use App\Traits\ManagesResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestfulController extends Controller
{
    use ManagesResponse, ManagesEndpoints;

    /**
     * RestfulController constructor.
     */
    public function __construct()
    {
        // $this->middleware(['auth:sanctum'], ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $endpoint
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($endpoint)
    {
        try {
            if (!array_key_exists($endpoint, $this->endpoints)) {
                return $this->sendError('no endpoint found');
            }
            if (array_key_exists($endpoint, $this->orderBy)) {
                $builder = $this->endpoints[$endpoint]::orderBy($this->orderBy[$endpoint]['key'], $this->orderBy[$endpoint]['order']);
            } else {
                $builder = $this->endpoints[$endpoint]::orderBy('created_at', 'desc');
            }

            if (count(\request()->query()) > 0) {
                $query = \request()->query();
                unset($query['page']);
                $builder->where($query);
            }

            if (array_key_exists($endpoint, $this->paginate)) {
                $results = $builder->paginate($this->paginate[$endpoint]);
            } else {
                $results = $builder->get();
            }

            return $this->sendResponse($results->toArray(), 'resources retrieved successfully.');
        } catch (\Exception $exception) {
            return $this->sendError('Something went wrong', $exception->getTrace(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $endpoint
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $endpoint)
    {
        try {
            if (!array_key_exists($endpoint, $this->endpoints)) {
                return $this->sendError('no endpoint found');
            }

            $rules = $this->rules[$endpoint]['store'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $error = $validator->errors();
                return $this->sendError('Validation Error.', $error, 422);
            }
            $input = $request->all();
            $response = $this->endpoints[$endpoint]::create($input);
            return $this->sendResponse($response, 'new resource created successfully.');
        } catch (\Exception $exception) {
            return $this->sendError('Something went wrong', $exception->getTrace(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $endpoint
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($endpoint, $id)
    {
        try {
            if (!array_key_exists($endpoint, $this->endpoints)) {
                return $this->sendError('no endpoint found');
            }

            $item = $this->endpoints[$endpoint]::find($id);
            if (is_null($item)) {
                return $this->sendError('resource not found.');
            }
            return $this->sendResponse($item, 'resource retrieved successfully.');
        } catch (\Exception $error) {
            return $this->sendError('Something went wrong', $error->getTrace(), 500);
        }
    }

    /**
     * Count the number of items in specified resource.
     *
     * @param $endpoint
     * @return \Illuminate\Http\JsonResponse
     */
    public function count($endpoint)
    {
        try {
            $count = $this->endpoints[$endpoint]::count();
            return $this->sendResponse($count, 'number of resources retrieved successfully');
        } catch (\Exception $exception) {
            return $this->sendError('Something went wrong', $exception->getTrace(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $endpoint
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $endpoint, $id)
    {
        try {
            if (!array_key_exists($endpoint, $this->endpoints)) {
                return $this->sendError('no endpoint found');
            }

            $rules = $this->rules[$endpoint]['update'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }
            $resource = $this->updateResource($request->all(), $endpoint, $id);
            if ($resource) {
                return $this->sendResponse($resource, 'resource updated successfully');
            }
            return $this->sendError('error in updating resource');
        } catch (\Exception $error) {
            return $this->sendError('Something went wrong', $error->getTrace(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $endpoint
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($endpoint, $id)
    {
        try {
            if (!array_key_exists($endpoint, $this->endpoints)) {
                return $this->sendError('no endpoint found');
            }

            if ($this->endpoints[$endpoint]::where('id', $id)->exists()) {
                $resource = $this->endpoints[$endpoint]::find($id);
                $resource->delete();

                return $this->sendResponse($resource, 'resource deleted successfully.');
            } else {
                return $this->sendError('resource not found in database.');
            }
        } catch (\Exception $error) {
            return $this->sendError('Something went wrong', $error->getTrace(), 500);
        }
    }

    /**
     * update a single resource
     * @param array $data
     * @param $endpoint
     * @param $id
     * @return |null
     */
    private function updateResource(array $data, $endpoint, $id)
    {
        if ($this->endpoints[$endpoint]::where('id', $id)->exists()) {
            $resource = $this->endpoints[$endpoint]::find($id);
            $updated = $resource->fill($data)->save();
            if ($updated) {
                return $this->endpoints[$endpoint]::find($id);
            }
        }
        return null;
    }
}