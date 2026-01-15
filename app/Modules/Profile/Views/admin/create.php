<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/profiles" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> <?= lang('Profile.buttons.back') ?>
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

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="/admin/profiles" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="username" class="form-label"><?= lang('Profile.fields.username') ?> *</label>
                        <div class="input-group">
                            <span class="input-group-text">bunlar.online/</span>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= old('username') ?>" required pattern="[a-zA-Z0-9_-]+"
                                placeholder="kullanici-adi">
                        </div>
                        <small class="text-muted">Sadece harf, rakam, tire ve alt cizgi kullanilabilir.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="display_name" class="form-label"><?= lang('Profile.fields.display_name') ?> *</label>
                        <input type="text" class="form-control" id="display_name" name="display_name"
                            value="<?= old('display_name') ?>" required placeholder="Gorunen Adiniz">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label"><?= lang('Profile.fields.bio') ?></label>
                <textarea class="form-control" id="bio" name="bio" rows="3"
                    maxlength="500" placeholder="Kendinizi kisa bir sekilde tanitin..."><?= old('bio') ?></textarea>
                <small class="text-muted">Maksimum 500 karakter.</small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="avatar" class="form-label"><?= lang('Profile.fields.avatar') ?></label>
                        <input type="file" class="form-control" id="avatar" name="avatar"
                            accept="image/jpeg,image/png,image/gif,image/webp">
                        <small class="text-muted">JPEG, PNG, GIF veya WebP. Maksimum 2MB.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="theme" class="form-label"><?= lang('Profile.fields.theme') ?></label>
                        <select class="form-select" id="theme" name="theme">
                            <?php foreach ($themes as $key => $label): ?>
                                <option value="<?= $key ?>" <?= old('theme', 'minimal') === $key ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="ga_measurement_id" class="form-label"><?= lang('Profile.fields.ga_measurement_id') ?></label>
                <input type="text" class="form-control" id="ga_measurement_id" name="ga_measurement_id"
                    value="<?= old('ga_measurement_id') ?>" placeholder="G-XXXXXXXXXX">
                <small class="text-muted">Google Analytics 4 olcum kimliginizi girin (opsiyonel).</small>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                        <?= old('is_active', true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        <?= lang('Profile.fields.is_active') ?>
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('Profile.buttons.save') ?></button>
                <a href="/admin/profiles" class="btn btn-outline-secondary"><?= lang('Profile.buttons.cancel') ?></a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
