<?php
$employee = false;
if(isset($_GET['id']) && $employee = get_employee($_GET['id']) ) {
	$employee_id = $_GET['id'];
}
?>
<div class="container">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
			<div class="x_panel">
				<div class="x_title">
					<h2>New Employee</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form class="form-horizontal form-label-left" id="create_employee">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Name <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="emp_name" name="emp_name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($employee) ? $employee->emp_name : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Mobile <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="emp_mobile" name="emp_mobile" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($employee) ? $employee->emp_mobile : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Address <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="emp_address" name="emp_address" class="form-control col-md-7 col-xs-12"><?php echo ($employee) ? $employee->emp_address : ''; ?></textarea>
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Salary (Per Day)<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="emp_salary" name="emp_salary" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo ($employee) ? $employee->emp_salary : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Join Date<span class="required"></span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="emp_joining" name="emp_joining" required="required" class="form-control col-md-7 col-xs-12 datepicker" value="<?php echo ($employee) ? $employee->emp_joining : ''; ?>">
							</div>
						</div>
						<div class="divider-dashed"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	                          	<button class="btn btn-primary" type="button">Cancel</button>
							  	<button class="btn btn-primary" type="reset">Reset</button>
	                          	<button type="submit" class="btn btn-success">Submit</button>
								<?php 
									if(  $employee ) {
										echo '<input type="hidden" name="employee_id" value="'.$employee_id.'">';
										echo '<input type="hidden" name="action" class="employee_action" value="update_employee">';
									} else {
										echo '<input type="hidden" name="action" class="employee_action" value="create_employee">';
									}
								?>

	                        </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>