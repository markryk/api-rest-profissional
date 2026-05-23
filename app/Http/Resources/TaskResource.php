<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
//use Illuminate\Support\Carbon;

class TaskResource extends JsonResource {
    
    /*Transform the resource into an array.
    *@return array<string, mixed>*/
    public function toArray(Request $request): array {
        $data = [
            'id' => $this->id,
            'title' => $this->title, 
            'description' => $this->description, 
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
        return $data;
    }
}