<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rooms;

class RoomManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $name, $description, $price, $size, $status = 'tersedia', $fasilitas, $stok = 1;
    public $search = '';
    public $editMode = false;
    public $roomId;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'size' => 'nullable|string|max:50',
        'status' => 'required|in:tersedia,terisi,perawatan,sudah_dipesan',
        'fasilitas' => 'nullable|string',
        'stok' => 'required|integer|min:0',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->size = '';
        $this->status = 'tersedia';
        $this->fasilitas = '';
        $this->stok = 1;
        $this->editMode = false;
        $this->roomId = null;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'size' => $this->size,
            'status' => $this->status,
            'fasilitas' => $this->fasilitas,
            'stok' => $this->stok,
        ];

        if ($this->editMode) {
            $room = Rooms::find($this->roomId);
            $room->update($data);
            session()->flash('message', 'Kamar berhasil diupdate.');
        } else {
            Rooms::create($data);
            session()->flash('message', 'Kamar berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $room = Rooms::findOrFail($id);
        $this->roomId = $id;
        $this->name = $room->name;
        $this->description = $room->description;
        $this->price = $room->price;
        $this->size = $room->size;
        $this->status = $room->status;
        $this->fasilitas = $room->fasilitas;
        $this->stok = $room->stok;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        Rooms::find($id)->delete();
        session()->flash('message', 'Kamar berhasil dihapus.');
    }

    public function render()
    {
        $rooms = Rooms::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.room-management', [
            'rooms' => $rooms
        ]);
    }
}
