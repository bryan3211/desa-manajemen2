<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'actor_id',
        'title',
        'message',
        'type',
        'related_type',
        'related_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $appends = [
        'icon_emoji',
        'icon_class',
        'icon_bg_color',
        'icon_text_color',
    ];

    /**
     * Relasi ke User (penerima notifikasi)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke User (pembuat aksi/actor)
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Get admin yang membuat notifikasi ini (dari biodata.verified_by)
     */
    public function admin()
    {
        if ($this->related_type === 'biodata' && $this->related_id) {
            $biodata = \App\Models\Biodata::find($this->related_id);
            if ($biodata && $biodata->verified_by) {
                return $biodata->verifiedBy;
            }
        }
        return null;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Get unread notifications count
     */
    public static function getUnreadCount($userId)
    {
        return self::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get unread notifications
     */
    public static function getUnread($userId, $limit = 10)
    {
        return self::where('user_id', $userId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get notification icon emoji
     */
    public function getIconEmojiAttribute()
    {
        return \App\Helpers\NotificationIconHelper::getNotificationIcon($this->related_type, $this->type);
    }

    /**
     * Get notification icon class (Tabler Icons)
     */
    public function getIconClassAttribute()
    {
        return \App\Helpers\NotificationIconHelper::getIconClass($this->type);
    }

    /**
     * Get notification icon background color
     */
    public function getIconBgColorAttribute()
    {
        return \App\Helpers\NotificationIconHelper::getBgColor($this->type);
    }

    /**
     * Get notification icon text color
     */
    public function getIconTextColorAttribute()
    {
        return \App\Helpers\NotificationIconHelper::getTextColor($this->type);
    }
}
