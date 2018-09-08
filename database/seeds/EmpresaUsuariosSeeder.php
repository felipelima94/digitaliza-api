<?php

use Illuminate\Database\Seeder;

class EmpresaUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EmpresaUsuarios::class, 4000)->create();
    }
}
