<?php

use App\Container\Financial\src\FileType;
use Illuminate\Database\Seeder;

class FileTypeFinancialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $files = [
            [ file_types() => 'ICETEX' ],
            [ file_types() => 'FRACCIONAMIENTO DE MATRÍCULA' ],
        ];

        foreach ($files as $file) {
            FileType::create( $file );
        }
    }
}