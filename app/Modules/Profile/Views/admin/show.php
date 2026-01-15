<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <div>
        <a href="/admin/profiles/<?= $item->id ?>/edit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> <?= lang('Profile.buttons.edit') ?>
        </a>
        <a href="/admin/profiles" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> <?= lang('Profile.buttons.back') ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <img src="<?= profile_avatar_url($item->avatar) ?>"
                         alt="<?= esc($item->display_name) ?>"
                         class="rounded-circle me-3" width="100" height="100"
                         style="object-fit: cover;">
                    <div>
                        <h3 class="mb-1"><?= esc($item->display_name) ?></h3>
                        <p class="text-muted mb-0">@<?= esc($item->username) ?></p>
                    </div>
                </div>

                <?php if ($item->bio): ?>
                    <div class="mb-4">
                        <h5><?= lang('Profile.fields.bio') ?></h5>
                        <p><?= nl2br(esc($item->bio)) ?></p>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong><?= lang('Profile.fields.theme') ?>:</strong> <?= profile_theme_badge($item->theme) ?></p>
                        <p><strong><?= lang('Profile.fields.is_active') ?>:</strong> <?= profile_active_badge($item->is_active) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><?= lang('Profile.fields.view_count') ?>:</strong> <?= profile_format_count($item->view_count) ?></p>
                        <p><strong><?= lang('Profile.fields.created_at') ?>:</strong> <?= profile_format_date($item->created_at) ?></p>
                    </div>
                </div>

                <?php if ($item->ga_measurement_id): ?>
                    <p><strong><?= lang('Profile.fields.ga_measurement_id') ?>:</strong> <?= esc($item->ga_measurement_id) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">QR Code</h5>
            </div>
            <div class="card-body text-center">
                <img src="<?= profile_qr_url($item->username) ?>"
                     alt="QR Code" class="img-fluid mb-3" style="max-width: 200px;">
                <div>
                    <a href="<?= profile_qr_url($item->username) ?>"
                       download="<?= $item->username ?>-qr.png"
                       class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-download"></i> <?= lang('Profile.frontend.download_qr') ?>
                    </a>
                </div>
                <hr>
                <a href="/<?= esc($item->username) ?>" target="_blank" class="btn btn-primary">
                    <i class="bi bi-box-arrow-up-right"></i> <?= lang('Profile.frontend.view_profile') ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
