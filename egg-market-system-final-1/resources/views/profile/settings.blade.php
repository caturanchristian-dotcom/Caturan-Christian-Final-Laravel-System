@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">Account Settings</h1>
        <p class="text-gray-500 font-medium mt-2">Manage your personal profile, farm details, and security.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-100 p-6 rounded-3xl text-green-700 font-bold text-sm flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-10">
        <!-- Profile Details -->
        <div class="bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm">
            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                <i class="fas fa-id-card text-green-600"></i> Profile Information
            </h3>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500 transition-all">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500 transition-all">
                    </div>
                </div>

                @if($user->role->name == 'farmer')
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Farm Name</label>
                    <input type="text" name="farm_name" value="{{ old('farm_name', $user->farm_name) }}" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500 transition-all">
                </div>
                @endif

                <!-- Location Selector -->
                <div class="space-y-3">
                    <div class="flex justify-between items-end">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">My Pinned Location</label>
                        <div class="flex items-center gap-4">
                            <a id="currentGoogleMapsLink" href="https://www.google.com/maps/search/?api=1&query={{ $user->latitude ?? 14.5995 }},{{ $user->longitude ?? 120.9842 }}" target="_blank" class="text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center gap-1 hover:underline">
                                <i class="fas fa-map-marker-alt"></i> Show on Google Maps
                            </a>
                            <button type="button" onclick="detectMyLocation()" class="text-[10px] font-black text-green-600 uppercase tracking-widest flex items-center gap-1 hover:underline">
                                <i class="fas fa-location-crosshairs"></i> Update with GPS
                            </button>
                        </div>
                    </div>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" required class="w-full bg-gray-50 border-none rounded-t-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500 transition-all" placeholder="Street Address, City">
                    <div id="map" class="h-64 w-full rounded-b-2xl border-2 border-gray-50"></div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $user->latitude) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $user->longitude) }}">
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-5 rounded-[24px] font-black uppercase tracking-widest hover:bg-green-700 shadow-xl shadow-green-100 transition-all">
                    Save Profile Changes
                </button>
            </form>
        </div>

        <!-- Security / Password -->
        <div class="bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm">
            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                <i class="fas fa-shield-halved text-blue-600"></i> Account Security
            </h3>

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Current Password</label>
                    <input type="password" name="current_password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">New Password</label>
                        <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white py-5 rounded-[24px] font-black uppercase tracking-widest hover:bg-black shadow-xl shadow-gray-200 transition-all">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([{{ $user->latitude ?? 14.5995 }}, {{ $user->longitude ?? 120.9842 }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker = L.marker([{{ $user->latitude ?? 14.5995 }}, {{ $user->longitude ?? 120.9842 }}]).addTo(map);

    function setLocation(lat, lng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 16);
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        document.getElementById('currentGoogleMapsLink').href = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
    }

    map.on('click', function(e) {
        setLocation(e.latlng.lat, e.latlng.lng);
    });

    function detectMyLocation() {
        if (!navigator.geolocation) return alert("Geolocation not supported");
        navigator.geolocation.getCurrentPosition((pos) => {
            setLocation(pos.coords.latitude, pos.coords.longitude);
        });
    }
</script>
@endsection
