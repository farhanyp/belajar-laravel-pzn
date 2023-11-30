<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    public function testFactory(): void
    {
        $employee1 = Employee::factory()->programmer()->create([
            'id' => '1',
            'name' => 'Employee 1',
        ]);
        self::assertNotNull($employee1);

        $employee2 = Employee::factory()->programmer()->create([
            'id' => '2',
            'name' => 'Employee 2',
        ]);
        self::assertNotNull($employee2);

        Log::info((Employee::query()->get()->toJson(JSON_PRETTY_PRINT)));
    }
}
