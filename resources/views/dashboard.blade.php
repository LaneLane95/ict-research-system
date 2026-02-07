<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Monitoring ZC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .print-only { display: none; }
        @media print {
            aside, .no-print, .modal { display: none !important; }
            main { width: 100% !important; padding: 0 !important; }
            .print-only { display: block !important; }
            .table-container { border: none !important; box-shadow: none !important; }
            table { width: 100% !important; border-collapse: collapse !important; }
            th, td { border: 1px solid #e2e8f0 !important; padding: 8px !important; font-size: 8px !important; }
        }
    </style>
</head>
<body class="min-h-screen flex overflow-hidden">

    <aside class="w-72 bg-slate-950 text-slate-300 flex flex-col shadow-2xl shrink-0 z-40 no-print">
        <div class="p-10 border-b border-slate-900 text-center">
            <h1 class="text-white font-black text-xl uppercase tracking-tighter">Research Monitoring <span class="text-indigo-500">ZC</span></h1>
        </div>
        <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                <span class="text-[10px] font-bold uppercase tracking-widest">🏠 Main Dashboard</span>
            </a>
            
            <div class="pt-6 pb-2 px-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">Modules</div>
            <a href="{{ route('dashboard', ['category' => 'DepEd']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request('category') == 'DepEd' ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                <span class="text-[10px] font-bold uppercase">DepEd Research</span>
            </a>
            <a href="{{ route('dashboard', ['category' => 'Non-DepEd']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request('category') == 'Non-DepEd' ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                <span class="text-[10px] font-bold uppercase">Non-DepEd Research</span>
            </a>
            <a href="{{ route('dashboard', ['category' => 'Innovation']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request('category') == 'Innovation' ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                <span class="text-[10px] font-bold uppercase">Innovation Research</span>
            </a>

            <div class="pt-6 pb-2 px-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">Archives</div>
            <a href="{{ route('dashboard', ['category' => 'Archived']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request('category') == 'Archived' ? 'bg-slate-700 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                <span class="text-[10px] font-bold uppercase">📁 Archived Records</span>
            </a>
        </nav>
        <div class="p-6 text-center border-t border-slate-900 italic text-[10px] text-slate-500 uppercase font-black">
            Dev: Shielane C. Garcia @2026
        </div>
    </aside>

    <main class="flex-grow flex flex-col h-screen overflow-hidden z-10">
        <header class="bg-white border-b h-20 flex items-center justify-between px-10 shrink-0 no-print z-30 relative">
            <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">{{ request('category') ?? 'Overall Statistics' }}</h2>
            
            @if(request('category'))
            <div class="flex items-center gap-4">
                <form action="{{ route('dashboard') }}" method="GET" class="relative">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="bg-slate-100 border-none rounded-xl px-4 py-2 text-xs font-bold w-48 focus:ring-2 focus:ring-indigo-500 outline-none">
                </form>
                
                <button onclick="window.print()" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase">Print</button>
                
                @if(request('category') != 'Archived')
                <button type="button" onclick="openAddModal()" class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase shadow-lg z-50">
                    + New Entry
                </button>
                @endif
            </div>
            @endif
        </header>

        <div class="p-10 overflow-y-auto flex-grow z-10">
            @if(!request('category'))
                <div class="grid grid-cols-4 gap-6 mb-12">
                    <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl text-white">
                        <p class="text-[10px] font-black uppercase opacity-70">Total Records</p>
                        <h3 class="text-4xl font-black italic">{{ $overallStats['total'] }}</h3>
                    </div>
                    <div class="bg-white p-8 rounded-[2.5rem] border-l-8 border-l-blue-500 shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ongoing DepEd</p>
                        <h3 class="text-4xl font-black text-slate-800 italic">{{ $overallStats['deped'] }}</h3>
                    </div>
                    <div class="bg-white p-8 rounded-[2.5rem] border-l-8 border-l-emerald-500 shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Archived (Completed)</p>
                        <h3 class="text-4xl font-black text-slate-800 italic">{{ $overallStats['archived'] }}</h3>
                    </div>
                    <div class="bg-white p-8 rounded-[2.5rem] border-l-8 border-l-amber-500 shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Innovation</p>
                        <h3 class="text-4xl font-black text-slate-800 italic">{{ $overallStats['innovation'] }}</h3>
                    </div>
                </div>
                <div class="bg-white p-10 rounded-[3rem] border border-slate-200 shadow-xl text-center italic font-black text-slate-800 uppercase">
                    Select a module to view records
                </div>
            @else
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b">
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-5">Date Received</th>
                                <th class="px-6 py-5">Title & Author</th>
                                <th class="px-6 py-5">Origin (School/Dist)</th>
                                <th class="px-6 py-5">Dates</th>
                                <th class="px-6 py-5 text-center no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($researches as $res)
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="px-6 py-5 text-[10px] font-bold text-slate-500">{{ $res->date_received }}</td>
                                <td class="px-6 py-5">
                                    <p class="text-[11px] font-black text-slate-900 uppercase leading-tight">{{ $res->title }}</p>
                                    <p class="text-[9px] text-indigo-600 font-bold uppercase mt-1">{{ $res->author }}</p>
                                </td>
                                <td class="px-6 py-5 text-[9px] font-bold text-slate-500 uppercase">
                                    @if($res->school_name) <span class="text-slate-900">{{ $res->school_name }}</span><br> @endif
                                    @if($res->district) <span class="text-slate-400">Dist: {{ $res->district }}</span><br> @endif
                                    <span class="text-indigo-400">{{ $res->sub_type }} {{ $res->theme ? '| '.$res->theme : '' }}</span>
                                </td>
                                <td class="px-6 py-5 text-[9px] font-black text-slate-400">
                                    <span class="text-blue-600 uppercase">E: {{ $res->endorsement_date ?? '---' }}</span><br>
                                    <span class="text-emerald-600 uppercase">R: {{ $res->released_date ?? '---' }}</span><br>
                                    <span class="text-indigo-600 font-bold uppercase">COC: {{ $res->coc_date ?? 'PENDING' }}</span>
                                </td>
                                <td class="px-6 py-5 text-center no-print space-x-2">
                                    <button onclick="openEditModal({{ $res }})" class="cursor-pointer text-amber-600 font-black text-[9px] uppercase hover:underline">Edit</button>
                                    
                                    @if(!$res->is_archived)
                                    <form action="{{ route('research.archive', $res->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Archive record?')" class="cursor-pointer text-indigo-500 font-black text-[9px] uppercase hover:underline">Archive</button>
                                    </form>
                                    @endif

                                    <form action="{{ route('research.destroy', $res->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete permanently?')" class="cursor-pointer text-rose-500 font-black text-[9px] uppercase hover:underline">Del</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-8 py-10 text-center text-slate-400 font-bold italic uppercase">No records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <div id="modalOverlay" class="hidden fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
        
        <div id="addModalContent" class="hidden bg-white w-full max-w-2xl rounded-[3rem] overflow-hidden shadow-2xl">
            <div class="bg-indigo-600 p-8 text-white flex justify-between items-center">
                <h3 class="text-xl font-black uppercase italic">New Entry - {{ request('category') }}</h3>
                <button onclick="closeModal()" class="text-white hover:text-slate-200">✕</button>
            </div>
            <form action="{{ route('research.store') }}" method="POST" class="p-10 grid grid-cols-2 gap-4">
                @csrf
                <input type="hidden" name="category" value="{{ request('category') }}">
                
                <div class="col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase">Sub-Type</label>
                    <select name="sub_type" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold">
                        @if(request('category') == 'DepEd')
                            <option value="Proposal">Proposal</option>
                            <option value="Ongoing">Ongoing</option>
                        @elseif(request('category') == 'Non-DepEd')
                            <option value="Research">Research</option>
                            <option value="Innovation">Innovation</option>
                            <option value="Thesis">Thesis</option>
                            <option value="Dissertation">Dissertation</option>
                        @else
                            <option value="Proposal">Proposal</option>
                            <option value="Innovation">Innovation</option>
                        @endif
                    </select>
                </div>

                @if(request('category') == 'DepEd')
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase">School ID</label>
                    <input type="text" name="school_id" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase">District</label>
                    <input type="text" name="district" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold">
                </div>
                <div class="col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase">Theme</label>
                    <input type="text" name="theme" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold" placeholder="e.g. Teaching & Learning">
                </div>
                @endif

                <div class="col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase">School/Office Name</label>
                    <input type="text" name="school_name" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold">
                </div>

                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase">Date Received</label>
                    <input type="date" name="date_received" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase">Author Name</label>
                    <input type="text" name="author" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold">
                </div>
                <div class="col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase">Title</label>
                    <textarea name="title" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold" rows="2"></textarea>
                </div>
                
                <div class="col-span-2 flex gap-3 mt-4">
                    <button type="submit" class="flex-grow py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs shadow-xl">Save Record</button>
                    <button type="button" onclick="closeModal()" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black uppercase text-xs">Cancel</button>
                </div>
            </form>
        </div>

        <div id="editModalContent" class="hidden bg-white w-full max-w-2xl rounded-[3rem] overflow-hidden shadow-2xl">
            <div class="bg-amber-500 p-8 text-white flex justify-between items-center">
                <h3 class="text-xl font-black uppercase italic">Update Record</h3>
                <button onclick="closeModal()" class="text-white hover:text-slate-200">✕</button>
            </div>
            <form id="editForm" method="POST" class="p-10 grid grid-cols-2 gap-4">
                @csrf @method('PUT')
                <div class="col-span-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase">Title</label>
                    <textarea name="title" id="edit_title" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold" rows="2"></textarea>
                </div>
                <div><label class="text-[9px] font-black text-slate-400 uppercase">Author</label><input type="text" name="author" id="edit_author" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold"></div>
                <div><label class="text-[9px] font-black text-slate-400 uppercase">School Name</label><input type="text" name="school_name" id="edit_school_name" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold"></div>
                
                <div><label class="text-[9px] font-black text-slate-400 uppercase">School ID</label><input type="text" name="school_id" id="edit_school_id" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold"></div>
                <div><label class="text-[9px] font-black text-slate-400 uppercase">District</label><input type="text" name="district" id="edit_district" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold"></div>

                <div><label class="text-[9px] font-black text-slate-400 uppercase">Endorsement Date</label><input type="date" name="endorsement_date" id="edit_endorsement_date" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold"></div>
                <div><label class="text-[9px] font-black text-slate-400 uppercase">Released Date</label><input type="date" name="released_date" id="edit_released_date" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold"></div>
                
                <div class="col-span-2 bg-indigo-50 p-6 rounded-2xl">
                    <label class="text-[9px] font-black text-indigo-600 uppercase">COC Date</label>
                    <input type="date" name="coc_date" id="edit_coc_date" class="w-full bg-white border-2 border-indigo-100 rounded-xl px-4 py-2 text-xs font-bold mt-2">
                </div>
                <div class="col-span-2 flex gap-3 mt-4">
                    <button type="submit" class="flex-grow py-4 bg-amber-500 text-white rounded-2xl font-black uppercase text-xs shadow-xl">Update Record</button>
                    <button type="button" onclick="closeModal()" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black uppercase text-xs">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const overlay = document.getElementById('modalOverlay');
        const addModal = document.getElementById('addModalContent');
        const editModal = document.getElementById('editModalContent');

        function openAddModal() {
            overlay.classList.remove('hidden');
            addModal.classList.remove('hidden');
            editModal.classList.add('hidden');
        }

        function openEditModal(data) {
            overlay.classList.remove('hidden');
            editModal.classList.remove('hidden');
            addModal.classList.add('hidden');
            
            const form = document.getElementById('editForm');
            form.action = "/research/update/" + data.id;
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_author').value = data.author;
            document.getElementById('edit_school_name').value = data.school_name || '';
            document.getElementById('edit_school_id').value = data.school_id || '';
            document.getElementById('edit_district').value = data.district || '';
            document.getElementById('edit_endorsement_date').value = data.endorsement_date || '';
            document.getElementById('edit_released_date').value = data.released_date || '';
            document.getElementById('edit_coc_date').value = data.coc_date || '';
        }

        function closeModal() {
            overlay.classList.add('hidden');
            addModal.classList.add('hidden');
            editModal.classList.add('hidden');
        }

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal();
        });
    </script>
</body>
</html>