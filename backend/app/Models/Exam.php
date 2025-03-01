<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    protected $guarded = [];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Relationship with questions
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_question');
    }
}
