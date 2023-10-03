<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Job extends Model
{
    use HasFactory;

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public static array $experience = [
        'entry', 'intermediate', 'senior'
    ];
    public static array $category = [
        'IT', 'Finance', 'Sales', 'Marketing'
    ];

    public function scopeFilter(Builder|QueryBuilder $query, array $filters): Builder|QueryBuilder

    // usiamo le regex per sostituire request('xxx') con $filters['xxx']
    // request\('([a-z_]+)'\) --> $filters['$1']
    // le tonde definiscono un gruppo di caratteri che viene richiamato e sostituito con $1 (1 perché è il primo gruppo)

    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    // per usare where su una relazione (employer) dobbiamo usare whereHas o in questo caso orWhereHas
                    ->orWhereHas('employer', function ($query) use ($search) {
                        $query->where('company_name', 'LIKE', '%' . $search . '%');
                    });
            });
        })->when($filters['min_salary'] ?? null, function ($query, $minSalary) {
            $query->where('salary', '>=', $minSalary);
        })->when($filters['max_salary'] ?? null, function ($query, $maxSalary) {
            $query->where('salary', '<=', $maxSalary);
        })->when($filters['experience'] ?? null, function ($query, $experience) {
            $query->where('experience', $experience);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category', $category);
        });
    }

    // prendiamo un job che abbia l'id del Job corrente
    // controlliamo che nelle JobApplications con cui è in relazione
    // esista una delle JobApplication ha lo stesso user_id del parametro $user 
    public function hasUserApplied(Authenticatable|User|int $user): bool
    {
        return $this->where('id', $this->id)
            ->whereHas(
                'jobApplications',
                fn ($query) => $query->where('user_id', '=', $user->id ?? $user)
            )->exists();
    }
}
