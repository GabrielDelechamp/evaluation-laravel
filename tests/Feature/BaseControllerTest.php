<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BaseControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new Controller;

        // Créer un utilisateur test
        $this->user = User::factory()->create();
    }

    public function test_can_method_when_authorized()
    {
        // Simuler un utilisateur authentifié avec une capacité
        Auth::shouldReceive('user')->andReturn($this->user);
        Bouncer::allow($this->user)->to('view-dashboard');

        // Tester la méthode can
        $result = $this->controller->can('view-dashboard');

        // Vérifier que la méthode retourne true
        $this->assertTrue($result);
    }

    public function test_can_method_when_not_authorized()
    {
        // Simuler un utilisateur authentifié sans capacité
        Auth::shouldReceive('user')->andReturn($this->user);
        Bouncer::forbid($this->user)->to('view-dashboard');

        // Tester la méthode can
        $result = $this->controller->can('view-dashboard');

        // Vérifier que la méthode retourne false
        $this->assertFalse($result);
    }

    public function test_is_a_method_when_user_has_role()
    {
        // Simuler un utilisateur authentifié avec un rôle
        Auth::shouldReceive('user')->andReturn($this->user);
        Bouncer::assign('admin')->to($this->user);

        // Tester la méthode isA
        $result = $this->controller->isA('admin');

        // Vérifier que la méthode retourne true
        $this->assertTrue($result);
    }

    public function test_is_a_method_when_user_does_not_have_role()
    {
        // Simuler un utilisateur authentifié sans le rôle spécifié
        Auth::shouldReceive('user')->andReturn($this->user);

        // Tester la méthode isA
        $result = $this->controller->isA('admin');

        // Vérifier que la méthode retourne false
        $this->assertFalse($result);
    }

    public function test_is_a_method_when_user_is_not_authenticated()
    {
        // Simuler un utilisateur non authentifié
        Auth::shouldReceive('user')->andReturn(null);

        // Tester la méthode isA
        $result = $this->controller->isA('admin');

        // Vérifier que la méthode retourne false
        $this->assertFalse($result);
    }
}
