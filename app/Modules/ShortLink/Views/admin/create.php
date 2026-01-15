<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/short-links" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> <?= lang('ShortLink.buttons.back') ?>
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
        <form action="/admin/short-links" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="target_url" class="form-label"><?= lang('ShortLink.fields.target_url') ?> *</label>
                <input type="url" class="form-control" id="target_url" name="target_url"
                    value="<?= old('target_url') ?>" required
                    placeholder="<?= lang('ShortLink.placeholders.target_url') ?>">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="code" class="form-label"><?= lang('ShortLink.fields.code') ?></label>
                        <div class="input-group">
                            <span class="input-group-text">bunlar.online/l/</span>
                            <input type="text" class="form-control" id="code" name="code"
                                value="<?= old('code') ?>" pattern="[a-zA-Z0-9]+"
                                placeholder="<?= esc($suggestedCode) ?>">
                        </div>
                        <small class="text-muted"><?= lang('ShortLink.help.code') ?></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?= lang('ShortLink.fields.title') ?></label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= old('title') ?>" placeholder="<?= lang('ShortLink.placeholders.title') ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="expires_at" class="form-label"><?= lang('ShortLink.fields.expires_at') ?></label>
                        <input type="datetime-local" class="form-control" id="expires_at" name="expires_at"
                            value="<?= old('expires_at') ?>">
                        <small class="text-muted"><?= lang('ShortLink.help.expires_at') ?></small>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                        <?= old('is_active', true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        <?= lang('ShortLink.fields.is_active') ?>
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('ShortLink.buttons.save') ?></button>
                <a href="/admin/short-links" class="btn btn-outline-secondary"><?= lang('ShortLink.buttons.cancel') ?></a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
