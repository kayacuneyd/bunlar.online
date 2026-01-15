<?php

namespace App\Modules\ShortLink\Controllers\Admin;

use App\Controllers\BaseController;
use App\Modules\ShortLink\Models\ShortLinkModel;
use CodeIgniter\HTTP\RedirectResponse;

class ShortLinkController extends BaseController
{
    protected ShortLinkModel $model;

    public function __construct()
    {
        $this->model = new ShortLinkModel();
        helper(['form', 'shortlink']);
    }

    public function index(): string
    {
        $userId = session()->get('user_id');

        $data = [
            'title' => lang('ShortLink.admin.title'),
            'items' => $this->model->getByUserId($userId ?? 1),
            'totalClicks' => $this->model->getTotalClicksByUserId($userId ?? 1),
        ];

        return view('App\Modules\ShortLink\Views\admin\index', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => lang('ShortLink.admin.create'),
            'item' => null,
            'suggestedCode' => $this->model->generateUniqueCode(),
        ];

        return view('App\Modules\ShortLink\Views\admin\create', $data);
    }

    public function store(): RedirectResponse
    {
        $data = $this->request->getPost();

        // Set user_id from session
        $data['user_id'] = session()->get('user_id') ?? 1;

        // Generate code if not provided or empty
        if (empty($data['code'])) {
            $data['code'] = $this->model->generateUniqueCode();
        }

        // Handle checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        // Handle empty expires_at
        if (empty($data['expires_at'])) {
            $data['expires_at'] = null;
        }

        if (!$this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/short-links')
            ->with('message', lang('ShortLink.messages.created'));
    }

    public function show(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/short-links')
                ->with('error', lang('ShortLink.messages.not_found'));
        }

        $data = [
            'title' => $item->title ?: $item->code,
            'item' => $item,
        ];

        return view('App\Modules\ShortLink\Views\admin\show', $data);
    }

    public function edit(int $id): string|RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/short-links')
                ->with('error', lang('ShortLink.messages.not_found'));
        }

        $data = [
            'title' => lang('ShortLink.admin.edit'),
            'item' => $item,
        ];

        return view('App\Modules\ShortLink\Views\admin\edit', $data);
    }

    public function update(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/short-links')
                ->with('error', lang('ShortLink.messages.not_found'));
        }

        $data = $this->request->getPost();

        // Handle checkbox
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        // Handle empty expires_at
        if (empty($data['expires_at'])) {
            $data['expires_at'] = null;
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/short-links')
            ->with('message', lang('ShortLink.messages.updated'));
    }

    public function delete(int $id): RedirectResponse
    {
        $item = $this->model->find($id);

        if ($item === null) {
            return redirect()->to('/admin/short-links')
                ->with('error', lang('ShortLink.messages.not_found'));
        }

        $this->model->delete($id);

        return redirect()->to('/admin/short-links')
            ->with('message', lang('ShortLink.messages.deleted'));
    }
}
