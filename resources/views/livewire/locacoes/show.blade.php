<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Locacao;

new class extends Component {

    public $locacoes;

    public function mount() {
        $this->locacoes = Locacao::where('user_id', '=', Auth::user()->id)->get();
    }

}; ?>

<div>

    @if(count($locacoes) == 0)
        <div class="p-5 bg-white shadow-md rounded-md">
            <div>
                <p class="text-lg">Você ainda não realizou nenhuma locação :(</p>
            </div>
        </div>
    @else
        <!-- TODO: Impl this -->
    @endif


</div>
