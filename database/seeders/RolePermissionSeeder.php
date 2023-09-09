<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create roles
        $roleSuperAdmin = Role::create(['name'=>'superadmin']);
        $roleAdmin = Role::create(['name'=>'admin']);
        $roleCaisser = Role::create(['name'=>'caisser']);


        $permissions = [
 
            [
                'group_name' => 'user',
                'permissions'=> [
                    // admin
                    'view-user',
                    'create-user',
                    'edit-user',
                    'delete-user',
                ]
            ],

             [
                'group_name' => 'role',
                'permissions'=> [
                    // role
                    'view-role',
                    'create-role',
                    'edit-role',
                    'delete-role',
                ]
            ],

            [
                'group_name' => 'category',
                'permissions'=> [
                    // category
                    'view-category',
                    'create-category',
                    'edit-category',
                    'delete-category'
                ]
            ],

            [
                'group_name' => 'article',
                'permissions'=> [
                    // article
                    'view-article',
                    'create-article',
                    'edit-article',
                    'delete-article'
                ]
            ],

           
            [
                'group_name' => 'client',
                'permissions'=> [
                    // client
                    'delete-client'
                ]
            ],

            
        ];
        // $permissions = [
 
        //     [
        //         'group_name' => 'admin',
        //         'permissions'=> [
        //             // admin
        //             'view-admin',
        //             'create-admin',
        //             'edit-admin',
        //             'delete-admin',
        //         ]
        //     ],

        //      [
        //         'group_name' => 'role',
        //         'permissions'=> [
        //             // role
        //             'view-role',
        //             'create-role',
        //             'edit-role',
        //             'delete-role',
        //         ]
        //     ],

        //     [
        //         'group_name' => 'category',
        //         'permissions'=> [
        //             // category
        //             'view-category',
        //             'create-category',
        //             'edit-category',
        //             'delete-category'
        //         ]
        //     ],

        //     [
        //         'group_name' => 'product',
        //         'permissions'=> [
        //             // product
        //             'view-product',
        //             'create-product',
        //             'edit-product',
        //             'delete-product'
        //         ]
        //     ],      
        // ];
       

        // assign permissions
        for ($i=0; $i < count($permissions); $i++) { 
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j=0; $j < count($permissions[$i]['permissions']); $j++) {
            # create permission
            $permission = Permission::create(['name'=>$permissions[$i]['permissions'][$j],'group_name'=>$permissionGroup]);
            $roleSuperAdmin->givePermissionTo($permission);
            $permission->assignRole($roleSuperAdmin);
          }
         
        }

    }
}
