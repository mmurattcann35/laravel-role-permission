<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateEditorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "name"  => "John DOE",
            "email" => "johndoe@admin.com",
            "password" =>bcrypt("123")
        ]);

        $role = Role::create(["name" => "Editor"]);

        $perms = [];

        $permissions = Permission::pluck("id","id")->all();

        foreach ($permissions as $permission){
            if(strpos($permission,"edit") ||
                strpos($permission,"show") ||
                strpos($permission,"list")){

                $perms[] = $permission ;
            }
        }

        $role->syncPermissions($perms);

        $user->assignRole([$role->id]);
    }
}
