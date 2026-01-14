<?php

namespace Tests\Feature;

use App\Models\FabricationStep;
use App\Models\Sample;
use App\Models\User;
use App\Models\Wafer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FabricationStepTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $wafer = Wafer::create(['name' => 'Test Wafer', 'description' => 'Test']);
        $sample = Sample::create(['wafer_id' => $wafer->id, 'name' => 'Test Sample', 'description' => 'Test']);
        $fabricationStep = FabricationStep::create([
            'sample_id' => $sample->id,
            'user_id' => $user->id,
            'activity_name' => 'Test Activity',
            'description' => 'Test Description',
            'performed_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('fabrication-steps.edit', $fabricationStep));

        $response->assertOk();
        $response->assertSee('Test Activity');
        $response->assertSee('Test Description');
    }

    public function test_fabrication_step_can_be_updated(): void
    {
        $user = User::factory()->create();
        $wafer = Wafer::create(['name' => 'Test Wafer', 'description' => 'Test']);
        $sample = Sample::create(['wafer_id' => $wafer->id, 'name' => 'Test Sample', 'description' => 'Test']);
        $fabricationStep = FabricationStep::create([
            'sample_id' => $sample->id,
            'user_id' => $user->id,
            'activity_name' => 'Original Activity',
            'description' => 'Original Description',
            'performed_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('fabrication-steps.update', $fabricationStep), [
                'activity_name' => 'Updated Activity',
                'description' => 'Updated Description',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('samples.show', $sample));

        $fabricationStep->refresh();

        $this->assertSame('Updated Activity', $fabricationStep->activity_name);
        $this->assertSame('Updated Description', $fabricationStep->description);
    }

    public function test_fabrication_step_update_requires_activity_name(): void
    {
        $user = User::factory()->create();
        $wafer = Wafer::create(['name' => 'Test Wafer', 'description' => 'Test']);
        $sample = Sample::create(['wafer_id' => $wafer->id, 'name' => 'Test Sample', 'description' => 'Test']);
        $fabricationStep = FabricationStep::create([
            'sample_id' => $sample->id,
            'user_id' => $user->id,
            'activity_name' => 'Original Activity',
            'description' => 'Original Description',
            'performed_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->put(route('fabrication-steps.update', $fabricationStep), [
                'activity_name' => '',
                'description' => 'Updated Description',
            ]);

        $response->assertSessionHasErrors('activity_name');
    }
}
