<?php

namespace App\Traits;

trait HasStatus
{
    /**
     * Scope to filter active records.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to filter inactive records.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Check if the model is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Toggle the status between active and inactive.
     */
    public function toggleStatus(): void
    {
        $this->update([
            'status' => $this->status === 'active' ? 'inactive' : 'active',
        ]);
    }

    /**
     * Get human-readable status label in Bangla.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'active' ? 'সক্রিয়' : 'নিষ্ক্রিয়';
    }

    /**
     * Get CSS class for the status badge.
     */
    public function getStatusClassAttribute(): string
    {
        return $this->status === 'active'
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }
}
