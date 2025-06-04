<?php

use App\Models\Carro;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

new class extends Component {

    use WithFileUploads;

    public $id;
    public $carro;

    public $modelo, $marca, $status;
    public int $ano;
    public $imagem;

    public function mount()
    {
        $this->carro = Carro::find($this->id);

        if ($this->carro->user != Auth::user()) {
            session()->flash('error', 'Não é possível realizar a alteração do carro de outro usuário');
            return redirect()->to(route('dashboard'));
        }

        $this->modelo = $this->carro->modelo;
        $this->marca = $this->carro->marca;
        $this->status = $this->carro->status;
        $this->ano = $this->carro->ano;
    }

    public function put()
    {
        $this->validate();

        $path = $this->imagem->store('carros', 'public');

        $carro = $this->carro;
        $carro->modelo = $this->modelo;
        $carro->marca = $this->marca;
        $carro->status = $this->status;
        $carro->ano = $this->ano;
        $carro->imagem = $path;
        $carro->user_id = Auth::user()->id;
        $carro->save();

        session()->flash('message', 'Veículo atualizado com sucesso!');

        return redirect()->to(route('dashboard'));
    }

    public function rules()
    {
        return [
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'imagem' => 'required|image|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'modelo.required' => 'O modelo é obrigatório',
            'marca.required' => 'A marca é obrigatória',
            'status.required' => 'O status é obrigatório',
            'ano.required' => 'O ano é obrigatório',
            'ano.min' => 'O ano deve ser maior que 1900',
            'ano.max' => 'O ano não pode ser maior que ' . (date('Y') + 1),
            'imagem.required' => 'A imagem é obrigatória',
            'imagem.image' => 'O arquivo deve ser uma imagem',
            'imagem.max' => 'A imagem não pode ter mais que 10MB'
        ];
    }

}; ?>

<div>
    <form enctype="multipart/form-data" wire:submit.prevent="put">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Aparência do Veículo</h2>
                <p class="mt-1 text-sm/6 text-gray-600">Insira sua melhor foto do veículo</p>
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-2 gap-x-6 gap-y-8">
                    <div>
                        <p class="block text-sm/6 font-medium text-gray-900">Foto Atual</p>
                        <div>
                            <img src="/storage/{{ $carro->imagem }}" alt="Foto do Carro" class="object-cover size-64"/>
                        </div>
                    </div>
                    <div class="sm:col-span-full">
                        <label for="imagem" class="block text-sm/6 font-medium text-gray-900">Nova Foto do
                            Veículo</label>

                        @if($imagem != null)
                            <div>
                                <p class="text-xs/5 text-gray-600">
                                    Imagem Anexada: {{ $imagem }}
                                </p>
                            </div>
                        @endif

                        <div
                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                     aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                          d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <div class="mt-4 flex text-sm/6 text-gray-600" wire:loading.remove>
                                    <label for="imagem"
                                           class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-indigo-500">
                                        <span>Realize o upload de um arquivo</span>
                                        <input id="imagem" name="imagem" type="file" class="sr-only"
                                               wire:model="imagem" required>
                                    </label>
                                </div>
                                <p class="text-xs/5 text-gray-600">PNG, JPG, GIF até 10MB</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Dados do Veículo</h2>
                <p class="mt-1 text-sm/6 text-gray-600">Insira as informações relevantes para a tramitação
                    burocrática</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="modelo" class="block text-sm/6 font-medium text-gray-900">Modelo</label>
                        <div class="mt-2">
                            <input type="text" name="modelo" id="modelo" autocomplete="given-name" wire:model="modelo"
                                   required
                                   class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="marca" class="block text-sm/6 font-medium text-gray-900">Marca</label>
                        <div class="mt-2">
                            <select id="marca" name="marca" autocomplete="marca" wire:model="marca"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="Fiat">Fiat</option>
                                <option value="Honda">Honda</option>
                                <option value="Toyota">Toyota</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="status" class="block text-sm/6 font-medium text-gray-900">Status</label>
                        <div class="mt-2">
                            <select id="status" name="status" autocomplete="status" wire:model="status"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="Livre">Livre</option>
                                <option value="Reservado">Reservado</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="ano" class="block text-sm/6 font-medium text-gray-900">Ano</label>
                        <div class="mt-2">
                            <input type="number" name="ano" id="ano" autocomplete="given-name" wire:model="ano" required
                                   class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>


                </div>
            </div>


        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Voltar</button>
            <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Salvar
            </button>
        </div>
    </form>
</div>
