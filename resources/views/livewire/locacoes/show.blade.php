<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Locacao;
use App\Models\Carro;

new class extends Component {
    public $locacoes;

    public function mount()
    {
        $this->locacoes = Auth::user()->carros->where('status', 'Reservado');
    }

    public function destroy($user_id, $carro_id)
    {
        $carro = Carro::find($carro_id);
        $carro->status = 'Livre';
        $carro->users()->detach($user_id);
        $carro->save();

        session()->flash('message', 'Locação excluída com sucesso!');

        return redirect()->to(route('locacoes.show'));
    }

    public function devolver($carro_id)
    {
        $carro = Carro::find($carro_id);
        $carro->status = 'Livre';
        $carro->save();

        session()->flash('message', 'Devolução realizada com sucesso!');
        return redirect()->to(route('locacoes.show'));
    }
}; ?>

<div>

    @if (count($locacoes) == 0)
        <div class="p-5 m-3 bg-white shadow-md rounded-md">
            <div>
                <p class="text-lg">Você ainda não realizou nenhuma locação :(</p>
            </div>
        </div>
    @else
        <div class="grid grid-cols-2 p-6 gap-3">
            @foreach ($locacoes as $carro)
                <div class="border-gray-900/10 pb-12">
                    <div class="">
                        <div class="">
                            <div
                                class="grid sm:grid-cols-2  bg-white rounded-2xl pb-4 overflow-hidden border border-gray-500/30">
                                <div class="flex flex-wrap items-center justify-center gap-4 ">
                                    <div class="">
                                        <p class="text-sm/6 text-gray-900 text-center m-3">Carro Selecionado</p>
                                        <img class="w-64 h-52 object-cover object-top opacity-60"
                                            src="/storage/{{ $carro->imagem }}"
                                            alt="{{ $carro->marca . ' ' . $carro->modelo }}">
                                        <div class="flex flex-col items-center gap-2 opacity-60">
                                            <p class="font-medium mt-3">{{ $carro->marca . ' ' . $carro->modelo }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-4 flex-col flex justify-between px-2">
                                    <div class="">
                                        <p class="text-lg">Status:
                                            <span @class([
                                                'text-green-500' => $carro->status == 'Livre',
                                                'text-yellow-500' => $carro->status == 'Reservado',
                                            ])>
                                                {{ $carro->status }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-lg">
                                            Retirada: {{ date_format(date_create($carro->pivot->taken),'d/m/Y' ) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-lg">Devolução:
                                            {{ $carro->pivot->returned ? $carro->pivot->returned : 'Devolução Pendente' }}
                                        </p>
                                    </div>
                                    <div class="flex flex-row gap-3 mt-2">
                                        <x-danger-button
                                            wire:click="destroy({{ $carro->pivot->user_id }}, {{ $carro->pivot->carro_id }})">Excluir</x-danger-button>
                                        <x-primary-button wire:click="devolver({{ $carro->id }})">Realizar
                                            Devolução</x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
            @endforeach

        </div>
    @endif


</div>
