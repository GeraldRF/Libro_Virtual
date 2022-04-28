<?php

namespace App\Http\Controllers;

use App\Http\Resources\LegendResource;
use App\Legend;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class LegendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $legends = Legend::all();

        return LegendResource::collection($legends);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'img_url' => 'required|string',
            'name' => 'required|string|max:60',
            'description' => 'required|string',
            'origin_province' => 'required|string|max:50',
            'origin_date' => 'required|date',
        ]);

        $legend = Legend::create($validated);
        return new LegendResource($legend);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Legend  $legend
     * @return \Illuminate\Http\Response
     */
    public function show($legend_id)
    {
        $legend = Legend::find($legend_id);
        return new LegendResource($legend);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Legend  $legend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $legend_id)
    {
        $validated = $request->validate([
            'img_url' => 'string',
            'name' => 'required|string|max:60',
            'description' => 'required|string',
            'origin_province' => 'required|string|max:50',
            'origin_date' => 'required|date',
        ]);

        $legend = Legend::find($legend_id);
        $legend->update($validated);
        return new LegendResource($legend);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Legend  $legend
     * @return \Illuminate\Http\Response
     */
    public function destroy($legend_id)
    {
        $legend = Legend::find($legend_id);
        $legend->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $imageName = time() . '.' . $request->image->extension();


            $request->image->move(public_path('uploads'), $imageName);
        } catch (UploadException $ex) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response(['url' => $imageName], Response::HTTP_CREATED);
    }

    public function getUpload($url)
    {
        $path = public_path('uploads/' . $url);

        return response()->file($path);
    }
}
