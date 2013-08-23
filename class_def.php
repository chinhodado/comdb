<?php
	class CPU{
		public $cpuid, $name, $technology, $package, $clock, $clockturbo, $l1cache,
				$l2cache, $l3cache, $numcore, $passmarkscore, $codename, $instructions,
				$multiplier, $numthread;

		function __construct($cpuid, $name, $technology, $package, $clock, $l1cache, $l2cache, $l3cache, $numcore, $passmarkscore, $codename, $instructions, $multiplier, $numthread, $clockturbo){
			$this->cpuid = $cpuid;										//0
			$this->name = $name;										//1
			$this->technology = $technology;							//2
			$this->package = $package;									//3
			$this->clock = $clock;										//4
			$this->l1cache = $l1cache;									//5
			$this->l2cache = $l2cache;									//6
			$this->l3cache = $l3cache;									//7
			$this->numcore = $numcore;									//8
			$this->passmarkscore = $passmarkscore;						//9
			$this->codename = $codename;								//10
			$this->instructions = $instructions;						//11
			$this->multiplier = $multiplier;							//12
			$this->numthread = $numthread;								//13
			$this->clockturbo = $clockturbo;							//14
		}
	}

	class Computer{
		public $computerid, $cpuid, $gpuid, $ram, $psu, $passmarkdiskscore, $name, $passmarkramscore, $model, $passmarktotalscore;
		function __construct($computerid, $cpuid, $gpuid, $ram, $psu, $passmarkdiskscore, $name, $passmarkramscore, $model, $passmarktotalscore){
			$this->computerid = $computerid;							//0
			$this->cpuid = $cpuid; 										//1
			$this->gpuid = $gpuid; 										//2
			$this->ram = $ram; 											//3
			$this->psu = $psu; 											//4
			$this->passmarkdiskscore = $passmarkdiskscore; 				//5
			$this->name = $name; 										//6
			$this->passmarkramscore = $passmarkramscore; 				//7
			$this->model = $model;										//8
			$this->passmarktotalscore = $passmarktotalscore;			//9
		}
	}

	class GPU {
		public $gpuid, $name, $gpuclock, $bandwidth, $memclock, $passmarkscore2D, $passmarkscore3D;
		function __construct($gpuid, $name, $passmarkscore2D, $passmarkscore3D, $gpuclock, $bandwidth, $memclock){
			$this->gpuid = $gpuid;										//0
			$this->name = $name;										//1
			$this->passmarkscore2D = $passmarkscore2D; 					//2
			$this->passmarkscore3D = $passmarkscore3D;					//3
			$this->gpuclock = $gpuclock; 								//4
			$this->bandwidth = $bandwidth; 								//5
			$this->memclock = $memclock; 								//6
		}
	}

	// for use in chart_allcpu.php
	class CPUAndScore {
		public $name, $data;
		function __construct($cpuName, $cpuScore){
			$this->name = $cpuName;
			$this->data = array();
			array_push($this->data, intval($cpuScore));
		}
	}

	//for use in chart_allcomputer_bar.php
	class NameAndData{
		public $name, $data;
			function __construct($name, $data){
			$this->name = $name;
			$this->data = $data;
		}
	}
?>