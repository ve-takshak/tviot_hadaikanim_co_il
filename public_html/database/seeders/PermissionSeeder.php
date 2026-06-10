<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Takshak\Adash\Models\Permission;
use Takshak\Adash\Models\Role;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public $permissions = [];

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();

        foreach ($this->data() as $item) {
            $permission = Permission::create([
                'name' => $item['name'],
                'title' => $item['title'],
            ]);
            $this->bifurcatePermissions($item);

            if (count($item['children']) > 0) {
                foreach ($item['children'] as $child) {
                    Permission::create([
                        'name' => $child['name'],
                        'permission_id' => $permission->id,
                        'title' => $child['title'],
                    ]);
                    $this->bifurcatePermissions($child);
                }
            }
        }

        foreach ($this->permissions as $role => $permissions) {
            $permissions = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
            $role = Role::where('name', $role)->first();
            $role->permissions()->sync($permissions);
        }
    }

    public function bifurcatePermissions($item)
    {
        foreach ($item['roles'] ?? [] as $role) {
            if (!isset($this->permissions[$role])) {
                $this->permissions[$role] = [];
            }

            $this->permissions[$role][] = $item['name'];
        }
    }

    public function data($value = '')
    {
        return collect([

            [
                'name'  => 'roles_access',
                'title'  => 'Roles Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'roles_create', 'title' => 'Roles Create', 'roles' => ['admin']],
                    ['name' => 'roles_update', 'title' => 'Roles Update', 'roles' => ['admin']],
                    ['name' => 'roles_delete', 'title' => 'Roles Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'permissions_access',
                'title'  => 'Permissions Access',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'permissions_create', 'title' => 'Permissions Create', 'roles' => ['admin']],
                    ['name' => 'permissions_update', 'title' => 'Permissions Update', 'roles' => ['admin']],
                    ['name' => 'permissions_delete', 'title' => 'Permissions Delete', 'roles' => ['admin']],
                    ['name' => 'permissions_roles_update', 'title' => 'Permissions Roles Update', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'users_access',
                'title'  => 'Users Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'users_show', 'title' => 'Users Show', 'roles' => ['admin']],
                    ['name' => 'users_create', 'title' => 'Users Create', 'roles' => ['admin']],
                    ['name' => 'users_update', 'title' => 'Users Update', 'roles' => ['admin']],
                    ['name' => 'users_delete', 'title' => 'Users Delete', 'roles' => ['admin']],
                    ['name' => 'login_to_user', 'title' => 'Users Login To', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'agent_access',
                'title'  => 'Agent Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'agent_show', 'title' => 'Agent Show', 'roles' => ['admin']],
                    ['name' => 'agent_create', 'title' => 'Agent Create', 'roles' => ['admin']],
                    ['name' => 'agent_update', 'title' => 'Agent Update', 'roles' => ['admin']],
                    ['name' => 'agent_delete', 'title' => 'Agent Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'admin_access',
                'title'  => 'Admin Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'admin_show', 'title' => 'Admin Show', 'roles' => ['admin']],
                    ['name' => 'admin_create', 'title' => 'Admin Create', 'roles' => ['admin']],
                    ['name' => 'admin_update', 'title' => 'Admin Update', 'roles' => ['admin']],
                    ['name' => 'admin_delete', 'title' => 'Admin Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'employee_access',
                'title'  => 'Employee Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'employee_show', 'title' => 'Employee Show', 'roles' => ['admin']],
                    ['name' => 'employee_create', 'title' => 'Employee Create', 'roles' => ['admin']],
                    ['name' => 'employee_update', 'title' => 'Employee Update', 'roles' => ['admin']],
                    ['name' => 'employee_delete', 'title' => 'Employee Delete', 'roles' => ['admin']],
                ]
            ],
            [
                'name'  => 'client_access',
                'title'  => 'Client Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'client_show', 'title' => 'Client Show', 'roles' => ['admin']],
                    ['name' => 'client_create', 'title' => 'Client Create', 'roles' => ['admin']],
                    ['name' => 'client_update', 'title' => 'Client Update', 'roles' => ['admin']],
                    ['name' => 'client_delete', 'title' => 'Client Delete', 'roles' => ['admin']],
                ]
            ],
            [
                'name'  => 'lawyer_access',
                'title'  => 'Lawyer Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'lawyer_show', 'title' => 'Lawyer Show', 'roles' => ['admin']],
                    ['name' => 'lawyer_create', 'title' => 'Lawyer Create', 'roles' => ['admin']],
                    ['name' => 'lawyer_update', 'title' => 'Lawyer Update', 'roles' => ['admin']],
                    ['name' => 'lawyer_delete', 'title' => 'Lawyer Delete', 'roles' => ['admin']],
                ]
            ],
            [
                'name'  => 'settings_access',
                'title'  => 'Settings Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'settings_create', 'title' => 'Settings Create', 'roles' => ['admin']],
                    ['name' => 'settings_update', 'title' => 'Settings Update', 'roles' => ['admin']],
                    ['name' => 'settings_delete', 'title' => 'Settings Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'inc_companies_access',
                'title'  => 'Insurance Companies Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'inc_companies_create', 'title' => 'Insurance Companies Create', 'roles' => ['admin']],
                    ['name' => 'inc_companies_show', 'title' => 'Insurance Companies Show', 'roles' => ['admin']],
                    ['name' => 'inc_companies_update', 'title' => 'Insurance Companies Update', 'roles' => ['admin']],
                    ['name' => 'inc_companies_delete', 'title' => 'Insurance Companies Delete', 'roles' => ['admin']],
                ]
            ],

            [
                'name'  => 'insurance_claim_access',
                'title'  => 'Insurance Claims Access',
                'roles' => ['admin','client'],
                'children' => [
                    ['name' => 'insurance_claim_create', 'title' => 'Insurance Claims Create', 'roles' => ['admin']],
                    ['name' => 'insurance_claim_show', 'title' => 'Insurance Claims Show', 'roles' => ['admin','client']],
                    ['name' => 'insurance_claim_update', 'title' => 'Insurance Claims Update', 'roles' => ['admin']],
                    ['name' => 'insurance_claim_delete', 'title' => 'Insurance Claims Delete', 'roles' => ['admin']],
                    ['name' => 'insurance_claim_comment_create', 'title' => 'Insurance Claims Comment Create', 'roles' => ['admin']],
                    ['name' => 'insurance_claim_comment_delete', 'title' => 'Insurance Claims Comment delete', 'roles' => ['admin']],
                    ['name' => 'insurance_claim_document_delete', 'title' => 'Insurance Claims Document delete', 'roles' => ['admin']],
                    ['name' => 'insurance_claim_document_create', 'title' => 'Insurance Claims Document create', 'roles' => ['admin']],
                ]
            ],
            [
                'name'  => 'appraiser_access',
                'title'  => 'Appraiser Management',
                'roles' => ['admin'],
                'children' => [
                    ['name' => 'appraiser_create', 'title' => 'Appraiser Create', 'roles' => ['admin']],
                    ['name' => 'appraiser_show', 'title' => 'Appraiser Show', 'roles' => ['admin']],
                    ['name' => 'appraiser_update', 'title' => 'Appraiser Update', 'roles' => ['admin']],
                    ['name' => 'appraiser_delete', 'title' => 'Appraiser Delete', 'roles' => ['admin']],
                ]
            ],
          
        ]);
    }
}
