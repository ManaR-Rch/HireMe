<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Candidature extends Model
{
    use Notifiable;

    protected $fillable = ['user_id', 'annonce_id', 'cv_path', 'motivation_letter_path', 'status', 'feedback'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}