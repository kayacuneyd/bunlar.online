<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
    <div>
        <a href="/admin/short-links/<?= $item->id ?>/edit" class="btn btn-primary">
            <i class="bi bi-pencil"></i> <?= lang('ShortLink.buttons.edit') ?>
        </a>
        <a href="/admin/short-links" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> <?= lang('ShortLink.buttons.back') ?>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5><?= lang('ShortLink.fields.short_url') ?></h5>
                <div class="d-flex align-items-center gap-2 mb-4">
                    <code class="bg-light px-3 py-2 rounded fs-5"><?= shortlink_url($item) ?></code>
                    <button type="button" class="btn btn-outline-primary"
                            onclick="copyToClipboard('<?= shortlink_url($item) ?>')">
                        <i class="bi bi-clipboard"></i> Kopyala
                    </button>
                    <a href="<?= shortlink_url($item) ?>" target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-up-right"></i> Ac
                    </a>
                </div>

                <h5><?= lang('ShortLink.fields.target_url') ?></h5>
                <p class="mb-4">
                    <a href="<?= esc($item->target_url) ?>" target="_blank" class="text-break">
                        <?= esc($item->target_url) ?>
                    </a>
                </p>

                <?php if ($item->title): ?>
                    <h5><?= lang('ShortLink.fields.title') ?></h5>
                    <p class="mb-4"><?= esc($item->title) ?></p>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Durum:</strong> <?= shortlink_status_badge($item) ?></p>
                        <p><strong><?= lang('ShortLink.fields.created_at') ?>:</strong> <?= shortlink_format_date($item->created_at) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><?= lang('ShortLink.fields.expires_at') ?>:</strong>
                            <?= $item->expires_at ? shortlink_format_date($item->expires_at) : 'Suresiz' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Istatistikler</h5>
            </div>
            <div class="card-body text-center">
                <h1 class="display-4 mb-0"><?= shortlink_format_count($item->click_count) ?></h1>
                <p class="text-muted"><?= lang('ShortLink.fields.click_count') ?></p>
            </div>
        </div>
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
