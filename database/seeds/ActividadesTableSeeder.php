<?php

use Illuminate\Database\Seeder;

class ActividadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Actividad::class, 30)->create()->each(function(App\Actividad $actividad){
			$usr = App\User::find($actividad->creador_id);
			$usuarios = App\Oficina::find($usr->oficina->id)->users()->where('cuenta', '<>', 'admin')->get();
			$ids = [];
			$loop_limit = rand(1, $usuarios->count());
			for ($i=0; $i < $loop_limit; $i++) {
				$rnd_res = $usuarios->random();
				array_push($ids, $rnd_res->id);
				// Elimino el id del array para que no se vuelva a repetir
				$usuarios = $usuarios->filter(function ($element) use ($rnd_res) { return ($element->id != $rnd_res->id); } );
			}
			$actividad->users()->attach($ids);
		});
    }
}
