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
        <form action="/admin/short-links/<?= $item->id ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="target_url" class="form-label"><?= lang('ShortLink.fields.target_url') ?> *</label>
                <input type="url" class="form-control" id="target_url" name="target_url"
                    value="<?= old('target_url', $item->target_url) ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="code" class="form-label"><?= lang('ShortLink.fields.code') ?> *</label>
                        <div class="input-group">
                            <span class="input-group-text">bunlar.online/l/</span>
                            <input type="text" class="form-control" id="code" name="code"
                                value="<?= old('code', $item->code) ?>" required pattern="[a-zA-Z0-9]+">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?= lang('ShortLink.fields.title') ?></label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= old('title', $item->title) ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="expires_at" class="form-label"><?= lang('ShortLink.fields.expires_at') ?></label>
                        <?php
                        $expiresValue = old('expires_at');
                        if (!$expiresValue && $item->expires_at) {
                            $expiresValue = is_object($item->expires_at)
                                ? $item->expires_at->format('Y-m-d\TH:i')
                                : date('Y-m-d\TH:i', strtotime($item->expires_at));
                        }
                        ?>
                        <input type="datetime-local" class="form-control" id="expires_at" name="expires_at"
                            value="<?= $expiresValue ?>">
                        <small class="text-muted"><?= lang('ShortLink.help.expires_at') ?></small>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                        <?= old('is_active', $item->is_active) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        <?= lang('ShortLink.fields.is_active') ?>
                    </label>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= shortlink_format_count($item->click_count) ?></h5>
                            <p class="card-text text-muted mb-0"><?= lang('ShortLink.fields.click_count') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= shortlink_format_date($item->created_at, 'd.m.Y') ?></h5>
                            <p class="card-text text-muted mb-0"><?= lang('ShortLink.fields.created_at') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <code class="d-block mb-2"><?= shortlink_url($item) ?></code>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="copyToClipboard('<?= shortlink_url($item) ?>')">
                                <i class="bi bi-clipboard"></i> Kopyala
                            </button>
                            <a href="<?= shortlink_url($item) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-box-arrow-up-right"></i> Test Et
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('ShortLink.buttons.update') ?></button>
                <a href="/admin/short-links" class="btn btn-outline-secondary"><?= lang('ShortLink.buttons.cancel') ?></a>
            </div>
        </form>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link kopyalandi: ' + text);
    });
}
</script>

<?= $this->endSection() ?>
