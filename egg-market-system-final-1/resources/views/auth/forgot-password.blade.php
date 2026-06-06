@extends('layouts.main')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-8 bg-[url('https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=1000')] bg-cover bg-center relative">
    <div class="absolute inset-0 bg-green-900/40 backdrop-blur-sm"></div>
    <div class="bg-white rounded-[40px] p-12 max-w-md w-full shadow-2xl relative z-10 animate-in zoom-in-95 duration-500">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-key text-3xl"></i>
            </div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Recover Access</h2>
            <p class="text-gray-500 font-medium mt-2">Enter your email to reset your password.</p>
        </div>

        <form action="#" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Registered Email</label>
                <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold placeholder:text-gray-300 focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <button type="submit" class="w-full bg-gray-900 text-white py-5 rounded-3xl font-black text-lg hover:bg-black shadow-2xl shadow-gray-200 transition-all active:scale-95">
                Send Reset Link
            </button>
        </form>

        <div class="mt-10 text-center">
            <a href="{{ route('login') }}" class="text-sm font-black text-blue-600 hover:underline flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>
</div>
@endsection
