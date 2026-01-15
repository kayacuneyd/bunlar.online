<?php

namespace App\Modules\Analytics\Models;

use CodeIgniter\Model;
use App\Modules\Analytics\Entities\AnalyticsEvent;

class AnalyticsEventModel extends Model
{
    protected $table = 'analytics_events';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = AnalyticsEvent::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'event_type',
        'target_id',
        'user_agent',
        'referrer',
        'created_at',
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    protected $skipValidation = true;

    // Event types
    const EVENT_PROFILE_VIEW = 'profile_view';
    const EVENT_PROFILE_LINK_CLICK = 'profile_link_click';
    const EVENT_SHORT_LINK_CLICK = 'short_link_click';

    public function logEvent(
        string $eventType,
        int $targetId,
        ?string $userAgent = null,
        ?string $referrer = null,
        ?int $userId = null
    ): bool {
        return $this->insert([
            'event_type' => $eventType,
            'target_id' => $targetId,
            'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
            'referrer' => $referrer ? substr($referrer, 0, 500) : null,
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getEventsByType(string $eventType, int $limit = 100): array
    {
        return $this->where('event_type', $eventType)
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    public function getEventsByTargetId(int $targetId, string $eventType): array
    {
        return $this->where('target_id', $targetId)
            ->where('event_type', $eventType)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function countEventsByType(string $eventType): int
    {
        return $this->where('event_type', $eventType)->countAllResults();
    }

    public function countEventsByTargetId(int $targetId, string $eventType): int
    {
        return $this->where('target_id', $targetId)
            ->where('event_type', $eventType)
            ->countAllResults();
    }

    public function getEventCountByDay(string $eventType, int $days = 7): array
    {
        $startDate = date('Y-m-d', strtotime("-{$days} days"));

        $results = $this->select("DATE(created_at) as date, COUNT(*) as count")
            ->where('event_type', $eventType)
            ->where('created_at >=', $startDate)
            ->groupBy('DATE(created_at)')
            ->orderBy('date', 'ASC')
            ->findAll();

        // Fill missing dates with 0
        $data = [];
        for ($i = $days; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $data[$date] = 0;
        }

        foreach ($results as $row) {
            $data[$row->date] = (int) $row->count;
        }

        return $data;
    }

    public function getEventCountByHour(string $eventType, int $hours = 24): array
    {
        $startTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

        $results = $this->select("strftime('%Y-%m-%d %H:00', created_at) as hour, COUNT(*) as count")
            ->where('event_type', $eventType)
            ->where('created_at >=', $startTime)
            ->groupBy("strftime('%Y-%m-%d %H:00', created_at)")
            ->orderBy('hour', 'ASC')
            ->findAll();

        return $results;
    }

    public function getTopTargets(string $eventType, int $limit = 10): array
    {
        return $this->select('target_id, COUNT(*) as count')
            ->where('event_type', $eventType)
            ->groupBy('target_id')
            ->orderBy('count', 'DESC')
            ->findAll($limit);
    }

    public function getTopReferrers(int $limit = 10): array
    {
        return $this->select('referrer, COUNT(*) as count')
            ->where('referrer IS NOT NULL')
            ->where('referrer !=', '')
            ->groupBy('referrer')
            ->orderBy('count', 'DESC')
            ->findAll($limit);
    }

    public function getBrowserStats(): array
    {
        $events = $this->where('user_agent IS NOT NULL')
            ->findAll(1000);

        $browsers = [];
        foreach ($events as $event) {
            $browser = $event->getBrowserName() ?? 'Unknown';
            if (!isset($browsers[$browser])) {
                $browsers[$browser] = 0;
            }
            $browsers[$browser]++;
        }

        arsort($browsers);
        return $browsers;
    }

    public function getDeviceStats(): array
    {
        $events = $this->where('user_agent IS NOT NULL')
            ->findAll(1000);

        $mobile = 0;
        $desktop = 0;

        foreach ($events as $event) {
            if ($event->isMobile()) {
                $mobile++;
            } else {
                $desktop++;
            }
        }

        return [
            'mobile' => $mobile,
            'desktop' => $desktop,
        ];
    }

    public function getTodayStats(): array
    {
        $today = date('Y-m-d');

        return [
            'profile_views' => $this->where('event_type', self::EVENT_PROFILE_VIEW)
                ->where('DATE(created_at)', $today)
                ->countAllResults(),
            'profile_link_clicks' => $this->where('event_type', self::EVENT_PROFILE_LINK_CLICK)
                ->where('DATE(created_at)', $today)
                ->countAllResults(),
            'short_link_clicks' => $this->where('event_type', self::EVENT_SHORT_LINK_CLICK)
                ->where('DATE(created_at)', $today)
                ->countAllResults(),
        ];
    }

    public function getWeeklyStats(): array
    {
        $startDate = date('Y-m-d', strtotime('-7 days'));

        return [
            'profile_views' => $this->where('event_type', self::EVENT_PROFILE_VIEW)
                ->where('created_at >=', $startDate)
                ->countAllResults(),
            'profile_link_clicks' => $this->where('event_type', self::EVENT_PROFILE_LINK_CLICK)
                ->where('created_at >=', $startDate)
                ->countAllResults(),
            'short_link_clicks' => $this->where('event_type', self::EVENT_SHORT_LINK_CLICK)
                ->where('created_at >=', $startDate)
                ->countAllResults(),
        ];
    }

    public function cleanOldEvents(int $daysToKeep = 90): int
    {
        $cutoffDate = date('Y-m-d', strtotime("-{$daysToKeep} days"));

        return $this->where('created_at <', $cutoffDate)->delete();
    }
}
