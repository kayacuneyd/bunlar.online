<?php

namespace App\Modules\ProfileLink\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\ProfileLink\Models\ProfileLinkModel;
use App\Modules\Profile\Models\ProfileModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileLinkController extends BaseController
{
    protected ProfileLinkModel $model;
    protected ProfileModel $profileModel;

    public function __construct()
    {
        $this->model = new ProfileLinkModel();
        $this->profileModel = new ProfileModel();
        helper(['form', 'profilelink']);
    }

    public function index(): string
    {
        $profileId = $this->request->getGet('profile_id');
        $profile = null;

        if ($profileId) {
            $profile = $this->profileModel->find($profileId);
            $items = $this->model->getByProfileId($profileId);
        } else {
            $items = $this->model->orderBy('created_at', 'DESC')->findAll();
        }

        $data = [
            'title' => lang('ProfileLink.admin.title'),
            'items' => $items,
            'profile' => $profile,
            'profiles' => $this->profileModel->findAll(),
        ];

        return view('App\Modules\ProfileLink\Views\admin\index', $data);
    }

    public function create(): string
    {
        $profileId = $this->request->getGet('profile_id');
        $profile = $profileId ? $this->profileModel->find($profileId) : null;

        $data = [
            'title' => lang('ProfileLink.admin.create'),
            'item' => null,
            'profile' => $profile,
            'profiles' => $this->profileModel->findAll(),
            'icons' => $this->getIcons(),
        ];

        return view('App\Modules\ProfileLink\Views\admin\create', $data);
    }

    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();

        // Set next position
        $data['position'] = $this->model->getNextPosition($data['profile_id']);

        // Handle checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/profile-links?profile_id=' . $data['profile_id'])
            ->with('message', lang('ProfileLink.messages.created'));
    }

    public function edit(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profile-links')
                ->with('error', lang('ProfileLink.messages.not_found'));
        }

        $data = [
            'title' => lang('ProfileLink.admin.edit'),
            'item' => $item,
            'profile' => $this->profileModel->find($item->profile_id),
            'profiles' => $this->profileModel->findAll(),
            'icons' => $this->getIcons(),
        ];

        return view('App\Modules\ProfileLink\Views\admin\edit', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profile-links')
                ->with('error', lang('ProfileLink.messages.not_found'));
        }

        $data = $this->request->getPost();

        // Handle checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (!$this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/profile-links?profile_id=' . $item->profile_id)
            ->with('message', lang('ProfileLink.messages.updated'));
    }

    public function delete(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profile-links')
                ->with('error', lang('ProfileLink.messages.not_found'));
        }

        $profileId = $item->profile_id;
        $this->model->delete($id);

        return redirect()->to('/admin/profile-links?profile_id=' . $profileId)
            ->with('message', lang('ProfileLink.messages.deleted'));
    }

    public function reorder(): ResponseInterface
    {
        $positions = $this->request->getJSON(true);

        if (empty($positions)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No data provided']);
        }

        $result = $this->model->updatePositions($positions);

        return $this->response->setJSON([
            'success' => $result,
            'message' => $result ? 'Order updated' : 'Failed to update order'
        ]);
    }

    protected function getIcons(): array
    {
        return [
            '' => 'Yok',
            '🔗' => '🔗 Link',
            '🌐' => '🌐 Web',
            '📧' => '📧 Email',
            '📱' => '📱 Telefon',
            '💼' => '💼 Is',
            '🛒' => '🛒 Alisveris',
            '📺' => '📺 Video',
            '🎵' => '🎵 Muzik',
            '📷' => '📷 Fotograf',
            '📝' => '📝 Blog',
            '💬' => '💬 Mesaj',
            '📍' => '📍 Konum',
            '🎮' => '🎮 Oyun',
            '📚' => '📚 Kitap',
            '🎨' => '🎨 Sanat',
            '💰' => '💰 Odeme',
            '☕' => '☕ Kahve',
        ];
    }
}
