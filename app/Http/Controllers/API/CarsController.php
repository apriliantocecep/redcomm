<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Repositories\CarRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Support\Facades\DB;

class CarsController extends Controller
{
    private $service;
    private $servicePhoto;

    public function __construct()
    {
        $this->authorizeResource(\App\Models\Car::class, 'car');

        $this->service = new \App\Services\CarService(new CarRepository);
        $this->servicePhoto = new \App\Services\PhotoService(new PhotoRepository);
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
    public function store(CreateCarRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = auth('api')->user();

            $collection = $this->service->create($request->merge([
                'user_id' => $user->id,
            ]));

            // upload file
            if ($request->hasFile('photos')) {

                // validate max count photos
                if (is_array($request->file('photos')) && count($request->file('photos')) > 10) {
                    throw new \Exception("Only 10 photos can be uploaded", 1);
                }

                foreach ($request->file('photos') as $file) {
                    $path = $file->store('photos');

                    $requestPhoto = new \App\Http\Requests\CreatePhotoRequest([
                        'car_id' => $collection->id,
                        'image' => $path,
                    ]);
                    $this->servicePhoto->create($requestPhoto);
                }

                // single photo
                // $path = $request->file('photos')->store('photos');
                // $requestPhoto = new \App\Http\Requests\CreatePhotoRequest([
                //     'car_id' => $collection->id,
                //     'image' => $path,
                // ]);
                // $this->servicePhoto->create($requestPhoto);
            }

            DB::commit();
            return ResponseHelper::ok($collection);
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
    public function show(Car $car)
    {
        try {
            $collection = $this->service->read($car->id);

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
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        DB::beginTransaction();

        try {
            $user = auth('api')->user();

            $collection = $this->service->update($request, $car->id);

            // upload file
            if ($request->hasFile('photos')) {

                // validate max count photos
                if (is_array($request->file('photos')) && count($request->file('photos')) > 10) {
                    throw new \Exception("Only 10 photos can be uploaded", 1);
                }

                // delete old photos
                foreach ($collection->photos as $photo) {
                    $this->servicePhoto->delete($photo->id);
                }

                foreach ($request->file('photos') as $file) {
                    $path = $file->store('photos');

                    $requestPhoto = new \App\Http\Requests\CreatePhotoRequest([
                        'car_id' => $collection->id,
                        'image' => $path,
                    ]);
                    $this->servicePhoto->create($requestPhoto);
                }
            }

            DB::commit();
            return ResponseHelper::ok($collection);
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
    public function destroy(Car $car)
    {
        DB::beginTransaction();

        try {
            $this->service->delete($car->id);

            DB::commit();
            return ResponseHelper::ok([
                'message' => 'Selected car has been deleted',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return ResponseHelper::error([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
