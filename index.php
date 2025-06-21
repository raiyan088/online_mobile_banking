<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Index Page</title>
	
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/index_style.css">
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css"/>
	
</head>
<body>
	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<form method="POST"> 
											<div class="section text-center">
												<h4 class="mb-4 pb-3">Log In</h4>
												<div class="form-group">
													<input type="text" class="form-style" placeholder="Mobile Number" name="lognumber" id="lognumber" autocomplete="off" required>
													<i class="input-icon uil uil-mobile-android"></i>
												</div>	
												<div class="form-group mt-2">
													<input type="password" class="form-style" placeholder="Password" name="logpass" id="logpass" autocomplete="off" required>
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<button class="btn-disable" name="login" id="login" type="submit" disabled>submit</button>
												<p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>
											</div>
										</form>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<form method="POST">
											<div class="section text-center">
												<h4 class="mb-4 pb-3">Sign Up</h4>
												<div class="form-group">
													<input type="text" name="regname" id="regname" class="form-style" placeholder="Full Name" autocomplete="off" required>
													<i class="input-icon uil uil-user"></i>
												<div class="form-group mt-2">
													<input type="text" name="regnumber" id="regnumber" class="form-style" placeholder="Mobile Number" autocomplete="off" required>
													<i class="input-icon uil uil-mobile-android"></i>
												</div>
												<div class="form-group mt-2">
													<input type="password" name="regpass" id="regpass" class="form-style" placeholder="Password" autocomplete="off" required>
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<div class="form-group mt-2">
													<input type="password" name="confirmpass" id="confirmpass" class="form-style" placeholder="Confirm Password" autocomplete="off">
													<i class="input-icon uil uil-lock-alt"></i>
												</div>
												<button class="btn-disable" name="signup" id="signup" type="submit" disabled>submit</a>
											</div>
										</form>
									</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>

	<div id="toastmsg"></div>

	<script>
	 	let reglog = document.getElementById('reg-log');

		let lognumber = document.getElementById('lognumber');
		let logpass = document.getElementById('logpass');
		let login = document.getElementById('login');

		if (window.location.search.includes('page=signup')) {
			reglog.checked = true;
		}

		reglog.addEventListener('input', (evt) => {
			window.history.replaceState('', '', updateURLParameter(window.location.href, "page", reglog.checked?"signup":"login"));
		});
		
		lognumber.addEventListener('input', (evt) => {
			if (lognumber.value.length == 11) {
				lognumber.style['border'] = 'none';
			} else {
				lognumber.style['border'] = '1px solid red';
			}

			changeLoginBtn();
		});

		logpass.addEventListener('input', (evt) => {
			if (logpass.value.length > 5) {
				logpass.style['border'] = 'none';
			} else {
				logpass.style['border'] = '1px solid red';
			}
			
			changeLoginBtn();
		});


		let regname = document.getElementById('regname');
		let regnumber = document.getElementById('regnumber');
		let regpass = document.getElementById('regpass');
		let confirmpass = document.getElementById('confirmpass');
		let signup = document.getElementById('signup');
		

		regname.addEventListener('input', (evt) => {

			if (regname.value.length > 0) {
				regname.style['border'] = 'none';
			} else {
				regname.style['border'] = '1px solid red';
			}

			changeSignUpBtn();
		});

		regnumber.addEventListener('input', (evt) => {
			
			if (regnumber.value.length == 11) {
				regnumber.style['border'] = 'none';
			} else {
				regnumber.style['border'] = '1px solid red';
			}

			changeSignUpBtn();
		});

		regpass.addEventListener('input', (evt) => {
			
			if (regpass.value.length > 5) {
				regpass.style['border'] = 'none';
			} else {
				regpass.style['border'] = '1px solid red';
			}

			changeSignUpBtn();
		});

		confirmpass.addEventListener('input', (evt) => {
			
			if (confirmpass.value == regpass.value) {
				confirmpass.style['border'] = 'none';
			} else {
				confirmpass.style['border'] = '1px solid red';
			}

			changeSignUpBtn();
		});

		function changeLoginBtn() {
			if (lognumber.value.length == 11 && logpass.value.length > 5) {
				login.disabled = false;
				login.className = 'btn-enable';
			} else {
				login.className = 'btn-disable';
				login.disabled = true;
			}
		}

		function changeSignUpBtn() {
			if (regname.value.length > 0 && regnumber.value.length == 11 && regpass.value.length > 5 && regpass.value == confirmpass.value) {
				signup.disabled = false;
				signup.className = 'btn-enable';
			} else {
				signup.className = 'btn-disable';
				signup.disabled = true;
			}
		}

		let timeout = null;

		function showTost(msg) {
			let toastmsg = document.getElementById('toastmsg');
			toastmsg.innerHTML = msg;
			toastmsg.className = "show";
			
			if (timeout) {
				clearTimeout(timeout)
			}

			timeout = setTimeout(function() {
				toastmsg.className = '';
				timeout = null;
			}, 3450);
		}

		function updateURLParameter(url, param, paramVal) {
			let newAdditionalURL = "";
			let tempArray = url.split("?");
			let baseURL = tempArray[0];
			let additionalURL = tempArray[1];
			let temp = "";
			if (additionalURL) {
				tempArray = additionalURL.split("&");
				for (let i=0; i<tempArray.length; i++){
					if(tempArray[i].split('=')[0] != param){
						newAdditionalURL += temp + tempArray[i];
						temp = "&";
					}
				}
			}

			let rows_txt = temp + "" + param + "=" + paramVal;

			if (!baseURL.endsWith('index.php')) {
				return baseURL + "index.php?" + newAdditionalURL + rows_txt;
			} else {
				return baseURL + "?" + newAdditionalURL + rows_txt;
			}
		}

	</script>
