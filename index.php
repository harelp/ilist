<?php 
	session_start();
	include('config/helpers.php');
  $isError = false;
	$error = "";
 if(isset($_POST['editList'])){
  $isError = false;
 	if(empty($_POST['pin'])){
        $isError = true;
        $error = 'List Pin is required!';
    } else{
    	$pin = strtoupper($_POST['pin']);

       	if (checkPin($pin)){
	    	$directTo = "list.php?id=" . $pin;
	    	header("Location: " . $directTo);
       	} else{
          $isError = true;
       		$error = "No List found with this Pin!";
       	}
         
    }
 }
 if(isset($_POST['newList'])){
   $isError = false;
 	if(isset($_SESSION['numOfTodo'])) $_SESSION['numOfTodo'] += 1;
    else $_SESSION['numOfTodo'] = 1;

 		if($_SESSION['numOfTodo'] <= 3){
 			createNewList();
 		} else{
      $isError = true;
 			$error = "Can't make more than 3 Lists";
 			session_unset();
 		}
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
	<section class="container grey-text">
        <form action="index.php" method="POST" class="grey lighten-4">
         	<div class="input-field center">
         		<h5 for="pin">iList Pin</h5>
            	<input class="center" type="text" name="pin" id="pin" value="" maxlength="4">
          	</div>
           
            <div class="center">
                <input type="submit" name="editList" value="Enter List" class="btn waves-effect waves-light red accent-2 z-depth-0">
                
            </div>
        </form>
        <form action="index.php" method="POST" class="center">

        	<input type="submit" name="newList" value="Create New List" class="btn-large btn waves-effect waves-light black accent-2 z-depth-0">
        </form>
    </section>
    <?php include('templates/footer.php'); ?>

<html>

<?php 
 ?>