<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommonPaginationRequest;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Api\v1\CommonPaginationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CommonPaginationRequest $request)
    {
        $data = Tag::query();

        if ($request->has('search')) {
            $search = '%'.$request->search.'%';
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', 'like', $search);
            });
        }

        if ($request->has('page')) {
            return response()->json(
                collect([
                    'message' => __('messages.tag_list_returned'),
                    'status' => '1',
                ])->merge($data->simplePaginate($request->has('per_page') ? $request->per_page : 10))
            );
        }

        return response()->json([
            'data' => $data->get(),
            'message' => __('messages.tag_list_returned'),
            'status' => '1',
        ]);
    }
}
