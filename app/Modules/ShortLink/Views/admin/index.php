<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Toplam Tiklanma: <strong><?= shortlink_format_count($totalClicks) ?></strong></p>
    </div>
    <a href="/admin/short-links/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> <?= lang('ShortLink.buttons.create') ?>
    </a>
</div>

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
            <p class="text-muted text-center py-4"><?= lang('ShortLink.messages.no_items') ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?= lang('ShortLink.fields.short_url') ?></th>
                            <th><?= lang('ShortLink.fields.target_url') ?></th>
                            <th><?= lang('ShortLink.fields.title') ?></th>
                            <th><?= lang('ShortLink.fields.click_count') ?></th>
                            <th><?= lang('ShortLink.fields.expires_at') ?></th>
                            <th>Durum</th>
                            <th class="text-end"><?= lang('ShortLink.buttons.edit') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <code class="bg-light px-2 py-1 rounded"><?= esc($item->code) ?></code>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="copyToClipboard('<?= shortlink_url($item) ?>')"
                                                title="Kopyala">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= esc($item->target_url) ?>" target="_blank"
                                       class="text-decoration-none" title="<?= esc($item->target_url) ?>">
                                        <?= shortlink_truncate_url($item->target_url, 35) ?>
                                        <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                    </a>
                                </td>
                                <td><?= $item->title ? esc($item->title) : '<span class="text-muted">-</span>' ?></td>
                                <td>
                                    <span class="badge bg-info"><?= shortlink_format_count($item->click_count) ?></span>
                                </td>
                                <td>
                                    <?php if ($item->expires_at): ?>
                                        <?= shortlink_format_date($item->expires_at, 'd.m.Y H:i') ?>
                                    <?php else: ?>
                                        <span class="text-muted">Suresiz</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= shortlink_status_badge($item) ?></td>
                                <td class="text-end">
                                    <a href="<?= shortlink_url($item) ?>" target="_blank"
                                        class="btn btn-sm btn-outline-info" title="Linki Test Et">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <a href="/admin/short-links/<?= $item->id ?>/edit"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="/admin/short-links/<?= $item->id ?>/delete" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('<?= lang('ShortLink.messages.delete_confirm') ?>');">
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

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link kopyalandi: ' + text);
    });
}
</script>

<?= $this->endSection() ?>
