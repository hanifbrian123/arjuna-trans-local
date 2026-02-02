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
            'order_num' => $this->order_num,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'start_date_formatted' => $this->start_date ? $this->start_date->format('d/m/Y, H:i') : null,
            'end_date_formatted' => $this->end_date ? $this->end_date->format('d/m/Y, H:i') : null,
            'pickup_address' => $this->pickup_address,
            'destination' => $this->destination,
            'route' => $this->route,
            'vehicle_count' => $this->vehicle_count,
            'vehicle_type' => $this->vehicle_type,
            'driver_name' => $this->driver_name,
            'rental_price' => $this->rental_price,
            'rental_price_formatted' => 'Rp ' . number_format($this->rental_price, 0, ',', '.'),
            'down_payment' => $this->down_payment,
            'down_payment_formatted' => $this->down_payment ? 'Rp ' . number_format($this->down_payment, 0, ',', '.') : 'Rp 0',
            'remaining_cost' => $this->remaining_cost,
            'remaining_cost_formatted' => $this->remaining_cost ? 'Rp ' . number_format($this->remaining_cost, 0, ',', '.') : 'Rp 0',
            'is_paid' => $this->remaining_cost <= 0,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'additional_notes' => $this->additional_notes,
            'customer' => new UserResource($this->whenLoaded('user')),
            'drivers' => DriverResource::collection($this->whenLoaded('drivers')),
            'vehicles' => VehicleResource::collection($this->whenLoaded('vehicles')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get human-readable status label
     *
     * @return string
     */
    private function getStatusLabel(): string
    {
        $labels = [
            'waiting' => 'Menunggu',
            'approved' => 'Disetujui',
            'canceled' => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? $this->status;
    }
}

