<?php

namespace App\Modules\Analytics\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\Analytics\Models\AnalyticsEventModel;
use App\Modules\Profile\Models\ProfileModel;
use App\Modules\ProfileLink\Models\ProfileLinkModel;
use App\Modules\ShortLink\Models\ShortLinkModel;

class AnalyticsController extends BaseController
{
    protected AnalyticsEventModel $model;

    public function __construct()
    {
        $this->model = new AnalyticsEventModel();
        helper(['analytics']);
    }

    public function index(): string
    {
        $todayStats = $this->model->getTodayStats();
        $weeklyStats = $this->model->getWeeklyStats();

        // Get profile view chart data
        $profileViewsDaily = $this->model->getEventCountByDay(
            AnalyticsEventModel::EVENT_PROFILE_VIEW,
            7
        );

        // Get top profiles
        $topProfiles = $this->getTopProfiles();

        // Get top links
        $topProfileLinks = $this->getTopProfileLinks();
        $topShortLinks = $this->getTopShortLinks();

        // Get referrers
        $topReferrers = $this->model->getTopReferrers(5);

        // Device stats
        $deviceStats = $this->model->getDeviceStats();

        $data = [
            'title' => lang('Analytics.admin.title'),
            'todayStats' => $todayStats,
            'weeklyStats' => $weeklyStats,
            'profileViewsDaily' => $profileViewsDaily,
            'topProfiles' => $topProfiles,
            'topProfileLinks' => $topProfileLinks,
            'topShortLinks' => $topShortLinks,
            'topReferrers' => $topReferrers,
            'deviceStats' => $deviceStats,
        ];

        return view('App\Modules\Analytics\Views\admin\index', $data);
    }

    protected function getTopProfiles(int $limit = 5): array
    {
        $profileModel = new ProfileModel();
        $topTargets = $this->model->getTopTargets(AnalyticsEventModel::EVENT_PROFILE_VIEW, $limit);

        $profiles = [];
        foreach ($topTargets as $target) {
            $profile = $profileModel->find($target->target_id);
            if ($profile) {
                $profiles[] = [
                    'profile' => $profile,
                    'views' => $target->count,
                ];
            }
        }

        return $profiles;
    }

    protected function getTopProfileLinks(int $limit = 5): array
    {
        $linkModel = new ProfileLinkModel();
        $topTargets = $this->model->getTopTargets(AnalyticsEventModel::EVENT_PROFILE_LINK_CLICK, $limit);

        $links = [];
        foreach ($topTargets as $target) {
            $link = $linkModel->find($target->target_id);
            if ($link) {
                $links[] = [
                    'link' => $link,
                    'clicks' => $target->count,
                ];
            }
        }

        return $links;
    }

    protected function getTopShortLinks(int $limit = 5): array
    {
        $linkModel = new ShortLinkModel();
        $topTargets = $this->model->getTopTargets(AnalyticsEventModel::EVENT_SHORT_LINK_CLICK, $limit);

        $links = [];
        foreach ($topTargets as $target) {
            $link = $linkModel->find($target->target_id);
            if ($link) {
                $links[] = [
                    'link' => $link,
                    'clicks' => $target->count,
                ];
            }
        }

        return $links;
    }
}
