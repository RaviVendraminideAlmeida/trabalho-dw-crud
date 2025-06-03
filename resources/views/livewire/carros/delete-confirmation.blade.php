<?php

use Livewire\Volt\Component;
use App\Models\Carro;

new class extends Component {

    public $id, $carro;

    public function mount()
    {
        $this->carro = Carro::find($this->id);
    }

    public function destroy()
    {
        $this->carro->delete();
    }

}

?>
<div>




</div>

