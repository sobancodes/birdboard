<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\Traits\RecordsActivity;

class Project extends Model
{
    use HasFactory, RecordsActivity;

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function path()
    {
        return '/projects/' . $this->id;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }
}
