<?php

// This includes classes and a script to generate the optimal defensive assignments for a coed kickball or baseball team

/**
* A player
**/
class player {
  
  public $name = ''; 
  
  public $defense = [];
  
  // Set the player's defensive rating at a position
  public function set_defense($position, $rating) {
    $this->defense[$position] = $rating;
  }
}

/**
* A team
**/
class team {
  // Number of players on the field in an inning
  const PLAYERS_PER_INNING = 10;

  // Positions on the field
  const POSITIONS = [
    1 => 'P',
    2 => 'C',
    3 => '1B',
    4 => '2B',
    5 => '3B',
    6 => 'SS',
    7 => 'LF',
    8 => 'LCF',
    9 => 'RCF',
   10 => 'RF' 
  ];
  
  // Players on the team
  public $players = [];
  
  // Get the defensive lineups for every inning  
  public function get_defense() {
    $start = 0;
    
    for ($inning = 1; $inning <= 7; $inning++) {
      $current_players = array_slice($this->players, $start, self::PLAYERS_PER_INNING);
      $start += self::PLAYERS_PER_INNING;
      // Add more players to the current available players if you reached the end of the team      
      if ($start >= count($this->players)) {
        $players_to_add = array_slice($this->players, 0, self::PLAYERS_PER_INNING - count($current_players));
        $current_players = array_merge($current_players, $players_to_add);
        $start = self::PLAYERS_PER_INNING - count($current_players);
      }
      
      $possible_lineups = array_2D_permute($current_players, [], true);
      
      // Find the best lineup among the possibilities
      $highest_lineup_score = 0;
      foreach ($possible_lineups as $possible_lineup) {
        $lineup_score = 0;
        foreach ($possible_lineup as $position_number => $player) {
          $lineup_score += isset(self::POSITIONS[$position_number + 1]) && isset($player->defense[self::POSITIONS[$position_number + 1]]) ? $player->defense[self::POSITIONS[$position_number + 1]] : 0;
        }
        $highest_lineup_score = max($highest_lineup_score, $lineup_score);
        $best_lineup = $lineup_score >= $highest_lineup_score ? $possible_lineup : $best_lineup;
      }
      
      // Get the best lineup by position for easy reading
      $best_lineup_by_position = [];
      foreach($best_lineup as $postion_number => $player) {
        $best_lineup_by_position[self::POSITIONS[$postion_number+1]] = $player->name;
      }
      
      // Store the best lineup for the inning
      $lineup[$inning] = ['best_lineup' => $best_lineup_by_position, 'best_score' => $highest_lineup_score];
      
    }
  print_r($lineup);
  }
}

// Get all the permutations of an array
function array_2D_permute($items, $perms = array(), $isNew = false) {
  static $permuted_array = array();

  if($isNew) 
     $permuted_array = array();

      if (empty($items)) {
          $permuted_array[]=$perms;
      }  else {
          for ($i = count($items) - 1; $i >= 0; --$i) {
               $newitems = $items;
               $newperms = $perms;
               list($foo) = array_splice($newitems, $i, 1);
               array_unshift($newperms, $foo);
               array_2D_permute($newitems, $newperms);
           }
           return $permuted_array;
      }
}

// Build a team and gets the optimal defensive assignments per innning
$team = new team();

$player = new player();
$player->name = 'Corey';
$player->set_defense('SS', 2);  
$team->players[] = $player;

$player = new player();
$player->name = 'Bange';
$player->set_defense('LF', 7);
$player->set_defense('LCF', 7);
$player->set_defense('RCF', 7);
$player->set_defense('RF', 7);
$player->set_defense('3B', 7);
$player->set_defense('P', 3);
$team->players[] = $player;

$player = new player();
$player->name = 'Carter';
$player->set_defense('LF', 9);
$player->set_defense('LCF', 10);
$player->set_defense('RCF', 10);
$player->set_defense('RF', 10);
$team->players[] = $player;

$player = new player();
$player->name = 'Ian';
$player->set_defense('P', 4);
$player->set_defense('LF', 8);
$player->set_defense('LCF', 8);
$player->set_defense('RCF', 8);
$player->set_defense('RF', 18);
$team->players[] = $player;

$player = new player();
$player->name = 'Jake';
$player->set_defense('LF', 9);
$player->set_defense('LCF', 9);
$player->set_defense('RCF', 9);
$player->set_defense('RF', 10);
$team->players[] = $player;

$player = new player();
$player->name = 'Jon';
$player->set_defense('LF', 9);
$player->set_defense('LCF', 10);
$player->set_defense('RCF', 10);
$player->set_defense('RF', 10);
$team->players[] = $player;

$player = new player();
$player->name = 'Jordan';
$player->set_defense('LF', 8);
$player->set_defense('LCF', 8);
$player->set_defense('RCF', 8);
$player->set_defense('RF', 18);
$team->players[] = $player;
  
$player = new player();
$player->name = 'Dawn';
$player->set_defense('1B', 6);  
$team->players[] = $player;

$player = new player();
$player->name = 'Shai';
$player->set_defense('P', 1);
$player->set_defense('RCF', 2);
$player->set_defense('1B', 2);
$team->players[] = $player;

$player = new player();
$player->name = 'Sliz';
$player->set_defense('P', 7);
$player->set_defense('1B', 5);  
$player->set_defense('3B', 5);
$player->set_defense('LF', 3);
$player->set_defense('LCF', 3);
$player->set_defense('RCF', 3);
$player->set_defense('RF', 3);
$team->players[] = $player;

$player = new player();
$player->name = 'Ashley';
$team->players[] = $player;

$player = new player();
$player->name = 'Christie';
$team->players[] = $player;

$player = new player();
$player->name = 'Jennifer';
$team->players[] = $player;

$player = new player();
$player->name = 'Kristen';
$team->players[] = $player;

$player = new player();
$player->name = 'Maggie';
$team->players[] = $player;

$player = new player();
$player->name = 'Marg';
$team->players[] = $player;

$player = new player();
$player->name = 'Sheba';
$team->players[] = $player;

$player = new player();
$player->name = 'Steph';
$team->players[] = $player;
  
$team->get_defense();

?>
