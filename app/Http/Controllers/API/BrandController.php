<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Facades\DB;

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
    public function store(CreateBrandRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->service->create($request);

            DB::commit();
            return ResponseHelper::ok($data);
        } catch (\Exception $e) {
            DB::rollBack();

            return ResponseHelper::error([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $collection = $this->service->read($id);

            return ResponseHelper::ok($collection);
        } catch (\Exception $e) {

            return ResponseHelper::error([
                'message' => $e->getMessage(),
            ]);
        }
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
    public function update(UpdateBrandRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $data = $this->service->update($request, $id);

            DB::commit();
            return ResponseHelper::ok($data);
        } catch (\Exception $e) {
            DB::rollBack();

            return ResponseHelper::error([
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $this->service->delete($id);

            DB::commit();
            return ResponseHelper::ok([
                'message' => 'Selected brand has been deleted',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return ResponseHelper::error([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
