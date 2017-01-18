<style>
	td {
		border-style:solid;
		border-width:1px;
	}
</style>

<?php 
//each player object has all of the relevent statistics as fields, 
//constructor takes an array with the query result and there is one getter for each of the necessary statistics
class Player {
	private $firstName;
	private $lastName;
	private $teamName;
	private $gamesPlayed;
	private $minutes;
	private $fgMade;
	private $fgAttempt;
	private $fgPct;
	private $threePtMade;
	private $threePtAttempt;
	private $threePtPercent;
	private $freeThrowMade;
	private $freeThrowAttempt;
	private $freeThrowPercent;
	private $reboundOff;
	private $reboundDef;
	private $reboundTot;
	private $assist;
	private $turnover;
	private $steal;
	private $blocks;
	private $personalFouls;
	private $pointsPerGame;

	public function __construct($queryResult) {
		$this->firstName = $queryResult['firstName'];
		$this->lastName = $queryResult['lastName'];
		$this->teamName = $queryResult['teamName'];
		$this->gamesPlayed = $queryResult['gamesPlayed'];
		$this->minutes = $queryResult['minutes'];
		$this->fgMade = $queryResult['fgMade'];
		$this->fgAttempt = $queryResult['fgAttempt'];
		$this->fgPercent = $queryResult['fgPercent'];
		$this->threePtMade = $queryResult['threePtMade'];
		$this->threePtAttempt = $queryResult['threePtAttempt'];
		$this->threePtPercent = $queryResult['threePtPercent'];
		$this->freeThrowMade = $queryResult['freeThrowMade'];
		$this->freeThrowAttempt = $queryResult['freeThrowAttempt'];
		$this->freeThrowPercent = $queryResult['freeThrowPercent'];
		$this->reboundOff = $queryResult['reboundOff'];
		$this->reboundDef = $queryResult['reboundDef'];
		$this->reboundTot = $queryResult['reboundTot'];
		$this->assist = $queryResult['assist'];
		$this->turnover = $queryResult['turnover'];
		$this->steal = $queryResult['steal'];
		$this->blocks = $queryResult['blocks'];
		$this->personalFouls = $queryResult['personalFouls'];
		$this->pointsPerGame = $queryResult['pointsPerGame'];
	}

	function get_firstName() {
		return $this->firstName;
	}

	function get_lastName() {
		return $this->lastName;
	}

	function get_teamName() {
		return $this->teamName;
	}

	function get_gamesPlayed() {
		return $this->gamesPlayed;
	}

	function get_minutes() {
		return $this->minutes;
	}

	function get_fgMade() {
		return $this->fgMade;
	}

	function get_fgAttempt() {
		return $this->fgAttempt;
	}

	function get_fgPercent() {
		return $this->fgPercent;
	}

	function get_threePtMade() {
		return $this->threePtMade;
	}

	function get_threePtAttempt() {
		return $this->threePtAttempt;
	}

	function get_threePtPercent() {
		return $this->threePtPercent;
	}

	function get_freeThrowMade() {
		return $this->freeThrowMade;
	}

	function get_freeThrowAttempt() {
		return $this->freeThrowAttempt;
	}

	function get_freeThrowPercent() {
		return $this->freeThrowPercent;
	}

	function get_reboundOff() {
		return $this->reboundOff;
	}

	function get_reboundDef() {
		return $this->reboundDef;
	}

	function get_reboundTot() {
		return $this->reboundTot;
	}

	function get_assist() {
		return $this->assist;
	}

	function get_turnover() {
		return $this->turnover;
	}

	function get_steal() {
		return $this->steal;
	}

	function get_blocks() {
		return $this->blocks;
	}

	function get_personalFouls() {
		return $this->personalFouls;
	}

	function get_pointsPerGame() {
		return $this->pointsPerGame;
	}
}

