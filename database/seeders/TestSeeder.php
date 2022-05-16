<?php

namespace Database\Seeders;

use App\Models\Comanda;
use App\Models\Mesa;
use App\Models\Mesero;
use App\Models\Plato;
use App\Models\PlatosComanda;
use App\Models\Restaurante;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $restaurante = Restaurante::create(['nombre' => 'Restaurante 1']);
        Restaurante::create(['nombre' => 'Restaurante 2']);

        // $andres = Mesero::create(['nombre' => 'Andres']);
        // $david = Mesero::create(['nombre' => 'David']);

        $mesa01 = Mesa::create(['restaurante_id' => $restaurante->id, 'numero' => '01']);
        $mesa02 = Mesa::create(['numero' => '02']);

        $plato01 = Plato::create([
            'restaurante_id' => $restaurante->id,
            'categoria_id'  => 5,
            'nombre'        => 'Sushi santandereano',
            'precio'        => 20000.00,
            'cantidad'      => 10,
            'disponible'    => TRUE
        ]);

        $plato02 = Plato::create([
            'restaurante_id' => $restaurante->id,
            'categoria_id'  => 5,
            'nombre'        => 'Suve de conejo',
            'precio'        => 25000.00,
            'cantidad'      => 10,
            'disponible'    => TRUE
        ]);

        // $comanda01 = Comanda::create([
        //     'mesa_id' => $mesa01->id,
        //     'mesero_id' => $andres->id,
        //     'codigo' => 'Andres - 01',
        //     'entregada' => FALSE,
        //     'total' => 0.00,
        // ]);

        // $comanda02 = Comanda::create([
        //     'mesa_id' => $mesa02->id,
        //     'mesero_id' => $david->id,
        //     'codigo' => 'David 02',
        //     'entregada' => FALSE,
        //     'total' => 0.00,
        // ]);

        // $platosComanda1 = PlatosComanda::create([
        //     'comanda_id' => $comanda01->id,
        //     'plato_id' => $plato01->id,
        //     'precio' => 20000.00,
        //     'cantidad' => 1
        // ]);
        // $plato = $platosComanda1->plato;
        // $plato->update(['cantidad' => $plato->cantidad - $platosComanda1->cantidad]);

        // $platosComanda2 = PlatosComanda::create([
        //     'comanda_id' => $comanda02->id,
        //     'plato_id' => $plato02->id,
        //     'precio' => 20000.00,
        //     'cantidad' => 1
        // ]);
        // $plato = $platosComanda2->plato;
        // $plato->update(['cantidad' => $plato->cantidad - $platosComanda2->cantidad]);

    }
}

