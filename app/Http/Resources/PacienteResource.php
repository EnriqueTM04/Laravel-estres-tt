<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $tz = config('app.output_timezone', 'America/Mexico_City');

        $fmt = function ($dt) use ($tz) {
            return optional($dt)->timezone($tz)->toIso8601String();
        };

        return [
            'id' => $this->id,
            'user_id' => $this->user_id ?? null,
            'nivel_estres_actual' => $this->nivel_estres_actual ?? null,
            'created_at' => $fmt($this->created_at ?? null),
            'updated_at' => $fmt($this->updated_at ?? null),
        ];
    }
}
