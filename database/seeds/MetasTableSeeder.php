<?php

use Illuminate\Database\Seeder;

class MetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(App\Meta::class, 120)->create()->each(function(App\Meta $meta){
			$responsables = App\Actividad::find($meta->actividad_id)->responsables()->get();
			$ids = [];
			for ($i=0; $i < $responsables->count(); $i++) {
				$rnd_res = $responsables->random();
				array_push($ids, $rnd_res->id);
				// Elimino el id del array para que no se vuelva a repetir
				$responsables = $responsables->filter(function ($element) use ($rnd_res) { return ($element->id != $rnd_res->id); } );
			}
			$meta->responsables()->attach($ids);
		});
	}
}
