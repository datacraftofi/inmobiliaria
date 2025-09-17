<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitud;

class DemoSolicitudSeeder extends Seeder
{
    public function run(): void
    {
        // Genera 20 solicitudes; cada una con 1-2 referencias, 1 soporte, 0-1 firma y 1 evento de auditoría
        Solicitud::factory()
            ->count(20)
            ->create()
            ->each(function (Solicitud $s) {
                $s->referencias()->createMany(
                    \Database\Factories\ReferenciaFactory::new()->count(rand(1,2))->make()->toArray()
                );

                $s->soportes()->create(
                    \Database\Factories\SoporteFactory::new()->make()->toArray()
                );

                if (rand(0,1)) {
                    $s->firmas()->create(
                        \Database\Factories\FirmaFactory::new()->make()->toArray()
                    );
                }

                $s->eventosAuditoria()->create(
                    \Database\Factories\EventoAuditoriaFactory::new()->make()->toArray()
                );
            });
    }
}
