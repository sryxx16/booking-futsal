<footer class="bg-gray-900 text-white pt-16 pb-8 border-t-4 border-blue-600 mt-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <h3 class="text-2xl font-black text-blue-500 mb-4 flex items-center">
                    <i class="fas fa-futbol mr-2"></i> FutsalHub
                </h3>
                <p class="text-gray-400 leading-relaxed text-sm">
                    Sistem Pemesanan Lapangan Futsal terbaik dan terpercaya. Main futsal jadi lebih mudah, cepat, dan praktis tanpa harus repot antri.
                </p>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2 inline-block">Tautan Cepat</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ url('/#home') }}" class="text-gray-400 hover:text-blue-400 hover:pl-2 transition-all"><i class="fas fa-chevron-right text-xs mr-2 text-blue-600"></i>Beranda</a></li>
                    <li><a href="{{ url('/#fields') }}" class="text-gray-400 hover:text-blue-400 hover:pl-2 transition-all"><i class="fas fa-chevron-right text-xs mr-2 text-blue-600"></i>Daftar Lapangan</a></li>
                    <li><a href="{{ url('/#reviews') }}" class="text-gray-400 hover:text-blue-400 hover:pl-2 transition-all"><i class="fas fa-chevron-right text-xs mr-2 text-blue-600"></i>Ulasan Pelanggan</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2 inline-block">Hubungi Kami</h4>
                <ul class="space-y-4 text-gray-400 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-500 text-lg"></i>
                        <span>Jl. Raya Futsal No. 1, Cibinong, Bogor</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3 text-blue-500 text-lg"></i>
                        <span>+62 812-3456-7890</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-blue-500 text-lg"></i>
                        <span>admin@futsalhub.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm text-center md:text-left mb-4 md:mb-0">
                &copy; {{ date('Y') }} FutsalHub. All rights reserved. Dibuat dengan <i class="fas fa-heart text-red-500 mx-1"></i>
            </p>
            <div class="flex space-x-5">
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors shadow-lg"><i class="fab fa-instagram text-lg"></i></a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors shadow-lg"><i class="fab fa-facebook-f text-lg"></i></a>
                <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition-colors shadow-lg"><i class="fab fa-whatsapp text-lg"></i></a>
            </div>
        </div>
    </div>
</footer>
