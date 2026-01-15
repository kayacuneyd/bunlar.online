<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/profiles/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> <?= lang('Profile.buttons.create') ?>
    </a>
</div>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($items)): ?>
            <p class="text-muted text-center py-4"><?= lang('Profile.frontend.no_items') ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?= lang('Profile.fields.avatar') ?></th>
                            <th><?= lang('Profile.fields.username') ?></th>
                            <th><?= lang('Profile.fields.display_name') ?></th>
                            <th><?= lang('Profile.fields.theme') ?></th>
                            <th><?= lang('Profile.fields.view_count') ?></th>
                            <th><?= lang('Profile.fields.is_active') ?></th>
                            <th class="text-end"><?= lang('Profile.buttons.edit') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= esc($item->id) ?></td>
                                <td>
                                    <img src="<?= profile_avatar_url($item->avatar) ?>"
                                         alt="<?= esc($item->display_name) ?>"
                                         class="rounded-circle" width="40" height="40"
                                         style="object-fit: cover;">
                                </td>
                                <td>
                                    <a href="/<?= esc($item->username) ?>" target="_blank">
                                        @<?= esc($item->username) ?>
                                    </a>
                                </td>
                                <td><?= esc($item->display_name) ?></td>
                                <td><?= profile_theme_badge($item->theme) ?></td>
                                <td><?= profile_format_count($item->view_count) ?></td>
                                <td><?= profile_active_badge($item->is_active) ?></td>
                                <td class="text-end">
                                    <a href="/<?= esc($item->username) ?>" target="_blank"
                                        class="btn btn-sm btn-outline-info" title="Profili Gor">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <a href="/admin/profiles/<?= esc($item->id) ?>/edit"
                                        class="btn btn-sm btn-outline-primary" title="<?= lang('Profile.buttons.edit') ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/admin/profiles/<?= esc($item->id) ?>/delete" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('<?= lang('Profile.messages.delete_confirm') ?>');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="<?= lang('Profile.buttons.delete') ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
