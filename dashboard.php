<?php
session_start();
include 'db.php';

if(!isset($_SESSION['acc_no'])){ 
	echo "<script> window.location = 'index.php'; </script>";
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Dashboard</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard_style.css">
    <link rel="stylesheet" type="text/css" href="font/css/font-awesome.min.css">
	
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
		<a class="navbar-brand" href="#">
			<img src="img/bank_logo.png" width="36" height="36" class="d-inline-block align-top" alt="">
		</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item ">
					<a class="nav-link active" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item ">  <a class="nav-link" href="">Accounts</a></li>
				<li class="nav-item ">  <a class="nav-link" onclick="openDialog('Fund Transfer')">Funds Transfer</a></li>
			</ul>
			
			<form class="form-inline my-2 my-lg-0">
				<a href="" class="btn btn-outline-success" data-toggle="tooltip" id="p_balance" title="Your current Account Balance" style="margin-right: 4px;">Acount Balance : 1000.00 ৳</a>  
				<a data-toggle="tooltip" title="Account Summary" class="btn btn-outline-primary mx-1" ><i class="fa fa-book fa-fw"></i></a> 
				<a href="logout.php" data-toggle="tooltip" title="Logout" class="btn btn-outline-danger mx-1" ><i class="fa fa-sign-out fa-fw"></i></a>    
			</form>
		</div>
	</nav>

	<div class="container">
		<div class="container-main">
			<div class="profile-section">
				<div class="profile">
					<h3 style="text-align: center;">Account Details</h3><br>
					<p id="p_name">Full Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</p>
					<p id="p_acc_no">Account Number &nbsp:</p>
					<p id="p_number">Mobile Number &nbsp&nbsp&nbsp&nbsp:</p>
					<p id="p_time">Create Time &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</p>
				</div>
			</div>

		
			<div class="dashboard">
				<div class="card">
					<img src="img/transfer.png" alt="Fund Transfer" class="card-bg-img" />
					<h3>Fund Transfer</h3><br>
					<button class="card-btn" onclick="openDialog('Fund Transfer')">Transfer Funds</button>
				</div>

				<div class="card">
					<img src="img/deposit.png" alt="Fund Transfer" class="card-bg-img" />
					<h3>Deposit</h3></br>
					<button class="card-btn" onclick="openDialog('Deposit')">Deposit Funds</button>
				</div>

				<div class="card">
					<img src="img/withdraw.png" alt="Fund Transfer" class="card-bg-img" />
					<h3>Withdraw Balance</h3></br>
					<button class="card-btn" onclick="openDialog('Withdraw')">Withdraw Funds</button>
				</div>

				<div class="card">
					<img src="img/history.png" alt="Fund Transfer" class="card-bg-img" />
					<h3>Transaction History</h3></br>
					<button class="card-btn" onclick="openDialog('Transaction History')">View History</button>
				</div>
			</div>
		</div>
    </div>

	
	<div id="dialog" class="dialog">
      <div class="dialog-content">
        <span class="close-btn" onclick="closeDialog()">&times;</span>
        <h2 id="dialog-title" style="text-align: center;">Action</h2></br>
        
		<div id="transaction-inputs">
			<form method="POST">
				<div id="account-inputs" class="input-group">
					<input class="form-style" type="text" id="account-number" name="sender_acc" placeholder="Enter account number" autocomplete="off">
				</div>
				<div class="input-group">
					<input class="form-style" type="number" step="0.01" id="amount" name="amount" placeholder="Enter Ammount" autocomplete="off" required>
				</div>
				<button id="dialog-submit" class="btn-disable" name="submit" type="submit">Submit</button>
			</form>
		</div>

        <div id="transaction-history" class="hidden">
          <div class="history-container">
            <ul id="history-list">
				
            </ul>
          </div>
        </div>

      </div>
    </div>

	<div id="toastmsg"></div>

	<script>
		let p_name = document.getElementById('p_name');
		let p_acc_no = document.getElementById('p_acc_no');
		let p_number = document.getElementById('p_number');
		let p_time = document.getElementById('p_time');
		let p_balance = document.getElementById('p_balance');
		let historylist = document.getElementById('history-list');
		let currentBalance = 0;
		let myAccount = null;
		
		function setProfile(name, acc_no, number, time) {
			myAccount = acc_no;
			p_name.innerHTML = 'Full Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp '+name;
			p_acc_no.innerHTML = 'Account Number &nbsp: &nbsp '+acc_no;
			p_number.innerHTML = 'Mobile Number &nbsp&nbsp&nbsp&nbsp: &nbsp '+number;
			p_time.innerHTML = 'Create Time &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: &nbsp '+time;
		}

		function setBalance(balance) {
			currentBalance = parseFloat(balance);
			p_balance.innerHTML = 'Acount Balance : '+currentBalance.toFixed(2)+' ৳';
		}

		function setTransactions(amount, type, time) {
			let li = document.createElement("li");
  			li.textContent = `${parseFloat(amount)} TK - ${type} - ${time}`;
			li.style.fontSize = "14px";
			historylist.appendChild(li);
		}

		function setNoTransactions() {
			let li = document.createElement("li");
  			li.textContent = 'No transactions found.';
			li.style.fontSize = "16px";
			historylist.appendChild(li);
		}
		
		let dialog = document.getElementById('dialog');
		let historyList = document.getElementById('history-list');
		let transactionInputs = document.getElementById('transaction-inputs');
		let transactionHistory = document.getElementById('transaction-history');
		let dialogSubmit = document.getElementById('dialog-submit');
		let accountnumber = document.getElementById('account-number');
		let amount = document.getElementById('amount');
		
		let currentAction = '';

		function openDialog(action) {
			currentAction = action;
			amount.style['border'] = 'none';
			accountnumber.style['border'] = 'none';
			
			document.getElementById('dialog-title').textContent = action;
			document.getElementById('dialog').style.display = 'flex';

			if (currentAction === 'Fund Transfer') {
				dialogSubmit.name = 'transfer';
				accountnumber.style.display = 'block';
			} else {
				accountnumber.style.display = 'none';
				if (action === 'Withdraw') {
					dialogSubmit.name = 'withdraw';
				} else if (action === 'Deposit') {
					dialogSubmit.name = 'deposit';
				}
			}

			if (action === 'Transaction History') {
				transactionInputs.style.display = 'none';
				transactionHistory.style.display = 'block';
				dialogSubmit.style.display = 'none';
			} else {
				transactionInputs.style.display = 'block';
				transactionHistory.style.display = 'none';
				dialogSubmit.style.display = 'inline-block';
			}
    	}

		function closeDialog() {
			document.getElementById('dialog').style.display = 'none';
			clearInputs();
		}

		function clearInputs() {
			accountnumber.value = '';
			amount.value = '';
		}

		accountnumber.addEventListener('input', (evt) => {
			if (accountnumber.value.length == 8 && myAccount != accountnumber.value) {
				accountnumber.style['border'] = 'none';
			} else {
				accountnumber.style['border'] = '1px solid red';
			}
		});

		amount.addEventListener('input', (evt) => {
			if ((currentAction == 'Fund Transfer' && amount.value >= 0.01 && accountnumber.value.length == 8 && myAccount != accountnumber.value) || (currentAction != 'Fund Transfer' && amount.value >= 0.01)) {
				if (currentAction == 'Withdraw') {
					if (currentBalance >= amount.value) {
						amount.style['border'] = 'none';
						dialogSubmit.className = 'btn-enable';
						dialogSubmit.disabled = false;
					} else {
						amount.style['border'] = '1px solid red';
						dialogSubmit.className = 'btn-disable';
						dialogSubmit.disabled = true;
					}
				} else {
					amount.style['border'] = 'none';
					dialogSubmit.className = 'btn-enable';
					dialogSubmit.disabled = false;
				}
			} else {
				amount.style['border'] = '1px solid red';
				dialogSubmit.className = 'btn-disable';
				dialogSubmit.disabled = true;
			}
		});

		let timeout = null;

		function showTost(msg) {
			let toastmsg = document.getElementById('toastmsg');
			toastmsg.innerHTML = msg;
			toastmsg.className = "show";
			
			if (timeout) {
				clearTimeout(timeout)
			}

			timeout = setTimeout(function(){ 
				toastmsg.className = '';
				timeout = null;
			}, 3450);
		}

		window.onclick = function(event) {
			if (event.target == dialog) {
				closeDialog();
			}
		}

	</script>
</body>
</html>

<?php

if(isset($_SESSION['acc_no']) && isset($_SESSION['c_id'])) {
	$c_id = intval($_SESSION['c_id']);
	$acc_no = $conn->real_escape_string($_SESSION['acc_no']);

	$result = $conn->query("SELECT * FROM account WHERE acc_no='$acc_no'");
	if ($result && $result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$balance = floatval($row['balance']);
		$time = htmlspecialchars($row['date']);

		$result = $conn->query("SELECT * FROM customer WHERE c_id=$c_id");
		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$name = htmlspecialchars($row['name']);
			$number = htmlspecialchars($row['number']);

			echo "<script> setProfile('$name', '$acc_no', '$number', '$time'); setBalance('$balance'); </script>";
		}

		$result = $conn->query("SELECT * FROM transaction WHERE acc_no = $acc_no ORDER BY date DESC");

		if ($result && $result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$amount = $row['amount'];
				$type = $row['type'];
				$time = $row['date'];
				echo "<script> setTransactions('$amount', '$type', '$time');</script>";
			}
		} else {
			echo "<script> setNoTransactions();</script>";
		}

		$date = date('Y-m-d h:i:s a');

		if (isset($_POST['deposit'])) {
			$amount = floatval($_POST['amount']);
			if ($amount >= 0.01) {
				$main_balance = $balance + $amount;
				if ($conn->query("UPDATE account SET balance=$main_balance WHERE acc_no='$acc_no'") === TRUE) {
					$conn->query("INSERT INTO transaction VALUES (NULL, '$acc_no', 'DEPOSIT', $amount, NULL, '$date')");
					echo "<script> showTost('Deposit Success'); setBalance('$main_balance');</script>";
				} else {
					echo "<script> showTost('Deposit Failed'); </script>";
				}
			} else {
				echo "<script> showTost('Invalid Deposit Amount'); </script>";
			}
		} else if (isset($_POST['withdraw'])) {
			$amount = floatval($_POST['amount']);
			if ($amount >= 0.01 && $balance >= $amount) {
				$main_balance = $balance - $amount;
				if ($conn->query("UPDATE account SET balance=$main_balance WHERE acc_no='$acc_no'") === TRUE) {
					$conn->query("INSERT INTO transaction VALUES (NULL, '$acc_no', 'WITHDRAW', $amount, NULL, '$date')");
					echo "<script> showTost('Withdraw Success'); setBalance('$main_balance');</script>";
				} else {
					echo "<script> showTost('Withdraw Failed'); </script>";
				}
			} else {
				echo "<script> showTost('Insufficient Balance or Invalid Amount'); </script>";
			}
		} else if (isset($_POST['transfer'])) {
			$amount = floatval($_POST['amount']);
			$sender_acc = $conn->real_escape_string($_POST['sender_acc']);

			if ($amount >= 0.01 && $balance >= $amount) {
				if ($sender_acc !== $acc_no) {
					$result = $conn->query("SELECT balance FROM account WHERE acc_no='$sender_acc'");
					if ($result && $result->num_rows > 0) {
						$row = $result->fetch_assoc();
						$sender_balance = floatval($row['balance']) + $amount;
						$main_balance = $balance - $amount;

						$update1 = $conn->query("UPDATE account SET balance=$sender_balance WHERE acc_no='$sender_acc'");
						$update2 = $conn->query("UPDATE account SET balance=$main_balance WHERE acc_no='$acc_no'");

						if ($update1 && $update2) {
							$conn->query("INSERT INTO transaction VALUES (NULL, '$acc_no', 'SEND', $amount, '$sender_acc', '$date')");
							$conn->query("INSERT INTO transaction VALUES (NULL, '$sender_acc', 'RECEIVE', $amount, '$acc_no', '$date')");
							echo "<script> showTost('Transfer Success'); setBalance('$main_balance');</script>";
						} else {
							echo "<script> showTost('Transfer Failed'); </script>";
						}
					} else {
						echo "<script> showTost('Invalid Account'); </script>";
					}
				} else {
					echo "<script> showTost('Cannot Transfer To Same Account'); </script>";
				}
			} else {
				echo "<script> showTost('Insufficient Balance or Invalid Amount'); </script>";
			}
		}
	} else {
		echo "<script> window.location = 'logout.php'; </script>";
		exit;
	}
}
?>