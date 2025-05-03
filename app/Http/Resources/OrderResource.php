<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'pickup_address' => $this->pickup_address,
            'destination' => $this->destination,
            'route' => $this->route,
            'vehicle_count' => $this->vehicle_count,
            'vehicle_type' => $this->vehicle_type,
            'driver_name' => $this->driver_name,
            'rental_price' => $this->rental_price,
            'down_payment' => $this->down_payment,
            'remaining_cost' => $this->remaining_cost,
            'status' => $this->status,
            'additional_notes' => $this->additional_notes,
            'customer' => new UserResource($this->whenLoaded('user')),
            'driver' => new DriverResource($this->whenLoaded('driver')),
            'vehicle' => new VehicleResource($this->whenLoaded('vehicle')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
