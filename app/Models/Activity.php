<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Pastikan baris ini ada di atas

class Activity extends Model
{
    use SoftDeletes; // <-- Pastikan baris ini ada di dalam class

    protected $fillable = ['code', 'title', 'description', 'activity_date', 'status', 'category_id'];
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    public function scopeFilterStatus($query, $status)
    {
        $validStatuses = ['Draft', 'Published', 'Completed'];

        if (in_array($status, $validStatuses)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}