<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * PropertyController constructor.
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function index()
    {
        return $this->propertyRepository->all();
    }

    public function store(PropertyRequest $request)
    {
        $property = $this->propertyRepository->create($request->all());
        return response()->json($property, 201);
    }

    public function edit(Property $property)
    {
        $property = $this->propertyRepository->find($property->id);
        return response()->json($property, 200);
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $property = $this->propertyRepository->update($request->all(), $property->id);
        return response()->json($property, 200);
    }

    public function destroy(Property $property)
    {
        $ret = $this->propertyRepository->delete($property->id);
        return response()->json(['success' => $ret], 200);
    }

    public function getAvaliable()
    {
        return $this->propertyRepository
            ->orderBy('street')
            ->findWhere(['status' => Property::STATUS_AVALIABLE])
            ->all();
    }
}
