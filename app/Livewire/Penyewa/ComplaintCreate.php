<?php

namespace App\Livewire\Penyewa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Complaints;
use App\Models\Rooms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintCreate extends Component
{
    use WithFileUploads;

    public $room_id;
    public $title;
    public $description;
    public $image;

    protected $rules = [
        'room_id' => 'required|exists:rooms,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ];

    public function submit()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('complaints', 'public');
        }

        Complaints::create([
            'user_id' => Auth::id(),
            'room_id' => $this->room_id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $imagePath,
            'status' => 'pending',
        ]);

        session()->flash('success', 'Keluhan berhasil dilaporkan!');
        return redirect()->route('penyewa.complaints.index');
    }

    public function render()
    {
        $rooms = Rooms::all();
        return view('livewire.penyewa.complaint-create', compact('rooms'));
    }
}
