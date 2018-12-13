<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="registerUserModal">Register an account</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="userForm" method="POST" action="<?php echo LINK_PATH . "index.php?page=user&action=register";?>">
					<input type="hidden" name="action" value="CreateUser">
					<input type="hidden" name="callee" value="<?php echo (isset($_GET['page']) ? $_GET['page'] : 'home'); ?>">
					<div class="form-group">
						<label for="userNameReg">Username</label>
						<input type="text" class="form-control" id="userNameReg" name="username" placeholder="Enter username">
					</div>
					<div class="form-group">
						<label for="userEmailReg">Email address</label>
						<input type="email" class="form-control" id="userEmailReg" name="email" placeholder="Enter email">
					</div>
					<div class="form-group">
						<label for="userPasswordReg">Password</label>
						<input type="password" class="form-control" id="userPasswordReg" name="password" placeholder="Password">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Register</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="loginModalLabel">Login</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="loginForm" method="POST" action="<?php echo LINK_PATH . "index.php?page=user&action=login";?>">
					<input type="hidden" name="action" value="LoginUser">
					<input type="hidden" name="callee" value="<?php echo (isset($_GET['page']) ? $_GET['page'] : 'home'); ?>">
					<div class="form-group">
						<label for="userNameLogin">Username</label>
						<input type="text" class="form-control" id="userNameLogin" name="username" placeholder="Enter username">
					</div>
					<div class="form-group">
						<label for="userPasswordLogin">Password</label>
						<input type="password" class="form-control" id="userPasswordLogin" name="password" placeholder="Password">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="login-user" type="button" class="btn btn-primary">Login</button>
			</div>
		</div>
	</div>
</div>