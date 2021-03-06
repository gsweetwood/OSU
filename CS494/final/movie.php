<?php
	$dbhost = 'localhost';
	$dbuser = 'afgntcom_osu';
	$dbpass = 'osu123';
	$dbname = 'afgntcom_OSUCS494';
	$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

	$imdbID = mysqli_real_escape_string($con, $_GET['id']);

	$result = mysqli_query($con,"SELECT avg(rating) FROM reviews WHERE imdbID = '$imdbID'");
	$numRows = mysqli_query($con,"SELECT * FROM reviews WHERE imdbID = '$imdbID'");
	$row_cnt = mysqli_num_rows($numRows);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CS494 - Final - Movie</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.css">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">Final Project</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav pull-right" id="userInfo">
					</ul>
				</div>
			</div>
		</nav>
		<div class="container" id="content">
			<div class="row">
				<div class="page-header">
					<h1 id="movieTitle"></h1>
					<hr class="colorgraph">
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<table class="table table-bordered">
						<tr>
							<td><strong>Plot</strong></td>
							<td id="plot"></td>
						</tr>
						<tr>
							<td><strong>Release Date</strong></td>
							<td id="releaseDate"></td>
						</tr>
						<tr>
							<td><strong>Runtime</strong></td>
							<td id="runTime"></td>
						</tr>
						<tr>
							<td><strong>Box Office</strong></td>
							<td id="boxOffice"></td>
						</tr>
						<tr>
							<td><strong>Production Company</strong></td>
							<td id="production"></td>
						</tr>
						<tr>
							<td><strong>Genre</strong></td>
							<td id="genre"></td>
						</tr>
						<tr>
							<td><strong>Director</strong></td>
							<td id="director"></td>
						</tr>
						<tr>
							<td><strong>Writers</strong></td>
							<td id="writers"></td>
						</tr>
						<tr>
							<td><strong>Main Actors</strong></td>
							<td id="actors"></td>
						</tr>
						<tr>
							<td><strong>Metascore</strong></td>
							<td><span id="metascore"></span> / 100</td>
						</tr>
						<tr>
							<td><strong>IMDb Rating</strong></td>
							<td><span id="imdbRating"></span> / 10</td>
						</tr>
						<tr>
							<td><strong>IMDb Number of Votes</strong></td>
							<td id="imdbVotes"></td>
						</tr>
						<tr>
							<td><strong>Tomato Rating</strong></td>
							<td><span id="tomatoRating"></span> / 10</td>
						</tr>
						<tr>
							<td><strong>Tomato Number of Reviews</strong></td>
							<td id="tomatoReviews"></td>
						</tr>
						<tr>
							<td><strong>Tomato User Rating</strong></td>
							<td><span id="tomatoUserRating"></span> / 5</td>
						</tr>
						<tr>
							<td><strong>Tomato Number of User Reviews</strong></td>
							<td id="tomatoUserReviews"></td>
						</tr>
						<tr>
							<td><strong>Our User Rating</strong></td>
							<td>
								<?php
										while($row = mysqli_fetch_row($result)) {
											echo $row[0] . ' / 5';
										}
								?>
							</td>
						</tr>
						<tr>
							<td><strong>Our Number of User Reviews</strong></td>
							<td>
								<?php
									echo $row_cnt;
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class="col-md-7">
					<div id="error"></div>
					<div id="writeReview">
						<h2>Write Your Own Review!</h2>
						<textarea maxlength="150" class="form-control" id="userReview" rows="3"></textarea>
						<span id="remainingChars"></span>
						<div class="row">
							<div class="col-md-3">
								<select id="userRating" class="form-control">
									<option value="5">5</option>
									<option value="4">4</option>
									<option value="3">3</option>
									<option value="2">2</option>
									<option value="1">1</option>
								</select>
							</div>
							<div class="col-md-9">
								<a href="#" class="btn btn-md btn-block btn-primary" onclick="submitReview()">Submit</a>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<h2>User Reviews</h2>
						<div id="userReviews">
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/site.js"></script>
		<script>
			function makeRequest() {
				var imdbID = gup('id');
				var requestURL = 'http://www.omdbapi.com/?i=' + imdbID + '&tomatoes=true';
				httpRequest.onreadystatechange = Contents;
			 	httpRequest.open('GET', requestURL);
			 	httpRequest.send();
			}

			function Contents() {
				if(httpRequest.readyState === 4) {
					var response = JSON.parse(httpRequest.responseText);
					document.getElementById('movieTitle').innerHTML += response.Title;
					document.getElementById('releaseDate').innerHTML += response.Released;
					document.getElementById('runTime').innerHTML += response.Runtime;
					document.getElementById('genre').innerHTML += response.Genre;
					document.getElementById('plot').innerHTML += response.Plot;
					document.getElementById('boxOffice').innerHTML += response.BoxOffice;
					document.getElementById('production').innerHTML += response.Production;
					document.getElementById('writers').innerHTML += response.Writer;
					document.getElementById('director').innerHTML += response.Director;
					document.getElementById('actors').innerHTML += response.Actors;
					document.getElementById('metascore').innerHTML += response.Metascore;
					document.getElementById('imdbRating').innerHTML += response.imdbRating;
					document.getElementById('imdbVotes').innerHTML += response.imdbVotes;
					document.getElementById('tomatoRating').innerHTML += response.tomatoRating;
					document.getElementById('tomatoReviews').innerHTML += response.tomatoReviews;
					document.getElementById('tomatoUserRating').innerHTML += response.tomatoUserRating;
					document.getElementById('tomatoUserReviews').innerHTML += response.tomatoUserReviews;
					getReviews();
				}
			}

			function submitReview() {
				var userId = localStorage.getItem('userId');
				var rating = document.getElementById('userRating').value;
				var review = document.getElementById('userReview').value;
				var imdbID = gup('id');
				var requestURL = 'http://aryanaziz.com/OSU/2014/Fall/CS494/final/submitReview.php?userId=' + userId + '&rating=' + rating + '&imdbID=' + imdbID + '&review=' + review;
				console.log(requestURL);
				httpRequest.onreadystatechange = submitReviewContents;
				httpRequest.open('GET', requestURL);
				httpRequest.send();
			}

			function submitReviewContents() {
				if(httpRequest.readyState === 4) {
					var response = JSON.parse(httpRequest.responseText);
					if(response.success === true) {
						document.getElementById('writeReview').style.display = "none";
						document.getElementById('error').innerHTML += '<div class="alert alert-success">Review Submitted. Thanks!</div>';
						getReviews();
					}
				}
			}

			function getReviews() {
				document.getElementById('userReviews').innerHTML = '';
				var imdbID = gup('id');
				var requestURL = 'http://aryanaziz.com/OSU/2014/Fall/CS494/final/getReviews.php?imdbID=' + imdbID;
				console.log(requestURL);
				httpRequest.onreadystatechange = getReviewContents;
				httpRequest.open('GET', requestURL);
				httpRequest.send();
			}

			function getReviewContents() {
				if(httpRequest.readyState === 4) {
					var response = JSON.parse(httpRequest.responseText);
					for(i = response.length - 1; i >= 0; i--) {
						document.getElementById('userReviews').innerHTML += '<div class="panel panel-primary"><div class="panel-heading">Rating: ' + response[i].rating + '</div><div class="panel-body">' + response[i].review + '</div><div class="panel-footer">Submitted By: ' + response[i].userName + ' (' + response[i].date + ')</div></div>';
					}					
				}
			}

			$('textarea').keypress(function() {
				if(this.value.length > 149) {
					return false;
				}
				$("#remainingChars").html("Remaining Characters: " + (149 - this.value.length));
			});
		</script>
	</body>
</html>