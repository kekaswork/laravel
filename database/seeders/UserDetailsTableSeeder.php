<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Generator;
use Illuminate\Container\Container;

class UserDetailsTableSeeder extends Seeder
{

	/**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        
        for( $i = 1; $i <= 15; $i ++ ) {
            $created_at = $this->faker->dateTimeBetween('-2 days', 'now');

        	$data[] = [
        		'user_id' => (string) $i,
        		'user_address' => $this->faker->address,
                'created_at' => $created_at,
                'updated_at' => $created_at,
        	];
        }

        \DB::table('user_details')->insert( $data );
    }
}
