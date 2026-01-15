<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <a href="/admin/profile-links?profile_id=<?= $item->profile_id ?>" class="btn btn-secondary">
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
        <form action="/admin/profile-links/<?= $item->id ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label"><?= lang('ProfileLink.fields.profile') ?></label>
                <?php if ($profile): ?>
                    <p class="form-control-plaintext">
                        <a href="/<?= esc($profile->username) ?>" target="_blank">
                            @<?= esc($profile->username) ?>
                        </a> - <?= esc($profile->display_name) ?>
                    </p>
                <?php endif; ?>
                <input type="hidden" name="profile_id" value="<?= $item->profile_id ?>">
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label"><?= lang('ProfileLink.fields.title') ?> *</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= old('title', $item->title) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="icon" class="form-label"><?= lang('ProfileLink.fields.icon') ?></label>
                        <select class="form-select" id="icon" name="icon">
                            <?php foreach ($icons as $value => $label): ?>
                                <option value="<?= $value ?>" <?= old('icon', $item->icon) === $value ? 'selected' : '' ?>>
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
                    value="<?= old('url', $item->url) ?>" required>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                        <?= old('is_active', $item->is_active) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">
                        <?= lang('ProfileLink.fields.is_active') ?>
                    </label>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= profilelink_format_count($item->click_count) ?></h5>
                            <p class="card-text text-muted mb-0"><?= lang('ProfileLink.fields.click_count') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $item->position + 1 ?></h5>
                            <p class="card-text text-muted mb-0"><?= lang('ProfileLink.fields.position') ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= profilelink_format_date($item->created_at, 'd.m.Y') ?></h5>
                            <p class="card-text text-muted mb-0"><?= lang('ProfileLink.fields.created_at') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><?= lang('ProfileLink.buttons.update') ?></button>
                <a href="/admin/profile-links?profile_id=<?= $item->profile_id ?>" class="btn btn-outline-secondary">
                    <?= lang('ProfileLink.buttons.cancel') ?>
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
