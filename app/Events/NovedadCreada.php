<?php

namespace App\Events;

use App\Models\Novedad;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class NovedadCreada implements ShouldBroadcastNow
{
    use SerializesModels;

    public $novedad;
    public $shouldBroadcastImmediately = true;

    public function __construct(Novedad $novedad)
    {
        // Cargar relaciones importantes
        $this->novedad = $novedad->load('vehiculo.conductor');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('admin.alertas');
    }

    public function broadcastAs()
    {
        return 'novedad.creada';
    }
}
