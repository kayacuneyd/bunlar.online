<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1><?= esc($title) ?></h1>
        <?php if ($profile): ?>
            <p class="text-muted mb-0">
                <a href="/<?= esc($profile->username) ?>" target="_blank">@<?= esc($profile->username) ?></a> profilinin linkleri
            </p>
        <?php endif; ?>
    </div>
    <div>
        <?php if ($profile): ?>
            <a href="/admin/profile-links/create?profile_id=<?= $profile->id ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> <?= lang('ProfileLink.buttons.create') ?>
            </a>
            <a href="/admin/profiles/<?= $profile->id ?>/edit" class="btn btn-outline-secondary">
                <i class="bi bi-person"></i> Profile Git
            </a>
        <?php else: ?>
            <a href="/admin/profile-links/create" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> <?= lang('ProfileLink.buttons.create') ?>
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (!$profile && !empty($profiles)): ?>
<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0">Profil Sec:</label>
            </div>
            <div class="col-auto">
                <select name="profile_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Tum Profiller</option>
                    <?php foreach ($profiles as $p): ?>
                        <option value="<?= $p->id ?>" <?= $profile && $profile->id === $p->id ? 'selected' : '' ?>>
                            @<?= esc($p->username) ?> - <?= esc($p->display_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if (session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($items)): ?>
            <p class="text-muted text-center py-4"><?= lang('ProfileLink.messages.no_items') ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover" id="linksTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th><?= lang('ProfileLink.fields.icon') ?></th>
                            <th><?= lang('ProfileLink.fields.title') ?></th>
                            <th><?= lang('ProfileLink.fields.url') ?></th>
                            <?php if (!$profile): ?>
                                <th><?= lang('ProfileLink.fields.profile') ?></th>
                            <?php endif; ?>
                            <th><?= lang('ProfileLink.fields.click_count') ?></th>
                            <th><?= lang('ProfileLink.fields.is_active') ?></th>
                            <th class="text-end"><?= lang('ProfileLink.buttons.edit') ?></th>
                        </tr>
                    </thead>
                    <tbody id="sortable-links">
                        <?php foreach ($items as $item): ?>
                            <tr data-id="<?= $item->id ?>">
                                <td class="drag-handle" style="cursor: move;">
                                    <i class="bi bi-grip-vertical text-muted"></i>
                                </td>
                                <td>
                                    <?php if ($item->icon): ?>
                                        <span style="font-size: 1.2em;"><?= esc($item->icon) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($item->title) ?></td>
                                <td>
                                    <a href="<?= esc($item->url) ?>" target="_blank" class="text-decoration-none" title="<?= esc($item->url) ?>">
                                        <?= profilelink_truncate_url($item->url, 30) ?>
                                        <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                    </a>
                                </td>
                                <?php if (!$profile): ?>
                                    <td>
                                        <?php
                                        $linkProfile = array_filter($profiles, fn($p) => $p->id === $item->profile_id);
                                        $linkProfile = reset($linkProfile);
                                        ?>
                                        <?php if ($linkProfile): ?>
                                            <a href="/admin/profile-links?profile_id=<?= $linkProfile->id ?>">
                                                @<?= esc($linkProfile->username) ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <span class="badge bg-info"><?= profilelink_format_count($item->click_count) ?></span>
                                </td>
                                <td><?= profilelink_active_badge($item->is_active) ?></td>
                                <td class="text-end">
                                    <a href="/admin/profile-links/<?= $item->id ?>/edit"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/admin/profile-links/<?= $item->id ?>/delete" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('<?= lang('ProfileLink.messages.delete_confirm') ?>');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
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

<?php if ($profile && !empty($items)): ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-links');
    if (el) {
        new Sortable(el, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function(evt) {
                const rows = el.querySelectorAll('tr');
                const positions = {};
                rows.forEach((row, index) => {
                    positions[row.dataset.id] = index;
                });

                fetch('/admin/profile-links/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(positions)
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          console.log('Order saved');
                      }
                  });
            }
        });
    }
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>
