<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\Locacao;
use App\Models\Carro;

new class extends Component {

    public $carro_id, $carro, $marca, $modelo, $ano;

    public $dt_ini, $dt_fim, $obs;

    public function mount()
    {
        $this->carro = Carro::find($this->carro_id);

        if ($this->carro->user == Auth::user()) {
            session()->flash('error', 'Não é possível alugar seu próprio carro ;(');
            return redirect()->to(route('dashboard'));
        }

        $this->marca = $this->carro->marca;
        $this->modelo = $this->carro->modelo;
        $this->ano = $this->carro->ano;

        $this->dt_ini = now();
    }

    public function store()
    {
        $this->validate();

        $locacao = new Locacao;
        $locacao->taken = $this->dt_ini;
        $locacao->returned = $this->dt_fim;
        $locacao->user_id = Auth::user()->id;
        $locacao->carro_id = $this->carro->id;
        $locacao->obs = $this->obs;
        $locacao->save();

        $carro = Carro::find($locacao->carro_id);
        $carro->status = 'Reservado';
        $carro->save();

        session()->flash('message', 'Locação realizada com sucesso');

        return redirect()->to(route('locacoes.show'));

    }

    public function rules()
    {
        return [
            'dt_ini' => [
                'required', 'date', Rule::date()->todayOrAfter(),
            ]
        ];
    }

}; ?>

<div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="mt-2 p-4 mb-2 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <span class="font-medium">{{ $error }}</span>
            </div>
        @endforeach
    @endif

    <div>
        <form wire:submit.prevent="store">
            <div class="">
                <div class="border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Realizar Aluguel</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">Informe a data na qual o aluguel será realizado</p>
                    <div class="grid lg:grid-cols-3 md:grid-cols-1 w-full min-w-64">
                        <div class="opacity-50">
                            <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-3 p-4">
                                <div class="flex flex-wrap items-center justify-center gap-4">
                                    <div class="bg-white rounded-2xl pb-4 overflow-hidden border border-gray-500/30">
                                        <p class="text-sm/6 text-gray-600 text-center m-3">Carro Selecionado</p>
                                        <img class="w-64 h-52 object-cover object-top"
                                             src="/storage/{{ $carro->imagem }}"
                                             alt="{{ $carro->marca . ' ' . $carro->modelo }}">
                                        <div class="flex flex-col items-center gap-2">
                                            <p class="font-medium mt-3">{{ $carro->marca . ' ' . $carro->modelo }}</p>
                                            <p class="text-gray-500 text-sm">{{ $carro->status }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <form class="">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="">
                                        <label for="taken" class="block text-sm/6 font-medium text-gray-900">Data da
                                            Retirada</label>
                                        <div class="mt-2">
                                            <input
                                                wire:model="dt_ini"
                                                type="date"
                                                id="taken"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            >
                                        </div>
                                    </div>
                                    <div class="">
                                        <label for="returned" class="block text-sm/6 font-medium text-gray-900">Data da
                                            Devolução <span class="opacity-25">(Omitir se ainda não devolvido ou sem previsão)</span>
                                        </label>
                                        <div class="mt-2">
                                            <input
                                                wire:model="dt_fim"
                                                type="date"
                                                id="returned"
                                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <label for="returned"
                                           class="block text-sm/6 font-medium text-gray-900">Observação</label>
                                    <div class="mt-2">
                                        <textarea
                                            rows="8"
                                            wire:model="obs"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">

                                        </textarea>
                                    </div>
                                </div>

                                <div class="flex flex-row justify-end mt-2">
                                    <button type="submit"
                                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Confirmar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>


            </div>


        </form>

    </div>

</div>
