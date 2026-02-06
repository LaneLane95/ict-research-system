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
            th, td { border: 1px solid #e2e8f0 !important; padding: 8px !important; font-size: 10px !important; }
        }
    </style>
</head>
<body class="min-h-screen flex overflow-hidden">

    <aside class="w-72 bg-slate-950 text-slate-300 flex flex-col shadow-2xl shrink-0 z-20 no-print">
        <div class="p-10 border-b border-slate-900 text-center">
            <h1 class="text-white font-black text-xl uppercase tracking-tighter">Research Monitoring <span class="text-indigo-500">ZC</span></h1>
        </div>
        <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ !$selectedModule ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                <span class="text-[10px] font-bold uppercase tracking-widest">🏠 Main Dashboard</span>
            </a>
            <div class="pt-6 pb-2 px-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">Modules</div>
            @foreach($modules as $module)
                <a href="{{ route('dashboard', ['module' => $module]) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $selectedModule == $module ? 'bg-indigo-600 text-white shadow-lg' : 'hover:bg-slate-900' }}">
                    <span class="text-[10px] font-bold uppercase">{{ $module }}</span>
                </a>
            @endforeach
        </nav>
        <div class="p-6 text-center border-t border-slate-900 italic text-[10px] text-slate-500 uppercase font-black">
            Dev: Shielane C. Garcia @2026
        </div>
    </aside>

    <main class="flex-grow flex flex-col h-screen overflow-hidden">
        <header class="bg-white border-b h-20 flex items-center justify-between px-10 shrink-0 no-print">
            <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">{{ $selectedModule ?? 'Overall Statistics' }}</h2>
            
            @if($selectedModule)
            <div class="flex items-center gap-4">
                <form action="{{ route('dashboard') }}" method="GET" class="relative">
                    <input type="hidden" name="module" value="{{ $selectedModule }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search title/author..." class="bg-slate-100 border-none rounded-xl px-4 py-2 text-xs font-bold w-64 focus:ring-2 focus:ring-indigo-500 outline-none">
                </form>
                <button onclick="window.print()" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-slate-200">Print</button>
                <button onclick="toggleModal('addModal')" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-indigo-200">+ New Entry</button>
            </div>
            @endif
        </header>

        <div class="p-10 overflow-y-auto flex-grow">
            @if(!$selectedModule)
                <div class="grid grid-cols-4 gap-6 mb-12">
                    <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl text-white">
                        <p class="text-[10px] font-black uppercase opacity-70">Grand Total</p>
                        <h3 class="text-4xl font-black italic">{{ $overallStats['total'] }}</h3>
                    </div>
                    @foreach(['checking' => 'amber', 'pending' => 'blue', 'completed' => 'emerald'] as $key => $color)
                    <div class="bg-white p-8 rounded-[2.5rem] border-l-8 border-l-{{$color}}-500 shadow-sm border border-slate-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $key }}</p>
                        <h3 class="text-4xl font-black text-slate-800 italic">{{ $overallStats[$key] }}</h3>
                    </div>
                    @endforeach
                </div>
                
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b">
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-8 py-5">Module Name</th>
                                <th class="px-8 py-5 text-center">Records</th>
                                <th class="px-8 py-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($moduleSummary as $ms)
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="px-8 py-5 font-bold text-slate-700 text-sm uppercase italic">{{ $ms['name'] }}</td>
                                <td class="px-8 py-5 text-center font-black text-lg text-indigo-600 italic">{{ $ms['count'] }}</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-4 py-1.5 rounded-full bg-slate-100 text-[10px] font-black text-slate-500 uppercase">{{ $ms['completed'] }} Processed</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden table-container">
                    <div class="print-only text-center py-10">
                        <h1 class="text-2xl font-black uppercase tracking-tighter">Research Monitoring ZC</h1>
                        <p class="text-sm font-bold uppercase tracking-widest">Module: {{ $selectedModule }}</p>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b">
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-5">Title & Author</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-6 py-5 text-center no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($researches as $res)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-5">
                                    <p class="text-xs font-black text-slate-800 uppercase leading-tight">{{ $res->title }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase italic mt-1">{{ $res->author }}</p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="px-4 py-1.5 text-[8px] font-black uppercase rounded-full border {{ $res->status == 'Completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-amber-50 text-amber-600 border-amber-200' }}">
                                        {{ $res->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center no-print space-x-3">
                                    <button onclick="openTrackingModal({{ $res }})" class="text-indigo-600 font-black text-[9px] uppercase border-b-2 border-indigo-100 hover:border-indigo-600 pb-0.5">🔍 View Tracking</button>
                                    <button onclick="openEditModal({{ $res }})" class="text-slate-600 font-black text-[9px] uppercase border-b-2 border-slate-100 hover:border-slate-600 pb-0.5">Edit</button>
                                    <form action="{{ route('research.destroy', $res->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-500 font-black text-[9px] uppercase border-b-2 border-rose-100 hover:border-rose-600 pb-0.5">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-8 py-10 text-center text-slate-400 font-bold italic">No records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="print-only mt-20 px-10 pb-10">
                        <div class="flex justify-between items-end">
                            <div class="text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-8 tracking-widest">Date</p>
                                <p class="border-b-2 border-black w-48 font-bold text-sm italic">{{ date('F d, Y') }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-[10px] font-black text-slate-400 uppercase mb-8 tracking-widest">Certified By</p>
                                <p class="border-b-2 border-black w-64 font-bold text-sm uppercase font-black italic"></p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <div id="trackingModal" class="hidden fixed inset-0 bg-slate-950/90 backdrop-blur-md z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[3rem] overflow-hidden shadow-2xl">
            <div class="bg-indigo-600 p-8 text-white">
                <p class="text-[10px] font-black uppercase opacity-70 tracking-widest">Research Tracking Info</p>
                <h3 id="trackTitle" class="text-xl font-black uppercase mt-2 leading-tight">Research Title</h3>
                <p id="trackAuthor" class="text-xs font-bold uppercase opacity-80 mt-1 italic">Author Name</p>
            </div>
            <div class="p-10 space-y-8 bg-slate-50">
                <div class="flex gap-6">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-indigo-600 shadow-[0_0_0_4px_rgba(79,70,229,0.2)]"></div>
                        <div class="w-0.5 h-full bg-slate-200"></div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phase 1: Entry Recorded</p>
                        <p id="trackEntryDate" class="text-sm font-bold text-slate-800 mt-1">Date Time</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex flex-col items-center">
                        <div class="w-4 h-4 rounded-full bg-amber-500 shadow-[0_0_0_4px_rgba(245,158,11,0.2)]"></div>
                        <div class="w-0.5 h-full bg-slate-200"></div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phase 2: Status & Timeline</p>
                        <p id="trackStatus" class="text-sm font-black text-amber-600 mt-1 uppercase italic">Current Status</p>
                        <p id="trackUpdateDate" class="text-[10px] font-bold text-slate-500 mt-1">Last Updated: Time</p>
                    </div>
                </div>
                <div class="flex gap-6 pb-4">
                    <div class="flex flex-col items-center">
                        <div id="statusDot" class="w-4 h-4 rounded-full bg-slate-200"></div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Phase 3: Final Output</p>
                        <p id="trackReleaseDate" class="text-sm font-bold text-slate-400 mt-1 italic italic">Not yet released</p>
                    </div>
                </div>
                <button onclick="toggleModal('trackingModal')" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black uppercase text-xs shadow-xl tracking-widest">Close Tracker</button>
            </div>
        </div>
    </div>

    <div id="addModal" class="hidden fixed inset-0 bg-slate-900/90 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl">
            <h3 class="font-black text-slate-900 uppercase text-lg mb-6 italic tracking-tighter">New Entry</h3>
            <form action="{{ route('research.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="{{ $selectedModule }}">
                <input type="text" name="title" placeholder="Research Title" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm font-bold focus:border-indigo-500 outline-none">
                <input type="text" name="author" placeholder="Author Name" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm font-bold focus:border-indigo-500 outline-none">
                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs shadow-xl hover:bg-indigo-700 transition-all italic">Save to Database</button>
                <button type="button" onclick="toggleModal('addModal')" class="w-full text-slate-400 font-black text-[10px] uppercase mt-2 tracking-widest">Cancel</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-slate-900/90 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl">
            <h3 class="font-black text-slate-900 uppercase text-lg mb-6 italic tracking-tighter">Update Record</h3>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Progress Status</label>
                <select name="status" id="editStatus" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm font-black uppercase outline-none focus:border-indigo-500">
                    <option value="For Checking">For Checking</option>
                    <option value="Pending">Pending</option>
                    <option value="Denied">Denied</option>
                    <option value="Completed">Completed</option>
                </select>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Release Date (If Done)</label>
                <input type="date" name="released_date" id="editReleasedDate" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3 text-sm font-bold outline-none focus:border-indigo-500">
                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs shadow-xl italic">Update Entry</button>
                <button type="button" onclick="toggleModal('editModal')" class="w-full text-slate-400 font-black text-[10px] uppercase mt-2 text-center tracking-widest">Close</button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) { document.getElementById(id).classList.toggle('hidden'); }

        function openEditModal(data) {
            const form = document.getElementById('editForm');
            form.action = `/research/update/${data.id}`;
            document.getElementById('editStatus').value = data.status;
            document.getElementById('editReleasedDate').value = data.released_date || '';
            toggleModal('editModal');
        }

        function openTrackingModal(data) {
            document.getElementById('trackTitle').innerText = data.title;
            document.getElementById('trackAuthor').innerText = data.author;
            
            // Format dates
            const entryDate = new Date(data.entry_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            document.getElementById('trackEntryDate').innerText = entryDate;
            
            document.getElementById('trackStatus').innerText = data.status;
            
            // Show last update time
            const updatedAt = new Date(data.updated_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            const updatedDate = new Date(data.updated_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            document.getElementById('trackUpdateDate').innerText = `Last Activity: ${updatedDate} at ${updatedAt}`;
            
            // Handle release date
            const releaseEl = document.getElementById('trackReleaseDate');
            const dotEl = document.getElementById('statusDot');
            if(data.released_date) {
                const releaseDate = new Date(data.released_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                releaseEl.innerText = `Released on ${releaseDate}`;
                releaseEl.classList.remove('text-slate-400');
                releaseEl.classList.add('text-emerald-600', 'font-black');
                dotEl.classList.remove('bg-slate-200');
                dotEl.classList.add('bg-emerald-500', 'shadow-[0_0_0_4px_rgba(16,185,129,0.2)]');
            } else {
                releaseEl.innerText = "Still in process...";
                releaseEl.classList.add('text-slate-400');
                releaseEl.classList.remove('text-emerald-600', 'font-black');
                dotEl.classList.add('bg-slate-200');
                dotEl.classList.remove('bg-emerald-500');
            }

            toggleModal('trackingModal');
        }
    </script>
</body>
</html>