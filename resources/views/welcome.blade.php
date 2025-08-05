<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bệnh viện Heruko</title>
   <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">


    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-10">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="ph ph-hospital text-indigo-600 text-3xl"></i>
                <span class="text-xl font-bold text-indigo-700">Bệnh viện Heruko</span>
            </div>
            <div class="space-x-4">
                <a href="/" class="text-gray-700 hover:text-indigo-600 font-medium">Trang chủ</a>
                <a href="/choose-role" class="text-gray-700 hover:text-indigo-600 font-medium">Đăng nhập</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">Về chúng tôi</a>
                <a href="#" class="text-gray-700 hover:text-indigo-600 font-medium">Liên hệ</a>
              
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex items-center justify-center min-h-screen pt-20 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-10 max-w-xl text-center animate-fade-in">
            <h1 class="text-3xl font-extrabold text-indigo-700 mb-4">🏥Khám chữa bệnh tại bệnh viện Heruko</h1>
            <p class="text-gray-600 text-lg mb-8">Chào mừng bạn đến với bệnh viện Heruko.<br>Vui lòng đăng nhập để sử dụng các chức năng.</p>
            <a href="/choose-role"
               class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-3 px-8 rounded-lg shadow-lg text-lg font-semibold transition transform hover:scale-105 hover:shadow-xl">
                Đăng nhập
            </a>
        </div>
    

    </main>
    <!-- Phần giới thiệu về bệnh viện Heruko -->
<section class="mt-20 px-4 md:px-10 lg:px-20 py-12 animate-fade-up">

  <div class="max-w-6xl mx-auto bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl flex flex-col md:flex-row gap-10 p-8 items-center">
    
    <!-- Ảnh bên trái -->
    <div class="w-full md:w-1/2">
    <img src="{{ asset('pic_doctor.png') }}"
     alt="Ảnh bác sĩ"
     class="w-full h-auto rounded-xl shadow-md object-cover transition-transform duration-500 hover:scale-105">

    </div>

    <!-- Nội dung bên phải -->
    <div class="w-full md:w-1/2 text-gray-800">
      <h2 class="text-3xl font-bold text-indigo-700 mb-4 text-center md:text-left">🌟 Giới thiệu về Bệnh viện Heruko</h2>
      <p class="text-lg leading-relaxed mb-4 text-justify">
          <strong>Bệnh viện Heruko</strong> là một trong những cơ sở y tế hàng đầu với sứ mệnh phục vụ cộng đồng bằng tất cả trái tim và sự tận tâm.
          Được thành lập với khát vọng mang đến dịch vụ khám chữa bệnh hiện đại, hiệu quả và đầy tính nhân văn, Heruko không ngừng đổi mới để đáp ứng mọi nhu cầu chăm sóc sức khỏe của người dân.
      </p>
      <p class="text-lg leading-relaxed mb-4 text-justify">
          Với đội ngũ y bác sĩ nhiều năm kinh nghiệm, luôn tận tụy với người bệnh cùng hệ thống trang thiết bị tiên tiến đạt chuẩn quốc tế, chúng tôi tự hào là địa chỉ tin cậy trong việc khám chữa bệnh tổng quát, chuyên khoa và cấp cứu 24/7.
      </p>
      <p class="text-lg leading-relaxed mb-4 text-justify">
          Hệ thống quản lý bệnh viện thông minh giúp quá trình đặt lịch, quản lý hồ sơ, đơn thuốc và thanh toán viện phí trở nên nhanh chóng và minh bạch.
          Chúng tôi tin rằng sự hài lòng và sức khỏe của bạn chính là thành công lớn nhất của chúng tôi.
      </p>
      <p class="text-lg font-semibold text-indigo-600 mt-4 text-center md:text-left">
          Cảm ơn bạn đã lựa chọn Heruko – Nơi gửi trọn niềm tin, chăm sóc bằng cả trái tim! 💖
      </p>
    </div>
  </div>
</section>


   <style>
  .animate-fade-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeUp 1.2s ease-out forwards;
  }

  @keyframes fadeUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

</body>
</html>
