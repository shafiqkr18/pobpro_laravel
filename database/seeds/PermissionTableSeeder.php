<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'planning-list',
            'planning-create',
            'planning-edit',
            'planning-delete',
            'organization-mgt-list',
            'organization-mgt-create',
            'organization-mgt-edit',
            'organization-mgt-delete',
            'positions-list',
            'positions-create',
            'positions-edit',
            'positions-delete',
            'recruitment-list',
            'recruitment-create',
            'recruitment-edit',
            'recruitment-delete',
            'mobilization-list',
            'mobilization-create',
            'mobilization-edit',
            'mobilization-delete',
            'insurance-list',
            'insurance-create',
            'insurance-edit',
            'insurance-delete',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}