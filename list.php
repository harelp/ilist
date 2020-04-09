
<?php
	include('config/helpers.php');
	$isError = false;
	$error = "";
	empty($_GET['id']) && header("Location: index.php");
	if(isset($_GET['id'])){
		$pin = $_GET['id'];
		$isValid = checkPin($pin);
		!$isValid && header("Location: index.php");
		if($isValid){
			$todos = getTodos($pin);
		}
	}else{
		header("Location: index.php");
	}

	if(isset($_POST['addtodo'])){
		$todo = $_POST['todo'];
		$pin = $_GET['id'];
		$isError = false;

		if(empty($todo)){
			$isError = true;
			$error = "Todo can't be empty!";
		}else{
			createTodo($pin, $todo);
			$todos = getTodos($pin);
		}
		
	}

	if(isset($_POST['active'])){
		$todo = $_POST['todo'];
		$id = $_POST['todo_id'];
		$pin = $_GET['id'];
		$func = $_POST['active'];
		$isError = false;

		// functions
		if(empty($todo)){
			$isError = true;
			$error = "Todo can't be empty!";
		}
		$func == 'delete' && deleteTodo($pin, $id);
		!empty($todo) && $func == 'update' && updateTodo($id, $todo);
		$func == 'completed' && updateStatus($id, 'false');
		$todos = getTodos($pin);
	}

	if(isset($_POST['inactive'])){
		$todo = $_POST['todo'];
		$id = $_POST['todo_id'];
		$pin = $_GET['id'];
		$func = $_POST['inactive'];

		// functions
		$func == 'delete' && deleteTodo($pin, $id);
		$func == 'uncomplete' && updateStatus($id, 'true');
		$todos = getTodos($pin);
	}

?>

 <!DOCTYPE html>
 <html>
 <?php include('templates/header.php'); ?>
 <?php if($isError): ?>
 <small class="toast">
	<?php echo $error?>
 </small>
<?php endif; ?>
 <div class="container">
 		<form class="form-max center">
 			<h5>iList Shortcut: <?php echo $pin; ?></h5>
 		</form>


 		<form class="form-max" action="list.php?id=<?php echo htmlspecialchars($_GET['id'])?>" method="POST">
 			<div class="row">
 				<div class="col s10">
 					<div class="input-field">
            			<input type="text" name="todo" maxlength="255">
          			</div>
 				</div>
 				<div class="col s2">
 					<input type="submit" name="addtodo" value="add" class="right btn waves-effect waves-light btn-large red accent-2 z-depth-0">
 				</div>
 			</div>
 		</form>
 		<?php foreach($todos as $todo): ?>
 			<?php if($todo['status'] == 'true'): ?>
			<form class="form-max" action="list.php?id=<?php echo htmlspecialchars($todo['list_id']) ?>" method="POST">
 			<div class="row">
 				<div class="col s12">
 					<div class="input-field">
            			<input type="text" name="todo" id="todo" value="<?php echo htmlspecialchars($todo['todo']) ?>" maxlength="255">
            			<input type="hidden" name="todo_id" value="<?php echo $todo['todo_id'] ?>">
          			</div>
 				</div>
 				<div class="col s4 right-align">
 					<input type="submit" name="active" value="update" class="btn waves-effect waves-light orange accent-2 z-depth-0">
 				</div>
 				<div class="col s4 center">
 					<input type="submit" name="active" value="delete" class="btn waves-effect waves-light red accent-2 z-depth-0">
 				</div>
 				<div class="col s4 left-align">
 					<input type="submit" name="active" value="completed" class="btn waves-effect waves-light blue accent-2 z-depth-0">
 				</div>
 			</div>
 		</form>
 	<?php endif; ?>
 		<?php endforeach; ?> 
 			<div class="row center">
					<h5>Completed</h5>
				</div>
 		<?php foreach($todos as $todo): ?>
 			<?php if($todo['status'] == 'false'): ?>
			<form class="form-un" action="list.php?id=<?php echo htmlspecialchars($todo['list_id']) ?>" method="POST">
 			<div class="row">
 				<div class="col s12">
 					<div class="input-field">
            			<input type="text" name="todo" id="todo" value="<?php echo htmlspecialchars($todo['todo']) ?>" maxlength="255">
            			<input type="hidden" name="todo_id" value="<?php echo htmlspecialchars($todo['todo_id']) ?>">
          			</div>
 				</div>
 				<div class="col s6 right-align">
 					<input type="submit" name="inactive" value="delete" class="btn waves-effect waves-light red accent-2 z-depth-0">
 				</div>
 				<div class="col s6 left-align">
 					<input type="submit" name="inactive" value="uncomplete" class="btn waves-effect waves-light black accent-2 z-depth-0">
 				</div>
 			</div>
 		</form>
 	<?php endif; ?>
 		<?php endforeach; ?> 
 		

 </div>
 <?php include('templates/footer.php'); ?>
 </body>
 </html>