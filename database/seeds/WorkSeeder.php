<?php

use Illuminate\Database\Seeder;
use App\Work;
class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //add artist1 work
        // $f = fopen( base_path()."/database/seeds/me_sucks.png", "r");
        // $image = fgetc($f);
        // $base64 = base64_encode($image);
        $img = Image::make(base_path()."/database/seeds/me_sucks.png");
        $img->stream();
        $filename = uniqid('img_');
        Storage::disk('public')->put('images/'.$filename, $img, 'public');

        $work = new Work;
        $work->title = "Me Sucks";
        $work->artist_id = 1;
        $work->type = "painting";
        $work->medium = "mix";
        $work->style = "contemporary";
        $work->size = "720X720";
        $work->image_path = "images/".$filename;
        $work->asking_price = 9487;
        $work->save();
    }
}
