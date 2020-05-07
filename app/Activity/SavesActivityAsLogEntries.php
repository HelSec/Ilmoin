<?php

namespace App\Activity;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait SavesActivityAsLogEntries
{
    use HasActivityLogEntries;

    private $pendingChanges = [];

    /**
     * @return array
     */
    public function getFieldToModelTypes(): array
    {
        return isset($this->fieldToModelTypes) ? $this->fieldToModelTypes : [];
    }

    public function getFieldName($field)
    {
        if (Str::endsWith($field, '_id')) {
            $field = substr($field, 0, strlen($field) - 3);
        }

        return __($this->getFieldNameTranslationPrefix() . $field);
    }

    /**
     * @return array
     */
    public function getPendingChanges(): array
    {
        return $this->pendingChanges;
    }

    public function clearPendingChanges(): void
    {
        $this->pendingChanges = [];
    }

    public function addPendingChange(string $key, $original, $new)
    {
        if ($original === $new) {
            return;
        }

        $this->pendingChanges[$key] = ['original' => $original, 'new' => $new];
    }

    public function savePendingChanges()
    {
        $diff = $this->getPendingChanges();

        if (empty($diff)) {
            return;
        }

        $userId = $this->getActorId();

        ActivityLogEntry::create([
            'user_id' => $userId,
            'model_id' => $this->id,
            'model_type' => get_class($this),
            'data' => ['diff' => $diff],
        ]);

        $this->clearPendingChanges();
    }

    public function saveAllChanges()
    {
        $fieldChanges = collect($this->getChanges())
            ->mapWithKeys(function ($item, $key) {
                $original = $this->getOriginal($key);

                if ($this->hasCast($key)) {
                    $original = $this->publicCastAttribute($key, $original);
                }

                return [$key => ['original' => $original, 'new' => $item]];
            })
            ->reject(function ($item, $key) {
                return $key === 'updated_at' || in_array($key, $this->getHidden());
            })
            ->toArray();
        $diff = array_merge($fieldChanges, $this->getPendingChanges());
        $this->clearPendingChanges();

        if (empty($diff)) {
            return;
        }

        $userId = $this->getActorId();

        ActivityLogEntry::create([
            'user_id' => $userId,
            'model_id' => $this->id,
            'model_type' => get_class($this),
            'data' => ['diff' => $diff],
        ]);
    }

    public static function bootSavesActivityAsLogEntries()
    {
        static::created(function (Model $model) {
            $model->saveAllChanges();
        });

        static::updated(function (Model $model) {
            $model->saveAllChanges();
        });
    }

    public function publicCastAttribute($key, $value)
    {
        return $this->castAttribute($key, $value);
    }

    public abstract function getFieldNameTranslationPrefix();
}
