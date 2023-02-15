<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Message;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSendMessage()
    {
        // Crear un usuario emisor y receptor para la prueba
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        // Llamar al método sendMessage en el controlador
        $response = $this->post('/api/messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Hola, ¿cómo estás?',
        ]);

        // Verificar que la respuesta del controlador es exitosa
        $response->assertStatus(201);

        // Verificar que se creó un mensaje en la base de datos
        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Hola, ¿cómo estás?',
        ]);
    }
}
