<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Http;

class ImagesController extends Controller {
  public function index() {
    $images = auth()->user()->images();
    return view('dashboard', compact('images'));
  }

  public function add() {
    return view('add');
  }

  public function create(Request $request) {
    if ($request->hasFile('image_file')) {
      if ($request->file('image_file')->isValid()) {
        $validated = $request->validate([
          'name' => 'string|max:40',
          'image_file' => 'required|mimes:png|max:1014',
        ]);
        $b64_file = base64_encode(file_get_contents($request->image_file->path()));
        $response = Http::asForm()->post('https://test.rxflodev.com', [
          'imageData' => $b64_file,
        ]);
        $json = json_decode($response, true);
        if($json['status'] == "success") {
          $images = new Image();
          $images->image_url = $json['url'];
          $images->user_id = auth()->user()->id;
          $images->save();
        }
        return redirect('/dashboard');
      }
    }
    return view('add')->withErrors(["error" => "No file added!"]);
  }

  public function view(Image $image) {
    if (auth()->user()->id == $image->user_id) {
      return view('view', compact('image'));
    } else {
      return redirect('/dashboard');
    }
  }

  public function edit(Image $image) {
    if (auth()->user()->id == $image->user_id) {
      return view('edit', compact('image'));
    } else {
      return redirect('/dashboard');
    }
  }

  public function update(Request $request, Image $image) {
    if (isset($_POST['delete'])) {
      $image->delete();
      return redirect('/dashboard');
    } else {
      $this->validate($request, [
        'image_url' => 'required'
      ]);
      $image->image_url = $request->image_url;
      $image->save();
      return redirect('/dashboard'); 
    } 
  }
}