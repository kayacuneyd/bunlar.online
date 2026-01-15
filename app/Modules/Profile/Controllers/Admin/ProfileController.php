<?php

namespace App\Modules\Profile\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\Profile\Models\ProfileModel;
use CodeIgniter\HTTP\RedirectResponse;

class ProfileController extends BaseController
{
    protected ProfileModel $model;

    public function __construct()
    {
        $this->model = new ProfileModel();
        helper(['form', 'profile']);
    }

    public function index(): string
    {
        $data = [
            'title' => lang('Profile.admin.title'),
            'items' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('App\Modules\Profile\Views\admin\index', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => lang('Profile.admin.create'),
            'item' => null,
            'themes' => $this->getThemes(),
        ];

        return view('App\Modules\Profile\Views\admin\create', $data);
    }

    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();

        // Set user_id from session
        $data['user_id'] = session()->get('user_id') ?? 1;

        // Check username availability
        if (!$this->model->isUsernameAvailable($data['username'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', lang('Profile.messages.username_taken'));
        }

        // Handle checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        // Handle avatar upload
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            $newName = $avatar->getRandomName();
            $avatar->move(WRITEPATH . '../public/uploads/avatars', $newName);
            $data['avatar'] = $newName;
        }

        if (!$this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/profiles')
            ->with('message', lang('Profile.messages.created'));
    }

    public function show(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profiles')
                ->with('error', lang('Profile.messages.not_found'));
        }

        $data = [
            'title' => $item->display_name,
            'item' => $item,
        ];

        return view('App\Modules\Profile\Views\admin\show', $data);
    }

    public function edit(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profiles')
                ->with('error', lang('Profile.messages.not_found'));
        }

        $data = [
            'title' => lang('Profile.admin.edit'),
            'item' => $item,
            'themes' => $this->getThemes(),
        ];

        return view('App\Modules\Profile\Views\admin\edit', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profiles')
                ->with('error', lang('Profile.messages.not_found'));
        }

        $data = $this->request->getPost();

        // Check username availability if changed
        if ($data['username'] !== $item->username) {
            if (!$this->model->isUsernameAvailable($data['username'], $id)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', lang('Profile.messages.username_taken'));
            }
        }

        // Handle checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        // Handle avatar upload
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) {
            // Delete old avatar
            if ($item->avatar && file_exists(WRITEPATH . '../public/uploads/avatars/' . $item->avatar)) {
                unlink(WRITEPATH . '../public/uploads/avatars/' . $item->avatar);
            }
            $newName = $avatar->getRandomName();
            $avatar->move(WRITEPATH . '../public/uploads/avatars', $newName);
            $data['avatar'] = $newName;
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/profiles')
            ->with('message', lang('Profile.messages.updated'));
    }

    public function delete(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/profiles')
                ->with('error', lang('Profile.messages.not_found'));
        }

        // Delete avatar file
        if ($item->avatar && file_exists(WRITEPATH . '../public/uploads/avatars/' . $item->avatar)) {
            unlink(WRITEPATH . '../public/uploads/avatars/' . $item->avatar);
        }

        $this->model->delete($id);

        return redirect()->to('/admin/profiles')
            ->with('message', lang('Profile.messages.deleted'));
    }

    protected function getThemes(): array
    {
        return [
            'minimal' => 'Minimal',
            'dark' => 'Dark',
            'colorful' => 'Colorful',
            'gradient' => 'Gradient',
        ];
    }
}
