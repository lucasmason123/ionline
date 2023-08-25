<?php

namespace App\Http\Livewire\Parameters;

use App\Models\Establishment;
use App\Models\Parameters\Location;
use App\Models\Parameters\Place;
use Livewire\Component;
use Livewire\WithPagination;

class Places extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $establishment;
    public $view;
    public $place;
    public $name;
    public $description;
    public $location_id;
    public $locations;
    public $filter;

    public function render()
    {
        return view('livewire.parameters.places', [
            //'places' => Place::latest()->paginate(10)
            'places' => $this->getPlaces()
        ]);
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|min:2|max:255',
            'description'   => 'nullable|string|min:0|max:255',
            'location_id'   => 'required|exists:cfg_locations,id',
            'architectural_design_code'   => 'nullable|string|min:0|max:255',
        ];
    }

    public function mount(Establishment $establishment)
    {
        $this->view = 'index';
    }

    public function index()
    {
        $this->view = 'index';
    }

    public function create()
    {
        $this->view = 'create';
        $this->place = null;
        $this->name = null;
        $this->description = null;
        $this->location_id = null;
        $this->locations = Location::whereEstablishmentId($this->establishment->id)->get();
    }

    public function store()
    {
        $dataValidated = $this->validate();
        $dataValidated['establishment_id'] = $this->establishment->id;
        $place = Place::create($dataValidated);
        $this->mount($this->establishment);

        session()->flash('info', 'Se ha creado la oficina con el id <span class="h5">' . $place->id . "</span>. Por favor anote el número en la hoja de inventario que está ubicada en la pared.");

        $this->reset([
            'name',
            'description',
            'location_id'
        ]);
        $this->view = 'create';
    }

    public function searchPlace()
    {
        $this->resetPage(); // Reinicia la paginación a la primera página
    }

    public function edit(Place $place)
    {
        $this->view = 'edit';
        $this->place = $place;
        $this->locations = Location::all();

        $this->name = $place->name;
        $this->description = $place->description;
        $this->location_id = $place->location_id;
    }

    public function update(Place $place)
    {
        $place->update($this->validate());
        $this->mount($this->establishment);

        session()->flash('info', 'La oficina fue actualizada exitosamente.');

        $this->view = 'index';
    }

    public function delete(Place $place)
    {
        $place->delete();
        $this->mount($this->establishment);
    }

    public function getPlaces()
    {
        $query = Place::query()
            ->orderBy('name', 'asc')
            ->with('establishment')
            ->when($this->establishment, function ($query) {
                $query->whereEstablishmentId($this->establishment->id);
            });

        if ($this->filter) {
            $searchTerm = '%' . $this->filter . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm)
                    ->orWhereHas('location', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', $searchTerm);
                    })
                    ->orWhere('architectural_design_code', 'LIKE', $searchTerm);
            });
        }

        return $query->paginate(100);
    }
}
