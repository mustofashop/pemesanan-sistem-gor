<?php

namespace App\Http\Controllers\Event;

//import Model "Post
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Label;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


//return type View
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(): View
    {
        //get posts
        $data = Event::latest()->paginate(5);
        $label = Label::all();

        //render view with data
        return view('event.transaction.index', compact('data', 'label'));
    }

    public function create(): View
    {
        $label = Label::all();
        return view('event.transaction.create', compact('label'));
    }

    public function store(Request $request, $id): RedirectResponse
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048' . $id,
            'title'         => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'date'          => 'required',
            'time'          => 'required',
            'location'      => 'required',
            'status'        => 'required',
            'maps'          => 'required',
            'organizer'     => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'expiry_date'   => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event = \App\Models\Event::latest()->first();
        $kodeEvent = "EPB-";
        if ($event == null) {
            $kodeEvent = "EPB-0001";
        } else {
            $kodeEvent = "EPB-" . sprintf("%04s", $event->id + 1);
        }

        //upload image
        if ($request->hasFile('image')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('event', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            //create post
            $event = new Event;
            $event->image       = $imageName;
            $event->code        = $kodeEvent;
            $event->title       = $request->input('title');
            $event->price       = str_replace(".", "", $request->input('price'));
            $event->description = strip_tags($request->input('description'));
            $event->date        = $request->input('date');
            $event->time        = $request->input('time');
            $event->location    = $request->input('location');
            $event->status      = $request->input('status');
            $event->maps        = $request->input('maps');
            $event->organizer   = $request->input('organizer');
            $event->start_date  = $request->input('start_date');
            $event->end_date    = $request->input('end_date');
            $event->expiry_date = $request->input('expiry_date');
            $event->save();
        }
        //redirect to index
        return redirect()->route('event.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        //get post by ID
        $data = Event::findOrFail($id);
        $label = Label::all();
        // return response()->json($data);

        //render view with post
        return view('event.transaction.show', compact('data', 'label'));
    }

    public function edit(string $id): View
    {
        $data = Event::findOrFail($id);
        $label = Label::all();
        return view('event.transaction.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048' . $id,
            'title'         => 'required',
            'price'         => 'required',
            'description'   => 'required',
            'date'          => 'required',
            'time'          => 'required',
            'location'      => 'required',
            'status'        => 'required',
            'maps'          => 'required',
            'organizer'     => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required',
            'expiry_date'   => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $event =   Event::findOrFail($id);
        if (!$event) {
            return redirect()->route('event.transaction.index')->with('error', 'Event not found.');
        }

        //upload image
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($event->image) {
                Storage::delete('public/event/' . $event->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('event', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $event->image = $imageName;
        }

        //create post
        $event->title       = $request->input('title');
        $event->price       = $request->input('price');
        $event->description = strip_tags($request->input('description'));
        $event->date        = $request->input('date');
        $event->time        = $request->input('time');
        $event->location    = $request->input('location');
        $event->status      = $request->input('status');
        $event->maps        = $request->input('maps');
        $event->organizer   = $request->input('organizer');
        $event->start_date  = $request->input('start_date');
        $event->end_date    = $request->input('end_date');
        $event->expiry_date = $request->input('expiry_date');
        $event->save();

        return redirect()->route('event.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Event::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "About deleted successfully.";
        } else {
            $success = false;
            $message = "About deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
