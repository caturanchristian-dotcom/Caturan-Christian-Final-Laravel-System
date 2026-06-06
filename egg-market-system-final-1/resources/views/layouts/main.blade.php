<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EggMarket | Premier Agricultural Exchange')</title>
    
    <!-- Professional Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dashboard-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .dashboard-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="bg-[#F8FAFC] text-[#1E293B] flex flex-col min-h-screen selection:bg-green-100 selection:text-green-900">
    
    <!-- High-Fidelity Top Navbar -->
    <nav class="glass-nav border-b border-slate-200/60 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center gap-12">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="relative">
                            <img src="https://tse1.mm.bing.net/th/id/OIP.kzenbVuAfiBwLzLLnNiKQwAAAA?w=400&h=400&rs=1&pid=ImgDetMain&o=7&rm=3" 
                                 class="w-10 h-10 rounded-xl shadow-xl shadow-green-100 group-hover:scale-110 transition-transform duration-500" alt="Logo">
                            <div class="absolute -inset-1 bg-green-400/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <span class="text-2xl font-extrabold text-slate-900 tracking-tighter">EggMarket</span>
                    </a>

                    <div class="hidden lg:flex items-center gap-8">
                        <a href="/" class="text-sm font-semibold {{ Request::is('/') ? 'text-green-600' : 'text-slate-500 hover:text-green-600' }} transition-colors">Home</a>
                        <a href="/marketplace" class="text-sm font-semibold {{ Request::is('marketplace*') ? 'text-green-600' : 'text-slate-500 hover:text-green-600' }} transition-colors">Marketplace</a>
                        
                        @auth
                            <div class="h-4 w-px bg-slate-200"></div>
                            @if(Auth::user()->role->name == 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold {{ Request::is('admin/dashboard') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-chart-line text-[10px]"></i> Oversight
                                </a>
                                <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold {{ Request::is('admin/inventory*') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-boxes-stacked text-[10px]"></i> Market Inventory
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold {{ Request::is('admin/users*') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-users-gear text-[10px]"></i> User Management
                                </a>
                            @endif
                            @if(Auth::user()->role->name == 'farmer')
                                <a href="{{ route('farmer.dashboard') }}" class="text-sm font-semibold {{ Request::is('farmer/dashboard') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-chart-line text-[10px]"></i> Performance
                                </a>
                                <a href="{{ route('farmer.inventory') }}" class="text-sm font-semibold {{ Request::is('farmer/inventory*') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-boxes-stacked text-[10px]"></i> Inventory
                                </a>
                            @endif
                            @if(Auth::user()->role->name == 'customer')
                                <a href="{{ route('customer.dashboard') }}" class="text-sm font-semibold {{ Request::is('customer/dashboard') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-chart-line text-[10px]"></i> Dashboard
                                </a>
                                <a href="{{ route('orders.index') }}" class="text-sm font-semibold {{ Request::is('my-orders*') ? 'text-green-600' : 'text-slate-500' }} transition-colors flex items-center gap-2">
                                    <i class="fas fa-history text-[10px]"></i> My Orders
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="flex items-center gap-5">
                    
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-2.5 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-xl transition-all">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>

                    @auth
                        <div class="relative group">
                            <button class="p-2.5 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-xl transition-all relative">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="notif-badge hidden absolute top-2 right-2 bg-red-500 text-white text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full ring-2 ring-white">0</span>
                            </button>
                        </div>
                    @endauth

                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-xl transition-all">
                        <i class="fas fa-shopping-bag text-xl"></i>
                        @if(session('cart'))
                            <span class="absolute top-1 -right-1 bg-slate-900 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full ring-4 ring-white">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <div class="h-8 w-px bg-slate-200 mx-2"></div>
                        <div class="relative group">
                            <button class="flex items-center gap-3 pl-1 pr-3 py-1 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-white hover:shadow-md transition-all">
                                <div class="w-9 h-9 bg-slate-900 rounded-xl flex items-center justify-center text-white font-bold text-sm">{{ Auth::user()->name[0] }}</div>
                                <div class="text-left hidden md:block">
                                    <p class="text-xs font-bold text-slate-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                                    <p class="text-[9px] font-black text-green-600 uppercase tracking-widest">{{ Auth::user()->role->name }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-[8px] text-slate-400 ml-1"></i>
                            </button>
                            <div class="absolute right-0 mt-3 w-64 bg-white rounded-[28px] border border-slate-100 shadow-2xl py-4 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all z-50">
                                <div class="px-6 py-3 border-b border-slate-50 mb-2">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Account Node</p>
                                    <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.settings') }}" class="flex items-center gap-4 px-6 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-green-600 transition-all">
                                    <i class="fas fa-sliders w-5 text-slate-300"></i> Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-3 text-sm font-semibold text-red-400 hover:bg-red-50 transition-all">
                                        <i class="fas fa-power-off w-5"></i> Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-green-600 px-4 py-2">Sign In</a>
                            <a href="{{ route('register') }}" class="text-sm font-extrabold text-white bg-green-600 hover:bg-green-700 px-6 py-3 rounded-2xl shadow-xl shadow-green-100 transition-all active:scale-95">Start Trading</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Professional Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden fixed inset-0 z-[100] animate-in fade-in duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
        <div class="absolute right-0 top-0 h-full w-4/5 max-w-sm bg-white shadow-2xl p-8 flex flex-col animate-in slide-in-from-right duration-500">
            <div class="flex justify-between items-center mb-12">
                <img src="https://tse1.mm.bing.net/th/id/OIP.kzenbVuAfiBwLzLLnNiKQwAAAA?w=400&h=400&rs=1&pid=ImgDetMain&o=7&rm=3" class="w-10 h-10 rounded-xl" alt="Logo">
                <button onclick="toggleMobileMenu()" class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="flex-1 space-y-6">
                <a href="/" class="block text-xl font-black text-slate-900">Home</a>
                <a href="/marketplace" class="block text-xl font-black text-slate-900">Marketplace</a>
                @auth
                    <div class="h-px bg-slate-100 my-8"></div>
                    @if(Auth::user()->role->name == 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block text-xl font-black text-green-600">Oversight</a>
                        <a href="{{ route('admin.products.index') }}" class="block text-xl font-black text-slate-900">Market Inventory</a>
                        <a href="{{ route('admin.users.index') }}" class="block text-xl font-black text-slate-900">User Management</a>
                    @endif
                    @if(Auth::user()->role->name == 'farmer')
                        <a href="{{ route('farmer.dashboard') }}" class="block text-xl font-black text-slate-900">Performance</a>
                        <a href="{{ route('farmer.inventory') }}" class="block text-xl font-black text-slate-900">Inventory</a>
                    @endif
                    @if(Auth::user()->role->name == 'customer')
                        <a href="{{ route('customer.dashboard') }}" class="block text-xl font-black text-green-600">Dashboard</a>
                        <a href="{{ route('orders.index') }}" class="block text-xl font-black text-slate-900">My Orders</a>
                    @endif
                    <a href="{{ route('profile.settings') }}" class="block text-xl font-black text-slate-500">Settings</a>
                @endauth
            </nav>

            @auth
                <div class="mt-auto pt-8 border-t border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black">{{ Auth::user()->name[0] }}</div>
                    <div class="flex-1 overflow-hidden">
                        <p class="font-black text-slate-900 truncate">{{ Auth::user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-black text-red-500 uppercase tracking-widest mt-1">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="mt-auto space-y-4">
                    <a href="{{ route('login') }}" class="block w-full text-center py-4 rounded-2xl font-black text-slate-900 border-2 border-slate-100">Sign In</a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-4 rounded-2xl font-black text-white bg-green-600">Start Trading</a>
                </div>
            @endauth
        </div>
    </div>

    <main class="flex-1">
        <!-- Global Feedback System (Auto-Dismiss enabled) -->
        @if(session('success') || session('error') || $errors->any())
            <div id="protocol-toast" class="fixed top-24 right-8 z-[100] w-full max-w-sm animate-in slide-in-from-right duration-500">
                @if(session('success'))
                    <div class="bg-emerald-500 text-white p-6 rounded-[32px] shadow-2xl flex items-center gap-4 mb-4">
                        <i class="fas fa-check-circle text-2xl text-emerald-200"></i>
                        <div>
                            <p class="font-black text-xs uppercase tracking-widest">Protocol Success</p>
                            <p class="text-sm font-bold opacity-90">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-500 text-white p-6 rounded-[32px] shadow-2xl flex items-center gap-4 mb-4">
                        <i class="fas fa-exclamation-triangle text-2xl text-rose-200"></i>
                        <div>
                            <p class="font-black text-xs uppercase tracking-widest">System Error</p>
                            <p class="text-sm font-bold opacity-90">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-slate-900 text-white p-6 rounded-[32px] shadow-2xl flex items-center gap-4">
                        <i class="fas fa-shield-exclamation text-2xl text-amber-400"></i>
                        <div>
                            <p class="font-black text-xs uppercase tracking-widest text-amber-400">Validation Failure</p>
                            <ul class="text-xs font-bold opacity-80 list-disc ml-4 mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Elite High-Contrast Footer -->
    <footer class="bg-slate-900 text-white py-24 px-8 mt-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/[0.02] rounded-l-full -z-0"></div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 relative z-10">
            <div class="col-span-1 lg:col-span-1 space-y-8">
                <a href="/" class="flex items-center gap-4 group">
                    <img src="https://tse1.mm.bing.net/th/id/OIP.kzenbVuAfiBwLzLLnNiKQwAAAA?w=400&h=400&rs=1&pid=ImgDetMain&o=7&rm=3" 
                         class="w-12 h-12 rounded-2xl shadow-2xl shadow-green-900/20 group-hover:rotate-6 transition-transform duration-500" alt="Footer Logo">
                    <span class="text-3xl font-black tracking-tighter">EggMarket</span>
                </a>
                <p class="text-slate-400 font-medium leading-relaxed text-sm max-w-xs">Deploying precision logistics to unite local farm nodes with global consumer demand.</p>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-green-600 hover:border-green-600 transition-all cursor-pointer"><i class="fab fa-linkedin-in text-xs"></i></div>
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-green-600 hover:border-green-600 transition-all cursor-pointer"><i class="fab fa-instagram text-xs"></i></div>
                </div>
            </div>
            <div>
                <h5 class="text-green-500 font-black uppercase tracking-[0.2em] text-[10px] mb-8">Protocol Hub</h5>
                <ul class="space-y-5 text-slate-300 font-bold text-sm">
                    <li><a href="/marketplace" class="hover:text-white hover:translate-x-1 inline-block transition-all">Live Exchange</a></li>
                    <li><a href="/about" class="hover:text-white hover:translate-x-1 inline-block transition-all">Node Traceability</a></li>
                    <li><a href="/contact" class="hover:text-white hover:translate-x-1 inline-block transition-all">Technical Support</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-green-500 font-black uppercase tracking-[0.2em] text-[10px] mb-8">Infrastructure</h5>
                <ul class="space-y-5 text-slate-300 font-bold text-sm">
                    <li class="flex items-center gap-3"><i class="fas fa-shield-halved text-[10px] text-slate-500"></i> Trade Compliance</li>
                    <li class="flex items-center gap-3"><i class="fas fa-location-crosshairs text-[10px] text-slate-500"></i> GPS Verification</li>
                    <li class="flex items-center gap-3"><i class="fas fa-lock text-[10px] text-slate-500"></i> Encrypted Session</li>
                </ul>
            </div>
            <div>
                <h5 class="text-green-500 font-black uppercase tracking-[0.2em] text-[10px] mb-8">Market Impact</h5>
                <div class="space-y-6">
                    <div class="p-6 bg-white/[0.03] rounded-3xl border border-white/[0.05]">
                        <p class="text-2xl font-black text-white leading-none">99.8%</p>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-2">Delivery Precision</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto border-t border-white/5 mt-24 pt-12 flex flex-col md:flex-row justify-between items-center gap-8">
            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">© 2024 EggMarket Management System</span>
            <div class="flex items-center gap-2 text-emerald-500 text-[10px] font-black uppercase tracking-widest">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                System Protocol: Online
            </div>
        </div>
    </footer>

    <script>
        async function syncSystem() {
            @auth
                try {
                    const response = await fetch("{{ route('api.sync') }}");
                    const data = await response.json();
                    const badges = document.querySelectorAll('.notif-badge');
                    badges.forEach(b => {
                        b.innerText = data.unread_count;
                        b.classList.toggle('hidden', data.unread_count === 0);
                    });
                } catch (e) {}
            @endauth
        }
        setInterval(syncSystem, 10000);
        syncSystem();

        // --- Auto-Dismiss Logic ---
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('protocol-toast');
            if (toast) {
                setTimeout(() => {
                    toast.classList.add('animate-out', 'fade-out', 'slide-out-to-right', 'duration-1000');
                    setTimeout(() => toast.remove(), 1000);
                }, 2000);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
