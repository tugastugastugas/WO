<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
    <title>Argon Dashboard 2 by Creative Tim</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://www.google.com/recaptcha/api.js?render=6LdX3FkqAAAAAGozQdjGHpnMnShgZInMQn5xf56Z"></script>
    <!-- reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function validateForm() {
            var backupCaptchaField = document.querySelector('input[name="backup_captcha"]');

            if (navigator.onLine) {
                var response = grecaptcha.getResponse();
                if (response.length === 0) {
                    alert('Please complete the CAPTCHA.');
                    return false;
                }
                backupCaptchaField.removeAttribute('required');
            } else {
                backupCaptchaField.setAttribute('required', 'required');
                var backupCaptcha = backupCaptchaField.value;
                if (backupCaptcha === '') {
                    alert('Please complete the offline CAPTCHA.');
                    return false;
                }
            }

            return true;
        }

        function checkInternet() {
            var backupCaptchaField = document.querySelector('input[name="backup_captcha"]');
            if (!navigator.onLine) {
                document.getElementById('offline-captcha').style.display = 'block';
                document.querySelector('.g-recaptcha').style.display = 'none';
                backupCaptchaField.removeAttribute('disabled'); // Enable the field for offline use
            } else {
                document.getElementById('offline-captcha').style.display = 'none';
                document.querySelector('.g-recaptcha').style.display = 'block';
                backupCaptchaField.setAttribute('disabled', 'disabled'); // Disable the field for online use
            }
        }

        window.onload = checkInternet;
    </script>
</head>

<body>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <form class="pt-3" action="{{ route('aksi_login') }}" method="POST" onsubmit="return validateForm()">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <!-- reCAPTCHA widget -->
                                        <div class="g-recaptcha" data-sitekey="6LfO3loqAAAAAA3uUfdmERfJ0o5mtOVF4qV_HwhL"></div>
                                        <!-- Offline CAPTCHA -->
                                        <div id="offline-captcha" style="display:none;">
                                            <p>Please enter the characters shown below:</p>
                                            <img id="captcha-image" src="{{ url('captcha.php') }}" alt="CAPTCHA Image">
                                            <input type="text" name="backup_captcha" placeholder="Enter CAPTCHA" required>
                                            <button type="button" onclick="refreshCaptcha()">Refresh CAPTCHA</button>


                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                        </div>
                                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                            <p class="mb-4 text-sm mx-auto">
                                                Don't have an account?
                                                <a href="{{ route('register')}}" class="text-primary text-gradient font-weight-bold">Sign up</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                                <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Core JS Files -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
        gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
        gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: [
                    "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: "#fbfbfb",
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            color: "#ccc",
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                },
            },
        });

        function refreshCaptcha() {
            document.getElementById('captcha-image').src = "{{ url('captcha.php') }}?rnd=" + Math.random();
        }
    </script>
</body>

</html>