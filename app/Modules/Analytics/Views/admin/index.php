<?= $this->extend('App\Views\layouts\admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= esc($title) ?></h1>
</div>

<!-- Today Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1"><?= lang('Analytics.stats.profile_views') ?></h6>
                        <h2 class="mb-0"><?= analytics_format_count($todayStats['profile_views']) ?></h2>
                        <small><?= lang('Analytics.stats.today') ?></small>
                    </div>
                    <i class="bi bi-eye fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1"><?= lang('Analytics.stats.profile_link_clicks') ?></h6>
                        <h2 class="mb-0"><?= analytics_format_count($todayStats['profile_link_clicks']) ?></h2>
                        <small><?= lang('Analytics.stats.today') ?></small>
                    </div>
                    <i class="bi bi-hand-index fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1"><?= lang('Analytics.stats.short_link_clicks') ?></h6>
                        <h2 class="mb-0"><?= analytics_format_count($todayStats['short_link_clicks']) ?></h2>
                        <small><?= lang('Analytics.stats.today') ?></small>
                    </div>
                    <i class="bi bi-link-45deg fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-1"><?= analytics_format_count($weeklyStats['profile_views']) ?></h3>
                <p class="text-muted mb-0"><?= lang('Analytics.stats.profile_views') ?> (<?= lang('Analytics.stats.this_week') ?>)</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-1"><?= analytics_format_count($weeklyStats['profile_link_clicks']) ?></h3>
                <p class="text-muted mb-0"><?= lang('Analytics.stats.profile_link_clicks') ?> (<?= lang('Analytics.stats.this_week') ?>)</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-1"><?= analytics_format_count($weeklyStats['short_link_clicks']) ?></h3>
                <p class="text-muted mb-0"><?= lang('Analytics.stats.short_link_clicks') ?> (<?= lang('Analytics.stats.this_week') ?>)</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Lists -->
<div class="row">
    <!-- Daily Chart -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Analytics.sections.daily_chart') ?></h5>
            </div>
            <div class="card-body">
                <canvas id="dailyChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Device Stats -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Analytics.sections.devices') ?></h5>
            </div>
            <div class="card-body">
                <?php
                $totalDevices = $deviceStats['mobile'] + $deviceStats['desktop'];
                if ($totalDevices > 0):
                ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="bi bi-phone"></i> <?= lang('Analytics.labels.mobile') ?></span>
                        <span><?= analytics_percent($deviceStats['mobile'], $totalDevices) ?></span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" style="width: <?= ($deviceStats['mobile'] / $totalDevices) * 100 ?>%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span><i class="bi bi-laptop"></i> <?= lang('Analytics.labels.desktop') ?></span>
                        <span><?= analytics_percent($deviceStats['desktop'], $totalDevices) ?></span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: <?= ($deviceStats['desktop'] / $totalDevices) * 100 ?>%"></div>
                    </div>
                </div>
                <?php else: ?>
                <p class="text-muted text-center mb-0"><?= lang('Analytics.labels.no_data') ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Profiles -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Analytics.sections.top_profiles') ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($topProfiles)): ?>
                    <p class="text-muted text-center mb-0"><?= lang('Analytics.labels.no_data') ?></p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($topProfiles as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <a href="/<?= esc($item['profile']->username) ?>" target="_blank" class="text-decoration-none">
                                    @<?= esc($item['profile']->username) ?>
                                </a>
                                <span class="badge bg-primary"><?= analytics_format_count($item['views']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Top Profile Links -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Analytics.sections.top_links') ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($topProfileLinks)): ?>
                    <p class="text-muted text-center mb-0"><?= lang('Analytics.labels.no_data') ?></p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($topProfileLinks as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-truncate" style="max-width: 180px;" title="<?= esc($item['link']->title) ?>">
                                    <?= esc($item['link']->title) ?>
                                </span>
                                <span class="badge bg-success"><?= analytics_format_count($item['clicks']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Top Short Links -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Analytics.sections.top_short_links') ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($topShortLinks)): ?>
                    <p class="text-muted text-center mb-0"><?= lang('Analytics.labels.no_data') ?></p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($topShortLinks as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <code><?= esc($item['link']->code) ?></code>
                                <span class="badge bg-info"><?= analytics_format_count($item['clicks']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Top Referrers -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><?= lang('Analytics.sections.referrers') ?></h5>
            </div>
            <div class="card-body">
                <?php if (empty($topReferrers)): ?>
                    <p class="text-muted text-center mb-0"><?= lang('Analytics.labels.no_data') ?></p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Kaynak</th>
                                    <th class="text-end">Ziyaret</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topReferrers as $item): ?>
                                    <tr>
                                        <td><?= esc(analytics_format_referrer($item->referrer)) ?></td>
                                        <td class="text-end"><?= analytics_format_count($item->count) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('dailyChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= analytics_chart_labels($profileViewsDaily) ?>,
            datasets: [{
                label: '<?= lang('Analytics.stats.profile_views') ?>',
                data: <?= analytics_chart_data($profileViewsDaily) ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
