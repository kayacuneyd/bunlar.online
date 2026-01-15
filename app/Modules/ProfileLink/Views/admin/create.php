<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/profile-links<?= $profile ? '?profile_id=' . $profile->id : '' ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> <?= lang('ProfileLink.buttons.back') ?>
    </a>
</div>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="/admin/profile-links" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="profile_id" class="form-label"><?= lang('ProfileLink.fields.profile') ?> *</label>
                <select class="form-select" id="profile_id" name="profile_id" required>
                    <option value="">Profil Secin</option>
                    <?php foreach ($profiles as $p): ?>
                        <option value="<?= $p->id ?>" <?= old('profile_id', $profile?->id) == $p->id ? 'selected' : '' ?>>
                            @<?= esc($p->username) ?> - <?= esc($p->display_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?= lang('ProfileLink.fields.title') ?> *</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= old('title') ?>" required placeholder="Link Basligi">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="icon" class="form-label"><?= lang('ProfileLink.fields.icon') ?></label>
                        <select class="form-select" id="icon" name="icon">
                            <?php foreach ($icons as $value => $label): ?>
                                <option value="<?= $value ?>" <?= old('icon') === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label"><?= lang('ProfileLink.fields.url') ?> *</label>
                <input type="url" class="form-control" id="url" name="url"
                    value="<?= old('url') ?>" required placeholder="https://example.com">
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                        <?= old('is_active', true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        <?= lang('ProfileLink.fields.is_active') ?>
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('ProfileLink.buttons.save') ?></button>
                <a href="/admin/profile-links<?= $profile ? '?profile_id=' . $profile->id : '' ?>" class="btn btn-outline-secondary">
                    <?= lang('ProfileLink.buttons.cancel') ?>
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
