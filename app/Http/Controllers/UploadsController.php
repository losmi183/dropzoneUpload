<?php

namespace App\Http\Controllers;

use App\ImageUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UploadsController extends Controller
{
    public function index()
    {
        $images = ImageUpload::latest()->get();
        return view('welcome', [
            'images' => $images
        ]);
    }


    public function store()
    {
        // Proveravamo da slucajno ne postoji foldes sa imenom, i ako ne postoji kreiramo ga
        if(! is_dir(public_path('/images'))) {
            mkdir(public_path('/images'), 0777);
        }

        // Laravel automatski kreira UploadedFile klasu od request()->file('file') a to je posao dropzone
        // Potrebno je wrapovati u kolekciju, i posle pristupiti sa each metodom nad kolekcijom
        // Jer dropzone salje asinhrono, moraju se skupiti sa kolekcijom
        $images = Collection::wrap(request()->file('file'));

        $images->each(function($image) {

            // $image je tipa Illuminate\Http\UploadedFile, format koji se moze koristiti u Image::make()

            
            // Random ime dodajemo ekstenziju na to
            $basename = Str::random();
            $original = $basename . '.' . $image->getClientOriginalExtension();
            $thumbnail = $basename . '_thumb.' . $image->getClientOriginalExtension();


            // 1. Primenjujemo make method iz paketa, fit method u isto vreme radi crop i resize, na kraju sacuvamo thumbnail u istom folderu
            // 2. koristiomo save metodu da bi smo sacuvali novokreirani thumb 
            Image::make($image)
                ->fit(250, 250)
                ->save(public_path('/images/' . $thumbnail));

            // move method kao 1. arg dobija putanju a 2. arg je ime fajla (sa original extenzijom)
            // kod move metode direktorijum mora da postoji
            $image->move(public_path('/images'), $original);

            
            // Dodajemo filename u bazu
            ImageUpload::create([
                'original' => '/images/' . $original,
                'thumbnail' => '/images/' . $thumbnail
            ]);
        });

    }

    public function destroy(ImageUpload $imageUpload)
    {
        // Delete Files
        File::delete([
            public_path($imageUpload->original),
            public_path($imageUpload->thumbnail),
        ]);

        // Delete Record form database
        $imageUpload->delete();

        // Redirect
        return redirect('/');

    }

}
