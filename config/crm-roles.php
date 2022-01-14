<?php
/**
 * ----------------------------------------------------
 * Defines all the roles/permissions
 * that the crm will use TODO any addition to the
 * Role Model make sure you add them here following
 * the formant that has been created. That's the name
 * ----------------------------------------------------
 */

use Illuminate\Support\Str;

return [
    'admin' => Str::slug('Admin'),
    'agent' => Str::slug('Agent'),
];
