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
        for($i = 0;$i <= 3; $i++){
            $path = base_path()."/database/seeds/me_sucks.png";
            $img = Image::make($path);
            //org
            $img->stream();
            $fileorg = uniqid('img_');
            Storage::disk('public')->put('images/arts/org/'.$fileorg, $img, 'public');

            //thumbnail
            $thumbnail = Image::make($path)->resize(200, 250, function($constraint){
                $constraint->aspectRatio();
            });
            $thumbnail->stream();
            $filethumb = uniqid('img_');
            Storage::disk('public')->put('images/arts/thumb/'.$filethumb, $thumbnail, 'public');

            $work = new Work;
            $work->title = "Me Sucks".$i;
            $work->artist_id = 1;
            $work->type = "painting";
            $work->medium = "mix";
            $work->style = "contemporary";
            $work->size = "720X720";
            $work->image_path = $fileorg;
            $work->image_thumb = $filethumb;
            $work->asking_price = 9487+$i;
            $work->descript = str_repeat("Yes! I really suck!\n", 5);
            $work->save();
        }
    }
}
