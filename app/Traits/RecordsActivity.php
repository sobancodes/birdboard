<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public $oldAttributes = [];

    public static function bootRecordsActivity()
    {
        if (property_exists(get_called_class(), 'recordableEvents')) {
            $recordableEvents = (new self)->recordableEvents;
        } else {
            $recordableEvents = ['created', 'updated', 'deleted'];
        }

        foreach ($recordableEvents as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity("{$event}_" . strtolower(class_basename($model)));
            });

            if ($event == 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->trackedChanges(),
            'project_id' => class_basename($this) == 'Project' ? $this->id : $this->project_id,
        ]);
    }

    protected function trackedChanges()
    {
        $old = Arr::except($this->oldAttributes, ['created_at', 'updated_at']);
        $current = Arr::except($this->getAttributes(), ['created_at', 'updated_at']);

        if ($this->wasChanged()) {
            return [
                'before' => array_diff($old, $current),
                'after' => array_diff($current, $old),
            ];
        }
    }
}
