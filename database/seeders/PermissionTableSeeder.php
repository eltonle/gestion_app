<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
 
            [
                'group_name' => 'admin',
                'permissions'=> [
                    // admin
                    'view-admin',
                    'create-admin',
                    'edit-admin',
                    'delete-admin',
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
                'group_name' => 'product',
                'permissions'=> [
                    // product
                    'view-product',
                    'create-product',
                    'edit-product',
                    'delete-product'
                ]
            ],

           

           
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }
    }
}
