<div class="space-y-6">
    <!-- Page Header -->
    <x-breadcrumbs tagline="Overview of system statistics and recent activity" />

    <!-- Main Stats Cards -->
    <x-dashboard.super-admin :stats="$stats" />

    <!-- Latest Activity Sections -->
    <x-dashboard.latest-activity :stats="$stats" />

    <!-- Certificate Requests -->
    <x-dashboard.certificate-request :stats="$stats" />
</div>
