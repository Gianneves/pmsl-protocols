<?php

namespace App\Http\Resources;

use App\Models\Attendance;
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
            'person' => new PersonResource($this->whenLoaded('person')),
            'departaments' => new DepartamentsResource($this->whenLoaded('departaments')),
            'files' => $this->files,
            'attendances' => AttendanceResource::collection($this->whenLoaded('attendances')),
            'latest_attendance_situation' => $this->latestAttendanceSituation()
        ];
        
    }

    public function latestAttendanceSituation()
    {
        return $this->attendances->last()->situation ?? '';
    }
}
