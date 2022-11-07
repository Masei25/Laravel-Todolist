<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;

    private $isPending = 'PENDING';
    private $inProgress = 'IN PROGRESS';
    private $isCompleted = 'COMPLETED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'task_name',
        'end_date',
        'status',
        'assigned_to',
    ];

    public function inProgress()
    {
        return $this->inProgress;
    }

    public function isPending()
    {
        return $this->isPending;
    }

    public function isCompleted()
    {
        return $this->isCompleted;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
