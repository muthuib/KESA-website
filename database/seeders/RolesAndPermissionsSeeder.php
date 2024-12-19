<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        //Create roles
        $admin = Role::create(['name' => 'admin']);
        $partner = Role::create(['name' => 'partner']);
        $member = Role::create(['name' => 'member']);

        //Create permissions
        $createPost = Permission::create(['name' => 'create post']);
        $editPost = Permission::create(['name' => 'edit post']);
        $updatePost = Permission::create(['name' => 'update post']);
        $deletePost = Permission::create(['name' => 'delete post']);
        $viewPost = Permission::create(['name' => 'view post']);

        //Assign permissions
        $admin->permissions()->attach([$createPost->id, $editPost->id, $deletePost->id, $updatePost->id]);
        $partner->permissions()->attach([$viewPost->id]);
        $member->permissions()->attach([$viewPost->id]);
    }
}
