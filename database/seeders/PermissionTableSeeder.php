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
                'group_name' => 'unit',
                'permissions'=> [
                    // unit
                    'view-unit',
                    'create-unit',
                    'edit-unit',
                    'delete-unit'
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
        
        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }
    }
}