//load database connection
$host = "assignment1instance.cp6sjhdmxyrg.us-west-2.rds.amazonaws.com";
$user = "info344user";
$password = "Pearl294!";
$database_name = "BasketballStatistics";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

//get user input from search field
$search=$_POST['search'];
//if there is nothing entered by the user
if ($search == '') {
	echo 'Nothing found';
} else {
	$results = array();
	//select all players in the database
	$query = $pdo->prepare('SELECT * FROM Player_Data_Final');
	$query->execute();
	$allData = $query->fetchAll();

	//adds players to an array of results if their name is close enough match to the input from the user
	//uses levenshtein distance
	foreach($allData as $player) {
		//if players first + last name matches the search term, add to results
		if (levenshtein(metaphone($search), metaphone($player['firstName']. $player['lastName'])) < 2) {
			array_push($results,$player);
		//if players first name matches the search term, add to results
		} else if (levenshtein(metaphone($search), metaphone($player['firstName'])) < 1) {
			array_push($results,$player);
		//if players last name matches the search term, add to results
		} else if (levenshtein(metaphone($search), metaphone($player['lastName'])) < 1) {
			array_push($results,$player);
		}
	}
	//if there are names that are similar to what the user searched
	if (count($results) > 0) {
		echo "Search found :<br/>";
		echo "<table>";	
		echo "<tr><td>First Name</td><td>Last Name</td><td>Team</td><td>GP</td><td>Min</td><td>FG-M</td><td>FG-A</td><td>FG-Pct</td><td>3PT-M</td><td>3PT-A</td><td>3PT-Pct</td><td>FT-M</td><td>FT-A</td><td>FT-Pct</td><td>RB-Off</td><td>RB-Def</td><td>RB-Tot</td><td>Ast</td><td>TO</td><td>Stl</td><td>Blk</td><td>PF</td><td>PPG</td></tr>";				
		//loop through results and print statistics in a table
		foreach ($results as $player) {
			//create a new instance of player
			$currPlayer = new Player($player);
			echo "<tr><td>";			
			echo $currPlayer->get_firstName();
			echo "</td><td>";			
			echo $currPlayer->get_lastName();
			echo "</td><td>";
			echo $currPlayer->get_teamName();
			echo "</td><td>";
			echo $currPlayer->get_gamesPlayed();		
			echo "</td><td>";
			echo $currPlayer->get_minutes();		
			echo "</td><td>";
			echo $currPlayer->get_fgMade();		
			echo "</td><td>";
			echo $currPlayer->get_fgAttempt();		
			echo "</td><td>";
			echo $currPlayer->get_fgPercent();		
			echo "</td><td>";
			echo $currPlayer->get_threePtMade();		
			echo "</td><td>";
			echo $currPlayer->get_threePtAttempt();		
			echo "</td><td>";
			echo $currPlayer->get_threePtPercent();		
			echo "</td><td>";
			echo $currPlayer->get_freeThrowMade();		
			echo "</td><td>";
			echo $currPlayer->get_freeThrowAttempt();		
			echo "</td><td>";
			echo $currPlayer->get_freeThrowPercent();		
			echo "</td><td>";
			echo $currPlayer->get_reboundOff();		
			echo "</td><td>";
			echo $currPlayer->get_reboundDef();		
			echo "</td><td>";
			echo $currPlayer->get_reboundTot();		
			echo "</td><td>";
			echo $currPlayer->get_assist();		
			echo "</td><td>";
			echo $currPlayer->get_turnover();		
			echo "</td><td>";
			echo $currPlayer->get_steal();		
			echo "</td><td>";
			echo $currPlayer->get_blocks();		
			echo "</td><td>";
			echo $currPlayer->get_personalFouls();		
			echo "</td><td>";
			echo $currPlayer->get_pointsPerGame();		
			echo "</td></tr>";				
		}
		echo "</table>";
	//if no results are similar to the search term		
	} else {
		echo 'Nothing found';
	}
}
?>