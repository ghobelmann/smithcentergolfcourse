@extends('layouts.app')@extends('layouts.app')



@section('content')@section('content')

<!-- Hero Section --><div class="container my-5">

<section class="relative bg-gray-900 py-20">    <h1 class="mb-4">Book a Tee Time</h1>

    <div class="absolute inset-0">    

        <img src="https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80"     <div class="row">

             alt="Golf Course"         <div class="col-md-8">

             class="w-full h-full object-cover opacity-30">            <div class="card mb-4">

    </div>                <div class="card-body">

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">                    <h4 class="card-title">Reserve Your Spot</h4>

        <h1 class="text-5xl sm:text-6xl font-display text-white mb-6">Book a Tee Time</h1>                    <p class="lead">

        <p class="text-xl text-gray-200 max-w-3xl mx-auto">                        Book your tee time online or call us directly. We recommend booking at least 24 hours in advance, 

            Reserve your spot on our championship course                        especially for weekend play.

        </p>                    </p>

    </div>

</section>                    <form action="#" method="POST" class="mt-4">

                        @csrf

<section class="py-20 bg-white">                        <div class="row g-3">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">                            <div class="col-md-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">                                <label for="date" class="form-label">Date</label>

            <!-- Booking Form -->                                <input type="date" class="form-control" id="date" name="date" required 

            <div class="lg:col-span-2">                                       min="{{ date('Y-m-d') }}">

                <div class="bg-white rounded-2xl shadow-lg p-8">                            </div>

                    <h2 class="text-3xl font-display mb-6">Reserve Your Spot</h2>                            <div class="col-md-6">

                    <p class="text-gray-600 mb-8 leading-relaxed">                                <label for="time" class="form-label">Preferred Time</label>

                        Book your tee time online or call us directly. We recommend booking at least 24 hours in advance,                                 <select class="form-select" id="time" name="time" required>

                        especially for weekend play.                                    <option value="">Select a time</option>

                    </p>                                    <option value="07:00">7:00 AM</option>

                                    <option value="07:30">7:30 AM</option>

                    <form action="#" method="POST" class="space-y-6">                                    <option value="08:00">8:00 AM</option>

                        @csrf                                    <option value="08:30">8:30 AM</option>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                                    <option value="09:00">9:00 AM</option>

                            <div>                                    <option value="09:30">9:30 AM</option>

                                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Date</label>                                    <option value="10:00">10:00 AM</option>

                                <input type="date"                                     <option value="10:30">10:30 AM</option>

                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                                     <option value="11:00">11:00 AM</option>

                                       id="date"                                     <option value="11:30">11:30 AM</option>

                                       name="date"                                     <option value="12:00">12:00 PM</option>

                                       required                                     <option value="12:30">12:30 PM</option>

                                       min="{{ date('Y-m-d') }}">                                    <option value="13:00">1:00 PM</option>

                            </div>                                    <option value="13:30">1:30 PM</option>

                                                                <option value="14:00">2:00 PM</option>

                            <div>                                    <option value="14:30">2:30 PM</option>

                                <label for="time" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Time</label>                                    <option value="15:00">3:00 PM</option>

                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                                     <option value="15:30">3:30 PM</option>

                                        id="time"                                     <option value="16:00">4:00 PM</option>

                                        name="time"                                 </select>

                                        required>                            </div>

                                    <option value="">Select a time</option>                            <div class="col-md-6">

                                    <option value="07:00">7:00 AM</option>                                <label for="players" class="form-label">Number of Players</label>

                                    <option value="08:00">8:00 AM</option>                                <select class="form-select" id="players" name="players" required>

                                    <option value="09:00">9:00 AM</option>                                    <option value="">Select number</option>

                                    <option value="10:00">10:00 AM</option>                                    <option value="1">1 Player</option>

                                    <option value="11:00">11:00 AM</option>                                    <option value="2">2 Players</option>

                                    <option value="12:00">12:00 PM</option>                                    <option value="3">3 Players</option>

                                    <option value="13:00">1:00 PM</option>                                    <option value="4">4 Players</option>

                                    <option value="14:00">2:00 PM</option>                                </select>

                                    <option value="15:00">3:00 PM</option>                            </div>

                                    <option value="16:00">4:00 PM</option>                            <div class="col-md-6">

                                </select>                                <label for="holes" class="form-label">Holes</label>

                            </div>                                <select class="form-select" id="holes" name="holes" required>

                                    <option value="">Select holes</option>

                            <div>                                    <option value="9">9 Holes</option>

                                <label for="players" class="block text-sm font-semibold text-gray-700 mb-2">Number of Players</label>                                    <option value="18">18 Holes</option>

                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                                 </select>

                                        id="players"                             </div>

                                        name="players"                             <div class="col-md-12">

                                        required>                                <div class="form-check">

                                    <option value="">Select number</option>                                    <input class="form-check-input" type="checkbox" id="cart" name="cart">

                                    <option value="1">1 Player</option>                                    <label class="form-check-label" for="cart">

                                    <option value="2">2 Players</option>                                        Include Golf Cart

                                    <option value="3">3 Players</option>                                    </label>

                                    <option value="4">4 Players</option>                                </div>

                                </select>                            </div>

                            </div>                            <div class="col-md-6">

                                <label for="name" class="form-label">Name</label>

                            <div>                                <input type="text" class="form-control" id="name" name="name" required>

                                <label for="holes" class="block text-sm font-semibold text-gray-700 mb-2">Holes</label>                            </div>

                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                             <div class="col-md-6">

                                        id="holes"                                 <label for="phone" class="form-label">Phone</label>

                                        name="holes"                                 <input type="tel" class="form-control" id="phone" name="phone" required>

                                        required>                            </div>

                                    <option value="">Select holes</option>                            <div class="col-md-12">

                                    <option value="9">9 Holes</option>                                <label for="email" class="form-label">Email</label>

                                    <option value="18">18 Holes</option>                                <input type="email" class="form-control" id="email" name="email" required>

                                </select>                            </div>

                            </div>                            <div class="col-md-12">

                        </div>                                <label for="notes" class="form-label">Special Requests (Optional)</label>

                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>

                        <div class="flex items-center">                            </div>

                            <input type="checkbox"                         </div>

                                   class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500" 

                                   id="cart"                         <div class="mt-4">

                                   name="cart">                            <button type="submit" class="btn btn-success btn-lg">

                            <label for="cart" class="ml-3 text-gray-700 font-medium">Include Golf Cart</label>                                <i class="fas fa-check me-2"></i>Request Tee Time

                        </div>                            </button>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                    </form>

                            <div>                </div>

                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>            </div>

                                <input type="text"         </div>

                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 

                                       id="name"         <div class="col-md-4">

                                       name="name"             <div class="card mb-3">

                                       required>                <div class="card-header bg-success text-white">

                            </div>                    <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Call to Book</h5>

                </div>

                            <div>                <div class="card-body">

                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>                    <p class="fs-4 fw-bold text-center mb-0">(555) 123-4567</p>

                                <input type="tel"                     <p class="text-center text-muted">Available 7 days a week</p>

                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                 </div>

                                       id="phone"             </div>

                                       name="phone" 

                                       required>            <div class="card mb-3">

                            </div>                <div class="card-header bg-info text-white">

                        </div>                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Tee Time Hours</h5>

                </div>

                        <div>                <div class="card-body">

                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>                    <p><strong>Spring/Summer/Fall:</strong><br>

                            <input type="email"                     7:00 AM - 5:00 PM</p>

                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                     <p><strong>Winter:</strong><br>

                                   id="email"                     8:00 AM - 4:00 PM<br>

                                   name="email"                     <small class="text-muted">(Weather permitting)</small></p>

                                   required>                </div>

                        </div>            </div>



                        <div>            <div class="card">

                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Special Requests (Optional)</label>                <div class="card-header bg-warning">

                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"                     <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Cancellation Policy</h5>

                                      id="notes"                 </div>

                                      name="notes"                 <div class="card-body">

                                      rows="4"></textarea>                    <p class="small">

                        </div>                        Please provide at least 24 hours notice for cancellations. 

                        Late cancellations may be subject to a fee.

                        <button type="submit" class="w-full px-8 py-4 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition text-lg">                    </p>

                            <i class="fas fa-check mr-2"></i>Request Tee Time                </div>

                        </button>            </div>

                    </form>        </div>

                </div>    </div>

            </div></div>

@endsection

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Call to Book -->
                <div class="bg-emerald-600 text-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-phone text-3xl mr-3"></i>
                            <h3 class="text-xl font-display">Call to Book</h3>
                        </div>
                        <p class="text-4xl font-bold text-center mb-2">(555) 123-4567</p>
                        <p class="text-center text-emerald-100">Available 7 days a week</p>
                    </div>
                </div>

                <!-- Tee Time Hours -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-blue-600 text-white p-4">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-2xl mr-3"></i>
                            <h3 class="text-xl font-display">Tee Time Hours</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="font-semibold text-gray-900 mb-1">Spring/Summer/Fall:</p>
                            <p class="text-gray-600">7:00 AM - 5:00 PM</p>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 mb-1">Winter:</p>
                            <p class="text-gray-600">8:00 AM - 4:00 PM</p>
                            <p class="text-sm text-gray-500">(Weather permitting)</p>
                        </div>
                    </div>
                </div>

                <!-- Cancellation Policy -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-yellow-500 text-gray-900 p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                            <h3 class="text-xl font-display">Cancellation Policy</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 leading-relaxed">
                            Please provide at least 24 hours notice for cancellations. 
                            Late cancellations may be subject to a fee.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