</body>
</html>

<?php
if(isset($_SESSION['acc_no'])){ 
	echo "<script> window.location = 'dashboard.php'; </script>";
} else {
	if (isset($_POST['login'])) {
		try {
	
			$number = $_POST['lognumber'];
			$pass = $_POST['logpass'];
	
			$result = $conn->query("select c_id from customer where number='$number' AND password='$pass'");
	
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$c_id = $row['c_id'];
				$result = $conn->query("select acc_no, status from account where c_id=$c_id");
	
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$acc_no = $row['acc_no'];
					$status = $row['status'];
					if ($status == 'ACTIVE') {
						$_SESSION['acc_no']=$acc_no;
						$_SESSION['c_id']=$c_id;
						echo "<script> window.location = 'dashboard.php'; </script>";
					} else if ($status == 'DEACTIVE') {
						echo "<script> showTost('Account De-Actived'); </script>";
					} else if ($status == 'PENDING') {
						echo "<script> showTost('Account Pending'); </script>";
					} else {
						echo "<script> showTost('Login Failed'); </script>";
					}
				} else {
					echo "<script> showTost('Login Failed'); </script>";
				}
			} else {
				echo "<script> showTost('Login Failed'); </script>";
			}
		} catch(Exception $e) {
			echo "<script> showTost('Login Failed'); </script>";
		}
	} else if (isset($_POST['signup'])) {
		try {
			$name = $_POST['regname'];
			$number = $_POST['regnumber'];
			$pass = $_POST['regpass'];
		
			$result = $conn->query("INSERT INTO customer (name, number, password) values ('$name', '$number', '$pass')");
		
			if ($result === TRUE) {
				$result = $conn->query("select c_id from customer where number='$number' AND password='$pass'");
		
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$c_id = $row['c_id'];
					$date = date('Y-m-d h:i:s a');
					if ($conn->query("INSERT INTO account (c_id, balance, status, date) values ($c_id, 0.00, 'PENDING', '$date')") === TRUE) {
						echo "<script> showTost('Registration Success'); </script>";
					} else {
						echo "<script> showTost('Registration Failed'); </script>";
					}
				} else {
					echo "<script> showTost('Registration Failed'); </script>";
				}
			} else {
				echo "<script> showTost('Registration Failed'); </script>";
			}
		} catch(Exception $e) {
			echo "<script> showTost('Registration Failed'); </script>";
		}
	}
}
?>