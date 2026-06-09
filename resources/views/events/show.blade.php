<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-3">
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ __('Detalhes do Evento') }}
            </h2>
            <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100 rounded-lg shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                Voltar para Eventos
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-xl border border-gray-100 dark:border-gray-700">
        
                <div class="relative h-72 bg-gray-200 dark:bg-gray-700">
                    @if($event->image_path)
                        <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center">
                            <div class="text-center px-6">
                                <p class="text-sm uppercase tracking-[0.3em] text-white/80 font-semibold">{{ __('Evento Solidário') }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>

                <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <p class="text-sm uppercase tracking-widest text-green-600 dark:text-green-300">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</p>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-3">{{ $event->title }}</h1>
                    <p class="text-sm mt-2 text-gray-600 dark:text-gray-300">{{ $event->location }}</p>
                </div>

                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Descrição do Evento') }}</h2>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Informações adicionais') }}</h2>
                                <dl class="grid grid-cols-1 gap-4 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700">
                                        <dt class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Organizador') }}</dt>
                                        <dd>{{ $event->creator->name ?? __('Anônimo') }}</dd>
                                    </div>
                                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700">
                                        <dt class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Localização') }}</dt>
                                        <dd>{{ $event->location }}</dd>
                                    </div>
                                    <div class="rounded-2xl bg-white dark:bg-gray-800 p-4 border border-gray-100 dark:border-gray-700">
                                        <dt class="font-semibold text-gray-900 dark:text-gray-100">{{ __('Data e Hora') }}</dt>
                                        <dd>{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Ação') }}</h2>
                                @if(Auth::user()->role !== 'receptor')
                                    <div class="rounded-3xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 p-5 text-yellow-800 dark:text-yellow-200">
                                        <p class="font-semibold">{{ __('Apenas receptores podem se inscrever neste evento.') }}</p>
                                        <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-200">{{ __('Você pode visualizar todos os detalhes, mas a inscrição não está disponível para doadores.') }}</p>
                                    </div>
                                @elseif(in_array($event->id, $userRegistrations))
                                    <div class="rounded-3xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 p-5 text-green-800 dark:text-green-200">
                                        <p class="font-semibold">{{ __('Você já está inscrito.') }}</p>
                                    </div>
                                @else
                                    <form action="{{ route('events.register', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-3xl font-bold transition">{{ __('Quero participar') }}</button>
                                    </form>
                                @endif
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-900 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('Visão Geral') }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Este espaço exibe todos os detalhes do evento, para que qualquer usuário autenticado possa revisar a descrição e o local antes de decidir participar.') }}</p>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Alimentos vinculados ao evento</h2>

                                @if($event->foodItems && $event->foodItems->count() > 0)
                                    <div class="space-y-3">
                                        @foreach($event->foodItems as $item)
                                            <div class="flex items-center justify-between p-3 border rounded-xl" data-food-item-id="{{ $item->id }}">
                                                <div>
                                                    <div class="font-semibold">{{ $item->title }}</div>
                                                    <div class="text-sm text-gray-500">Qtd: <span class="food-quantity">{{ $item->quantity }}</span> — <span class="food-availability">{{ $item->is_available ? 'Disponível' : 'Esgotado' }}</span></div>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    @php $user = Auth::user(); @endphp
                                                    @if($user && $user->id === $event->user_id)
                                                        <button class="btn-edit px-3 py-1 bg-yellow-500 text-white rounded-lg">Editar</button>
                                                    @endif

                                                    @if($user && $user->role === 'receptor')
                                                        <form action="{{ route('donations.store') }}" method="POST" class="inline-block">
                                                            @csrf
                                                            <input type="hidden" name="food_item_id" value="{{ $item->id }}" />
                                                            <button class="px-3 py-1 bg-green-600 text-white rounded-lg">Pedir</button>
                                                        </form>
                                                    @else
                                                        <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg cursor-not-allowed" disabled title="Apenas receptores podem solicitar alimentos">Pedir (somente receptores)</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <script>
                                        (function(){
                                            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                            // simple toast helper
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

                                            function showUndo(li, prev){
                                                // create small undo UI and update in-memory prev
                                                let container = li.querySelector('.e2e-undo');
                                                if(container) container.remove();
                                                container = document.createElement('div');
                                                container.className = 'e2e-undo mt-2 text-sm';
                                                container.innerHTML = 'Alteração salva.';
                                                const undo = document.createElement('button');
                                                undo.textContent = 'Desfazer';
                                                undo.className = 'ml-3 px-2 py-1 bg-gray-200 rounded';
                                                container.appendChild(undo);
                                                li.appendChild(container);
                                                const timer = setTimeout(()=> container.remove(), 7000);
                                                undo.addEventListener('click', async ()=>{
                                                    clearTimeout(timer);
                                                    try{
                                                        const res = await fetch(`/food-items/${li.dataset.foodItemId}`, {
                                                            method: 'PATCH',
                                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                                                            body: JSON.stringify(prev)
                                                        });
                                                        if(!res.ok) throw new Error('undo failed');
                                                        // revert DOM without reload
                                                        li.querySelector('.food-quantity').textContent = prev.quantity;
                                                        li.querySelector('.food-availability').textContent = prev.is_available? 'Disponível':'Esgotado';
                                                        container.remove();
                                                        showToast('Alteração desfeita');
                                                    }catch(e){
                                                        console.warn(e);
                                                        showToast('Falha ao desfazer');
                                                    }
                                                });
                                            }

                                            document.querySelectorAll('div[data-food-item-id]').forEach(li=>{
                                                const id = li.dataset.foodItemId;
                                                const editBtn = li.querySelector('.btn-edit');
                                                if(!editBtn) return;
                                                editBtn.addEventListener('click', ()=>{
                                                    const qtyEl = li.querySelector('.food-quantity');
                                                    const availEl = li.querySelector('.food-availability');
                                                    const prev = { quantity: parseInt(qtyEl.textContent,10)||0, is_available: availEl.textContent.trim() === 'Disponível' };
                                                    const editor = document.createElement('div');
                                                    editor.className = 'inline-editor flex items-center gap-2 mt-2';
                                                    editor.innerHTML = `
                                                        <input type="number" class="inline-quantity border px-2 py-1" value="${prev.quantity}" min="0" />
                                                        <label class="flex items-center gap-2 text-sm"><input type="checkbox" class="inline-available" ${prev.is_available? 'checked':''} /> Disponível</label>
                                                        <button class="inline-save px-3 py-1 bg-blue-600 text-white rounded">Salvar</button>
                                                        <button class="inline-cancel px-3 py-1 bg-gray-300 rounded">Cancelar</button>
                                                    `;
                                                    editBtn.insertAdjacentElement('afterend', editor);
                                                    editBtn.style.display = 'none';
                                                    editor.querySelector('.inline-cancel').addEventListener('click', ()=>{ editor.remove(); editBtn.style.display = ''; });
                                                    editor.querySelector('.inline-save').addEventListener('click', async ()=>{
                                                        const saveBtn = editor.querySelector('.inline-save');
                                                        saveBtn.disabled = true;
                                                        const q = parseInt(editor.querySelector('.inline-quantity').value,10)||0;
                                                        const a = editor.querySelector('.inline-available').checked;
                                                        try{
                                                            const res = await fetch(`/food-items/${id}`, {
                                                                method: 'PATCH',
                                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                                                                body: JSON.stringify({ quantity: q, is_available: a })
                                                            });
                                                            if(!res.ok) throw new Error('update failed');
                                                            qtyEl.textContent = q;
                                                            availEl.textContent = a? 'Disponível':'Esgotado';
                                                            editor.remove(); editBtn.style.display = '';
                                                            showUndo(li, prev);
                                                            showToast('Alteração salva');
                                                        }catch(e){ alert('Falha ao salvar.'); }
                                                        finally{ saveBtn.disabled = false; }
                                                    });
                                                });
                                            });
                                        })();
                                    </script>
                                @else
                                    <div class="text-sm text-gray-500">Nenhum alimento vinculado a este evento.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
