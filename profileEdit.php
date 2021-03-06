<?php
include 'core/init.php';
if($getFromUser->loggedIn()=== false){
    header('Location: index.php');
}


$user_id = $_SESSION['user_id'];
$user    = $getFromUser->userData($user_id);

if(isset($_POST['screenName'])){
    if(!empty($_POST['screenName'])){

        $screenName = $getFromUser->inputCheck($_POST['screenName']);
        $profileBio = $getFromUser->inputCheck($_POST['bio']);
        $country = $getFromUser->inputCheck($_POST['country']);
        $website = $getFromUser->inputCheck($_POST['websiteUrl']);

        if(strlen($screnName)> 20){

            $error = "Name must be between 3 and 20 characters!";
        }elseif (strlen($profileBio) > 130 )  {
            $error = "Description is too long!";
        }elseif (strlen($country) > 80) {
           
            $error ="Country name is too long!";

        }else {
             $getFromUser->update('users', $user_id, array('screenName'=>$screenName, 'bio'=>$profileBio, 'country'=>$country, 'websiteUrl'=>$website));
             header('Location: '.$user->username);
        }

    }else{

        $error= "Name field can't be blank!";


    }  
}


if(isset($_FILES['profilePic'])){
    if(!empty($_FILES['profilePic']['name'][0])){

        $fileRoot = $getFromUser->uploadImage($_FILES['profilePic']);
        $getFromUser->update('users', $user_id,array('profilePic'=>$fileRoot));
        header('Location:' .$user->username);

    }
}


if(isset($_FILES['profileCover'])){
    if(!empty($_FILES['profileCover']['name'][0])){

        $fileRoot = $getFromUser->uploadImage($_FILES['profileCover']);
        $getFromUser->update('users', $user_id,array('profileCover'=>$fileRoot));
        header('Location:' .$user->username);
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
	<link rel="stylesheet" href="assets/css/style-complete.css"/>
	<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>

    <title>Document</title>


</head>
<body>

<div class="wrapper">

<div class="header-wrapper">

<div class="nav-container">

	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<li><a href="i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notification</a></li>
				<li><i class="fa fa-envelope" aria-hidden="true"></i>Messages</li>
			</ul>
		</div>
	
		<div class="nav-center"><ul><li>
					<input type="text" placeholder="Search" class="search"/>
					<div id="search-icon-box"><i class="fa fa-search" aria-hidden="true"></i></div>
					<div class="search-result">			
					</div>
				</li></ul></div>
		<div class="nav-right">
			<ul>
		
				<?php if($getFromUser->loggedIn()===true) {?>		
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profilePic; ?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo $user->username; ?>"><?php echo $user->username; ?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-recommend" class="addRecommendBtn">Recommend</label></li>
				<?php }else {
					echo '<li><a href="'.BASE_URL.'index.php">Already have an account? Log in here!</a></li>';
				} ?>
			</ul>
		</div>

</div>

</div>

<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">

		<img src="<?php echo $user->profileCover; ?>"/>
 
		<div class="img-upload-button-wrap">
			<div class="img-upload-button1">
				<label for="cover-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text1">
					Change your profile photo
				</span>
				<input id="cover-upload-btn" type="checkbox"/>
				<div class="img-upload-menu1">
					<span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="file-up">
									Upload photo
								</label>
								<input type="file" name="profileCover" onchange="this.form.submit();" id="file-up" />
							</li>
								<li>
								<label for="cover-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="profile-nav">
	<div class="profile-navigation">
		<ul>
			<li>
				<a href="#">
					<div class="n-head">
						TWEETS
					</div>
					<div class="n-bottom">
						0
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						FOLLOWINGS
					</div>
					<div class="n-bottom">
                    <?php echo $user->following; ?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						FOLLOWERS
					</div>
					<div class="n-bottom">
					<?php echo $user->followers; ?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						LIKES
					</div>
					<div class="n-bottom">
						0
					</div>
				</a>
			</li>
			
		</ul>
		<div class="edit-button">
			<span>
				<button class="f-btn" type="button" onclick="window.location.href='<?php echo $user->username; ?>'" value="Cancel">Cancel</button>
			</span>
			<span>
				<input type="submit" id="save" value="Save Changes">
			</span>
		 
		</div>
	</div>
</div>
</div>

<div class="in-wrapper">
<div class="in-full-wrap">
  <div class="in-left">
	<div class="in-left-wrap">
	
<div class="profile-info-wrap">
	<div class="profile-info-inner">
		<div class="profile-img">
			
			<img src="<?php echo $user->profilePic; ?>"/>
 			<div class="img-upload-button-wrap1">
			 <div class="img-upload-button">
				<label for="img-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text">
					Change your profile photo
				</span>
				<input id="img-upload-btn" type="checkbox"/>
				<div class="img-upload-menu">
				 <span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="profilePic">
									Upload photo
								</label>
								<input id="profilePic" type="file"  onchange="this.form.submit();"  name="profilePic"/>
								
							</li>
							<li><a href="#">Remove</a></li>
							<li>
								<label for="img-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			  </div>
			</div>
		</div>

			    <form id="editForm" method="post" enctype="multipart/Form-data">	
				<div class="profile-name-wrap">
                    <?php 
                    
                      if(isset($imageError)) {

                        echo '<ul>
                            <li class="error-li">
                                <div class="span-pe-error">'.$imageError.'</div>
                            </li>
                            </ul>';

                      }    

                    ?>
				
					<div class="profile-name">
						<input type="text" name="screenName" value="<?php echo $user->screenName; ?>"/>
					</div>
					<div class="profile-tname">
						@<?php echo $user->username; ?>
					</div>
				</div>
				<div class="profile-bio-wrap">
					<div class="profile-bio-inner">
						<textarea class="status" name="bio"><?php echo $user->bio; ?></textarea>
						<div class="hash-box">
					 		<ul>
					 		</ul>
					 	</div>
					</div>
				</div>
					<div class="profile-extra-info">
					<div class="profile-extra-inner">
						<ul>
							<li>
								<div class="profile-ex-location">
									<input id="cn" type="text" name="country" placeholder="Country" value="<?php echo $user->country; ?>" />
								</div>
							</li>
							<li>
								<div class="profile-ex-location">
									<input type="text" name="website" placeholder="Website" value="<?php echo $user->websiteUrl; ?>"/>
								</div>
                            </li>
                            
                            <?php 
                    
                    if(isset($error)) {

                      echo '
                          <li class="error-li">
                              <div class="span-pe-error">'.$error.'</div>
                          </li>
                          ';

                    }    

                  ?>

                </form>
                <script type="text/javascript">
                
                    $('#save').click(function(){
                        $('#editForm').submit();
                    })
                
                </script>

						</ul>						
					</div>
				</div>
				<div class="profile-extra-footer">
					<div class="profile-extra-footer-head">
						<div class="profile-extra-info">
							<ul>
								<li>
									<div class="profile-ex-location-i">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</div>
									<div class="profile-ex-location">
										<a href="#">0 Photos and videos </a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="profile-extra-footer-body">
						<ul>
						  
						</ul>
					</div>
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>


<div class="in-center">
	<div class="in-center-wrap">	

	</div>

   <div class="popupRec"></div>
   
  		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/follow.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/like.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popouprcmd.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/comment.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/popupForm.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/hashtag.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/messages.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/postMessage.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/notification.js"></script>
</div>


<div class="in-right">
	<div class="in-right-wrap">

	</div>

</div>


   </div>
  
 
  </div>


</div>

    
</body>
</html>