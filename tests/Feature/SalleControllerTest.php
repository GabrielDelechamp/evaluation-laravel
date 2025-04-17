<?php

namespace Tests\Feature;

use App\Http\Controllers\SalleController;
use App\Models\Salle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SalleControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;
    protected $user;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new SalleController();

        // Créer des utilisateurs tests
        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create();

        // Assigner le rôle admin à l'admin
        \Bouncer::assign('admin')->to($this->adminUser);
    }

    public function testIndex()
    {
        // Créer quelques salles
        Salle::factory()->count(3)->create();

        // Simuler un utilisateur connecté
        Auth::shouldReceive('user')->andReturn($this->user);

        // Exécuter la méthode index
        $response = $this->controller->index();

        // Vérifier la vue et les données
        $this->assertEquals('salle.indexSalle', $response->getName());
        $data = $response->getData();
        $this->assertCount(3, $data['salles']);
    }

    public function testCreateAsAdmin()
    {
        // Simuler un admin connecté
        Auth::shouldReceive('user')->andReturn($this->adminUser);

        // Exécuter la méthode create
        $response = $this->controller->create();

        // Vérifier la vue retournée
        $this->assertEquals('salle.createSalle', $response->getName());
    }

    public function testCreateAsNormalUser()
    {
        // Simuler un utilisateur normal connecté
        Auth::shouldReceive('user')->andReturn($this->user);

        // Nous attendons une exception 403
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Accès non autorisé.');

        // Exécuter la méthode create
        $this->controller->create();
    }

    public function testStoreAsAdmin()
    {
        // Simuler un admin connecté
        Auth::shouldReceive('user')->andReturn($this->adminUser);

        // Préparer la requête
        $requestData = [
            'name' => 'Nouvelle Salle',
            'capacity' => 15,
            'surface' => 30
        ];

        $request = Request::create('/salle', 'POST', $requestData);

        // Exécuter la méthode store
        $response = $this->controller->store($request);

        // Vérifier qu'une nouvelle salle a été créée
        $this->assertDatabaseHas('salles', [
            'name' => 'Nouvelle Salle',
            'capacity' => 15,
            'surface' => 30
        ]);

        // Vérifier la vue retournée
        $this->assertEquals('salle.indexSalle', $response->getName());
    }

    public function testStoreAsNormalUser()
    {
        // Simuler un utilisateur normal connecté
        Auth::shouldReceive('user')->andReturn($this->user);

        // Préparer la requête
        $requestData = [
            'name' => 'Nouvelle Salle',
            'capacity' => 15,
            'surface' => 30
        ];

        $request = Request::create('/salle', 'POST', $requestData);

        // Nous attendons une exception 403
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Accès non autorisé.');

        // Exécuter la méthode store
        $this->controller->store($request);
    }

    public function testEditAsAdmin()
    {
        // Créer une salle
        $salle = Salle::factory()->create();

        // Simuler un admin connecté
        Auth::shouldReceive('user')->andReturn($this->adminUser);

        // Exécuter la méthode edit
        $response = $this->controller->edit($salle);

        // Vérifier la vue retournée
        $this->assertEquals('salle.editSalle', $response->getName());
        $data = $response->getData();
        $this->assertEquals($salle->id, $data['salle']->id);
    }

    public function testEditAsNormalUser()
    {
        // Créer une salle
        $salle = Salle::factory()->create();

        // Simuler un utilisateur normal connecté
        Auth::shouldReceive('user')->andReturn($this->user);

        // Nous attendons une exception 403
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Accès non autorisé.');

        // Exécuter la méthode edit
        $this->controller->edit($salle);
    }

}
