<?php

use Illuminate\Database\Seeder;
use App\Artist;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create artist Role and Permission

        $artists = [];
        $f = fopen( base_path()."/database/seeds/artist_parsed.csv", "r");
        while (($data = fgetcsv($f, 1000, ",")) !== FALSE) 
        {
            $artists[] = $data;
        }
        fclose($f);

        foreach($artists as $i=>$row){
            if($i !== 0){
                $artist = new Artist;
                $artist->artist_ssn = $row[0];
                $artist->name = $row[1];
                $artist->address = $row[2];
                $artist->phone = $row[3];
                $artist->usual_type = $row[4];
                $artist->usual_medium = $row[5];
                $artist->usual_style = $row[6];
                $artist->sales_last_year = (int)$row[7];
                $artist->sales_year_to_date = (int)$row[8];
                $artist->artist_email = "artist".$i."@mail.com";
                $artist->save();
                
                $user = new User;
                $user->name = $row[1];
                $user->email = "artist".$i."@mail.com";
                $user->password = Hash::make('password');
                $user->assignRole('artist');
                $user->save();
            } 
        }
    }
}
