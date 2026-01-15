<?php

namespace App\Modules\ProfileLink\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\ProfileLink\Models\ProfileLinkModel;
use App\Modules\Analytics\Models\AnalyticsEventModel;
use CodeIgniter\HTTP\RedirectResponse;

class ProfileLinkController extends BaseController
{
    protected ProfileLinkModel $model;

    public function __construct()
    {
        $this->model = new ProfileLinkModel();
    }

    /**
     * Redirect to link URL and track click
     */
    public function redirect(int $id): RedirectResponse
    {
        $link = $this->model->find($id);

        if ($link === null || !$link->isActive()) {
            return redirect()->to('/')->with('error', 'Link bulunamadi.');
        }

        // Increment click count
        $this->model->incrementClickCount($id);

        // Log analytics event
        $this->logLinkClick($link);

        // Redirect to target URL
        return redirect()->to($link->url);
    }

    protected function logLinkClick($link): void
    {
        try {
            $analyticsModel = new AnalyticsEventModel();
            $analyticsModel->logEvent(
                'profile_link_click',
                $link->id,
                $this->request->getUserAgent()->getAgentString(),
                $this->request->getHeaderLine('Referer') ?: null,
                session()->get('user_id')
            );
        } catch (\Exception $e) {
            log_message('error', 'Failed to log link click: ' . $e->getMessage());
        }
    }
}
