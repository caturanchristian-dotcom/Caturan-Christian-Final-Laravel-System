@extends('layouts.main')

@section('content')
<div class="animate-in fade-in duration-700">
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
            <h2 class="text-sm font-black text-green-600 uppercase tracking-[0.3em]">Support Center</h2>
            <h1 class="text-5xl lg:text-7xl font-black text-gray-900 leading-tight tracking-tighter">Get in Touch.</h1>
            <p class="text-xl text-gray-500 font-medium">Our enterprise support team is available 24/7 to assist with your agricultural trade needs.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Contact Info -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm flex items-start gap-6 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shrink-0">
                        <i class="fas fa-phone-alt fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 text-lg">Direct Line</h3>
                        <p class="text-gray-500 font-medium">+1 (555) 123-4567</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2">Mon-Fri: 9am - 6pm</p>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm flex items-start gap-6 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0">
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 text-lg">Email Support</h3>
                        <p class="text-gray-500 font-medium">support@eggmarket.com</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2">Average response: 2hrs</p>
                    </div>
                </div>

                <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm flex items-start gap-6 hover:shadow-xl transition-all">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shrink-0">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 text-lg">HQ Location</h3>
                        <p class="text-gray-500 font-medium">123 Agriculture Valley, Central District, PH</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <form action="#" class="bg-white p-12 rounded-[50px] border border-gray-100 shadow-2xl shadow-gray-100 space-y-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block ml-1">Full Name</label>
                            <input type="text" placeholder="John Doe" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold focus:ring-2 focus:ring-green-500 transition-all">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block ml-1">Email Address</label>
                            <input type="email" placeholder="john@example.com" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold focus:ring-2 focus:ring-green-500 transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block ml-1">Inquiry Subject</label>
                        <select class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500 transition-all">
                            <option>Platform Registration</option>
                            <option>Order Inquiries</option>
                            <option>Supplier Partnership</option>
                            <option>Technical Support</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block ml-1">Your Message</label>
                        <textarea rows="5" placeholder="Tell us how we can help your business..." class="w-full bg-gray-50 border-none rounded-3xl p-6 font-medium text-sm focus:ring-2 focus:ring-green-500 transition-all"></textarea>
                    </div>
                    <button type="button" class="w-full bg-gray-900 text-white py-6 rounded-[28px] font-black uppercase tracking-widest hover:bg-black shadow-2xl shadow-gray-200 transition-all flex items-center justify-center gap-3">
                        Dispatch Message <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
