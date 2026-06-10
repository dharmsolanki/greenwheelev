<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Scooter, ScooterImage};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ScooterAdminController extends Controller {
    public function index() {
        return view('admin.scooters.index', ['scooters'=>Scooter::with('images')->latest()->paginate(20)]);
    }

    public function create() {
        return view('admin.scooters.form', ['scooter'=>new Scooter]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'         => 'required',
            'category'     => 'required',
            'price'        => 'required|numeric',
            'range'        => 'required',
            'top_speed'    => 'required',
            'charging_time'=> 'required',
            'motor_power'  => 'required',
            'images.*'     => 'nullable|image|max:5120',
        ]);

        $data = $request->except('images','primary_image');
        $data['slug'] = Str::slug($request->name);
        $scooter = Scooter::create($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('scooters', 'public');
                ScooterImage::create([
                    'scooter_id'  => $scooter->id,
                    'image_path'  => $path,
                    'alt_text'    => $scooter->name.' - Image '.($index+1),
                    'is_primary'  => $index === 0,
                    'sort_order'  => $index,
                ]);
            }
        }

        return redirect()->route('admin.scooters.index')->with('success','Scooter added with '.($request->file('images') ? count($request->file('images')) : 0).' images!');
    }

    public function edit(Scooter $scooter) {
        $scooter->load('images');
        return view('admin.scooters.form', compact('scooter'));
    }

    public function update(Request $request, Scooter $scooter) {
        $request->validate([
            'name'     => 'required',
            'category' => 'required',
            'price'    => 'required|numeric',
            'images.*' => 'nullable|image|max:5120',
        ]);

        $data = $request->except('images','primary_image','delete_images');
        $scooter->update($data);

        // Delete selected images
        if ($request->delete_images) {
            foreach ($request->delete_images as $imageId) {
                $img = ScooterImage::find($imageId);
                if ($img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        // Set primary image
        if ($request->primary_image) {
            ScooterImage::where('scooter_id',$scooter->id)->update(['is_primary'=>false]);
            ScooterImage::where('id',$request->primary_image)->update(['is_primary'=>true]);
        }

        // Add new images
        if ($request->hasFile('images')) {
            $lastOrder = $scooter->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('scooters', 'public');
                $isPrimary = $scooter->images()->count() === 0 && $index === 0;
                ScooterImage::create([
                    'scooter_id' => $scooter->id,
                    'image_path' => $path,
                    'alt_text'   => $scooter->name.' - Image '.($lastOrder+$index+1),
                    'is_primary' => $isPrimary,
                    'sort_order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.scooters.index')->with('success','Scooter updated!');
    }

    public function destroy(Scooter $scooter) {
        // Delete all images from storage
        foreach ($scooter->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $scooter->delete();
        return back()->with('success','Scooter deleted.');
    }

    public function show(Scooter $scooter) {
        $scooter->load('images');
        return view('admin.scooters.show', compact('scooter'));
    }

    // AJAX - delete single image
    public function deleteImage(ScooterImage $image) {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return response()->json(['success'=>true]);
    }

    // AJAX - set primary image
    public function setPrimary(ScooterImage $image) {
        ScooterImage::where('scooter_id',$image->scooter_id)->update(['is_primary'=>false]);
        $image->update(['is_primary'=>true]);
        return response()->json(['success'=>true]);
    }
}
