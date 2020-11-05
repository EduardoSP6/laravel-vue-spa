<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Http\Requests\ContractRequest;
use App\Jobs\UpdatePropertyStatus;
use App\Repositories\ContractRepository;

class ContractController extends Controller
{
    /**
     * @var ContractRepository
     */
    private $contractRepository;

    /**
     * ContractController constructor.
     * @param ContractRepository $contractRepository
     */
    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function index()
    {
        return $this->contractRepository->with('property')->all();
    }

    public function store(ContractRequest $request)
    {
        $contract = $this->contractRepository->create($request->all());

        $this->dispatch(new UpdatePropertyStatus($contract));

        return response()->json($contract, 201);
    }

    public function edit(Contract $contract)
    {
        $contract = $this->contractRepository->with('property')->find($contract->id);
        return response()->json($contract, 200);
    }

    public function update(ContractRequest $request, Contract $contract)
    {
        $oldPropertyId = $contract->property_id;

        $contract = $this->contractRepository->update($request->all(), $contract->id);

        $this->dispatch(new UpdatePropertyStatus($contract, $oldPropertyId));

        return response()->json($contract, 200);
    }
}
