@extends('layouts.main')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-8 bg-[url('https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=1000')] bg-cover bg-center relative">
    <div class="absolute inset-0 bg-green-900/40 backdrop-blur-sm"></div>
    <div class="bg-white rounded-[40px] p-12 max-w-md w-full shadow-2xl relative z-10 animate-in zoom-in-95 duration-500">
        <div class="text-center mb-10">
            <img src="https://tse1.mm.bing.net/th/id/OIP.kzenbVuAfiBwLzLLnNiKQwAAAA?w=400&h=400&rs=1&pid=ImgDetMain&o=7&rm=3" class="w-20 h-20 rounded-3xl shadow-xl shadow-green-100 mx-auto mb-6" alt="Branding">
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="text-gray-500 font-medium mt-2 text-sm uppercase tracking-widest">Digital Trade Terminal</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-xs font-bold uppercase tracking-widest">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Email Address</label>
                <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold placeholder:text-gray-300 focus:ring-2 focus:ring-green-500 transition-all" placeholder="name@domain.com">
            </div>
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Password</label>
                <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold placeholder:text-gray-300 focus:ring-2 focus:ring-green-500 transition-all" placeholder="••••••••">
            </div>
            <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                <label class="flex items-center gap-2 text-gray-400 cursor-pointer hover:text-green-600">
                    <input type="checkbox" name="remember" class="rounded text-green-600 focus:ring-green-500 border-gray-200">
                    Remember Me
                </label>
                <a href="{{ route('password.request') }}" class="text-green-600 hover:underline">Forgot Password?</a>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-5 rounded-3xl font-black text-lg hover:bg-green-700 shadow-2xl shadow-green-100 transition-all active:scale-95">
                Access System
            </button>
        </form>

        <div class="mt-10 text-center">
            <p class="text-sm font-bold text-gray-500">
                New to the platform? 
                <a href="{{ route('register') }}" class="text-green-600 font-black hover:underline">Create Account</a>
            </p>
        </div>
    </div>
</div>
@endsection
