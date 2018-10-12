<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Storage;

/**
 * App\Task
 *
 * @property int $id
 * @property string $status
 * @property string $url
 * @property string|null $result_url
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereResultUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUrl($value)
 * @mixin \Eloquent
 */
class Task extends Model {

    const STATUS_PENDING     = 'pending';
    const STATUS_DOWNLOADING = 'downloading';
    const STATUS_COMPLETE    = 'complete';
    const STATUS_ERROR       = 'error';

    protected $fillable = [
        'url',
        'status',
    ];

    public function scopeSorted(Builder $builder) {
        $builder->orderBy('id', 'DESC');
    }

    public function resultUrl() {
        return $this->result_url ? Storage::url($this->result_url) : null;
    }
}
