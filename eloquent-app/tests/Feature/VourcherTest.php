<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class VourcherTest extends TestCase
{

    public function setUp(): void{

        parent::setUp();
        DB::delete("DELETE FROM vouchers");
    }

    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->voucher_code = "12345789123";
        $voucher->save();

        self::assertNotNull($voucher->id);
    }

    public function testCreateVoucherUUID(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->save();

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }

    public function testSoftDeletes(): void
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where("name" , '=', "Sample Voucher")->first();
        $voucher->delete();
        
        $voucher = Voucher::where("name" , '=', "Sample Voucher")->first();
        self::assertNull($voucher);

        // Mengambil data yang soft delete
        $voucher = Voucher::withTrashed()->where("name" , '=', "Sample Voucher")->first();
        self::assertNotNull($voucher);
    }

    public function testLocalScope(): void
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->is_active = true;
        $voucher->save();

        $total = Voucher::query()->active()->count();
        self::assertEquals(1, $total);

        $total = Voucher::query()->nonActive()->count();
        self::assertEquals(0, $total);
    }
}
