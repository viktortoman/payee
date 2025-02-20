<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\InterestCalculation;
use App\Models\InterestRate;
use Carbon\Carbon;

class InterestControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_get_all_interest_calculations()
    {
        InterestCalculation::factory()->count(3)->create();
        $response = $this->getJson('/api/interest');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => [
                    'start_date',
                    'end_date',
                    'calculated_interest',
                    'principal_amount',
                    'days_count'
                ]
            ]);
    }

    /**
     * @test
     */
    public function it_can_calculate_interest_successfully()
    {
        InterestRate::factory()->create([
            'effective_date' => Carbon::parse('2023-12-20'),
            'rate' => 10.75,
        ]);

        $payload = [
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-30',
            'amount' => 100000
        ];

        $response = $this->postJson('/api/interest/calculate', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'start_date',
                'end_date',
                'calculated_interest',
                'principal_amount',
                'days_count'
            ])
            ->assertJson([
                'start_date' => $payload['start_date'],
                'end_date' => $payload['end_date'],
                'principal_amount' => $payload['amount']
            ]);

        $this->assertDatabaseHas('interest_calculations', [
            'start_date' => $payload['start_date'],
            'end_date' => $payload['end_date'],
            'principal_amount' => $payload['amount']
        ]);
    }

    /**
     * @test
     */
    public function it_returns_error_when_no_interest_rate_found()
    {
        $payload = [
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-30',
            'amount' => 100000
        ];

        $response = $this->postJson('/api/interest/calculate', $payload);

        $response->assertStatus(500)
            ->assertJson([
                'error' => 'No interest rate found for the given dates: 2024-01-01 - 2024-01-30'
            ]);
    }
}

