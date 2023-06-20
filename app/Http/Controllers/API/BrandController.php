<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;

class BrandController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new \App\Services\BrandService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $collection = $this->service->all();

            return ResponseHelper::ok($collection);
        } catch (\Exception $e) {

            return ResponseHelper::error([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
