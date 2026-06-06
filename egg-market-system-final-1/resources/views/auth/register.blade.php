@extends('layouts.main')

@section('title', 'Network Onboarding | EggMarket')

@section('content')
<div class="min-h-[calc(100vh-5rem)] flex items-center justify-center p-8 bg-[#F8FAFC] relative overflow-hidden">
    <!-- Sophisticated Background Elements -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-green-50 rounded-l-[200px] -z-10 animate-in slide-in-from-right duration-1000"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-green-200/20 blur-[120px] rounded-full -z-10"></div>
    
    <div class="max-w-6xl w-full grid lg:grid-cols-2 gap-16 items-center animate-in zoom-in-95 duration-700">
        
        <!-- Left Col: Value Proposition -->
        <div class="hidden lg:block space-y-12">
            <div>
                <h2 class="text-sm font-black text-green-600 uppercase tracking-[0.4em] mb-4">Onboarding Protocol</h2>
                <h1 class="text-6xl font-black text-slate-900 tracking-tighter leading-tight">Secure your node in the <span class="text-green-600 underline decoration-8 underline-offset-8 decoration-green-100">network.</span></h1>
            </div>
            
            <div class="space-y-8">
                <div class="flex gap-6">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-green-600 shadow-xl shadow-green-100/50 shrink-0 border border-slate-50"><i class="fas fa-shield-check fa-lg"></i></div>
                    <div>
                        <h4 class="font-black text-slate-900 text-lg">Verified Identity</h4>
                        <p class="text-slate-500 font-medium text-sm mt-1">Multi-point farm verification protocols ensure highest market standards.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-xl shadow-blue-100/50 shrink-0 border border-slate-50"><i class="fas fa-location-crosshairs fa-lg"></i></div>
                    <div>
                        <h4 class="font-black text-slate-900 text-lg">GPS Synchronization</h4>
                        <p class="text-slate-500 font-medium text-sm mt-1">Integrated precision logistics for optimized regional delivery routing.</p>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-slate-900 rounded-[40px] text-white shadow-2xl shadow-slate-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full"></div>
                <p class="text-sm font-medium text-slate-400 italic mb-6">"Transitioning to EggMarket reduced our logistics overhead by 24% in the first quarter."</p>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-700"></div>
                    <div>
                        <p class="font-black text-xs uppercase tracking-widest">Director of Logistics</p>
                        <p class="text-[10px] text-green-500 font-bold uppercase">Heritage Poultry Nodes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: Registration Form -->
        <div class="bg-white rounded-[60px] p-10 lg:p-16 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border border-slate-50 relative">
            <div class="text-center lg:text-left mb-12">
                <img src="https://tse1.mm.bing.net/th/id/OIP.kzenbVuAfiBwLzLLnNiKQwAAAA?w=400&h=400&rs=1&pid=ImgDetMain&o=7&rm=3" 
                     class="w-16 h-16 rounded-2xl shadow-xl shadow-green-100 mx-auto lg:mx-0 mb-6" alt="Logo">
                <h3 class="text-3xl font-black text-slate-900 tracking-tight">Initiate Registration</h3>
                <p class="text-slate-400 font-semibold mt-2">Deploy your profile to the agricultural exchange.</p>
            </div>

            <!-- Enhanced Error Feedback -->
            @if($errors->any())
                <div class="bg-rose-50 border border-rose-100 p-6 rounded-[32px] mb-10 animate-in slide-in-from-top duration-500">
                    <div class="flex items-center gap-3 text-rose-600 font-black text-[10px] uppercase tracking-widest mb-2">
                        <i class="fas fa-triangle-exclamation"></i> Security Warning
                    </div>
                    <ul class="text-xs font-bold text-rose-500 space-y-1 ml-1">
                        @foreach ($errors->all() as $error)
                            <li>— {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-8" id="regForm">
                @csrf
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Full Legal Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all" placeholder="John Doe">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Network Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all" placeholder="name@protocol.com">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Access Key</label>
                        <input type="password" name="password" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Verify Key</label>
                        <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block ml-1 text-center lg:text-left">Select Operational Protocol</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($roles as $role)
                            <button type="button" onclick="setRole('{{ $role->id }}', '{{ $role->name }}')" id="btn-{{ $role->name }}" 
                                    class="py-5 rounded-3xl font-black text-xs uppercase tracking-widest border-2 border-slate-50 text-slate-400 hover:border-green-100 transition-all flex flex-col items-center gap-2">
                                <i class="fas {{ $role->name == 'customer' ? 'fa-shopping-basket' : 'fa-tractor' }} fa-lg"></i>
                                {{ $role->name == 'customer' ? 'Acquisition' : 'Supply' }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="role_id" id="role_id" value="{{ old('role_id') }}" required>
                </div>

                <div id="farm-name-container" class="{{ old('role_id') == 2 ? '' : 'hidden' }} animate-in fade-in duration-300">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Farm Node Designation</label>
                    <input type="text" name="farmName" id="farmName" value="{{ old('farmName') }}" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all" placeholder="e.g. Genesis Organic Orchards">
                </div>

                <!-- GPS Precision Module -->
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Geo-Location Node</label>
                        <button type="button" onclick="detectMyLocation()" class="text-[10px] font-black text-green-600 uppercase tracking-widest flex items-center gap-2 hover:scale-105 transition-all">
                            <i class="fas fa-location-crosshairs text-xs"></i> Initialize GPS
                        </button>
                    </div>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" required class="w-full bg-slate-50 border-none rounded-t-3xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all" placeholder="Physical Node Address">
                    <div id="map" class="h-56 w-full rounded-b-3xl border-2 border-slate-50 shadow-inner z-0"></div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-6 rounded-[28px] font-black text-lg uppercase tracking-widest hover:bg-green-700 shadow-2xl shadow-green-100 transition-all active:scale-95">
                    Deploy Profile
                </button>
            </form>

            <div class="mt-12 text-center pt-8 border-t border-slate-50">
                <p class="text-sm font-bold text-slate-400">
                    Already a network member? 
                    <a href="{{ route('login') }}" class="text-slate-900 font-black hover:text-green-600 transition-colors ml-1">Sign In to Dashboard</a>
                </p>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([14.5995, 120.9842], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    var marker;

    function setLocation(lat, lng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 16);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    }

    map.on('click', (e) => setLocation(e.latlng.lat, e.latlng.lng));

    function detectMyLocation() {
        if (!navigator.geolocation) return alert("System Error: GPS Protocol Not Supported");
        navigator.geolocation.getCurrentPosition((pos) => setLocation(pos.coords.latitude, pos.coords.longitude));
    }

    function setRole(id, name) {
        document.getElementById('role_id').value = id;
        @foreach($roles as $r)
            document.getElementById('btn-{{ $r->name }}').className = 'py-5 rounded-3xl font-black text-xs uppercase tracking-widest border-2 border-slate-50 text-slate-400 hover:border-green-100 transition-all flex flex-col items-center gap-2';
        @endforeach
        const selected = document.getElementById('btn-' + name);
        selected.className = 'py-5 rounded-3xl font-black text-xs uppercase tracking-widest bg-green-600 border-2 border-green-600 text-white shadow-2xl shadow-green-100 transition-all flex flex-col items-center gap-2 scale-105';
        document.getElementById('farm-name-container').classList.toggle('hidden', name !== 'farmer');
    }

    window.onload = () => {
        const oldId = "{{ old('role_id') }}";
        if (oldId) {
            @foreach($roles as $r)
                if (oldId == "{{ $r->id }}") setRole("{{ $r->id }}", "{{ $r->name }}");
            @endforeach
        }
    };
</script>
@endsection
