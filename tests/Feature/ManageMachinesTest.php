<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageMachinesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**  @test  */
    public function guests_cannnot_manage_machines()
    {
        $machine = factory(\App\Machine::class)->create();

        $this->get('admin/machines')->assertRedirect('/login');
        $this->get('admin/machines/create')->assertRedirect('/login');
        $this->post('admin/machines', $machine->toArray())->assertRedirect('/login');
    }

    /**  @test  */
    public function a_user_can_view_machines()
    {
        $this->actingAs($this->authenticatedUser);

        factory(\App\Machine::class, 5)->create();

        $this->get('admin/machines')->assertSee('Machines')->assertStatus(200);
    }

    /**  @test  */
    public function a_user_can_create_a_machine()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->authenticatedUser);

        $this->get('admin/machines/create')->assertStatus(200);

        $attributes = factory(\App\Machine::class)->raw();

        $this->post('admin/machines', $attributes)->assertRedirect('/admin/machines');

        $this->assertDatabaseHas('machines', $attributes);

        $this->get('admin/machines')->assertSee($attributes['name']);
    }

    /**  @test  */
    public function a_user_can_update_a_machine()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->authenticatedUser);

        $machine = factory(\App\Machine::class)->create();

        $updatedMachine = factory(\App\Machine::class)->raw();

        // Check the edit route is working
        $this->get($machine->path())->assertStatus(200);

        $this->put($machine->path(), $updatedMachine)->assertRedirect('/admin/machines');

        $this->assertDatabaseHas('machines', array_merge(['id' => $machine->id], $updatedMachine));
    }

    /**  @test  */
    public function a_user_can_delete_a_machine()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->authenticatedUser);

        $machine = factory(\App\Machine::class)->create();

        $this->delete($machine->path())->assertRedirect('/admin/machines');

        $this->assertDatabaseMissing('machines', $machine->toArray());
    }

    /**  @test  */
    public function a_machine_requires_a_name()
    {
        $this->actingAs($this->authenticatedUser);

        $attributes = factory(\App\Machine::class)->raw(['name' => '']);

        $this->post('admin/machines', $attributes)->assertSessionHasErrors('name');
    }

    /**  @test  */
    public function a_machine_requires_a_price()
    {
        $this->actingAs($this->authenticatedUser);

        $attributes = factory(\App\Machine::class)->raw(['price' => '']);

        $this->post('admin/machines', $attributes)->assertSessionHasErrors('price');
    }

    /**  @test  */
    public function machines_should_be_visible_on_the_front_end()
    {
        $this->actingAs($this->authenticatedUser);

        $machines = factory(\App\Machine::class, 5)->create();

        $homePage = $this->get('/');

        foreach ($machines as $machine) {
            $homePage->assertSeeText($machine->name);
            $homePage->assertSeeText($machine->price);
            $homePage->assertSeeText($machine->description);
        }
    }
}
