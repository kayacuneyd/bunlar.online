<?php

namespace App\Modules\ShortLink\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\ShortLink\Models\ShortLinkModel;
use App\Modules\Analytics\Models\AnalyticsEventModel;
use CodeIgniter\HTTP\RedirectResponse;

class ShortLinkController extends BaseController
{
    protected ShortLinkModel $model;

    public function __construct()
    {
        $this->model = new ShortLinkModel();
    }

    /**
     * Redirect to target URL
     */
    public function redirect(string $code): RedirectResponse|string
    {
        $link = $this->model->findByCode($code);

        // Link not found
        if ($link === null) {
            return $this->showError('Link bulunamadi.', 404);
        }

        // Link is inactive
        if (!$link->isActive()) {
            return $this->showError('Bu link artik aktif degil.', 410);
        }

        // Link is expired
        if ($link->isExpired()) {
            return $this->showError('Bu linkin suresi dolmus.', 410);
        }

        // Increment click count
        $this->model->incrementClickCount($link->id);

        // Log analytics event
        $this->logShortLinkClick($link);

        // Redirect to target URL (302 redirect)
        return redirect()->to($link->target_url);
    }

    protected function showError(string $message, int $statusCode): string
    {
        $this->response->setStatusCode($statusCode);

        return view('App\Modules\ShortLink\Views\frontend\error', [
            'title' => 'Link Hatasi',
            'message' => $message,
        ]);
    }

    protected function logShortLinkClick($link): void
    {
        try {
            $analyticsModel = new AnalyticsEventModel();
            $analyticsModel->logEvent(
                'short_link_click',
                $link->id,
                $this->request->getUserAgent()->getAgentString(),
                $this->request->getHeaderLine('Referer') ?: null,
                $link->user_id
            );
        } catch (\Exception $e) {
            log_message('error', 'Failed to log short link click: ' . $e->getMessage());
        }
    }
}
