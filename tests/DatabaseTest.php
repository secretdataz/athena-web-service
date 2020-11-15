<?php

use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DatabaseTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetWebServiceTable()
    {
        $count = DB::table('web_service')->where('key', 'woe')->count();
        $this->assertEquals(1, $count);
    }

    public function testUserConfigTable()
    {
        $ret = DB::table('user_configs')->insert([
            'account_id' => 2000001,
            'data' => '{}',
            'world_name' => 'rAthena',
        ]);
        $this->assertTrue($ret);
    }

    public function testEmblemTable()
    {
        $ret = DB::table('guild_emblems')->insert([
            'guild_id' => 1,
            'world_name' => 'rAthena',
            'file_name' => 'dummy.jpg',
            'version' => 0,
        ]);
        $this->assertTrue($ret);
    }
}
