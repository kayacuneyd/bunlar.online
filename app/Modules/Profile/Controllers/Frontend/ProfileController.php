<?php

namespace App\Modules\Profile\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Modules\Profile\Models\ProfileModel;
use App\Modules\ProfileLink\Models\ProfileLinkModel;
use App\Modules\Analytics\Models\AnalyticsEventModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    protected ProfileModel $model;

    public function __construct()
    {
        $this->model = new ProfileModel();
        helper(['profile']);
    }

    public function show(string $username): string|RedirectResponse
    {
        $profile = $this->model->findByUsername($username);

        if ($profile === null || !$profile->isActive()) {
            return redirect()->to('/')
                ->with('error', lang('Profile.messages.not_found'));
        }

        // Increment view count
        $this->model->incrementViewCount($profile->id);

        // Log analytics event
        $this->logProfileView($profile->id);

        // Get profile links
        $linkModel = new ProfileLinkModel();
        $links = $linkModel->getActiveByProfileId($profile->id);

        $data = [
            'title' => $profile->display_name . ' | bunlar.online',
            'profile' => $profile,
            'links' => $links,
        ];

        return view('App\Modules\Profile\Views\frontend\show', $data);
    }

    public function qrCode(string $username): ResponseInterface
    {
        $profile = $this->model->findByUsername($username);

        if ($profile === null) {
            return $this->response->setStatusCode(404);
        }

        $url = site_url($profile->username);

        // Generate QR code using Google Charts API
        $qrApiUrl = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . urlencode($url) . '&choe=UTF-8';

        // Fetch QR code image
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $qrApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $imageData = curl_exec($ch);
        curl_close($ch);

        if ($imageData === false) {
            return $this->response->setStatusCode(500);
        }

        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $profile->username . '-qr.png"')
            ->setBody($imageData);
    }

    public function qrCodePage(string $username): string|RedirectResponse
    {
        $profile = $this->model->findByUsername($username);

        if ($profile === null || !$profile->isActive()) {
            return redirect()->to('/')
                ->with('error', lang('Profile.messages.not_found'));
        }

        $data = [
            'title' => $profile->display_name . ' - QR Code',
            'profile' => $profile,
        ];

        return view('App\Modules\Profile\Views\frontend\qrcode', $data);
    }

    protected function logProfileView(int $profileId): void
    {
        try {
            $analyticsModel = new AnalyticsEventModel();
            $analyticsModel->logEvent(
                'profile_view',
                $profileId,
                $this->request->getUserAgent()->getAgentString(),
                $this->request->getHeaderLine('Referer') ?: null,
                session()->get('user_id')
            );
        } catch (\Exception $e) {
            log_message('error', 'Failed to log profile view: ' . $e->getMessage());
        }
    }
}
