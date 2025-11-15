<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'account_id',
        'owner_id',
        'reports_to_id',
        'salutation',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'secondary_email',
        'phone',
        'mobile',
        'whatsapp',
        'fax',
        'title',
        'department',
        'birthdate',
        'linkedin_url',
        'mailing_street',
        'mailing_city',
        'mailing_state',
        'mailing_postal_code',
        'mailing_country',
        'lead_source',
        'lead_source_description',
        'status',
        'email_opt_out',
        'do_not_call',
        'sms_opt_out',
        'engagement_score',
        'last_contacted_at',
        'last_activity_at',
        'last_email_opened_at',
        'last_email_clicked_at',
        'description',
        'custom_fields',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'email_opt_out' => 'boolean',
        'do_not_call' => 'boolean',
        'sms_opt_out' => 'boolean',
        'last_contacted_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'last_email_opened_at' => 'datetime',
        'last_email_clicked_at' => 'datetime',
        'custom_fields' => 'array',
    ];

    protected $appends = ['full_name'];

    // Accessors
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function reportsTo()
    {
        return $this->belongsTo(Contact::class, 'reports_to_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Contact::class, 'reports_to_id');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'related_to');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function scopeActive(Builder $query): Builder // <-- 2. BU FONKSİYONU EKLEYİN
    {
        // "Aktif" tanımınız ne ise onu buraya yazın.
        // Veritabanınızda 'status' adında bir sütun olduğunu varsayıyorum.
        // Eğer 'is_active' gibi boolean bir sütunsa:
        // return $query->where('is_active', true);

        // 'status' sütunu 'active' olanları varsayıyorum:
        return $query->where('status', 'active');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}