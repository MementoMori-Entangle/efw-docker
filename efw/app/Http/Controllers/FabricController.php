<?php

namespace App\Http\Controllers;

use App\Util;
use App\Models\Fabric;
use App\Models\FabricImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FabricController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fabric = DB::table('fabrics')
                    ->join('fabric_images', 'fabrics.id', '=', 'fabric_images.id')
                    ->select('fabrics.id', 'fabrics.name', 'fabric_images.physics_name', 'fabric_images.logic_name'
                           , 'fabric_images.json_name', 'fabric_images.svg_name')
                    ->get();

        return view('fabric', ['fabric' => $fabric]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isSave = true;
        $fabric = new Fabric();
        $fabricImage = new FabricImage();

        if (isset($request['name']) && !empty($request['name'])) {
            $fabric->name = $request['name'];
        } else {
            $isSave = false;
        }

        if (isset($request['image_physics_name']) && !empty($request['image_physics_name'])) {
            $fabricImage->physics_name = $request['image_physics_name'];
        }

        if (isset($request['image_logic_name']) && !empty($request['image_logic_name'])) {
            $fabricImage->logic_name = $request['image_logic_name'];
        }

        $util = new Util();

        if (isset($request['image_json']) && !empty($request['image_json'])) {
            $fileName = $util->getFileUploadPhysicsFileName() . '.json';
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/output/json/' . $fileName;

            file_put_contents($filePath, $request['image_json']);

            $fabricImage->json_name = $fileName;
        }

        if (isset($request['image_svg']) && !empty($request['image_svg'])) {
            $fileName = $util->getFileUploadPhysicsFileName() . '.svg';
            $filePath = $_SERVER['DOCUMENT_ROOT'] . '/output/svg/' . $fileName;

            file_put_contents($filePath, $request['image_svg']);

            $fabricImage->svg_name = $fileName;
        }

        if ($isSave) {
            $fabric->save();
            $fabricImage->id = $fabric->id;
            $fabricImage->save();
        }

        return redirect('/fabric');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param Integer $id ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $fabricImage = FabricImage::find($id);
        $fabric = Fabric::find($id);

        $fabricImage->delete();
        $fabric->delete();

        return redirect('/fabric');
    }
}
