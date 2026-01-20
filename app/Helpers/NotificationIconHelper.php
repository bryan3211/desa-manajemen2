<?php

namespace App\Helpers;

class NotificationIconHelper
{
    /**
     * Get icon emoji untuk notification type
     */
    public static function getIcon($type)
    {
        return [
            'success' => '✅',
            'danger' => '❌',
            'warning' => '⚠️',
            'info' => 'ℹ️',
            'primary' => '📌',
            'secondary' => '📝',
        ][$type] ?? 'ℹ️';
    }

    /**
     * Get icon class untuk notification type
     */
    public static function getIconClass($type)
    {
        return [
            'success' => 'ti ti-check-circle',
            'danger' => 'ti ti-x-circle',
            'warning' => 'ti ti-alert-circle',
            'info' => 'ti ti-info-circle',
            'primary' => 'ti ti-pin',
            'secondary' => 'ti ti-note',
        ][$type] ?? 'ti ti-info-circle';
    }

    /**
     * Get background color untuk icon
     */
    public static function getBgColor($type)
    {
        return [
            'success' => '#d4edda',
            'danger' => '#f8d7da',
            'warning' => '#fff3cd',
            'info' => '#e7f3ff',
            'primary' => '#e0f2fe',
            'secondary' => '#f3f4f6',
        ][$type] ?? '#e7f3ff';
    }

    /**
     * Get text color untuk icon
     */
    public static function getTextColor($type)
    {
        return [
            'success' => '#155724',
            'danger' => '#721c24',
            'warning' => '#856404',
            'info' => '#004085',
            'primary' => '#0369a1',
            'secondary' => '#4b5563',
        ][$type] ?? '#004085';
    }

    /**
     * Get icon untuk notification berdasarkan related_type dan type
     */
    public static function getNotificationIcon($relatedType, $type = 'info')
    {
        $icons = [
            'surat' => [
                'pending' => '📋',
                'diproses' => '⚙️',
                'selesai' => '📄',
                'ditolak' => '❌',
                'revisi' => '✏️',
            ],
            'pengaduan' => [
                'pending' => '📢',
                'diproses' => '🔄',
                'selesai' => '✅',
                'ditolak' => '❌',
                'revisi' => '📝',
            ],
            'biodata' => [
                'pending' => '👤',
                'diproses' => '🔍',
                'terverifikasi' => '✅',
                'ditolak' => '❌',
            ],
        ];

        return $icons[$relatedType][$type] ?? '📬';
    }
}
