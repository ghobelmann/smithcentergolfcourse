@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&q=80&w=2000" 
             alt="Pro Shop" 
             class="w-full h-full object-cover opacity-40">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Pro Shop</h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto">
            Show your Smith Center Golf pride with our exclusive merchandise
        </p>
    </div>
</section>

<!-- Products Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Info Banner -->
        <div class="bg-emerald-50 border-l-4 border-emerald-600 p-6 rounded-lg mb-12">
            <div class="flex items-start">
                <i class="fas fa-store text-emerald-600 text-2xl mr-4 mt-1"></i>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Visit Our Pro Shop</h3>
                    <p class="text-gray-700">
                        All merchandise is available for purchase at the course. Contact us at 
                        <a href="tel:785-282-3249" class="text-emerald-600 hover:text-emerald-700 font-semibold">785-282-3249</a> 
                        for availability and ordering.
                    </p>
                </div>
            </div>
        </div>

        <!-- Product Categories -->
        <div class="mb-12">
            <h2 class="text-3xl font-display text-center mb-12">Featured Merchandise</h2>
            
            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Hoodie -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&q=80&w=800" 
                             alt="Golf Hoodie" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Logo Hoodie</h3>
                            <span class="text-emerald-600 font-bold text-xl">$45</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Comfortable pullover hoodie with embroidered Smith Center Golf logo. Available in emerald green and navy blue.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">S</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">M</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">L</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">XL</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">XXL</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Polo Shirt -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1628016876762-e8e6bc551234?auto=format&fit=crop&q=80&w=800" 
                             alt="Golf Polo" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Performance Polo</h3>
                            <span class="text-emerald-600 font-bold text-xl">$38</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Moisture-wicking performance polo with embroidered logo. Perfect for the course. Multiple colors available.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">S</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">M</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">L</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">XL</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">XXL</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- T-Shirt -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&q=80&w=800" 
                             alt="Golf T-Shirt" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Cotton T-Shirt</h3>
                            <span class="text-emerald-600 font-bold text-xl">$22</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Classic comfort cotton tee with screen-printed logo. Great for casual wear or layering.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">S</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">M</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">L</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">XL</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">XXL</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Baseball Cap -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1588850561407-ed78c282e89b?auto=format&fit=crop&q=80&w=800" 
                             alt="Golf Cap" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Classic Baseball Cap</h3>
                            <span class="text-emerald-600 font-bold text-xl">$25</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Adjustable baseball cap with embroidered logo. Features moisture-wicking sweatband and curved bill.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">One Size Fits All</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Visor -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1575428652377-a2d80e2277fc?auto=format&fit=crop&q=80&w=800" 
                             alt="Golf Visor" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Performance Visor</h3>
                            <span class="text-emerald-600 font-bold text-xl">$20</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Lightweight visor with moisture-wicking fabric and adjustable strap. Perfect for sunny days on the course.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">One Size Fits All</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Golf Towel -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1580910051074-3eb694886505?auto=format&fit=crop&q=80&w=800" 
                             alt="Golf Towel" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Golf Towel</h3>
                            <span class="text-emerald-600 font-bold text-xl">$18</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Premium microfiber golf towel with embroidered logo. Features clip attachment and high absorbency.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">16" x 24"</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Driver Head Cover -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1530028828-25e8270ace32?auto=format&fit=crop&q=80&w=800" 
                             alt="Driver Head Cover" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Driver Head Cover</h3>
                            <span class="text-emerald-600 font-bold text-xl">$32</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Premium knit driver head cover with embroidered logo. Protects your driver with style and fits most 460cc drivers.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">Universal Fit</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Hybrid Head Cover Set -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?auto=format&fit=crop&q=80&w=800" 
                             alt="Hybrid Head Covers" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Hybrid Head Cover Set</h3>
                            <span class="text-emerald-600 font-bold text-xl">$48</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Set of 3 hybrid/fairway wood head covers with numbered tags. Features embroidered logo and soft lining.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">3-5-7</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

                <!-- Putter Head Cover -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                    <div class="relative bg-gray-100 h-80 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1535131749006-b7f58c99034b?auto=format&fit=crop&q=80&w=800" 
                             alt="Putter Head Cover" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-4 left-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <img src="{{ asset('SC_Logo.png') }}" alt="SC Logo" class="inline h-4 w-4 mr-1 filter brightness-0 invert">
                            SC Golf
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display text-gray-900">Blade Putter Cover</h3>
                            <span class="text-emerald-600 font-bold text-xl">$28</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Magnetic closure blade putter cover with embroidered logo. Fits most standard blade-style putters.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">Blade Style</span>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full text-center px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-phone mr-2"></i>Order Now
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Additional Info Section -->
        <div class="mt-16 bg-gradient-to-br from-emerald-50 to-blue-50 rounded-2xl p-8 md:p-12">
            <div class="text-center mb-8">
                <i class="fas fa-shopping-bag text-5xl text-emerald-600 mb-4"></i>
                <h2 class="text-3xl font-display text-gray-900 mb-4">How to Order</h2>
                <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                    All merchandise is available for in-person purchase at our Pro Shop or can be ordered by phone.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-white rounded-xl shadow">
                    <i class="fas fa-store text-4xl text-emerald-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Visit Pro Shop</h3>
                    <p class="text-gray-600">Stop by during course hours to see and purchase items in person</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-xl shadow">
                    <i class="fas fa-phone text-4xl text-emerald-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Call to Order</h3>
                    <p class="text-gray-600">Call us at <a href="tel:785-282-3249" class="text-emerald-600 font-semibold">785-282-3249</a> to order</p>
                </div>
                
                <div class="text-center p-6 bg-white rounded-xl shadow">
                    <i class="fas fa-gift text-4xl text-emerald-600 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Great Gifts</h3>
                    <p class="text-gray-600">Perfect for birthdays, holidays, or tournament prizes</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('contact') }}" class="inline-block px-10 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">
                    <i class="fas fa-phone mr-2"></i>Contact Us About Merchandise
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
