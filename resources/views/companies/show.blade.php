<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-6">
            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-sm shrink-0">
                @if($company->logo_path)
                    <img src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-12 h-12 text-gray-400 m-auto mt-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                @endif
            </div>
            <div>
                <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ $company->name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2 max-w-xl">{{ $company->description }}</p>
                <div class="mt-2 text-sm text-green-600 font-semibold flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Doador Verificado
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">
                <h3 class="font-semibold text-2xl text-gray-800 dark:text-gray-200">Alimentos Disponíveis</h3>
                @if(auth()->check() && auth()->user()->role === 'doador' && auth()->user()->company && auth()->user()->company->id === $company->id)
                    <a href="{{ route('food-items.create', $company->id) }}" class="text-sm bg-orange-100 text-orange-600 px-3 py-1 rounded-full font-medium hover:bg-orange-200 transition">
                        + Adicionar Alimento
                    </a>
                @endif
            </div>

            @if($company->foodItems->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-gray-500 text-lg">No momento, esta empresa não possui alimentos listados para doação.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-0">
                    @foreach($company->foodItems as $item)
                        <div data-food-item-id="{{ $item->id }}" class="group relative flex w-full py-6 border-b border-gray-100 dark:border-gray-700/60 hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors rounded-xl px-2 -mx-2 items-center">
                            <div class="flex-1 pr-4">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100 text-base mb-1 group-hover:text-orange-600 transition-colors">{{ $item->title }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-snug">{{ $item->description }}</p>
                                <div class="mt-3 flex items-center space-x-2">
                                    <span class="text-sm font-semibold text-green-600 dark:text-green-500">Grátis</span>
                                    <span class="text-xs text-gray-400">&bull;</span>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Qtd disponível: {{ $item->quantity }}</span>
                                </div>

                                @if(auth()->check() && auth()->user()->role === 'doador' && auth()->user()->company && auth()->user()->company->id === $company->id)
                                    <div class="mt-2">
                                        <button type="button" class="btn-edit-food ml-2 px-3 py-1 bg-yellow-500 text-white rounded-lg">Editar</button>
                                    </div>
                                @endif

                                @if($item->quantity > 0)
                                    @if(auth()->check() && auth()->user()->role === 'receptor')
                                        <form action="{{ route('donations.store') }}" method="POST" class="mt-4 flex items-center space-x-3 donation-form">
                                            @csrf
                                            <input type="hidden" name="food_item_id" value="{{ $item->id }}">
                                            <label class="text-sm text-gray-600">Quantidade</label>
                                            <input name="quantity" type="number" min="1" max="{{ $item->quantity }}" value="1" class="w-20 ml-2 px-2 py-1 border rounded-md text-sm bg-white dark:bg-gray-800" />
                                            <button type="submit" class="ml-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">Solicitar</button>
                                        </form>
                                    @else
                                        <div class="mt-4 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-md text-sm text-orange-800">Apenas usuários do tipo <strong>Receptor</strong> podem solicitar este alimento.</div>
                                    @endif
                                @else
                                    <div class="mt-4 text-sm text-red-500">Esgotado</div>
                                @endif
                            </div>

                            <!-- Image -->
                            <div class="w-[110px] h-[110px] rounded-xl overflow-hidden shrink-0 bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                @if($item->image_path)
                                    <img src="{{ Storage::url($item->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <script>
                (function(){
                    function showToast(msg, timeout = 3500){
                        let toast = document.getElementById('e2e-toast');
                        if(!toast){
                            toast = document.createElement('div');
                            toast.id = 'e2e-toast';
                            toast.style.position = 'fixed';
                            toast.style.right = '20px';
                            toast.style.bottom = '20px';
                            toast.style.zIndex = 9999;
                            document.body.appendChild(toast);
                        }
                        const el = document.createElement('div');
                        el.textContent = msg;
                        el.style.background = 'rgba(0,0,0,0.8)';
                        el.style.color = '#fff';
                        el.style.padding = '8px 12px';
                        el.style.borderRadius = '8px';
                        el.style.marginTop = '6px';
                        toast.appendChild(el);
                        setTimeout(()=> el.remove(), timeout);
                    }

                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    document.querySelectorAll('div[data-food-item-id]').forEach(li=>{
                        const id = li.dataset.foodItemId;
                        const editBtn = li.querySelector('.btn-edit-food');
                        if(!editBtn) return;
                        editBtn.addEventListener('click', ()=>{
                            const qtySpan = li.querySelector('.text-xs.font-medium');
                            const qtyText = qtySpan ? qtySpan.textContent.match(/:\s*(\d+)/) : null;
                            const currentQty = qtyText ? parseInt(qtyText[1],10) : 0;
                            const editor = document.createElement('div');
                            editor.className = 'company-inline-editor mt-3 flex items-center gap-2';
                            editor.innerHTML = `
                                <label class="text-sm">Qtd</label>
                                <input type="number" class="inline-quantity w-20 px-2 py-1 border rounded" value="${currentQty}" min="0" />
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" class="inline-available" ${currentQty>0? 'checked':''} /> Disponível</label>
                                <button class="inline-save px-3 py-1 bg-blue-600 text-white rounded">Salvar</button>
                                <button class="inline-cancel px-3 py-1 bg-gray-300 rounded">Cancelar</button>
                            `;
                            editBtn.insertAdjacentElement('afterend', editor);
                            editBtn.style.display = 'none';
                            editor.querySelector('.inline-cancel').addEventListener('click', ()=>{ editor.remove(); editBtn.style.display = ''; });
                            editor.querySelector('.inline-save').addEventListener('click', async ()=>{
                                const q = parseInt(editor.querySelector('.inline-quantity').value,10) || 0;
                                const a = editor.querySelector('.inline-available').checked;
                                try{
                                    const res = await fetch(`/food-items/${id}`, {
                                        method: 'PATCH',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                                        body: JSON.stringify({ quantity: q, is_available: a })
                                    });
                                    if(!res.ok) throw new Error('update failed');
                                    // update DOM
                                    if(qtySpan) qtySpan.textContent = `Qtd disponível: ${q}`;
                                    editor.remove(); editBtn.style.display = '';
                                    showToast('Alimento atualizado');
                                }catch(e){
                                    showToast('Falha ao atualizar');
                                }
                            });
                        });
                    });
                })();
            </script>
        </div>
    </div>
</x-app-layout>
