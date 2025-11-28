<?php

namespace App\Events;

use App\Models\Novedad;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NovedadCreada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $novedad;

    public function __construct(Novedad $novedad)
    {
        $this->novedad = $novedad->load('vehiculo');
    }

    public function broadcastOn()
    {
        // Canal privado para administradores
        return new PrivateChannel('admin.alertas');
    }

    public function broadcastAs()
    {
        return 'novedad.creada';
    }
}
