<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'created_data' => Carbon::parse($this->created_data)->format('d/m/Y'),
            'deadline' => $this->deadline,
            'people' => new PersonResource($this->whenLoaded('people'))
        ];
    }
}