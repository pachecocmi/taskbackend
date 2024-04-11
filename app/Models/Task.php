<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'status'];

    const STATUS_TODO = 0;
    const STATUS_DONE = 1;

    /**
     * Check if the task is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_TODO;
    }

    /**
     * Check if the task is completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_DONE;
    }

    /**
     * Set the status of the task.
     *
     * @param int $status
     * @return void
     * @throws InvalidArgumentException
     */
    public function setStatus(int $status): void
    {
        if (!in_array($status, [self::STATUS_TODO, self::STATUS_DONE])) {
            throw new Exception('Invalid status value.');
        }

        $this->status = $status;
    }
}
