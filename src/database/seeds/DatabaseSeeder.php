<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $seedsRan = [];

    protected $table = 'seeds';

    public function __construct()
    {
        $this->seedsRan = $this->getRan();
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             CreateAdminData::class,
             CreateStripePlans::class,
             CreateSocialFocusSeeder::class,
         ]);
    }

    /**
     * {@inheritdoc}
     */
    public function call($class, $silent = false): void
    {
        if (!is_array($class)) {
            $class = [$class];
        }

        foreach ($class as $seed) {
            if (!in_array($seed, $this->seedsRan, true)) {
                parent::call($seed, $silent);

                DB::table($this->table)->insert(['seed_name' => $seed]);
            } else {
                $this->command->getOutput()->writeln("<info>Seed already run, skipping:</info> $seed");
            }
        }
    }

    public function getRan(): array
    {
        return DB::table($this->table)->pluck('seed_name')->toArray();
    }
}
