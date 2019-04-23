<?php
    class ArrayProductGenerator
    {
        private $result = array();
		public function __construct($input_array) 
		{ 
			$product = array_product( $input_array); // Product of array values
			
			if($product > 0)
			{	
				for($i = 0; $i< count($input_array); $i++)
				{
					$this->result[$i]= $product/$input_array[$i];
				}
			}
        }

        public function results(): ?array
        {
            return $this->result;
        }
    }
