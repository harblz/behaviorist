<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate = ['users', 'guardians', 'clients', 'agencies'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach($this->toTruncate as $table) {
    		DB::table($table)->truncate();
    	}

        $this->call('UsersTableSeeder');
        $this->call('ClientsTableSeeder');
        $this->call('StaffTableSeeder');
        $this->call('GuardiansTableSeeder');
        $this->call('AgencyTableSeeder');
        $this->call('GuardianRelationshipsTableSeeder');
        $this->call('AppointmentsTableSeeder');
        $this->call('SessionNotesTableSeeder');
    }
}
