<?php

namespace App\Jobs;

use App\Contract;
use App\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePropertyStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Contract
     */
    private $contract;
    /**
     * @var null
     */
    private $oldPropertyId;

    /**
     * Create a new job instance.
     *
     * @param Contract $contract
     * @param null $oldPropertyId
     */
    public function __construct(Contract $contract, $oldPropertyId = null)
    {
        $this->contract = $contract;
        $this->oldPropertyId = $oldPropertyId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Atualiza status do imovel ao cadastrar ou editar um contrato

        // retorna se nao alterou o imovel associado ao contrato
        if ($this->oldPropertyId != null && $this->oldPropertyId == $this->contract->property_id) {
            return;
        }

        // Se for edicao volta o status do imovel anterior para nao contratado
        if ($this->oldPropertyId != null) {
            $oldProperty = Property::find($this->oldPropertyId);
            if ($oldProperty instanceof Property) {
                $oldProperty->status = Property::STATUS_AVALIABLE;
                $oldProperty->save();
            }
        }

        // Atualiza o status do imovel atual para contratado
        $property = $this->contract->property()->first();
        if ($property instanceof Property) {
            $property->status = Property::STATUS_HIRED;
            $property->save();
        }

    }
}
