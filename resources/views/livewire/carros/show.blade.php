<?php

use Livewire\Volt\Component;
use App\Models\Carro;

new class extends Component {

    public $carros;

    public function mount()
    {
        $this->carros = Carro::all();
    }

    public function destroy($id)
    {
        $carro = Carro::find($id);
        $carro->delete();
        session()->flash('message', 'Carro excluído com sucesso!');
        return redirect()->to(route('dashboard'));
    }

}; ?>

<div>

    @if(count($carros) == 0)
        <div class="p-5 bg-white shadow-md rounded-md">
            <div>
                <p class="text-lg">nenhum carro cadastrado</p>
            </div>
        </div>
    @else
        <div
            class="grid lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-1 gap-3">
            @foreach($carros as $carro)
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <div class="bg-white rounded-2xl pb-4 overflow-hidden border border-gray-500/30">
                        <img class="w-64 h-52 object-cover object-top"
                             src="/storage/{{ $carro->imagem }}" alt="{{ $carro->marca . ' ' . $carro->modelo }}">
                        <div class="flex flex-col items-center gap-2">
                            <p class="font-medium mt-3">{{ $carro->marca . ' ' . $carro->modelo }}</p>
                            <p class="text-gray-500 text-sm">{{ $carro->status }}</p>
                            <div class="d-flex flex-row ">
                                @if(Auth::user() == $carro->user)
                                    <a href="{{ route('carros.edit', ['id' => $carro->id]) }}">
                                        <x-secondary-button>
                                            Editar
                                        </x-secondary-button>
                                    </a>
                                    <x-danger-button
                                        wire:click="destroy({{$carro->id}})"
                                        wire:confirm="Você está certo que deseja excluir esse veículo?"
                                    >
                                        Deletar
                                    </x-danger-button>
                                @else
                                    <a href="{{ route('locacoes.create', ['id' => $carro->id]) }}">
                                        <x-secondary-button>
                                            Alugar
                                        </x-secondary-button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

