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
         $this->call(CreateAdminData::class);
    }

    /**
     * {@inheritdoc}
     */
    public function call($class, $silent = false): void
    {
        if (!empty($class) && !in_array($class, $this->seedsRan, true)) {
            parent::call($class, $silent);

            DB::table($this->table)->insert(['seed_name' => $class]);
        } else {
            $this->command->getOutput()->writeln("<info>Seed already run, skipping:</info> $class");
        }
    }

    public function getRan(): array
    {
        return DB::table($this->table)->pluck('seed_name')->toArray();
    }
}
