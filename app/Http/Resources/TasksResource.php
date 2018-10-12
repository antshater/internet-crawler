<?php

namespace App\Http\Resources;

use App\Task;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Task */
class TasksResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'         => $this->id,
            'status'     => $this->status,
            'error'      => $this->error,
            'url'        => $this->url,
            'result_url' => $this->resultUrl(),
        ];
    }
}
