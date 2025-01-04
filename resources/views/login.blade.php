<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{asset('css/my-login.css')}}">
    <style>
        /* Styling overlay */
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Background gelap transparan */
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Pastikan overlay berada di atas elemen lainnya */
        }
        .loader {
            height: 15px;
            aspect-ratio: 5;
            display: grid;
        }
        .loader:before,
        .loader:after {
            content: "";
            grid-area: 1/1;
            height: inherit;
            --_g: no-repeat radial-gradient(farthest-side,#00BFFF 94%,#00BFFF);
            background:
                var(--_g) left,
                var(--_g) right;
            background-size: 15px 100%;
            background-repeat: no-repeat;
            animation: l35 1s infinite linear; 
        }
        .loader:after {
            margin-left: auto;
            --s:-1;
        }
        @keyframes l35 {
            0%   {transform:translateY(calc(var(--s,1)*0px));aspect-ratio: 2.3 }
            33%  {transform:translateY(calc(var(--s,1)*8px));aspect-ratio: 2.3 }
            66%  {transform:translateY(calc(var(--s,1)*8px));aspect-ratio: 3.7 }
            100% {transform:translateY(calc(var(--s,1)*0px));aspect-ratio: 3.7 }
        }
    </style>
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
                <div class="loader-overlay">
                    <div class="loader"></div>
                </div>
				<div class="card-wrapper">
					<div class="brand">
						<img src="{{asset('img/logo.png')}}" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form id="formLogin">
                                @csrf
								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2025 &mdash; Your Company 
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#formLogin").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{route('login-proses')}}",
                    data: $(this).serialize(),
                    dataType: "json",
                    type: "post",
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if(response.success) {
                            window.location.href = "{{route('dashboard')}}";
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoader();
                    }
                })
            })
        })

        function showLoader() {
            $(".loader-overlay").css('display', 'flex');
        }
        function hideLoader() {
            $(".loader-overlay").css('display', 'none');
        }
    </script>
</body>
</html>
