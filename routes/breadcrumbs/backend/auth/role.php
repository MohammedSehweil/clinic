<?php

Breadcrumbs::for('admin.role.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('menus.backend.access.roles.management'), route('admin.role.index'));
});

Breadcrumbs::for('admin.role.create', function ($trail) {
    $trail->parent('admin.role.index');
    $trail->push(__('menus.backend.access.roles.create'), route('admin.role.create'));
});

Breadcrumbs::for('admin.role.edit', function ($trail, $id) {
    $trail->parent('admin.role.index');
    $trail->push(__('menus.backend.access.roles.edit'), route('admin.role.edit', $id));
});
