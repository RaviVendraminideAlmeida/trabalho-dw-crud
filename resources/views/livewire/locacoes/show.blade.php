<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Locacao;

new class extends Component {

    public $locacoes;

    public function mount()
    {
        $this->locacoes = Auth::user()->carros;
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
        @foreach($locacoes as $carro)
            <div class="border-gray-900/10 pb-12">
                <div class="grid lg:grid-cols-2 md:grid-cols-1 w-full min-w-64">
                    <div class="">
                        <div class="grid sm:grid-cols-2  bg-white rounded-2xl pb-4 overflow-hidden border border-gray-500/30">
                            <div class="flex flex-wrap items-center justify-center gap-4">
                                <div class="">
                                    <p class="text-sm/6 text-gray-600 text-center m-3">Carro Selecionado</p>
                                    <img class="w-64 h-52 object-cover object-top" src="/storage/{{ $carro->imagem }}"
                                        alt="{{ $carro->marca . ' ' . $carro->modelo }}">
                                    <div class="flex flex-col items-center gap-2">
                                        <p class="font-medium mt-3">{{ $carro->marca . ' ' . $carro->modelo }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 flex-col flex justify-between">
                                <div>
                                    <p class="text-lg">Status: {{ $carro->pivot->taken  }}</p>
                                </div>
                                <div>
                                    <p class="text-lg">Retirada: {{ $carro->pivot->taken  }}</p>
                                </div>
                                <div>
                                    <p class="text-lg">Devolução: {{ $carro->pivot->taken  }}</p>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>


            </div>
        @endforeach
    @endif


</div>