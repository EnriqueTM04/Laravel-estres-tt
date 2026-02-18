<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstresRegistroResource extends JsonResource
{
    public function toArray($request)
    {
        $tz = config('app.output_timezone', 'America/Mexico_City');
        return [
            'id' => $this->id,
            'score' => (int) $this->score,
            'created_at' => optional($this->created_at)->timezone($tz)->toIso8601String(),
        ];
    }
}
