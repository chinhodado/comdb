<?php
	class CPU{
		public $cpuid, $name, $technology, $package, $clock, $clockturbo, $l1cache,
				$l2cache, $l3cache, $numcore, $passmarkscore, $codename, $instructions,
				$multiplier, $numthread;

		function __construct($cpuid, $name, $technology, $package, $clock, $l1cache, $l2cache, $l3cache, $numcore, $passmarkscore, $codename, $instructions, $multiplier, $numthread, $clockturbo){
			$this->cpuid = $cpuid;
			$this->name = $name;
			$this->technology = $technology;
			$this->package = $package;
			$this->clock = $clock;
			$this->clockturbo = $clockturbo;
			$this->l1cache = $l1cache;
			$this->l2cache = $l2cache;
			$this->l3cache = $l3cache;
			$this->numcore = $numcore;
			$this->passmarkscore = $passmarkscore;
			$this->codename = $codename;
			$this->instructions = $instructions;
			$this->multiplier = $multiplier;
			$this->numthread = $numthread;
		}
	}

	class Computer{
		public $computerid, $cpuid, $gpuid, $ram, $psu, $passmarkdiskscore, $name, $passmarkramscore, $model, $passmarktotalscore;
		function __construct($computerid, $cpuid, $gpuid, $ram, $psu, $passmarkdiskscore, $name, $passmarkramscore, $model, $passmarktotalscore){
			$this->computerid = $computerid;
			$this->cpuid = $cpuid; 
			$this->gpuid = $gpuid; 
			$this->ram = $ram; 
			$this->psu = $psu; 
			$this->passmarkdiskscore = $passmarkdiskscore; 
			$this->name = $name; 
			$this->passmarkramscore = $passmarkramscore; 
			$this->model = $model;
			$this->passmarktotalscore = $passmarktotalscore;
		}
	}

	class GPU {
		public $gpuid, $name, $gpuclock, $bandwidth, $memclock, $passmarkscore2D, $passmarkscore3D;
		function __construct($gpuid, $name, $passmarkscore2D, $passmarkscore3D, $gpuclock, $bandwidth, $memclock){
			$this->gpuid = $gpuid;
			$this->name = $name; 
			$this->gpuclock = $gpuclock; 
			$this->bandwidth = $bandwidth; 
			$this->memclock = $memclock; 
			$this->passmarkscore2D = $passmarkscore2D; 
			$this->passmarkscore3D = $passmarkscore3D; 
		}
	}
?>